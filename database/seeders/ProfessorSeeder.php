<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('professores')->insert([
            'nome' => 'Professor Teste',
            'email' => 'professor@teste.com',
            'password' => Hash::make('testelogin'), // Senha: testelogin (hashed)
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
