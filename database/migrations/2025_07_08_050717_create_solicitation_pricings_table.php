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
        Schema::create('solicitation_pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enterprise_id')->constrained('enterprises');

            // Preços base
            $table->decimal('individual_driver_price', 10, 2);
            $table->decimal('individual_vehicle_price', 10, 2);
            $table->decimal('unified_price', 10, 2);

            // Recorrência base
            $table->boolean('individual_driver_recurring')->default(false);
            $table->boolean('individual_vehicle_recurring')->default(false);
            $table->boolean('unified_recurring')->default(false);

            // Validade base
            $table->integer('validity_days')->nullable();

            // Precificação granular por tipo de pesquisa e serviço
            $table->decimal('price_expressa_driver', 10, 2)->nullable();
            $table->decimal('price_normal_driver', 10, 2)->nullable();
            $table->decimal('price_plus_driver', 10, 2)->nullable();

            $table->decimal('price_expressa_vehicle', 10, 2)->nullable();
            $table->decimal('price_normal_vehicle', 10, 2)->nullable();
            $table->decimal('price_plus_vehicle', 10, 2)->nullable();

            $table->decimal('price_expressa_unified', 10, 2)->nullable();
            $table->decimal('price_normal_unified', 10, 2)->nullable();
            $table->decimal('price_plus_unified', 10, 2)->nullable();

            // Preços adicionais por veículo (para pesquisa unificada)
            $table->decimal('unified_additional_per_vehicle_expressa', 10, 2)->nullable();
            $table->decimal('unified_additional_per_vehicle_normal', 10, 2)->nullable();
            $table->decimal('unified_additional_per_vehicle_plus', 10, 2)->nullable();

            // Validade por tipo de vínculo
            $table->integer('validity_autonomo_days')->nullable();
            $table->integer('validity_agregado_days')->nullable();
            $table->integer('validity_funcionario_days')->nullable();

            // Outros campos
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitation_pricings');
    }
};
