<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Primeiro, atualizar os valores existentes para o formato correto
        DB::statement("
            UPDATE solicitations
            SET vincle_type = CASE
                WHEN vincle_type = 'Autonomo' THEN 'autonomo'
                WHEN vincle_type = 'Agregado' THEN 'agregado'
                WHEN vincle_type = 'Funcionario' THEN 'funcionario'
                ELSE 'autonomo'
            END
            WHERE vincle_type IS NOT NULL
        ");

        // Alterar a coluna para ENUM
        Schema::table('solicitations', function (Blueprint $table) {
            $table->enum('vincle_type', ['autonomo', 'agregado', 'funcionario'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverter para string
        Schema::table('solicitations', function (Blueprint $table) {
            $table->string('vincle_type')->nullable()->change();
        });
    }
};
