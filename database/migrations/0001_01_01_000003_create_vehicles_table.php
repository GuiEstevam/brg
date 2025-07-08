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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate')->unique();
            $table->string('renavam')->unique()->nullable();
            $table->string('chassi')->unique()->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('manufacture_year')->nullable();
            $table->string('model_year')->nullable();
            $table->string('color')->nullable();
            $table->string('fuel')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('vehicle_specie')->nullable();
            $table->date('licensing_date')->nullable();
            $table->string('licensing_status')->nullable();
            $table->string('owner_document')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('lessee_document')->nullable();
            $table->string('lessee_name')->nullable();
            $table->string('antt_situation')->nullable();
            $table->string('status')->default('pending_onboarding'); // 'active', 'pending_onboarding', 'awaiting_documents'
            $table->timestamps();
            $table->softDeletes(); // Permite soft delete para histórico
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
