<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class ProfessorModel extends Authenticatable
{
    use HasFactory;

    /**
     * Define o nome da tabela no banco de dados.
     * @var string
     */
    protected $table = 'professores';

    /**
     * Define a chave primária personalizada.
     * @var string
     */
    protected $primaryKey = 'cpf';

    /**
     * Indica se a chave primária é auto-incrementável.
     * @var bool
     */
    public $incrementing = false;

    /**
     * Define o tipo da chave primária.
     * @var string
     */
    protected $keyType = 'string';

    protected $fillable = [
        'cpf',
        'nome',
        'email',
        'password',
        'role',
    ];

    /**
     * Os atributos que devem ser ocultados para serialização, incluindo remember_token.
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token', // ⬅️ Essencial para a função "Lembrar de Mim"
    ];

    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed', // Garante que a senha seja hashed automaticamente
        'email_verified_at' => 'datetime',
    ];
}
