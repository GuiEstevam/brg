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
        // Verificar estrutura atual
        $solicitationsColumns = DB::select("SHOW COLUMNS FROM solicitations");
        $researchesColumns = DB::select("SHOW COLUMNS FROM researches");

        $solicitationsColumnNames = array_column($solicitationsColumns, 'Field');
        $researchesColumnNames = array_column($researchesColumns, 'Field');

        // ATUALIZAR TABELA SOLICITATIONS
        Schema::table('solicitations', function (Blueprint $table) use ($solicitationsColumnNames) {
            // Adicionar novos campos se não existirem
            if (!in_array('entity_type', $solicitationsColumnNames)) {
                $table->enum('entity_type', ['driver', 'vehicle', 'composed'])->after('vehicle_id');
            }
            if (!in_array('entity_value', $solicitationsColumnNames)) {
                $table->string('entity_value')->after('entity_type');
            }
            if (!in_array('research_type', $solicitationsColumnNames)) {
                $table->enum('research_type', ['basic', 'complete', 'express'])->default('basic')->after('entity_value');
            }
            if (!in_array('calculated_price', $solicitationsColumnNames)) {
                $table->decimal('calculated_price', 10, 2)->nullable()->after('status');
            }
            if (!in_array('auto_renewal', $solicitationsColumnNames)) {
                $table->boolean('auto_renewal')->default(false)->after('calculated_price');
            }
            if (!in_array('notes', $solicitationsColumnNames)) {
                $table->text('notes')->nullable()->after('api_request_data');
            }
        });

        // Migrar dados existentes para novos campos
        if (in_array('type', $solicitationsColumnNames)) {
            DB::statement("
                UPDATE solicitations
                SET
                    entity_type = CASE
                        WHEN type = 'driver' THEN 'driver'
                        WHEN type = 'vehicle' THEN 'vehicle'
                        WHEN type = 'composed' THEN 'composed'
                        ELSE 'driver'
                    END,
                    entity_value = value
            ");
        }

        // Remover campos antigos se existirem
        Schema::table('solicitations', function (Blueprint $table) use ($solicitationsColumnNames) {
            if (in_array('type', $solicitationsColumnNames)) {
                $table->dropColumn('type');
            }
            if (in_array('subtype', $solicitationsColumnNames)) {
                $table->dropColumn('subtype');
            }
            if (in_array('value', $solicitationsColumnNames)) {
                $table->dropColumn('value');
            }
        });

        // ATUALIZAR TABELA RESEARCHES
        Schema::table('researches', function (Blueprint $table) use ($researchesColumnNames) {
            // Adicionar novos campos se não existirem
            if (!in_array('api_provider', $researchesColumnNames)) {
                $table->string('api_provider')->nullable()->after('vehicle_id');
            }
            if (!in_array('api_status', $researchesColumnNames)) {
                $table->string('api_status')->default('pending')->after('api_response');
            }
            if (!in_array('processed_data', $researchesColumnNames)) {
                $table->json('processed_data')->nullable()->after('api_status');
            }
            if (!in_array('validation_status', $researchesColumnNames)) {
                $table->enum('validation_status', ['valid', 'invalid', 'expired', 'pending'])->default('pending')->after('processed_data');
            }
            if (!in_array('score', $researchesColumnNames)) {
                $table->integer('score')->nullable()->after('validity_date');
            }
            if (!in_array('notes', $researchesColumnNames)) {
                $table->text('notes')->nullable()->after('score');
            }
            if (!in_array('document_number', $researchesColumnNames)) {
                $table->string('document_number')->nullable()->after('notes');
            }
            if (!in_array('document_type', $researchesColumnNames)) {
                $table->enum('document_type', ['cpf', 'plate', 'renavam', 'cnh'])->nullable()->after('document_number');
            }
            if (!in_array('person_name', $researchesColumnNames)) {
                $table->string('person_name')->nullable()->after('document_type');
            }
            if (!in_array('document_status', $researchesColumnNames)) {
                $table->enum('document_status', ['valid', 'invalid', 'expired'])->nullable()->after('person_name');
            }
            if (!in_array('restrictions', $researchesColumnNames)) {
                $table->json('restrictions')->nullable()->after('document_status');
            }
            if (!in_array('infractions', $researchesColumnNames)) {
                $table->json('infractions')->nullable()->after('restrictions');
            }
            if (!in_array('processes', $researchesColumnNames)) {
                $table->json('processes')->nullable()->after('infractions');
            }
        });

        // Migrar dados existentes
        if (in_array('status_api', $researchesColumnNames)) {
            DB::statement("
                UPDATE researches
                SET
                    validation_status = CASE
                        WHEN status_api = 'Adequado ao risco' THEN 'valid'
                        WHEN status_api = 'Inconclusivo' THEN 'pending'
                        ELSE 'invalid'
                    END,
                    api_status = status_api
            ");
        }

        if (in_array('total_points', $researchesColumnNames)) {
            DB::statement("UPDATE researches SET score = total_points");
        }

        // Remover campos antigos se existirem
        Schema::table('researches', function (Blueprint $table) use ($researchesColumnNames) {
            if (in_array('status_api', $researchesColumnNames)) {
                $table->dropColumn('status_api');
            }
            if (in_array('total_points', $researchesColumnNames)) {
                $table->dropColumn('total_points');
            }
            if (in_array('rejection_reasons', $researchesColumnNames)) {
                $table->dropColumn('rejection_reasons');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverter tabela RESEARCHES
        Schema::table('researches', function (Blueprint $table) {
            $table->string('status_api')->nullable()->after('api_response');
            $table->integer('total_points')->nullable()->after('validity_date');
            $table->json('rejection_reasons')->nullable()->after('total_points');
        });

        // Migrar dados de volta
        DB::statement("
            UPDATE researches
            SET
                status_api = api_status,
                total_points = score
        ");

        Schema::table('researches', function (Blueprint $table) {
            $table->dropColumn([
                'api_provider',
                'api_status',
                'processed_data',
                'validation_status',
                'score',
                'notes',
                'document_number',
                'document_type',
                'person_name',
                'document_status',
                'restrictions',
                'infractions',
                'processes'
            ]);
        });

        // Reverter tabela SOLICITATIONS
        Schema::table('solicitations', function (Blueprint $table) {
            $table->string('type')->after('vehicle_id');
            $table->string('subtype')->after('type');
            $table->string('value')->after('subtype');
        });

        // Migrar dados de volta
        DB::statement("
            UPDATE solicitations
            SET
                type = entity_type,
                value = entity_value
        ");

        Schema::table('solicitations', function (Blueprint $table) {
            $table->dropColumn([
                'entity_type',
                'entity_value',
                'research_type',
                'calculated_price',
                'auto_renewal',
                'notes'
            ]);
        });
    }
};
