<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Mapa de roles para guards
        $guardMap = [
            'professor' => 'professores',
            'aluno' => 'alunos',
            'master' => 'masters',
        ];

        $guard = $guardMap[$role] ?? null;

        if (!$guard || !Auth::guard($guard)->check()) {
            return $this->handleUnauthorizedResponse($request);
        }

        $user = Auth::guard($guard)->user();

        if ($user->role !== $role) {
            return $this->handleUnauthorizedResponse($request);
        }

        return $next($request);
    }

    private function handleUnauthorizedResponse(Request $request): Response
    {
        if (Auth::guard('professores')->check()) {
            return redirect()->route('dashboard.professor');
        }
        if (Auth::guard('alunos')->check()) {
            return redirect()->route('dashboard.aluno');
        }
        if (Auth::guard('masters')->check()) {
            return redirect()->route('dashboard.master');
        }

        return redirect()->route('login_form');
    }
}
