<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Musica extends Model
{
    public function categorias(){
        return $this->belongsToMany(Categoria::class, 'musica_categorias', 'idMusica', 'idCategoria');
    }
}
