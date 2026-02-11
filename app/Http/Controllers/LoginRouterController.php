<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controller as BaseController;

class LoginRouterController extends BaseController
{
    public function showLoginForm()
    {
        return view('index');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'ra_email_cpf' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'user_role' => 'required|in:aluno,professor',
        ], [
            'ra_email_cpf.required' => 'O campo de acesso é obrigatório.',
            'password.required' => 'A senha é obrigatória.',
            'user_role.required' => 'Selecione se você é Aluno ou Professor.',
        ]);

        $role = $request->input('user_role');

        if ($role === 'aluno') {
            return app(AlunoLoginController::class)->attemptAuthentication($request);
        }

        if ($role === 'professor') {
            return app(ProfessorLoginController::class)->attemptAuthentication($request);
        }

        return back()->withErrors([
            'ra_email_cpf' => 'Perfil de acesso inválido.',
        ])->onlyInput('ra_email_cpf');
    }
}
