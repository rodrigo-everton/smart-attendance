<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importar a facade Auth
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  // Argumento para a role esperada (ex: 'professor' ou 'aluno')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Verificar se o usuário está logado em qualquer guard relevante
        $user = null;
        if (Auth::guard('professores')->check()) {
            $user = Auth::guard('professores')->user();
        } elseif (Auth::guard('alunos')->check()) {
            $user = Auth::guard('alunos')->user();
        }

        if (!$user) {
            // Se não estiver logado em nenhum guard, redireciona para a página de login.
            return redirect()->route('login_form');
        }

        // 2. Verificar se a role do usuário corresponde à role esperada
        // NOTA: O campo 'role' deve existir nos seus Models (AlunoModel, ProfessorModel)
        if ($user->role !== $role) {
            // Se a role não corresponder, redirecionar para uma página de erro ou para a sua própria dashboard.

            // Redireciona para o dashboard correto (caso ele tenha tentado acessar a URL do outro)
            if ($user->role === 'professor') {
                return redirect()->route('dashboard.professor');
            }

            // Caso contrário, redireciona para a dashboard do aluno (ou uma página de acesso negado)
            return redirect()->route('dashboard.aluno');
        }

        // 3. Se a role for válida, permite a continuação da requisição
        return $next($request);
    }
}
