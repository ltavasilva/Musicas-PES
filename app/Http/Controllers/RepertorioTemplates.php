<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Ministerio;
use App\Models\Musica;
use App\Models\Categoria;
use App\Models\EscalaTipo;
use App\Models\Repertorio;
use App\Models\RepertorioTemplate;
use App\Classes\DiaSemana;
use Carbon\Carbon;
use DateTime;

class RepertorioTemplates extends Controller
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
        $param["template"] = RepertorioTemplate::Find($id);
        $param["templates"] = RepertorioTemplate::all();
        $param["tipos"] = EscalaTipo::all();
        $param["ministerios"] = Ministerio::all();

        $dias[] = new DiaSemana(0, "Domingo", "FDS");
        $dias[] = new DiaSemana(1, "Segunda", "DDS");
        $dias[] = new DiaSemana(2, "Terça",   "DDS");
        $dias[] = new DiaSemana(3, "Quarta",  "DDS");
        $dias[] = new DiaSemana(4, "Quinta",  "DDS");
        $dias[] = new DiaSemana(5, "Sexta",   "DDS");
        $dias[] = new DiaSemana(6, "Sabado",  "FDS");

        $param["dias"] = $dias;

        return $param;
    }

    public function index(){
        Security('coordenador');

        $param = $this->loadDatabase();
        $param["title"] = "Template de repertorios";
        $param["submit"] = true;
        $param["editing"] = true;
        $param["formAction"] = "repertorioTemplates";
        
        return $this->openView('templates.repertorioTemplates', $param);  
    }

    public function insert(Request $request){
        Security('coordenador');

        $validated = $request->validate([
            'descricao' => 'required',
            'tipo' => 'required',
            'idDiaSemana' => 'required',
            'dataEvento' => 'required',            
            'horaEvento' => 'required'      
        ]);
        

        if ($request){
            $template = new RepertorioTemplate;

            if($request->tipo == "Avulso"){
                $dt = new DateTime($request->dataEvento);
                $template->dataEvento = $dt->format('Y-m-d');
            }else{
                $dt = new DateTime($request->dataEvento." ".$request->horaEvento.":00");
                $template->dataEvento = $dt->format('Y-m-d H:i');
            }

            $template->idMinisterio = 0;
            $template->tipo = $request->tipo;
            $template->status = 1;
            $template->idDiaSemana = $request->idDiaSemana;
            $template->descricao = $request->descricao;
            $template->created_By = auth()->user()->id;
            $template->updated_By = auth()->user()->id;
            $template->save();

            return redirect()->action([RepertorioTemplates::class, 'index']);

        }else{
            $param["errorMsg"] = "Operação inválida";
            $param["title"] = "Novo template";
            return $this->openView('Templates.repertorioTemplates', $param, 'template');  
        }
    }

    public function update(Request $request){
        Security('coordenador');
        
        $validated = $request->validate([
            'descricao' => 'required',
            'tipo' => 'required',
            'idDiaSemana' => 'required',
            'dataEvento' => 'required',            
            'horaEvento' => 'required',   
        ]);

        $template = RepertorioTemplate::Find($request->id);

        if ($request){
            $dt = new DateTime($request->dataEvento." ".$request->horaEvento.":00");

            $template->dataEvento = $dt->format('Y-m-d H:i');
            $template->idMinisterio = 0;
            $template->tipo = $request->tipo;
            $template->status = 1;
            $template->idDiaSemana = $request->idDiaSemana;
            $template->descricao = $request->descricao;
            $template->updated_By = auth()->user()->id;
            $template->save();

            return redirect()->action([RepertorioTemplates::class, 'index']);

        }else{
            $param["errorMsg"] = "Operação inválida";
            $param["title"] = "Novo template";
            return $this->openView('Templates.repertorioTemplates', $param, 'template');  
        }
    }

    public function delete(Request $request){
        Security('coordenador');

        $validated = $request->validate([
            'id' => 'required'
        ]);

        $template = RepertorioTemplate::Find($request->id);

        if ($request){          
            
            $template->delete();

            return redirect()->action([RepertorioTemplates::class, 'index']);
        }else{
            $param["errorMsg"] = "Operação inválida";
            $param["title"] = "Novo template";
            return $this->openView('Templates.repertorioTemplates', $param, 'template');  
        }
    }
}