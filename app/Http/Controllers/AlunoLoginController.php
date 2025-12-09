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
     * Exibe o formulário de login (se for a rota GET).
     */
    public function showLoginForm()
    {
        return view('index');
    }

    /**
     * Lida com a tentativa de autenticação do Aluno, sendo chamado pelo Router.
     * * @param Request $request A requisição HTTP.
     * @param string $login O valor do campo de login (RA/CPF/Email).
     * @param string $password A senha fornecida.
     * @param bool $remember Se o usuário quer ser lembrado.
     * @return \Illuminate\Http\RedirectResponse|bool Retorna o redirect em caso de sucesso, ou false em caso de falha.
     */
    public function attemptAuthentication(Request $request, string $login, string $password, bool $remember): \Illuminate\Http\RedirectResponse|bool
    {
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
            // Sucesso na autenticação
            Auth::login($aluno, $remember);
            $request->session()->regenerate();

            // Retorna o objeto de redirecionamento para ser repassado pelo Router
            return redirect()->route('dashboard.aluno');
        }

        // Falhou na autenticação do Aluno
        return false;
    }
}
