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
        Schema::table('model_has_roles', function (Blueprint $table) {
            // Remover chave primária composta antes de remover a coluna
            $table->dropPrimary(['role_id', 'model_type', 'model_id', 'team_id']);
        });
        Schema::table('model_has_roles', function (Blueprint $table) {
            if (Schema::hasColumn('model_has_roles', 'team_id')) {
                $table->dropColumn('team_id');
            }
            // Recriar chave primária sem o team_id
            $table->primary(['role_id', 'model_type', 'model_id']);
        });

        Schema::table('model_has_permissions', function (Blueprint $table) {
            // Repita o mesmo processo se necessário
            if (Schema::hasColumn('model_has_permissions', 'team_id')) {
                $table->dropColumn('team_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('model_has_roles', function (Blueprint $table) {
            if (!Schema::hasColumn('model_has_roles', 'team_id')) {
                $table->unsignedBigInteger('team_id')->nullable();
            }
        });

        Schema::table('model_has_permissions', function (Blueprint $table) {
            if (!Schema::hasColumn('model_has_permissions', 'team_id')) {
                $table->unsignedBigInteger('team_id')->nullable();
            }
        });
    }
};
