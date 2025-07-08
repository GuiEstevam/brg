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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('cpf', 14)->unique();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('rg_number')->nullable();
            $table->string('rg_uf', 2)->nullable();
            $table->string('status')->default('pending_onboarding'); // 'active', 'pending_onboarding', 'awaiting_documents'
            $table->timestamps();
            $table->softDeletes(); // Habilita Soft Deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
