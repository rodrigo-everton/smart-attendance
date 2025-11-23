<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlunoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('alunos')->insert([
            'ra' => '100000000',
            'nome' => 'Aluno Teste',
            'email' => 'aluno.teste@site.com',
            'password' => Hash::make('aluno123'), // Senha: aluno123
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
