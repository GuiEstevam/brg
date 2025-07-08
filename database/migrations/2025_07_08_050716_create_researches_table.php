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
        Schema::create('researches', function (Blueprint $table) {
            $table->id();

            // Relacionamentos principais
            $table->foreignId('solicitation_id')->constrained('solicitations');
            $table->foreignId('driver_id')->nullable()->constrained('drivers');
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles');

            // Resposta da API Dminer
            $table->json('api_response')->nullable();

            // Status e validade
            $table->string('status_api')->nullable(); // 'Adequado ao risco', 'Inconclusivo', etc.
            $table->date('validity_date')->nullable();

            // Motivos de reprovação
            $table->json('rejection_reasons')->nullable();

            // Dados agregados
            $table->integer('total_points')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('researches');
    }
};
