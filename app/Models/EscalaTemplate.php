<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EscalaTemplate extends Model
{

    protected $fillable = [
        'idDiaSemana',
    ];

    protected $appends = [
        'idDiaSemanaStr',
    ];

    public function ministerio(){
        return $this->hasOne(Ministerio::class, 'id', 'idMinisterio');
    }
    
    public function getIdDiaSemanaStrAttribute(){        
        switch ($this->idDiaSemana) {
            case 0:
                $result = "Domingo";
                break;
            case 1:
                $result = "Segunda";
                break;
            case 2:
                $result = "Terça";
                break;
            case 3:
                $result = "Quarta";
                break;
            case 4:
                $result = "Quinta";
                break;
            case 5:
                $result = "Sexta";
                break;
            case 6:
                $result = "Sábado";
                break;

                                                                                                                            
            default:
                $result = "";
                break;
        }

        return $result;
    }
}