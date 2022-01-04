<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserPerfil extends Model
{
    protected $table="Users_Perfil";

    protected $fillable = [
        'created_at',
        'updated_at',
    ];

    public function getCreatedAtAttribute($value){
        $result = Carbon::parse($value)->format('d/m/Y H:i');

        return $result;
    }

    public function getUpdatedAtAttribute($value){
        $result = Carbon::parse($value)->format('d/m/Y H:i');

        return $result;
    }

    public function userCria(){
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userAltera(){
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}