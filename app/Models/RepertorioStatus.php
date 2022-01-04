<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RepertorioStatus extends Model
{
    protected $appends = [
        'statusStr',
        'statusIcon',
        'statusClass',
        'statusColor',
    ];

    protected $table="repertorio_status";

    public function getStatusStrAttribute(){
        $status = RepertorioStatus::Find($this->aprovado);
        return $status->descricao;
    }

    public function getStatusIconAttribute(){
        $status = RepertorioStatus::Find($this->aprovado);
        return $status->icon;
    }

    public function getStatusClassAttribute(){
        $status = RepertorioStatus::Find($this->aprovado);
        return $status->tableStyle;
    }

    public function getStatusCardAttribute(){
        $status = RepertorioStatus::Find($this->aprovado);
        return $status->objetoStyle;
    }

    public function getStatusColorAttribute(){
        $status = RepertorioStatus::Find($this->aprovado);
        return str_replace('bg', 'text', $status->objetoStyle);
    }
}