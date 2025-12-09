<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ProfessorModel;
use App\Http\Controller as BaseController;

class ProfessorLoginController extends BaseController
{
    /**
     * Este método é apenas para exibir o formulário, se necessário.
     */
    public function showLoginForm()
    {
        return view('index');
    }

    /**
     * Lida com a tentativa de autenticação do Professor, sendo chamado pelo Router.
     * * @param Request $request A requisição HTTP.
     * @param string $login O valor do campo de login (CPF/Email).
     * @param string $password A senha fornecida.
     * @param bool $remember Se o usuário quer ser lembrado.
     * @return \Illuminate\Http\RedirectResponse|bool Retorna o redirect em caso de sucesso, ou false em caso de falha.
     */
    public function attemptAuthentication(Request $request, string $login, string $password, bool $remember): \Illuminate\Http\RedirectResponse|bool
    {
        // NOTA: A validação dos campos de input é feita pelo Router.
        $searchFieldsProfessor = ['cpf', 'email'];

        // --- AUTENTICAÇÃO MANUAL COMO PROFESSOR ---

        $professor = null;
        // Tenta encontrar o Professor usando apenas CPF e E-mail
        foreach ($searchFieldsProfessor as $searchField) {
            $professor = ProfessorModel::where($searchField, $login)->first();
            if ($professor) break;
        }

        if ($professor && Hash::check($password, $professor->password)) {
            // Sucesso na autenticação
            Auth::login($professor, $remember);
            $request->session()->regenerate();

            // Retorna o objeto de redirecionamento para ser repassado pelo Router
            return redirect()->route('dashboard.professor');
        }

        // Falhou na autenticação do Professor
        return false;
    }
}
