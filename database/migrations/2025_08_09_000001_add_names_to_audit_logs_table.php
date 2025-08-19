<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->string('user_name')->nullable()->after('user_id');
            $table->string('enterprise_name')->nullable()->after('enterprise_id');
            $table->string('branch_name')->nullable()->after('branch_id');
        });
    }

    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropColumn(['user_name', 'enterprise_name', 'branch_name']);
        });
    }
};
