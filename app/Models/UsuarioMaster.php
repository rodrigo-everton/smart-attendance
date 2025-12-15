<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UsuarioMaster extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UsuarioMasterFactory> */
    use HasFactory;

    protected $table = 'usuario_masters';

    protected $fillable = [
        'nome',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
}
