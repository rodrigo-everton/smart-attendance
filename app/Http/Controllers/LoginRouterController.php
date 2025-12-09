<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controller as BaseController;
// Importamos os controllers especializados
use App\Http\Controllers\AlunoLoginController;
use App\Http\Controllers\ProfessorLoginController;

class LoginRouterController extends BaseController
{
    public function showLoginForm()
    {
        return view('index');
    }

    public function authenticate(Request $request)
    {
        // 1. VALIDAÇÃO
        $request->validate([
            'ra_email_cpf' => 'required|string',
            'password' => 'required|string',
            'user_role' => 'required|in:aluno,professor', // Obtido do formulário
        ], [
            'ra_email_cpf.required' => 'O campo de acesso é obrigatório.',
            'password.required' => 'A senha é obrigatória.',
            'user_role.required' => 'Selecione se você é Aluno ou Professor.',
        ]);

        $login = $request->input('ra_email_cpf');
        $password = $request->input('password');
        $remember = $request->has('remember');
        $role = $request->input('user_role');

        // 2. DELEGAÇÃO DA AUTENTICAÇÃO
        $loginResult = false;

        if ($role === 'aluno') {
            $alunoController = new AlunoLoginController();
            // Chama o método que processa o Request
            $loginResult = $alunoController->attemptAuthentication($request);
        } elseif ($role === 'professor') {
            $professorController = new ProfessorLoginController();
            // Chama o método que processa o Request
            $loginResult = $professorController->attemptAuthentication($request);
        }

        // 3. VERIFICAÇÃO DO RESULTADO
        if ($loginResult) {
            // Retorna o redirect que veio do Controller especializado
            return $loginResult;
        }

        // 4. FALHA FINAL
        return back()->withErrors([
            'ra_email_cpf' => 'Credenciais de acesso fornecidas são inválidas para o perfil de ' . $role . '.',
        ])->onlyInput('ra_email_cpf');
    }
}
