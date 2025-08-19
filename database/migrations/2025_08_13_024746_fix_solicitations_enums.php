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
        // Primeiro, verificar se as colunas existem e são do tipo correto
        $columns = DB::select("SHOW COLUMNS FROM solicitations");
        $columnNames = array_column($columns, 'Field');
        $columnTypes = array_column($columns, 'Type');

        // Corrigir entity_type se necessário
        if (in_array('entity_type', $columnNames)) {
            $entityTypeIndex = array_search('entity_type', $columnNames);
            $entityTypeType = $columnTypes[$entityTypeIndex];

            // Se não for ENUM, converter
            if (strpos($entityTypeType, 'enum') === false) {
                // Primeiro, garantir que os valores estão corretos
                DB::statement("
                    UPDATE solicitations
                    SET entity_type = CASE
                        WHEN entity_type = 'driver' THEN 'driver'
                        WHEN entity_type = 'vehicle' THEN 'vehicle'
                        WHEN entity_type = 'composed' THEN 'composed'
                        ELSE 'driver'
                    END
                    WHERE entity_type IS NOT NULL
                ");

                // Converter para ENUM
                DB::statement("
                    ALTER TABLE solicitations
                    MODIFY COLUMN entity_type ENUM('driver', 'vehicle', 'composed') NOT NULL
                ");
            }
        }

        // Corrigir vincle_type se necessário
        if (in_array('vincle_type', $columnNames)) {
            $vincleTypeIndex = array_search('vincle_type', $columnNames);
            $vincleTypeType = $columnTypes[$vincleTypeIndex];

            // Se não for ENUM, converter
            if (strpos($vincleTypeType, 'enum') === false) {
                // Primeiro, garantir que os valores estão corretos
                DB::statement("
                    UPDATE solicitations
                    SET vincle_type = CASE
                        WHEN vincle_type = 'Autonomo' THEN 'autonomo'
                        WHEN vincle_type = 'Agregado' THEN 'agregado'
                        WHEN vincle_type = 'Funcionario' THEN 'funcionario'
                        WHEN vincle_type = 'autonomo' THEN 'autonomo'
                        WHEN vincle_type = 'agregado' THEN 'agregado'
                        WHEN vincle_type = 'funcionario' THEN 'funcionario'
                        ELSE 'autonomo'
                    END
                    WHERE vincle_type IS NOT NULL
                ");

                // Converter para ENUM
                DB::statement("
                    ALTER TABLE solicitations
                    MODIFY COLUMN vincle_type ENUM('autonomo', 'agregado', 'funcionario') NULL
                ");
            }
        }

        // Corrigir research_type se necessário
        if (in_array('research_type', $columnNames)) {
            $researchTypeIndex = array_search('research_type', $columnNames);
            $researchTypeType = $columnTypes[$researchTypeIndex];

            // Se não for ENUM, converter
            if (strpos($researchTypeType, 'enum') === false) {
                // Primeiro, garantir que os valores estão corretos
                DB::statement("
                    UPDATE solicitations
                    SET research_type = CASE
                        WHEN research_type = 'basic' THEN 'basic'
                        WHEN research_type = 'complete' THEN 'complete'
                        WHEN research_type = 'express' THEN 'express'
                        ELSE 'basic'
                    END
                    WHERE research_type IS NOT NULL
                ");

                // Converter para ENUM
                DB::statement("
                    ALTER TABLE solicitations
                    MODIFY COLUMN research_type ENUM('basic', 'complete', 'express') NOT NULL DEFAULT 'basic'
                ");
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverter para string
        Schema::table('solicitations', function (Blueprint $table) {
            $table->string('entity_type')->change();
            $table->string('vincle_type')->nullable()->change();
            $table->string('research_type')->change();
        });
    }
};
