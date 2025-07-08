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
        Schema::create('solicitation_vehicle', function (Blueprint $table) {
            $table->unsignedBigInteger('solicitation_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->timestamps();

            // Chave primária composta
            $table->primary(['solicitation_id', 'vehicle_id']);

            // Chaves estrangeiras
            $table->foreign('solicitation_id')->references('id')->on('solicitations')->onDelete('cascade');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitation_vehicle');
    }
};
