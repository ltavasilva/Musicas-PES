<?php
namespace App\Classes;

use PhpParser\Node\Stmt\TryCatch;

class DiaSemana{
    public $id;
    public $descricao;
    public $tipo;

    public function __construct($id, $descricao, $tipo)
    {
        $this->id = $id;   
        $this->descricao = $descricao;
        $this->tipo = $tipo;
    }
}