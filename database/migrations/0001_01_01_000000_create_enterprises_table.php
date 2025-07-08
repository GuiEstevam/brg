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
        Schema::create('enterprises', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj')->unique();
            $table->string('name');
            $table->string('state_registration')->nullable();
            $table->string('address');
            $table->string('number');
            $table->string('uf');
            $table->string('complement')->nullable();
            $table->string('cep');
            $table->string('district');
            $table->string('city');
            $table->string('status')->default('active');
            $table->timestamp('deactivated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enterprises');
    }
};
