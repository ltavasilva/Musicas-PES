<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Escala extends Model
{
    protected $appends = [
        'DataEventoDateBr',
        'DataEventoDate',
    ];

    public function getDataEventoDateAttribute(){
        $result = Carbon::parse(str_replace("/", "-", $this->dataRef))->format('Y-m-d');

        return $result;
    }
    public function getDataEventoDateBrAttribute(){
        $result = Carbon::parse(str_replace("/", "-", $this->dataRef))->format('d/m/Y');

        return $result;
    }

    public function escalas(){
        return $this->hasMany(EscalaRepertorio::class, 'idEscala', 'id');
    }

    public function tipo(){
        return $this->hasOne(EscalaTipo::class, 'id', 'tipo');
    }

    public function repertorios(){
        return $this->belongsToMany(Repertorio::class, 'escala_repertorios', 'idEscala', 'idRepertorio');        
    }

    public function template(){
        return RepertorioTemplate::whereIn('tipo', array('Template_DDS','Template_FDS','Avulso'));    
    }
}