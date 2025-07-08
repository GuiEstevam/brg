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
        Schema::create('solicitations', function (Blueprint $table) {
            $table->id();

            // Relacionamentos principais
            $table->foreignId('enterprise_id')->constrained('enterprises');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('branch_id')->nullable()->constrained('branches');

            // Vínculo com entidades centrais
            $table->foreignId('driver_id')->nullable()->constrained('drivers');
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles');

            // Tipo e detalhamento da solicitação
            $table->string('type'); // 'driver', 'vehicle', 'composed'
            $table->string('subtype'); // 'person_process', 'cnh', 'vehicle_data', etc.
            $table->string('value'); // CPF ou Placa principal pesquisada
            $table->string('status')->default('pending'); // 'pending', 'completed', 'inconclusive', etc.

            // Regras de negócio específicas
            $table->string('vincle_type')->nullable(); // 'Autonomo', 'Agregado', 'Funcionario'
            $table->string('research_type')->nullable(); // 'Expressa', 'Normal', 'Pesquisa_Mais'

            // Controle de fluxo
            $table->foreignId('original_solicitation_id')->nullable()->constrained('solicitations');

            // Dados da API
            $table->json('api_request_data')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitations');
    }
};
