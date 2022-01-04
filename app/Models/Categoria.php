<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Categoria extends Model
{
    public static function musicaCategoria(){
        return Categoria::join(DB::raw('(select distinct idCategoria from musica_categorias) as mucat'), 
        function($join)
        {
            $join->on('categorias.id', '=', 'mucat.idCategoria');
        });
    }
}