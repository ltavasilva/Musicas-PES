<?php

namespace App\Http\Controllers;

use App\Models\Repertorio;
use App\Models\Categoria;
use App\Models\RepertorioMusica;
use Illuminate\Http\Request;

class Pascom extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    private function loadRepertorio($id=null) {
        $param["repertorio"] = Repertorio::Find($id);
        
        if($param["repertorio"]){
            $param["ministerio"] = $param["repertorio"]->ministerio()->first();
            $repertorioMusicas = $param["repertorio"]->musicas()->get();
            $param["categorias"] = Categoria::musicaCategoria()->get()->sortBy('tipo')->sortBy('categoria');
            
            $list = array();
            foreach ($repertorioMusicas as &$repMusica) {
                $repMusica['info']=RepertorioMusica::where('idRepertorio', $id)
                    ->where('idMusica', $repMusica->id)->first();
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
                $mus["motivo"] = $repMusica['info']->motivo;
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

    public function index()
    {
        Security('pascom');

        $param["title"] = "Repertórios disponíveis";
        $param["repertorios"] = Repertorio::where('status', 2)->get();

        return view('pascom.repertorios', $param);
    }

    public function view($id) {
        Security('pascom');

        $param = $this->loadRepertorio($id);
        $param["title"] = "Ver repertorio";
        $param["repertorio"] = Repertorio::Find($id)->first();
        $param["submit"] = false;
        $param["editing"] = false;
        $param["formAction"] = "repertorio/view/$id";

        return $this->openView('pascom.repertorio', $param, 'repertorio');  
    }
}
