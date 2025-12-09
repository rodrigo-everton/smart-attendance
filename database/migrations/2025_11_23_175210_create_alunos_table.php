<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alunos', function (Blueprint $table) {
            $table->string('ra', 15)->primary(); // PK (Registro Acadêmico)
            $table->string('cpf', 11)->unique(); // CPF com 11 caracteres
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('password'); // SENHA para login
            $table->string('role')->default('aluno');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alunos');
    }
};
