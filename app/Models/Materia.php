<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $fillable = [
        'nome',
        'horario_matutino',
        'horario_vespertino',
        'horario_noturno',
        'sala',
        'carga_horaria',
    ];

    public function alunos()
    {
        return $this->belongsToMany(AlunoModel::class, 'aluno_materia', 'materia_id', 'aluno_ra');
    }

    public function professores()
    {
        return $this->belongsToMany(ProfessorModel::class, 'materia_professor', 'materia_id', 'professor_cpf');
    }
}
