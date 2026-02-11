<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'alunos',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'alunos',
        ],
        'alunos' => [
            'driver' => 'session',
            'provider' => 'alunos',
        ],
        'professores' => [
            'driver' => 'session',
            'provider' => 'professores',
        ],
        'masters' => [
            'driver' => 'session',
            'provider' => 'masters',
        ],
    ],

    'providers' => [
        'alunos' => [
            'driver' => 'eloquent',
            'model' => App\Models\AlunoModel::class,
        ],
        'professores' => [
            'driver' => 'eloquent',
            'model' => App\Models\ProfessorModel::class,
        ],
        'masters' => [
            'driver' => 'eloquent',
            'model' => App\Models\UsuarioMaster::class,
        ],
    ],

    'passwords' => [
        'alunos' => [
            'provider' => 'alunos',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'professores' => [
            'provider' => 'professores',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'masters' => [
            'provider' => 'masters',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
