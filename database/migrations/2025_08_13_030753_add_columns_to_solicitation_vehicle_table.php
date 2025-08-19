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
        Schema::table('solicitation_vehicle', function (Blueprint $table) {
            // Adicionar colunas para controle do relacionamento
            $table->string('vehicle_role')->nullable()->after('vehicle_id'); // 'principal', 'secundario', etc.
            $table->integer('order')->default(0)->after('vehicle_role'); // Ordem dos veículos
            $table->string('status')->default('active')->after('order'); // 'active', 'inactive', 'removed'
            $table->json('api_data')->nullable()->after('status'); // Dados específicos da API para este veículo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitation_vehicle', function (Blueprint $table) {
            $table->dropColumn(['vehicle_role', 'order', 'status', 'api_data']);
        });
    }
};
