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
        $professor = Auth::user();
        return view('homeProfessor', compact('professor'));
    }

    /**
     * Exibe a dashboard do Aluno.
     */
    public function alunoIndex()
    {
        $aluno = Auth::user();
        return view('homeAluno', compact('aluno'));
    }
}
