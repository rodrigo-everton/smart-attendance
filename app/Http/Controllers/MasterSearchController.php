<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controller as BaseController;
use App\Models\ProfessorModel;
use App\Models\AlunoModel;
use App\Models\Materia;

class MasterSearchController extends BaseController
{
    public function searchProfessores(Request $request)
    {
        $query = $request->input('q');
        
        $professores = ProfessorModel::with('materias')
            ->where('nome', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('cpf', 'like', "%{$query}%")
            ->get();

        return response()->json($professores);
    }

    public function searchAlunos(Request $request)
    {
        $query = $request->input('q');

        $alunos = AlunoModel::with('materias')
            ->where('nome', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('ra', 'like', "%{$query}%")
            ->orWhere('cpf', 'like', "%{$query}%")
            ->get();

        return response()->json($alunos);
    }

    public function searchMaterias(Request $request)
    {
        $query = $request->input('q');

        $materias = Materia::query()
            ->with(['professores', 'alunos']) // Carrega contagens/relacionamentos se necessário
            ->where('nome', 'like', "%{$query}%")
            ->orWhere('sala', 'like', "%{$query}%")
            ->get()
            ->map(function($materia) {
                // Adiciona contagens para ajudar no front
                $materia->professores_count = $materia->professores->count();
                $materia->alunos_count = $materia->alunos->count();
                return $materia;
            });

        return response()->json($materias);
    }
}
