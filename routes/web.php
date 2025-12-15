<?php

use App\Http\Controllers\AlunoLoginController;
use App\Http\Controllers\ProfessorLoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Usamos o Router para exibir o seletor, mas os especializados para o processamento.
use App\Http\Controllers\LoginRouterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PdfTesteVulnerabilidadeController;
use App\Http\Controllers\MasterSearchController;



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
    if (Auth::guard('masters')->check()) {
        Auth::guard('masters')->logout();
    }

    // Invalida sessão e token
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login_form');
})->name('logout');


// ----------------------------------------------------
// ROTAS DE LOGIN ESPECIALIZADAS POR PERFIL
// ----------------------------------------------------

// Rota GET para exibir o formulário do Aluno
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
// 2. ROTAS PROTEGIDAS (Dashboards & Recursos) - MIDDLEWARE DE PERMISSÃO
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

// Dashboard do Master (autenticação via guard 'masters')
Route::get('/dashboard/master', [DashboardController::class, 'masterIndex'])
    ->middleware('auth:masters') // Pode adicionar 'role:master' se criar middleware
    ->name('dashboard.master');

// --- Rotas Protegidas para Todos (Professores, Alunos e Masters) ---
Route::middleware(['auth:professores,alunos,masters'])->group(function () {
    
    // Rota genérica '/dashboard' (verifica todos os guards)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rota raiz (redireciona para dashboard)
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    // Rota para PDF de Teste de Vulnerabilidade
    Route::get('/pdf-teste-vulnerabilidade', [PdfTesteVulnerabilidadeController::class, 'index'])->name('pdf.teste.vulnerabilidade');

});

// ----------------------------------------------------
// 3. ROTAS DE PESQUISA (AJAX) - EXCLUSIVO MASTER
// ----------------------------------------------------
Route::middleware(['auth:masters'])->prefix('master/search')->group(function () {
    Route::get('/professores', [MasterSearchController::class, 'searchProfessores'])->name('master.search.professores');
    Route::get('/alunos', [MasterSearchController::class, 'searchAlunos'])->name('master.search.alunos');
    Route::get('/materias', [MasterSearchController::class, 'searchMaterias'])->name('master.search.materias');
});


