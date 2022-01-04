<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RepertorioTemplate extends Model
{
    protected $fillable = [
        'dataEvento',
    ];

    protected $appends = [
        'tipoStr',
        'DataEventoDate',
        'DataEventoTime',
        'DataEventoDateBr',
    ];

    public function getDataEventoAttribute($value){
        $result = Carbon::parse($value)->format('Y/m/d H:i:s');

        return $result;
    }
    public function getDataEventoDateAttribute(){
        $result = Carbon::parse(str_replace("/", "-", $this->dataEvento))->format('Y-m-d');

        return $result;
    }
    public function getDataEventoTimeAttribute(){
        $valor = str_replace("/", "-", $this->dataEvento);
        $result = Carbon::parse($valor)->format('H:i');

        return $result;
    }

    public function getDataEventoDateBrAttribute(){
        $result = Carbon::parse(str_replace("/", "-", $this->dataEvento))->format('d/m/Y');

        return $result;
    }

    public function getTipoStrAttribute(){
        $template = EscalaTipo::Where('tipo', $this->tipo)->first();
        return $template->descricao;
    }
}