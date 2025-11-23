<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Importante
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aluno extends Authenticatable // Altere de Model para Authenticatable
{
    use HasFactory;

    // Indica que a chave primária é 'ra' e é string
    protected $primaryKey = 'ra';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ra',
        'nome',
        'email',
        'password',
    ];
}
