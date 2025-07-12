<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('solicitation_pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enterprise_id')->constrained()->onDelete('cascade');
            $table->string('description');
            $table->decimal('individual_driver_price', 10, 2)->nullable();
            $table->decimal('individual_vehicle_price', 10, 2)->nullable();
            $table->decimal('unified_price', 10, 2)->nullable();

            // Adicionais por placa para pesquisa unificada (2 a 4 veículos)
            $table->decimal('unified_additional_vehicle_2', 10, 2)->nullable();
            $table->decimal('unified_additional_vehicle_3', 10, 2)->nullable();
            $table->decimal('unified_additional_vehicle_4', 10, 2)->nullable();

            // Recorrência automática por tipo de pesquisa
            $table->boolean('recurrence_autonomo')->default(false);
            $table->boolean('recurrence_agregado')->default(false);
            $table->boolean('recurrence_frota')->default(false);

            // Vigências
            $table->integer('validity_days')->nullable();
            $table->integer('validity_autonomo_days')->nullable();
            $table->integer('validity_agregado_days')->nullable();
            $table->integer('validity_funcionario_days')->nullable();

            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitation_pricings');
    }
};
