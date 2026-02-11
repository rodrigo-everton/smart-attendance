<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // O correto é usar este, não o Model padrão

class AlunoModel extends Authenticatable
{
    use HasFactory;

    /**
     * Define o nome da tabela no banco de dados.
     * @var string
     */
    protected $table = 'alunos';

    // Indica que a chave primária é 'ra' e é string
    protected $primaryKey = 'ra';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ra',
        'cpf', // Você tem CPF na migração, então deve estar no Model.
        'nome',
        'email',
        'password',
        'role', // ⬅️ Essencial para o redirecionamento baseado na role
    ];

    /**
     * Os atributos que devem ser ocultados para serialização.
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
        'password' => 'hashed',
        'email_verified_at' => 'datetime',
    ];

    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'aluno_materia', 'aluno_ra', 'materia_id')
            ->withPivot('prova1', 'trabalho1', 'trabalho2', 'prova2', 'id')
            ->withTimestamps();
    }
}
