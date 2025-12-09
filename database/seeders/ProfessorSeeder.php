<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpar a tabela antes de inserir (opcional, mas útil para testes)
        // DB::table('professores')->truncate(); 

        DB::table('professores')->insert([
            'cpf' => '1223334444', // CPF é a chave primária
            'nome' => 'Professor Teste',
            'email' => 'professor@teste.com',
            'password' => Hash::make('professor123'),
            'role' => 'professor', // Define a função (role)
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('professores')->insert([
            'cpf' => '55566677788',
            'nome' => 'Profa. Maria',
            'email' => 'maria@teste.com',
            'password' => Hash::make('professor123'),
            'role' => 'professor',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
