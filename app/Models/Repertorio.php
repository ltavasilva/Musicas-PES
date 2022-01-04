<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Repertorio extends Model
{
    protected $fillable = [
        'dataEvento',
    ];

    protected $appends = [
        'statusStr',
        'statusIcon',
        'statusClass',
        'statusCard',
        'statusColor',
        'DataEventoDateBr',
        'DataEventoDate',
        'DataEventoTime',
    ];

    public function getDataEventoAttribute($value){
        $result = Carbon::parse($value)->format('d/m/Y H:i');

        return $result;
    }
    public function getDataEventoDateAttribute(){
        $result = Carbon::parse(str_replace("/", "-", $this->dataEvento))->format('Y-m-d');

        return $result;
    }
    public function getDataEventoDateBrAttribute(){
        $result = Carbon::parse(str_replace("/", "-", $this->dataEvento))->format('d/m/Y');

        return $result;
    }
    public function getDataEventoTimeAttribute(){
        $valor = str_replace("/", "-", $this->dataEvento);
        $result = Carbon::parse($valor)->format('H:i');

        return $result;
    }

    public function getStatusStrAttribute(){
        $status = RepertorioStatus::Find($this->status);
        return $status->descricao;
    }

    public function getStatusIconAttribute(){
        $status = RepertorioStatus::Find($this->status);
        return $status->icon;
    }

    public function getStatusClassAttribute(){
        $status = RepertorioStatus::Find($this->status);
        return $status->tableStyle;
    }

    public function getStatusCardAttribute(){
        $status = RepertorioStatus::Find($this->status);
        return $status->objetoStyle;
    }

    public function getStatusColorAttribute(){
        $status = RepertorioStatus::Find($this->status);
        return str_replace('bg', 'text', $status->objetoStyle);
    }

    public function musicas(){
        return $this->belongsToMany(Musica::class, 'repertorio_musicas', 'idRepertorio', 'idMusica');
    }

    public function ministerio(){
        return $this->hasOne(Ministerio::class, 'id', 'idMinisterio');
    }
}