<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\ProfessorModel;
use App\Http\Controller as BaseController;

class ProfessorLoginController extends BaseController
{
    /**
     * Exibe o formulário de login do professor.
     */
    public function showLoginForm()
    {
        return view('login_professor');
    }

    /**
     * Processa o login do professor.
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

        $searchFieldsProfessor = ['cpf', 'email'];

        // --- AUTENTICAÇÃO MANUAL COMO PROFESSOR ---

        $professor = null;
        // Tenta encontrar o Professor usando apenas CPF e E-mail
        foreach ($searchFieldsProfessor as $searchField) {
            $professor = ProfessorModel::where($searchField, $login)->first();
            if ($professor) break;
        }

        \Log::info('Professor Login Attempt', [
            'login_input' => $login,
            'professor_found' => $professor ? $professor->email : 'not found',
            'professor_role' => $professor ? $professor->role : 'N/A',
        ]);

        if ($professor && Hash::check($password, $professor->password)) {
            // Sucesso na autenticação
            \Log::info('Professor Password Match - Logging in', [
                'professor_id' => $professor->cpf,
                'professor_email' => $professor->email,
                'professor_role' => $professor->role,
            ]);

            // Usa guard específico para professores
            Auth::guard('professores')->login($professor, $remember);
            $request->session()->regenerate();

            \Log::info('Professor Auth Check After Login', [
                'auth_check' => Auth::check(),
                'auth_user_role' => Auth::user()->role ?? 'null',
            ]);

            // Retorna o redirect para o dashboard
            return redirect()->route('dashboard.professor');
        }

        \Log::info('Professor Login Failed', [
            'professor_found' => $professor ? 'yes' : 'no',
            'password_match' => $professor ? Hash::check($password, $professor->password) : 'n/a',
        ]);

        // Falhou na autenticação do Professor
        return redirect()->route('login.professor.form')
            ->withErrors([
                'ra_email_cpf' => 'Credenciais de acesso fornecidas são inválidas.',
            ])->withInput();
    }
}
