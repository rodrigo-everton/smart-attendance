<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// 🚨 CORREÇÃO: Usando o Router de Login como o Controller primário
use App\Http\Controllers\LoginRouterController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;

// ----------------------------------------------------
// 1. ROTAS DE AUTENTICAÇÃO (Acesso Público)
// ----------------------------------------------------

// O LoginRouterController agora cuida da exibição e do processamento do POST
Route::get('/login', [LoginRouterController::class, 'showLoginForm'])->name('login_form');
Route::post('/login', [LoginRouterController::class, 'authenticate'])->name('login');

// Rota de Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login_form');
})->name('logout');


// ----------------------------------------------------
// 2. ROTAS PROTEGIDAS (Dashboards) - MIDDLEWARE DE PERMISSÃO
// ----------------------------------------------------

Route::middleware('auth')->group(function () {

    // Rota da Dashboard do Professor
    Route::get('/dashboard/professor', [DashboardController::class, 'professorIndex'])
        // Proteção: Apenas usuários com role 'professor'
        ->middleware(\App\Http\Middleware\CheckRole::class . ':professor')
        ->name('dashboard.professor');

    // Rota da Dashboard do Aluno
    Route::get('/dashboard/aluno', [DashboardController::class, 'alunoIndex'])
        // Proteção: Apenas usuários com role 'aluno'
        ->middleware(\App\Http\Middleware\CheckRole::class . ':aluno')
        ->name('dashboard.aluno');

    // Rota genérica '/dashboard' (Redirecionamento)
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $role = $user->role ?? 'aluno';

        if ($role === 'professor') {
            return redirect()->route('dashboard.professor');
        }
        return redirect()->route('dashboard.aluno');
    })->name('dashboard');
});


// ----------------------------------------------------
// 3. ROTA RAIZ (PONTO DE ENTRADA PRINCIPAL)
// ----------------------------------------------------

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login_form');
})->name('home');
