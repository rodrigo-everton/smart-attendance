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
        Schema::table('aluno_materia', function (Blueprint $table) {
            $table->decimal('prova1', 4, 2)->nullable()->after('materia_id');
            $table->decimal('trabalho1', 4, 2)->nullable()->after('prova1');
            $table->decimal('trabalho2', 4, 2)->nullable()->after('trabalho1');
            $table->decimal('prova2', 4, 2)->nullable()->after('trabalho2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aluno_materia', function (Blueprint $table) {
            $table->dropColumn(['prova1', 'trabalho1', 'trabalho2', 'prova2']);
        });
    }
};
