<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PhpParser\Node\Stmt\TryCatch;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'device_key',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userPerfil(){
        $res = $this->hasOne(UserPerfil::class, 'userId', 'id');
        if (is_Null($res)){
            $res = New UserPerfil();
        }
        return $res;
    }

    public function ministerioCoord(){
        return $this->hasOne(Ministerio::class, 'coordenador', 'id');
    }

    public function ministerioCorresp(){
        return $this->hasOne(Ministerio::class, 'corresponsavel', 'id');
    }

    public function ministerios(){
        return $this->belongsToMany(Ministerio::class, 'ministerio_membros', 'userId', 'idMinisterio');
    }
}
