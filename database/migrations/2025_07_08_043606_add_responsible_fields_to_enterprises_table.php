<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enterprises', function (Blueprint $table) {
            // Campos de responsável
            $table->unsignedBigInteger('user_id')->nullable()->after('city');
            $table->string('responsible_name')->nullable()->after('user_id');
            $table->string('responsible_email')->nullable()->after('responsible_name');
            $table->string('responsible_phone')->nullable()->after('responsible_email');

            // Foreign key
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('enterprises', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'responsible_name', 'responsible_email', 'responsible_phone']);
        });
    }
};
