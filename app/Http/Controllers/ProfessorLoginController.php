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
        return view('professor.login');
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

        $professor = null;
        foreach ($searchFieldsProfessor as $searchField) {
            $professor = ProfessorModel::where($searchField, $login)->first();
            if ($professor) break;
        }

        if ($professor && Hash::check($password, $professor->password)) {
            Auth::guard('professores')->login($professor, $remember);
            $request->session()->regenerate();
            return redirect()->route('dashboard.professor');
        }

        // Tentativa como Master
        $master = \App\Models\UsuarioMaster::where('email', $login)->first();

        if ($master && Hash::check($password, $master->password)) {
            Auth::guard('masters')->login($master, $remember);
            $request->session()->regenerate();
            return redirect()->route('dashboard.master');
        }

        // Falhou na autenticação do Professor
        return redirect()->route('login.professor.form')
            ->withErrors([
                'ra_email_cpf' => 'Credenciais de acesso fornecidas são inválidas.',
            ])->withInput();
    }
}
