<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\UsuarioMaster;

class UsuarioMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UsuarioMaster::create([
            'nome' => 'Master Admin',
            'email' => 'master@admin.com',
            'password' => Hash::make('password'), // Senha padrão
            'role' => 'master',
        ]);
    }
}
