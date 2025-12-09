<?php

use App\Models\Aluno;
use App\Models\AlunoModel;
use App\Models\User;

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'alunos',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'alunos', // Configurado para usar a tabela 'alunos'
        ],
        // ... (outros guards)
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => User::class,
        ],
        // NOVO PROVIDER PARA ALUNOS
        'alunos' => [
            'driver' => 'eloquent',
            'model' => AlunoModel::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'alunos' => [ // Configuração de reset de senha para Alunos
            'provider' => 'alunos',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
