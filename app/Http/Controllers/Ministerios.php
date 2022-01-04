<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Classes\Controle;
use App\Models\User;
use App\Models\Ministerio;
use App\Models\MinisterioMembros;

class Ministerios extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function loadMinisterio($id) {
        $param["users"] = User::all()->sortBy('id');
        $param["ministerio"] = Ministerio::Find($id);
        $param["ministerio"]->membros = $param["ministerio"]->membros()->get();
        $list = array();
        foreach ($param["ministerio"]->membros as $membro) {
            $mem["id"] = $membro->id;
            $list[] = $mem;
        }
        $param["ministerio"]->membrosJson = json_encode ($list);

        $arr = $param["ministerio"]->membros->pluck('id')->toArray();

        $list = array_values($arr);
        $naoMembros = Array();
        foreach ($param["users"] as $user) {
            if(array_search($user->id, $list) === false){        
                $naoMembros[] = $user;
            }
        }
        $param["ministerio"]->naoMembros = $naoMembros;

        $param["isAdmin"] = ($param["ministerio"]->coordenador == auth()->user()->id || $param["ministerio"]->coordenador == auth()->user()->id || isCoordenador());
        $param["ministerios"] = Ministerio::all()->sortBy('id');
        
        foreach ($param["ministerios"] as &$ministerio) {
            $ministerio->listar = ($ministerio->coordenador == auth()->user()->id || $ministerio->coordenador == auth()->user()->id || isCoordenador());
            $coordenador = User::where('id', $ministerio->coordenador)->get()->first();
            $corresponsavel = User::where('id', $ministerio->corresponsavel)->get()->first();
            $ministerio->membros = $ministerio->membros()->get();
            $ministerio["coordenador"] =  $coordenador;
            $ministerio["corresponsavel"] = $corresponsavel;            
        }
        return $param;
    }
    
    public function index(){
        Security('ministerios');
        $param["title"] = "Ministérios de música";
        $param["editing"] = true;
        $param["ministerios"] = Ministerio::all()->sortBy('id');
        
        foreach ($param["ministerios"] as &$ministerio) {
            $ministerio->listar = ($ministerio->coordenador == auth()->user()->id || $ministerio->coordenador == auth()->user()->id || isCoordenador());
            $coordenador = User::where('id', $ministerio->coordenador)->get()->first();
            $corresponsavel = User::where('id', $ministerio->corresponsavel)->get()->first();
            $ministerio->membros = $ministerio->membros()->get();
            $ministerio["coordenador"] =  $coordenador;
            $ministerio["corresponsavel"] = $corresponsavel;
            
        }
        return view('ministerios/ministerios', $param);  
    }

    public function view($id) {
        Security('ministerios');
        $param = $this->loadMinisterio($id);
        $param["title"] = "Ver Ministério";
        $param["submit"] = false;
        $param["editing"] = false;
        $param["mode"] = "view";
        $param["formAction"] = "ministerio/view/$id";

        return view('ministerios/ministerio', $param);  
    }

    public function novo() {
        Security('ministerios');
        $param["title"] = "Novo Ministério";
        $param["users"] = User::all()->sortBy('id');
        $param["isAdmin"] = true;
        $param["ministerio"] = new Ministerio;
        $param["ministerio"]->naoMembros = $param["users"];
        $param["ministerio"]->ativo = 1;
        $param["submit"] = isCoordenador();
        $param["editing"] = false;
        $param["mode"] = "new";
        $param["formAction"] = "ministerios/insert";

        return view('ministerios/ministerio', $param);  
    }

    public function edit($id) {
        Security('ministerios');
        $param = $this->loadMinisterio($id);
        $param["title"] = "Editar Ministério";
        $param["submit"] = $param["isAdmin"];
        $param["editing"] = $param["isAdmin"];
        $param["mode"] = "edit";
        $param["formAction"] = "ministerios/update";

        return view('ministerios/ministerio', $param);  
    }

    public function insert(Request $request){
        Security('ministerios');
        $ministerio = new Ministerio;

        $validated = $request->validate([
            'nome' => 'required',
            'coordenador' => 'required',
            'membrosJson' => 'required',
        ]);

        $jsonText = $request->membrosJson;
        $decodedText = html_entity_decode($jsonText);
        $membros = json_decode($decodedText);
        foreach ($membros as $membro) {
            if($membro->id == ""){
                throw ValidationException::withMessages(['Msg-1' => 'Nenhum membro foi definido!', 'Msg-2' => 'Por Favor verificar a lista de membros.']);
            }
        }

        if ($request){
            $ministerio->nome = $request->nome;
            $ministerio->coordenador = $request->coordenador;
            $ministerio->corresponsavel = $request->corresponsavel;
            $ministerio->ativo = $request->ativo;
            $ministerio->created_by = auth()->user()->id;
            $ministerio->updated_by = auth()->user()->id;
            $ministerio->save();

            foreach ($membros as $membro) {                
                $ministerioMembro = new MinisterioMembros;
                $ministerioMembro->idMinisterio = $ministerio->id;
                $ministerioMembro->userId = $membro->id;
                $ministerioMembro->created_by = auth()->user()->id;
                $ministerioMembro->updated_by = auth()->user()->id;
                $ministerioMembro->save();
            }

            return redirect()->action([Ministerios::class, 'index']);

        }else{
            $param["title"] = "Novo Ministério";
            $param["users"] = User::all()->sortBy('id');
            $param["errorMsg"] = "Operação inválida";
            return view('ministerios/ministerio', $param);
        }
    }

    public function update(Request $request){
        Security('ministerios');
        $ministerio = Ministerio::Find($request->id);

        $validated = $request->validate([
            'nome' => 'required',
            'coordenador' => 'required',
            'membrosJson' => 'required',
        ]);

        $jsonText = $request->membrosJson;
        $decodedText = html_entity_decode($jsonText);
        $membros = json_decode($jsonText);
        $val = Array();
        foreach ($membros as $membro) {
            array_push($val, $membro->id);
            if($membro->id == ""){
                throw ValidationException::withMessages(['Msg-1' => 'Nenhum membro foi definido!', 'Msg-2' => 'Por Favor verificar a lista de membros.']);
            }
        }

        if(array_search($request->coordenador, $val) === false){
            array_push($val, $request->coordenador);
        }
        if($request->corresponsavel != ""){
            if(array_search($request->corresponsavel, $val) === false){
                array_push($val, $request->corresponsavel);
            }
        }
        $membros = $val;

        if ($ministerio){
            $ministerio->nome = $request->nome;
            $ministerio->coordenador = $request->coordenador;
            $ministerio->corresponsavel = $request->corresponsavel;
            $ministerio->ativo = $request->ativo;
            if(is_Null($ministerio->ativo)){$ministerio->ativo = 0;}
            $ministerio->updated_by = auth()->user()->id;
            $ministerio->update();

            if(isset($membros)){
                MinisterioMembros::where('idMinisterio', $ministerio->id)->delete();
                foreach ($membros as $membro) {   
                    $ministerioMembro = new MinisterioMembros;       
                    $ministerioMembro->idMinisterio = $ministerio->id;
                    $ministerioMembro->userId = $membro;
                    $ministerioMembro->created_by = auth()->user()->id;
                    $ministerioMembro->updated_by = auth()->user()->id;
                    $ministerioMembro->save();
                }
            }

            return redirect()->action([Ministerios::class, 'index']);
        }
    }

    public function delete(Request $request){
        Security('ministerios');
        $ministerio = Ministerio::Find($request->id);

        if ($ministerio){          
            $ministerio->ativo = 0;
            $ministerio->updated_by = auth()->user()->id;
            
            $ministerio->update();

            return redirect()->action([Ministerios::class, 'view'], ['id' => $ministerio->id]);
        }
    }
}