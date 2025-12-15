<?php

namespace App\Http\Controllers;

use App\Http\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends BaseController
{
    /**
     * Exibe a dashboard do Professor.
     */
    public function professorIndex()
    {
        $professor = Auth::guard('professores')->user();
        return view('professor.home', compact('professor'));
    }

    /**
     * Exibe a dashboard do Aluno.
     */
    public function alunoIndex()
    {
        $aluno = Auth::guard('alunos')->user();
        return view('aluno.home', compact('aluno'));
    }

    /**
     * Exibe a dashboard do Master (Admin).
     */
    public function masterIndex()
    {
        $master = Auth::guard('masters')->user();
        
        $professoresCount = \App\Models\ProfessorModel::count();
        $alunosCount = \App\Models\AlunoModel::count();
        $materiasCount = \App\Models\Materia::count();

        $professores = \App\Models\ProfessorModel::with('materias')
            ->withCount('materias') // Calculate materias_count
            ->orderByDesc('materias_count')
            ->limit(5)
            ->get();
            
        $alunos = \App\Models\AlunoModel::with('materias')
             ->withCount('materias') 
             ->limit(5)->get();
             
        $materias = \App\Models\Materia::with(['professores', 'alunos'])
            ->withCount(['professores', 'alunos'])
            ->orderByDesc('alunos_count')
            ->limit(5)
            ->get();

        return view('master.home', compact('master', 
            'professores', 'professoresCount', 
            'alunos', 'alunosCount', 
            'materias', 'materiasCount'
        ));
    }
    /**
     * Redireciona para o dashboard correto com base no usuário logado.
     */
    public function index()
    {
        if (Auth::guard('professores')->check()) {
            return redirect()->route('dashboard.professor');
        }
        if (Auth::guard('masters')->check()) {
            return redirect()->route('dashboard.master');
        }
        if (Auth::guard('alunos')->check()) {
            return redirect()->route('dashboard.aluno');
        }
        // Se cair aqui, apesar do middleware, aborta.
        abort(403, 'Acesso não autorizado ou perfil desconhecido.');
    }
}
