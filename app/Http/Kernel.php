<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array<int, class-string>
     */
    protected $middleware = [
        // Intencionalmente vazio — adicione global middleware quando necessário
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string>>
     */
    protected $middlewareGroups = [
        'web' => [],
        'api' => [],
    ];

    /**
     * The application's route middleware.
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string>
     */
    protected $routeMiddleware = [
        // Registra o middleware 'role' usado nas rotas como ->middleware('role:professor')
        'role' => \App\Http\Middleware\CheckRole::class,

        // Garante que o middleware 'auth' funcione; usamos o middleware do framework.
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
    ];
}
