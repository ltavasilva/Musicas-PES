<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Classes\Controle;
use App\Models\Musica;
use App\Models\MusicaCategoria;
use App\Models\Categoria;
use PhpParser\Node\Stmt\TryCatch;

class Musicas extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
    }

    private function loadMusica($id) {
        $categoriaSel = MusicaCategoria::where('idMusica', $id)->get();
        $catSel = "";
        $sep = "";
        foreach ($categoriaSel as $key => $value) {
            $catSel .= $sep . $value->idCategoria;
            $sep = ",";
        }

        $param["categoriaSel"] = explode(',', $catSel);
        $param["categoria"] = Categoria::all()->sortBy('id')->sortBy('tipo');
        $param["musica"] = Musica::Find($id);
        $param["isAdmin"] = isCoordenador();

        return $param;
    }

    public function index() {
        isBloqued();
        $param["title"] = "Lista de musicas";
        $param["editing"] = true;
        $param["categoria"] = Categoria::all()->sortBy('id')->sortBy('tipo');
        $param["autores"] = Musica::select('autor')->distinct()->get();
        $param["musicas"] = Musica::all()->sortBy('id');
        $param["isAdmin"] = isCoordenador();
        
        foreach ($param["musicas"] as &$musica) {
            $categoriaSel = MusicaCategoria::where('idMusica', $musica->id)->get();
            
            $tipoList = "";
            $categoriaTipo = array();
            $categoriaArr = array();
            $sep = "";
            foreach ($categoriaSel as $catSel) {
                $cat = Categoria::where('id', $catSel->idCategoria)->get()->first();

                if (!in_array($cat->categoria, $categoriaArr)) { 
                    $categoriaArr[] = $cat->categoria;
                }
                if (!in_array($cat->tipo, $categoriaTipo)) { 
                    $categoriaTipo[] = $cat->tipo;
                }                
            }
            $musica["categorias"] =  $categoriaArr;
            $musica["tipos"] = $categoriaTipo;
            
        }

        return view('musicas/musicas', $param);  
    }
    
    public function view($id) {
        isBloqued();
        $param = $this->loadMusica($id);
        $param["title"] = "Ver musica";
        $param["submit"] = false;
        $param["editing"] = false;
        $param["formAction"] = "musicas/view/$id";

        return view('musicas/musica', $param);  
    }

    public function letra($id) {
        isBloqued();
        $param = $this->loadMusica($id);
        $param["title"] = "Letra da musica";
        $res = array("nome"=>$param["musica"]->nome, 
            "autor"=>$param["musica"]->autor,
            "letra"=>$param["musica"]->letra, 
            "slides"=>$param["musica"]->slides
        );
        return response()->json($res);
    }
    
    public function nova() {
        isBloqued();
        $param["title"] = "Nova musica";
        $param["categoriaSel"] = explode(',', ',');
        $param["categoria"] = Categoria::all()->sortBy('id')->sortBy('tipo');
        $param["musica"] = new Musica;
        $param["submit"] = true;
        $param["editing"] = false;
        $param["formAction"] = "musicas/insert";

        header('Access-Control-Allow-Origin: *');
        
        return view('musicas/musica', $param);  
    }

    public function edit($id) {
        isBloqued();
        $param = $this->loadMusica($id);
        $param["title"] = "Editar musica";
        $param["submit"] = true;
        $param["editing"] = true;
        $param["formAction"] = "musicas/update";

        return view('musicas/musica', $param);  
    }

    public function insert(Request $request){
        isBloqued();

        $validated = $request->validate([
            'musicaCategoria' => 'required',
            'nome' => 'required',
            'autor' => 'required',
            'letra' => 'required',
        ]);

        if ($request){
            $musica = new Musica;
            $musica->nome = $request->nome;
            $musica->autor = $request->autor;
            $musica->letra = $request->letra;
            $musica->slides = $request->slides;
            $musica->usuCriacao = auth()->user()->id;
            $musica->usuAlteracao = auth()->user()->id;
            $musica->save();

            $categorias = explode(";", $request->musicaCategoria);
            foreach ($categorias as $key => $categId) {
                $musicaCategoria = new MusicaCategoria;
                $musicaCategoria->idMusica = $musica->id;
                $musicaCategoria->idCategoria = $categId;
                $musicaCategoria->save();
            }

            return redirect()->action([Musicas::class, 'index']);

        }else{
            $param["categoria"] = Categoria::all()->sortBy('id')->sortBy('tipo');
            $param["errorMsg"] = "Operação inválida";
            $param["title"] = "Nova musica";
            return view('musicas/musica', $param);
        }

        
    }

    public function update(Request $request){
        isBloqued();

        $validated = $request->validate([
            'musicaCategoria' => 'required',
            'nome' => 'required',
            'autor' => 'required',
            'letra' => 'required',
        ]);

        $musica = Musica::Find($request->id);

        if ($musica){
            $musica->nome = $request->nome;
            $musica->autor = $request->autor;
            $musica->letra = $request->letra;
            $musica->slides = $request->slides;
            $musica->usuAlteracao = auth()->user()->id;
            
            $musica->update();

            return redirect()->action([Musicas::class, 'view'], ['id' => $musica->id]);
        }
    }

    public function delete(Request $request){
        isBloqued();
        $musica = Musica::Find($request->id);

        if ($musica){          
            $musica->delete();

            return redirect()->action([Musicas::class, 'index']);
        }
    }
}