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
        Schema::create('presencas', function (Blueprint $table) {
            $table->id();
            
            // Relacionamento com Aluno (RA é string)
            $table->string('aluno_ra');
            $table->foreign('aluno_ra')->references('ra')->on('alunos')->onDelete('cascade');

            // Relacionamento com Professor (CPF é string)
            $table->string('professor_cpf');
            $table->foreign('professor_cpf')->references('cpf')->on('professores')->onDelete('cascade');

            // Relacionamento com Matéria
            $table->unsignedBigInteger('materia_id');
            $table->foreign('materia_id')->references('id')->on('materias')->onDelete('cascade');

            // Dados da Aula
            $table->date('data_aula');
            $table->string('semestre', 20)->nullable(); // Ex: 2026/1
            $table->string('horario', 5)->nullable(); // M, V, N
            $table->string('codigo_aula')->index(); // Para agrupar todos os alunos da mesma chamada
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presencas');
    }
};
