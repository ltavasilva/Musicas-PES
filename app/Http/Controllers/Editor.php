<?php

namespace App\Http\Controllers;

class Editor extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        Security('editor');
        $param["title"] = "Editor de texto para o painel de LED";
        return view('tools/editor', $param);  
    }
}
