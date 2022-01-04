<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Ministerio;
use App\Models\Musica;
use App\Models\Categoria;
use App\Models\EscalaTipo;
use App\Models\Escala;
use App\Models\RepertorioTemplate;
use App\Models\EscalaTemplate;
use App\Classes\DiaSemana;
use DateTime;
use PhpParser\Node\Expr\Cast\Object_;

class EscalaTemplates extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');   
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

    public function loadDatabase($id = null){
        $param["template"] = EscalaTemplate::Find($id);
        if($param["template"]){
            $param["template"]->ministerio = $param["template"]->ministerio();
        }
        
        $param["missaTemplates"] = RepertorioTemplate::all();
        $lista = Array();
        for ($idSemanaMes=1; $idSemanaMes <= 5 ; $idSemanaMes++) {
            for ($idDiaSemana=0; $idDiaSemana <= 6 ; $idDiaSemana++) { 
                $missas = RepertorioTemplate::Where('idDiaSemana', '=', $idDiaSemana)->get();
                foreach ($missas as $missa) {

                    $ds = EscalaTemplate::Where('idSemanaMes', '=', $idSemanaMes)->Where('idDiaSemana', '=', $idDiaSemana)->Where('idRepertorioTemplate', '=', $missa->id)->First();
                    if($ds){
                        $missa->idMinisterio = $ds->idMinisterio;
                        $ds->ministerio = Ministerio::Find($missa->idMinisterio);
                        $ds->missa = $missa;
                    }else{
                        $ds = new EscalaTemplate; 
                        $ds->idSemanaMes = $idSemanaMes;
                        $ds->idDiaSemana = $idDiaSemana;
                        $ds->idRepertorioTemplate = $missa->id;
                        $ds->idMinisterio = 0;
                        $ds->created_By = auth()->user()->id;
                        $ds->updated_By = auth()->user()->id;
                        $ds->save();

                        $ds->ministerio = Null;
                        $ds->missa = $missa;
                    }
                    $lista[] = $ds;
                }
            }
        }

        $param["escalaTemplates"] = $lista;
        $param["ministerios"] = Ministerio::all();
        return $param;
    }

    public function index(){
        Security('coordenador');

        $param = $this->loadDatabase();
        $param["title"] = "Template de Escalas";
        $param["submit"] = true;
        $param["editing"] = true;
        $param["formAction"] = "escalaTemplates";
        
        return $this->openView('templates.escalaTemplates', $param);  
    }

    public function update(Request $request){
        Security('coordenador');
        
        $validated = $request->validate([
            'id' => 'required',
            'idMinisterio' => 'required',   
        ]);

        $template = EscalaTemplate::Find($request->id);

        if ($request){
            $template->idMinisterio = $request->idMinisterio;
            $template->updated_By = auth()->user()->id;
            $template->save();

            return redirect()->action([EscalaTemplates::class, 'index']);

        }else{
            $param["errorMsg"] = "Operação inválida";
            $param["title"] = "Alteração de template de escalas";
            return $this->openView('Templates.escalaTemplates', $param, 'template');  
        }
    }

    public function delete(Request $request){
        Security('coordenador');

        $validated = $request->validate([
            'id' => 'required'
        ]);

        $template = EscalaTemplate::Find($request->id);

        if ($request){          
            
            $template->delete();

            return redirect()->action([EscalaTemplates::class, 'index']);
        }else{
            $param["errorMsg"] = "Operação inválida";
            $param["title"] = "Novo template";
            return $this->openView('Templates.escalaTemplates', $param, 'template');  
        }
    }
}