<?php

use App\Http\Controllers\AlunoLoginController;
use App\Http\Controllers\ProfessorLoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Usamos o Router para exibir o seletor, mas os especializados para o processamento.
use App\Http\Controllers\LoginRouterController;
use App\Http\Controllers\DashboardController;


// ----------------------------------------------------
// 1. ROTAS DE AUTENTICAÇÃO (Acesso Público)
// ----------------------------------------------------

// Rota GET /login: Exibe a página de seleção de perfil (index.blade.php)
Route::get('/login', [LoginRouterController::class, 'showLoginForm'])->name('login_form');

// Rota POST /login: Alias para compatibilidade com views antigas
Route::post('/login', function (Request $request) {
    // Redireciona para a rota específica do tipo de usuário
    // Se a view precisar de route('login'), ela será redirecionada para o aluno por padrão
    return redirect()->route('login.aluno');
})->name('login');

// Rota de Logout
Route::post('/logout', function (Request $request) {
    // Logout de ambos os guards (caso um esteja autenticado)
    if (Auth::guard('professores')->check()) {
        Auth::guard('professores')->logout();
    }
    if (Auth::guard('alunos')->check()) {
        Auth::guard('alunos')->logout();
    }

    // Invalida sessão e token
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login_form');
})->name('logout');


// 🚨 NOVO: ROTAS DE LOGIN ESPECIALIZADAS POR PERFIL (Resolve o RouteNotFoundException)

// Rota GET para exibir o formulário do Aluno (nome exigido pelo index.blade.php)
Route::get('/login/aluno', [AlunoLoginController::class, 'showLoginForm'])
    ->name('login.aluno.form');

// Rota POST para processar o login do Aluno
Route::post('/login/aluno', [AlunoLoginController::class, 'attemptAuthentication'])
    ->name('login.aluno');

// Rota GET para exibir o formulário do Professor
Route::get('/login/professor', [ProfessorLoginController::class, 'showLoginForm'])
    ->name('login.professor.form');

// Rota POST para processar o login do Professor
Route::post('/login/professor', [ProfessorLoginController::class, 'attemptAuthentication'])
    ->name('login.professor');


// ----------------------------------------------------
// 2. ROTAS PROTEGIDAS (Dashboards) - MIDDLEWARE DE PERMISSÃO
// ----------------------------------------------------

// Rotas protegidas: cada rota usa o guard apropriado

// Dashboard do Professor (autenticação via guard 'professores')
Route::get('/dashboard/professor', [DashboardController::class, 'professorIndex'])
    ->middleware('auth:professores', 'role:professor')
    ->name('dashboard.professor');

// Dashboard do Aluno (autenticação via guard 'alunos')
Route::get('/dashboard/aluno', [DashboardController::class, 'alunoIndex'])
    ->middleware('auth:alunos', 'role:aluno')
    ->name('dashboard.aluno');

// Rota genérica '/dashboard' (verifica ambos os guards)
Route::get('/dashboard', function () {
    if (Auth::guard('professores')->check()) {
        return redirect()->route('dashboard.professor');
    }
    if (Auth::guard('alunos')->check()) {
        return redirect()->route('dashboard.aluno');
    }
    return redirect()->route('login_form');
})->name('dashboard');


// ----------------------------------------------------
// 3. ROTA RAIZ (PONTO DE ENTRADA PRINCIPAL)
// ----------------------------------------------------

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    // Redireciona para a página de seleção de perfil
    return redirect()->route('login_form');
})->name('home');
