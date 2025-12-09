<?php

use App\Models\AlunoModel;
use App\Models\ProfessorModel;
use App\Models\User;

// config/auth.php

// ... (imports de AlunoModel e ProfessorModel)

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'alunos', // Mantemos 'alunos' como default
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            // Mantemos 'web' para compatibilidade (aponta para 'alunos')
            'provider' => 'alunos',
        ],
        // Guards separados para autenticação específica
        'alunos' => [
            'driver' => 'session',
            'provider' => 'alunos',
        ],
        'professores' => [
            'driver' => 'session',
            'provider' => 'professores',
        ],
    ],

    'providers' => [
        // Provider original para Alunos
        'alunos' => [
            'driver' => 'eloquent',
            'model' => App\Models\AlunoModel::class, // Usa o Model do Aluno
        ],

        // 🚨 NOVO PROVIDER PARA PROFESSORES
        'professores' => [
            'driver' => 'eloquent',
            'model' => App\Models\ProfessorModel::class, // Usa o Model do Professor
        ],
    ],

    'passwords' => [
        // ... (configurações de reset de senha)

        // Configuração de reset de senha para Alunos
        'alunos' => [
            'provider' => 'alunos',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        // 🚨 NOVO PASSWORD CONFIG para Professores
        'professores' => [
            'provider' => 'professores',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
