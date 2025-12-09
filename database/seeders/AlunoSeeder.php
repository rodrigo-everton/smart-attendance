<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlunoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpar a tabela de alunos antes de inserir 
        // DB::table('alunos')->truncate(); 

        DB::table('alunos')->insert([

            'ra' => '100000000',
            'cpf' => '00011122233',
            'nome' => 'Aluno Teste',
            'email' => 'aluno.teste@site.com',
            'password' => Hash::make('aluno123'), // Senha: aluno123
            'role' => 'aluno',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('alunos')->insert([
            'ra' => '200000000',
            'cpf' => '44455566677',
            'nome' => 'Aluna Mariana',
            'email' => 'mariana@aluno.com',
            'password' => Hash::make('aluno123'),
            'role' => 'aluno',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
