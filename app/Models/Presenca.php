<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presenca extends Model
{
    use HasFactory;

    protected $table = 'presencas';

    protected $fillable = [
        'aluno_ra',
        'professor_cpf',
        'materia_id',
        'data_aula',
        'semestre',
        'horario',
        'codigo_aula',
    ];

    public function aluno()
    {
        return $this->belongsTo(AlunoModel::class, 'aluno_ra', 'ra');
    }

    public function professor()
    {
        return $this->belongsTo(ProfessorModel::class, 'professor_cpf', 'cpf');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
}
