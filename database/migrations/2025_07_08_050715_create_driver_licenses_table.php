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
        Schema::create('driver_licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained('drivers');
            $table->string('renach_number')->nullable();
            $table->string('register_number')->nullable();
            $table->string('category')->nullable();
            $table->date('issuance_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('performs_paid_activity')->nullable();
            $table->string('moop_course')->nullable();
            $table->string('local_issuance')->nullable();
            $table->string('security_number')->nullable();
            $table->string('ordinance')->nullable();
            $table->string('restriction')->nullable();
            $table->string('mirror_number')->nullable();
            $table->integer('total_points')->nullable();

            // Campos de validação da API Dminer
            $table->string('status_cnh_image')->nullable();
            $table->string('status_message_cnh_image')->nullable();
            $table->integer('validation_status_document_image')->nullable();
            $table->integer('validation_status_cnh')->nullable();
            $table->integer('validation_status_security_number')->nullable();
            $table->integer('validation_status_uf')->nullable();
            $table->string('validation_image_message')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_licenses');
    }
};
