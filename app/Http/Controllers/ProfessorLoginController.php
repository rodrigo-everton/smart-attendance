<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ProfessorModel;
use App\Models\UsuarioMaster;
use App\Http\Controller as BaseController;

class ProfessorLoginController extends BaseController
{
    public function showLoginForm()
    {
        return view('professor.login');
    }

    public function attemptAuthentication(Request $request)
    {
        $request->validate([
            'ra_email_cpf' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        $login = $request->input('ra_email_cpf');
        $password = $request->input('password');
        $remember = $request->has('remember');

        // Tentativa como Professor
        $searchFields = ['cpf', 'email'];

        $professor = null;
        foreach ($searchFields as $field) {
            $professor = ProfessorModel::where($field, $login)->first();
            if ($professor) break;
        }

        if ($professor && Hash::check($password, $professor->password)) {
            Auth::guard('alunos')->logout();
            Auth::guard('masters')->logout();

            Auth::guard('professores')->login($professor, $remember);
            $request->session()->regenerate();
            return redirect()->route('dashboard.professor');
        }

        // Tentativa como Master
        $master = UsuarioMaster::where('email', $login)->first();

        if ($master && Hash::check($password, $master->password)) {
            Auth::guard('professores')->logout();
            Auth::guard('alunos')->logout();

            Auth::guard('masters')->login($master, $remember);
            $request->session()->regenerate();
            return redirect()->route('dashboard.master');
        }

        return redirect()->route('login.professor.form')
            ->withErrors([
                'ra_email_cpf' => 'Credenciais de acesso fornecidas são inválidas.',
            ])->withInput();
    }
}
