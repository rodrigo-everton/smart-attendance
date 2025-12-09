<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     * Estes middlewares são executados em todas as requisições.
     *
     * @var array<int, class-string>
     */
    protected $middleware = [
        // Esses são essenciais em instalações modernas do Laravel:
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        //\App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     * O grupo 'web' é ESSENCIAL para sessões, cookies e proteção CSRF.
     *
     * @var array<string, array<int, class-string>>
     */
    protected $middlewareGroups = [
        'web' => [
            //\App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            // \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        // O grupo 'api' pode ser mantido vazio ou adicionado, dependendo da sua necessidade
        'api' => [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware aliases.
     * Estes middlewares podem ser atribuídos individualmente ou em grupos.
     *
     * @var array<string, class-string>
     */
    protected $routeMiddleware = [
        // ✅ SEU REGISTRO DE PERMISSÃO
        'role' => \App\Http\Middleware\CheckRole::class,

        // Aliases essenciais (mantidos do seu original)
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        // 'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
