<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Ministerio;
use App\Models\Musica;
use App\Models\Categoria;
use App\Models\Repertorio;
use App\Models\RepertorioStatus;
use App\Models\RepertorioTemplate;
use App\Models\RepertorioMusica;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class Repertorios extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');   
    }

    private function loadRepertorio($id=null) {
        $param["repertorio"] = Repertorio::Find($id);
        $param["ministerios"] = Ministerio::All()->sortBy('nome');
        $param["status"] = RepertorioStatus::All();
        $param["musicas"] = Musica::all()->sortBy('nome');
        if($param["musicas"]){
            foreach ($param["musicas"] as &$musica) {
                $categoriasMusica = $musica->categorias()->get();
                $catMusSel = array();
                foreach ($categoriasMusica as $catMus) {
                    $catMusSel[]=$catMus->id;
                }
                $musica["categorias"] = implode(";", $catMusSel);
            }
        }

        if($param["repertorio"]){
            $param["ministerio"] = $param["repertorio"]->ministerio()->first();
            $param["ministerio"]->membros = $param["ministerio"]->membros()->get();
            $repertorioMusicas = $param["repertorio"]->musicas()->get();
            $param["categorias"] = Categoria::musicaCategoria()->get()->sortBy('tipo')->sortBy('categoria');
            
            $list = array();
            foreach ($repertorioMusicas as &$repMusica) {
                $repMusica['info']=RepertorioMusica::where('idRepertorio', $id)->where('idMusica', $repMusica->id)->first();
                $repMusica['categoria'] = $repMusica['info']->categoria()->first();
                $mus["idRepertorio"] = $id;
                $mus["sequencia"] = $repMusica['info']->sequencia;
                $mus["idMusica"] = $repMusica->id;
                $mus["aprovado"] = $repMusica['info']->aprovado;
                $mus["aprovadoStr"] = "<span class='{$repMusica['info']->getStatusColorAttribute()}'><i data-feather='{$repMusica['info']->getStatusIconAttribute()}'></i> {$repMusica['info']->getStatusStrAttribute()}</span>";
                $mus["idCategoria"] = $repMusica['categoria']->id;
                $mus["categoria"] = $repMusica['categoria']->categoria;
                $mus["nome"] = $repMusica->nome;
                $mus["autor"] = $repMusica->autor;
                $mus["motivo"] = (is_null($repMusica['info']->motivo)) ? '' : $repMusica['info']->motivo;
                $mus["letra"] = $repMusica->letra;
                $list[] = $mus;
            }
            $param["repertorio"]->musicasJson = json_encode ($list);
            $param["repertorioMusicas"] = json_decode ($param["repertorio"]->musicasJson, FALSE);
            
        }
        $jsonCategoria = Categoria::where('tipo', "=", "Missa")->whereNotIn("id", [11, 20, 21])->get()->sortBy('id')->toJson(JSON_HEX_TAG);
        $param["categoriasMissa"] = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $jsonCategoria);


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
        isBloqued();

        $param["title"] = "Lista de repertorios";
        $param["formAction"] = "repertorios";
        if(isCoordenador()){
            $param["ministerios"] = Ministerio::all();
            $param["coordenador"] = 1;
        }else{
            $param["coordenador"] = 0;

            $user = User::Find(auth()->user()->id);
            $param["ministerios"] = $user->ministerios()->get();
        }

        foreach ($param["ministerios"] as &$min) {
            if(isCoordenador()){
                if($min->coordenador == auth()->user()->id || $min->corresponsavel == auth()->user()->id){
                    $min->membro = 'membro';
                }else{
                    $min->membro = '';
                }
            }else{
                $min->membro = 'membro';
            }
        }
        
        $ministerioList = $param["ministerios"]->pluck('id')->toArray();
        

        $param["repertorios"] = Repertorio::whereIn('idMinisterio', $ministerioList)->get();
        foreach ($param["repertorios"] as &$rep) {
            $rep["ministerio"]=Ministerio::where('id', $rep->idMinisterio)->first();
            if(isCoordenador()){
                if($rep["ministerio"]->coordenador == auth()->user()->id || $rep["ministerio"]->corresponsavel == auth()->user()->id){
                    $rep->membro = 'membro';
                }else{
                    $rep->membro = '';
                }
            }else{
                $rep->membro = 'membro';
            }
        }

        $param["musicas"] = Musica::all();

        if($param["ministerios"]->isEmpty()){
            $param["errorMsg"] = "Você não está registrado em um Ministério de música. Peça ao administrador para te registrar";
        }

        $param["dataIni"] = Carbon::now()->format('Y-m-d');
        $dataFim = Carbon::now();
        $dataFim->addDays(15);
        $param["dataFim"] = $dataFim->format('Y-m-d');

        return $this->openView('repertorios.repertorios', $param);  
        //return $this->openView('repertorios.teste');  
    }

    public function musicas($id){
        isBloqued();

        $param = $this->loadRepertorio($id);
        $param["title"] = "Repertório::Músicas";

        if(!isCoordenador()){
            checkContentAccess($param["ministerio"]->membros, 'id', auth()->user()->id);
        }

        return $this->openView('repertorios.musicas', $param);  
    }
    
    public function view($id) {
        isBloqued();
        $param = $this->loadRepertorio($id);

        if(!isCoordenador()){
            checkContentAccess($param["ministerio"]->membros, 'id', auth()->user()->id);
        }

        $param["title"] = "Ver repertorio";
        $param["mode"] = "Viewrem";
        $param["submit"] = false;
        $param["editing"] = false;
        $param["formAction"] = "repertorios/view/$id";

        return $this->openView('repertorios.repertorio', $param, 'repertorio');  
    }

    public function novo($idMinisterio = 0) {
        isBloqued();
        $param = $this->loadRepertorio();
        $param["repertorio"] = new Repertorio();
        $param["repertorio"]->idMinisterio = $idMinisterio;
        $param["categorias"] = Categoria::musicaCategoria()->get()->sortBy('tipo')->sortBy('categoria');
        $param["repertorio"]->status = 1;
        $param["ministerio"] = Ministerio::Find($idMinisterio);
        $param["title"] = "Novo repertório";
        $param["mode"] = "New";
        $param["submit"] = true;
        $param["editing"] = true;
        $param["formAction"] = "repertorios/insert";

        return $this->openView('repertorios.repertorio', $param, 'repertorio');  
    }

    public function edit($id) {
        isBloqued();
        $param = $this->loadRepertorio($id);

        if(!isCoordenador()){
            checkContentAccess($param["ministerio"]->membros, 'id', auth()->user()->id);
        }
        
        $param["title"] = "Editar repertorio";
        $param["mode"] = "Edit";
        $param["submit"] = true;
        $param["editing"] = true;
        $param["formAction"] = "repertorios/update";

        return $this->openView('repertorios.repertorio', $param, 'repertorio');  
    }

    public function insert(Request $request){
        isBloqued();

        $validated = $request->validate([
            'idMinisterio' => 'required',
            'descricao' => 'required',
            'tipo' => 'required',
            'dataEvento' => 'required',            
            'horaEvento' => 'required',        
            'musicasJson' => 'required',
        ]);

        $jsonText = $request->musicasJson;
        $decodedText = html_entity_decode($jsonText);
        $musicas = json_decode($decodedText);
        foreach ($musicas as $musica) {
            if($musica->idMusica == ""){
                throw ValidationException::withMessages(['Msg-1' => 'Existe musica não definida!', 'Msg-2' => 'Por Favor verificar a lista de músicas.']);
            }
        }

        if ($request){
            $repertorio = new Repertorio;
            $repertorio->dataEvento = $request->dataEvento;
            $repertorio->idMinisterio = $request->idMinisterio;
            $repertorio->tipo = $request->tipo;
            $repertorio->status = $request->status;
            $repertorio->descricao = $request->descricao;
            $repertorio->created_By = auth()->user()->id;
            $repertorio->updated_By = auth()->user()->id;
            $repertorio->save();

            foreach ($musicas as $musica) {                
                $repertorioMusica = new RepertorioMusica;
                $repertorioMusica->idRepertorio = $repertorio->id;
                $repertorioMusica->sequencia = $musica->sequencia;
                $repertorioMusica->idMusica = $musica->idMusica;
                $repertorioMusica->aprovado = ($request->tipo == "Geral") ? 2 : $musica->aprovado;
                $repertorioMusica->idCategoria = $musica->idCategoria;
                $repertorioMusica->save();
            }

            return redirect()->action([Repertorios::class, 'index']);

        }else{
            $param["errorMsg"] = "Operação inválida";
            $param["title"] = "Novo repertório";
            return $this->openView('repertorios.repertorio', $param, 'repertorio');  
        }
    }

    public function update(Request $request){
        isBloqued();

        if ($request->musicasJson != ""){
            $jsonText = $request->musicasJson;
            $decodedText = html_entity_decode($jsonText);
            $musicas = json_decode($decodedText);

            $repertorioMusica = array();
            foreach ($musicas as $musica) {
                $mus = Musica::Find($request->idMusica);
                $repertorioMusica[] = $mus;
            }
            $request->repertorioMusica = $repertorioMusica;
        }

        $validated = $request->validate([
            'idMinisterio' => 'required',
            'dataEvento' => 'required',
            'tipo' => 'required',
            'descricao' => 'required',
            'musicasJson' => 'required',
        ]);

        $repertorio = Repertorio::Find($request->id);

        if ($request){
            $repertorio->dataEvento = $request->dataEvento;
            $repertorio->idMinisterio = $request->idMinisterio;
            $repertorio->tipo = $request->tipo;
            $repertorio->status = ($request->tipo == "Geral") ? 2 : 1;
            $repertorio->descricao = $request->descricao;
            $repertorio->updated_By = auth()->user()->id;
            $repertorio->save();

            
            if(isset($musicas)){
                RepertorioMusica::where('idRepertorio', $repertorio->id)->delete();
                foreach ($musicas as $musica) {
                    
                    $repertorioMusica = new RepertorioMusica;
                    $repertorioMusica->idRepertorio = $repertorio->id;
                    $repertorioMusica->sequencia = $musica->sequencia;
                    $repertorioMusica->idMusica = $musica->idMusica;
                    $repertorioMusica->aprovado = ($request->tipo == "Geral") ? 2 : 1;
                    $repertorioMusica->idCategoria = $musica->idCategoria;
                    $repertorioMusica->save();
                }
            }

            return redirect()->action([Repertorios::class, 'index']);

        }else{
            $param["errorMsg"] = "Operação inválida";
            $param["title"] = "Novo repertório";
            return $this->openView('repertorios.repertorio', $param, 'repertorio');  
        }
    }

    public function delete(Request $request){
        isBloqued();

        $validated = $request->validate([
            'id' => 'required'
        ]);

        if ($request){    
            $repertorio = Repertorio::Find($request->id);
            RepertorioMusica::where('idRepertorio', $repertorio->id)->delete();      
            
            $repertorio->delete();

            return redirect()->action([Repertorios::class, 'index']);
        }else{
            $param["errorMsg"] = "Operação inválida";
            $param["title"] = "Excluir escala";
            return $this->openView('repertorios.repertorio', $param, 'escala');  
        }
    }
}