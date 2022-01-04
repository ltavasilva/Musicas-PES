<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ministerio extends Model
{
    public function repertorios(){
        return $this->hasMany(Repertorio::class, 'idMinisterio', 'id');
    }

    public function membros(){
        return $this->belongsToMany(User::class, 'ministerio_membros', 'idMinisterio', 'userId');
    }
}
