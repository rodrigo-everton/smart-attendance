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

        $alunosAdicionais = [
            ['ra' => '300000000', 'cpf' => '11111111111', 'nome' => 'Lucas Silva', 'email' => 'lucas@aluno.com'],
            ['ra' => '400000000', 'cpf' => '22222222222', 'nome' => 'Beatriz Costa', 'email' => 'beatriz@aluno.com'],
            ['ra' => '500000000', 'cpf' => '33333333333', 'nome' => 'Gabriel Santos', 'email' => 'gabriel@aluno.com'],
            ['ra' => '600000000', 'cpf' => '44444444444', 'nome' => 'Julia Souza', 'email' => 'julia@aluno.com'],
            ['ra' => '700000000', 'cpf' => '55555555555', 'nome' => 'Rafael Lima', 'email' => 'rafael@aluno.com'],
        ];

        foreach ($alunosAdicionais as $aluno) {
            DB::table('alunos')->insert([
                'ra' => $aluno['ra'],
                'cpf' => $aluno['cpf'],
                'nome' => $aluno['nome'],
                'email' => $aluno['email'],
                'password' => Hash::make('aluno123'),
                'role' => 'aluno',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
