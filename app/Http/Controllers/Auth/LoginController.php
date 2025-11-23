<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Aluno;

class LoginController extends Controller
{
    /**
     * Exibe o formulário de login.
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Lida com a tentativa de autenticação.
     */
    public function authenticate(Request $request)
    {
        // 1. VALIDAÇÃO
        $request->validate([
            'ra_email_cpf' => 'required|string',
            'password' => 'required|string',
        ], [
            'ra_email_cpf.required' => 'O campo Matrícula/RA/E-Mail é obrigatório.',
            'password.required' => 'A senha é obrigatória.',
        ]);

        $login = $request->input('ra_email_cpf');
        $password = $request->input('password');
        $remember = $request->has('remember');

        // 2. DETERMINAÇÃO DO CAMPO (RA ou E-mail)
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'ra';

        // 3. TENTATIVA DE LOGIN REAL
        $credentials = [
            $fieldType => $login,
            'password' => $password,
        ];

        // Tenta o login (usa a tabela 'alunos')
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // 4. FALLBACK: Tenta a opção oposta
        $fallbackField = ($fieldType === 'email') ? 'ra' : 'email';

        if (Auth::attempt([$fallbackField => $login, 'password' => $password], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }


        // 5. FALHA NO LOGIN
        return back()->withErrors([
            'ra_email_cpf' => 'As credenciais de aluno/matrícula fornecidas são inválidas.',
        ])->onlyInput('ra_email_cpf');
    }
}
