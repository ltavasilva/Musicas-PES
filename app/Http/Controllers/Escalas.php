<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Ministerio;
use App\Models\Repertorio;
use App\Models\EscalaRepertorio;
use App\Models\EscalaTemplate;
use App\Models\Escala;
use App\Models\EscalaTipo;
use App\Models\RepertorioTemplate;
use App\Models\User;
use Carbon\Carbon;
use App\Classes\MailSend;
use App\Classes\PushNotifications;
use Carbon\CarbonPeriod;
use DateTime;
use Faker\Provider\DateTime as ProviderDateTime;

class Escalas extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');   
    }

    private function setAttributes($param){
        $param->created_by = User::Find($param->created_by);
        $param->updated_by = User::Find($param->updated_by);
        $param->repertorios = $param->repertorios()->get();
        if($param->repertorios){
            foreach ($param->repertorios as &$repertorio) {
                $repertorio->ministerio = Ministerio::Find($repertorio->idMinisterio);
                $musicas = $repertorio->musicas()->get();
                $repertorio->temMusica = Count($musicas) > 0;
                if($repertorio->ministerio){
                    $repertorio->ministerio->coordenador = User::Find($repertorio->ministerio->coordenador);
                    $repertorio->ministerio->corresponsavel = User::Find($repertorio->ministerio->corresponsavel);
                }
            }
        }
        $param->tipo = $param->tipo()->first();

        return $param;
    }

    private function loadEscalas($id=null) {
        $param["escala"] = Escala::Find($id);
        if($param["escala"]){
            $param["escala"] = $this->setAttributes($param["escala"]);    
        }

        if(!isset($id)){
            $param["escalas"] = Escala::all();
            foreach ($param["escalas"] as &$escala) {
                $escala = $this->setAttributes($escala);
            }
        }
        $param["ministerios"] = Ministerio::all();
        $param["tipos"] = EscalaTipo::all();

        $param["mode"] = "";

        $date = new \DateTime();
        $date->modify('next monday');
        $param["nextMonday"] = $date->format('Y-m-d');

        $date = new \DateTime();
        $date->modify('next saturday');
        $param["nextSaturday"] = $date->format('Y-m-d');

        //Lista dos próximos 10 Sabados
        $sabado = Carbon::createFromFormat('Y-m-d', $param["nextSaturday"]);
        $param["sabados"][] = $sabado;
        for ($i=0; $i < 9; $i++) { 
            $sabado = Carbon::createFromFormat('Y-m-d', $sabado->format('Y-m-d'));
            $sabado->addDays(7);
            $param["sabados"][] = $sabado;
        }

        $date = new \DateTime();
        $date->modify('today');
        $param["today"] = $date->format('Y-m-d');
        
        return $param;
    }

    private function openView($View, $param = array(), $check = ""){
        if($check != ""){
            if($param[$check]){
                return view($View, $param);  
            }else{
                
                return view('layouts.noDatafound');  
            }
        }else{
            return view($View, $param);  
        }
    }

    public function index(){
        Security('escalas');

        $param = $this->loadEscalas();
        $param["title"] = "Lista de Escalas";
        $param["formAction"] = "escalas";

        return $this->openView('Escalas.escalas', $param);  
    }

    function Array_Match($escalaTemplates, $array){
        $return = Array();
        if(is_Array($array)){
            foreach ($escalaTemplates as $escalaTemplate) {
                foreach ($array as $value) {
                    if ($escalaTemplate->idSemanaMes == $value['weekOfMonth'] && $escalaTemplate->idDiaSemana === $value['dayOfWeek']) {
                        $escalaTemplate->data = $value['date'];
                        $return[] = $escalaTemplate;                
                    }
                }
            }
        }else{
            throw "O Parametro informado não é um array";
        }
        return $return;
    }

    public function teste(){
        /*
        $msg_payload = array (
            'mtitle' => 'Test push notification title',
            'mdesc' => 'Test push notification body',
        );
        
        // For Android
        $regId = 'APA91bHdOmMHiRo5jJRM1jvxmGqhComcpVFDqBcPfLVvaieHeFI9WVrwoDeVVD1nPZ82rV2DxcyVv-oMMl5CJPhVXnLrzKiacR99eQ_irrYogy7typHQDb5sg4NB8zn6rFpiBuikNuwDQzr-2abV6Gl_VWDZlJOf4w';
        // For iOS
        $deviceToken = 'FE66489F304DC75B8D6E8200DFF8A456E8DAEACEC428B427E9518741C92C6660';
        // For WP8
        $uri = 'http://s.notify.live.net/u/1/sin/HmQAAAD1XJMXfQ8SR0b580NcxIoD6G7hIYP9oHvjjpMC2etA7U_xy_xtSAh8tWx7Dul2AZlHqoYzsSQ8jQRQ-pQLAtKW/d2luZG93c3Bob25lZGVmYXVsdA/EKTs2gmt5BG_GB8lKdN_Rg/WuhpYBv02fAmB7tjUfF7DG9aUL4';
        
        // Replace the above variable values
        $notif = new PushNotifications();
	
    	$notif->android($msg_payload, $regId);
    	
    	$notif->WP($msg_payload, $uri);
    	
    	$notif->iOS($msg_payload, $deviceToken);

        return view('Tools.teste'); 
        */
    }
    
    public function missas($data){
        $templates = EscalaTemplate::OrderBy('idSemanaMes', 'asc')->orderBy('idDiaSemana', 'asc')->orderBy('id', 'asc')->Get();
        $start_date = Carbon::createFromFormat('Y-m-d', $data);

        $escopo = Array();
        $dataInfo = dateInfo($start_date);
        for ($i=0; $i < 7; $i++) { 
            $escopo[] = $dataInfo;

            $start_date->addDays(1);
            $dataInfo = dateInfo($start_date);
        }
        if($templates){
            $escalas = $this->Array_Match($templates, $escopo);
        }else{
            $escalas = new EscalaTemplate();
        }
        
        $ministerios = Ministerio::all();

        $html = "";
        $seq = 0;        
        foreach ($escalas as &$escala) {
            $ministerio = EscalaTemplate::Find($escala->id)->ministerio()->first();
            if(!$ministerio){
                $ministerio = new EscalaTemplate;
            }
            $missa = RepertorioTemplate::Find($escala->idRepertorioTemplate);
            $tipo = EscalaTipo::Where('tipo', '=', $missa->tipo)->first();
            $dataEvento = Carbon::createFromFormat('Y-m-d', $escala->data);
            $escala->tipo = $tipo->id;
            $escala->statusCard = "";
            $escala->ministerio = $ministerio;
            $escala->missa = $missa;

            $ministeriosHtml = "";
            foreach ($ministerios as $ministerio) {
                if($ministerio->id == $escala->ministerio->id){
                    $ministeriosHtml .= "<option value='{$ministerio->id}' selected>{$ministerio->nome}</option>";
                }else{
                    $ministeriosHtml .= "<option value='{$ministerio->id}'>{$ministerio->nome}</option>";
                }
            }
            $html .= "<div class='col-12 col-sm-12 col-md-6 col-lg-4 cards space cards{$escala->tipo} cardsItem{$escala->id} hide'>
            <input type='hidden' class='inputData inputRepertorio' name='itemRepertorio' value='{$escala->id}'>
            <input type='hidden' class='inputData inputMinisterio' name='itemMinisterio' value='{$escala->ministerio->id}'>
            <input type='hidden' class='inputData inputTipo' name='itemTipo' value='{$escala->tipo}'>
            <input type='hidden' class='inputData inputDescricao' name='itemDescricao' value='{$escala->missa->descricao}'>
            <input type='hidden' class='inputData inputDataEventoData' name='itemDataEventoData' value='{$dataEvento->format('Y-m-d')}'>
            <input type='hidden' class='inputData inputDataEventoTime' name='itemDataEventoTime' value='{$dataEvento->format('H:i')}'>

            <div class='card' style='width: 18rem;'>
                <div class='card-header'>
                    <input type='text' class='form-control cardDescricao' id='frmDescricao' name='frmDescricao' data-select='cardsItem{$escala->id}' placeholder='Insira a descrição da missal' value='{$escala->missa->descricao}'>
                </div>
                <div class='card-body'>
                    <p class='card-text'>
                        <h5>Ministério: <select id='frmMinisterio' class='form-select ministerioSel'  data-select='cardsItem{$escala->id}' name='frmMinisterio' aria-label='Selecione o ministério'>
                                <option value=''>Selecione...</option>
                                {$ministeriosHtml}
                            </select>
                        </h5>
                        <h6 class='dataEvento'>Data: <span class='dataEvento'>{$dataEvento->format('d/m/Y')}</span></h6>
                        <div class='col-12'>
                            <label for='cardHoraEvento' class='form-label'>Hora do evento:</label> 
                            <input type='time' class='form-control cardHoraEvento' id='cardHoraEvento' name='frmHoraEvento' data-select='cardsItem{$escala->id}' value='{$escala->missa->dataEventoTime}' readonly>
                        </div>
                    </p>
                    
                    <div class='row'>
                        <div class='col-6'>
                            <button id='btnRemoveCard' type='button' class='btn btn-secondary btnRemoveCard' data-select='cardsItem{$escala->id}'>Remover</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>";
        }

        echo $html;
        //header('Content-Type: application/json; charset=utf-8');
        //echo json_encode($escalas);
    }
        
    public function view($id) {
        Security('escalas');
        $param = $this->loadEscalas($id);
        $param["title"] = "Ver Escalas";
        $param["submit"] = false;
        $param["editing"] = false;
        $param["formAction"] = "escalas/view/$id";

        return $this->openView('Escalas.escala', $param, 'escala');  
    }

    public function novo($idMinisterio = 0) {
        Security('escalas');
        $param = $this->loadEscalas();
        $param["escala"] = new Escala();
        $param["escala"]->repertorios = $param["escala"]->template()->get();

        $seq = 0;
        foreach ($param["escala"]->repertorios as &$repertorio) {
            $repertorio->ministerio = new Ministerio();
            $repertorio->sequencia = $seq;
            if($repertorio->ministerio){
                $repertorio->ministerio->coordenador = User::Find($repertorio->ministerio->coordenador);
                $repertorio->ministerio->corresponsavel = User::Find($repertorio->ministerio->corresponsavel);
            }
            $seq +=1;
        }
        $param["escala"]->tipo = null;
        $param["title"] = "Novo repertório";
        $param["submit"] = true;
        $param["editing"] = true;
        $param["mode"] = "New";
        $param["formAction"] = "escalas/insert";

        return $this->openView('Escalas.escalaNovo', $param, 'escala');  
    }

    public function edit($id) {
        Security('escalas');
        $param = $this->loadEscalas($id);
        $param["title"] = "Editar Escalas";
        $param["submit"] = true;
        $param["editing"] = true;
        $param["formAction"] = "escalas/update";
        
        return $this->openView('Escalas.escala', $param, 'escala');  
    }

    public function insert(Request $request){
        Security('escalas');
        $escala = new Escala;

        $validated = $request->validate([
            'descricao' => 'required',
            'tipo' => 'required',
            'dataRef' => 'required',
            'escalaItems' => 'required',
        ]);
        
        if ($request){
            $escala->descricao = $request->descricao;
            $escala->tipo = $request->tipo;
            $escala->dataRef = $request->dataRef;
            $escala->created_by = auth()->user()->id;
            $escala->updated_by = auth()->user()->id;
            $escala->save();

            $jsonText = $request->escalaItems;
            $decodedText = html_entity_decode($jsonText);
            $items = json_decode($decodedText);
            foreach ($items as $key => $item) {
                if(Count($items) != $request->qtdeEscalas){
                    throw ValidationException::withMessages(['Msg-1' => 'Existe repertório não definido!', 'Msg-2' => 'Por Favor verificar a escala.']);
                }

                if($item->itemDataEventoTime == ''){
                    throw ValidationException::withMessages(['Msg-1' => 'O Campo [Hora] da Missa não está definido!', 'Msg-2' => 'Por Favor verificar a escala.']);
                }

                $date = str_replace("/", "-", $item->itemDataEventoData." ".$item->itemDataEventoTime.":00");
                $dt = new DateTime($date);
                //dd($item->itemDataEventoData, $item->itemDataEventoTime, $dt);

                $repertorio = new Repertorio;
                $repertorio->dataEvento = $dt->format('Y-m-d H:i');
                $repertorio->idMinisterio = $item->itemMinisterio;
                $repertorio->tipo = "Missa";
                $repertorio->status = 4; //Insert sempre será 4 (Sem música)
                $repertorio->descricao = $item->itemDescricao;
                $repertorio->created_By = auth()->user()->id;
                $repertorio->updated_By = auth()->user()->id;
                $repertorio->save();

                $escalaRepertorio = new EscalaRepertorio;
                $escalaRepertorio->idEscala = $escala->id;
                $escalaRepertorio->idRepertorio = $repertorio->id;
                $escalaRepertorio->save();
            }

            MailSend::NovaEscala($escala->id);

            return redirect()->action([Escalas::class, 'index']);

        }else{
            $param["title"] = "Nova Escala";
            $param["users"] = User::all()->sortBy('id');
            $param["errorMsg"] = "Operação inválida";
            return view('Escalas/escala', $param);
        }
        
    }

    public function update(Request $request){
        Security('escalas');

        $validated = $request->validate([
            'descricao' => 'required',
            'tipo' => 'required',
            'dataRef' => 'required',
            'escalaItems' => 'required',
        ]);

        if ($request){
            $escala = Escala::Find($request->id);
            $escala->descricao = $request->descricao;
            $escala->updated_by = auth()->user()->id;
            $escala->save();

            if ($request->escalaItems != ""){
                $jsonText = $request->escalaItems;
                $decodedText = html_entity_decode($jsonText);
                $items = json_decode($decodedText);

                if($request->tipo != "Avulso"){
                    if(Count($items) != $request->qtdeEscalas){
                        throw ValidationException::withMessages(['Msg-1' => 'Existe repertório não definido!', 'Msg-2' => 'Por Favor verificar a escala.']);
                    }
                }

                if(isset($items)){
                    foreach ($items as $key => $item) {
                        $date = str_replace("/", "-", $item->itemDataEventoData." ".$item->itemDataEventoTime.":00");
                        $dt = new DateTime($date);

                        $repertorio = Repertorio::Find($item->itemRepertorio);
                        if(!$repertorio){
                            $repertorio = new Repertorio;
                            $repertorio->tipo = $item->itemTipo;
                            $repertorio->status = 4; //Insert sempre será 4 (Sem música)
                            $repertorio->dataEvento = $dt->format('Y-m-d H:i');
                            $repertorio->idMinisterio = $item->itemMinisterio;
                            $repertorio->descricao = $item->itemDescricao;
                            $repertorio->created_By = auth()->user()->id;
                            $repertorio->updated_By = auth()->user()->id;
                            $repertorio->save();

                            $escalaRepertorio = new EscalaRepertorio;
                            $escalaRepertorio->idEscala = $request->id;
                            $escalaRepertorio->idRepertorio = $repertorio->id;
                            $escalaRepertorio->save();
                        }else{
                            $repertorio->dataEvento = $dt->format('Y-m-d H:i');
                            $repertorio->idMinisterio = $item->itemMinisterio;
                            $repertorio->descricao = $item->itemDescricao;
                            $repertorio->updated_By = auth()->user()->id;
                            $repertorio->save();
                        }
                    }
                }

                $jsonText = $request->removeItems;
                $decodedText = html_entity_decode($jsonText);
                $items = json_decode($decodedText);
                if(isset($items)){
                    foreach ($items as $item) {
                        $repertorioDel = Repertorio::Find($item->id);
                        $repertorioDel->delete();

                        $escalaRepertorioDel = EscalaRepertorio::where('idEscala', $request->id)->where('idRepertorio', $item->id);
                        $escalaRepertorioDel->delete();
                    }
                }
            }

            MailSend::AlteraEscala($escala->id);

            return redirect()->action([Escalas::class, 'index']);

        }else{
            $param["title"] = "Nova Escala";
            $param["users"] = User::all()->sortBy('id');
            $param["errorMsg"] = "Operação inválida";
            return view('Escalas/escala', $param);
        }
    }

    public function delete(Request $request){
        Security('escalas');

        $validated = $request->validate([
            'id' => 'required'
        ]);

        $escala = Escala::Find($request->id);

        if ($request){          
            
            $escala->delete();

            return redirect()->action([Escalas::class, 'index']);
        }else{
            $param["errorMsg"] = "Operação inválida";
            $param["title"] = "Excluir escala";
            return $this->openView('Escalas/escala', $param, 'escala');  
        }
    }
}