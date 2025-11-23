<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;

// ----------------------------------------------------
// 1. ROTAS DE AUTENTICAÇÃO (Acesso Público)
// ----------------------------------------------------

// Rota GET para exibir o formulário de login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login_form');

// Rota POST para processar a submissão do formulário
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');

// Rota de Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login_form');
})->name('logout');


// ----------------------------------------------------
// 2. ROTAS PROTEGIDAS (Acesso Restrito)
// ----------------------------------------------------

Route::middleware('auth')->group(function () {

    // Rota do Dashboard - Retorna a view 'home.blade.php'
    Route::get('/dashboard', function () {
        return view('home');
    })->name('dashboard');
});


// ----------------------------------------------------
// 3. ROTA RAIZ (PONTO DE ENTRADA PRINCIPAL)
// ----------------------------------------------------

// Redireciona / para o dashboard se logado, ou para o login se não logado.
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login_form');
});


// ----------------------------------------------------
// 4. ROTAS DE TESTE DE REDIRECIONAMENTO (DESENVOLVIMENTO)
// ----------------------------------------------------

// Rota de Destino de Teste (Pode ser acessada via GET)
Route::get('/home-teste', function () {
    return view('home');
})->name('home_teste');

// Rota de Submissão de Teste: Recebe o POST do formulário e redireciona.
Route::post('/teste-redirect', function (Request $request) {
    return redirect()->route('home_teste');
})->name('teste_redirect');
