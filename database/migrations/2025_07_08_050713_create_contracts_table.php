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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enterprise_id')->constrained('enterprises');
            $table->string('plan_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default('pending'); // 'active', 'inactive', 'expired', 'pending'
            $table->integer('max_users')->nullable();
            $table->integer('max_queries')->nullable();
            $table->boolean('unlimited_queries')->default(false);
            $table->integer('total_queries_used')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
