<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AlunoModel;
use App\Http\Controller as BaseController;

class AlunoLoginController extends BaseController
{
    /**
     * Exibe o formulário de login do aluno.
     */
    public function showLoginForm()
    {
        return view('login_aluno');
    }

    /**
     * Processa o login do aluno.
     */
    public function attemptAuthentication(Request $request)
    {
        $request->validate([
            'ra_email_cpf' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->input('ra_email_cpf');
        $password = $request->input('password');
        $remember = $request->has('remember');

        $searchFieldsAluno = ['ra', 'cpf', 'email'];

        // --- AUTENTICAÇÃO MANUAL COMO ALUNO ---

        $aluno = null;
        // Tenta encontrar o Aluno usando todos os campos possíveis
        foreach ($searchFieldsAluno as $searchField) {
            // Usa o Model renomeado: AlunoModel
            $aluno = AlunoModel::where($searchField, $login)->first();
            if ($aluno) break;
        }

        if ($aluno && Hash::check($password, $aluno->password)) {
            // Sucesso na autenticação (usa guard 'alunos')
            Auth::guard('alunos')->login($aluno, $remember);
            $request->session()->regenerate();

            // Retorna o redirect para o dashboard do aluno
            return redirect()->route('dashboard.aluno');
        }

        // Falhou na autenticação do Aluno
        return redirect()->route('login.aluno.form')
            ->withErrors([
                'ra_email_cpf' => 'Credenciais de acesso fornecidas são inválidas.',
            ])->withInput();
    }
}
