<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AlunoModel;
use App\Models\ProfessorModel;
use App\Http\Controller as BaseController;

class LoginRouterController extends BaseController
{
    // Usamos esta classe para unificar a apresentação e a autenticação sequencial

    public function showLoginForm()
    {
        return view('index');
    }

    public function authenticate(Request $request)
    {
        // 1. VALIDAÇÃO BÁSICA
        $request->validate([
            'ra_email_cpf' => 'required|string',
            'password' => 'required|string',
        ], [
            'ra_email_cpf.required' => 'O campo é obrigatório.',
            'password.required' => 'A senha é obrigatória.',
        ]);

        $login = $request->input('ra_email_cpf');
        $password = $request->input('password');
        $remember = $request->has('remember');

        // 2. TENTATIVA DE AUTENTICAÇÃO SEQUENCIAL (Alunos -> Professores)

        // Crie instâncias dos controladores especializados (sem usar a injeção de dependência via construtor)
        $alunoController = new AlunoLoginController();
        $professorController = new ProfessorLoginController();

        // 🚨 Tenta autenticar como Aluno
        $alunoResult = $alunoController->attemptAuthentication($request, $login, $password, $remember);
        if ($alunoResult) {
            return $alunoResult;
        }

        // 🚨 Se falhou, tenta autenticar como Professor
        $professorResult = $professorController->attemptAuthentication($request, $login, $password, $remember);
        if ($professorResult) {
            return $professorResult;
        }

        // 3. FALHA FINAL
        return back()->withErrors([
            'ra_email_cpf' => 'Credenciais de acesso fornecidas são inválidas.',
        ])->onlyInput('ra_email_cpf');
    }
}
