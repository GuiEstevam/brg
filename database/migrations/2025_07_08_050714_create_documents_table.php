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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('file_path');
            $table->string('document_type'); // 'cnh', 'crlv', 'photocheck', 'rg', 'proof_of_residence'
            $table->string('original_name');
            $table->string('mime_type');
            $table->integer('size');
            $table->date('expiration_date')->nullable();

            // Status do documento
            $table->string('status')->default('pending_validation'); // 'pending_validation', 'validated', 'rejected', 'expired'

            // Relacionamento polimórfico
            $table->unsignedBigInteger('owner_id');
            $table->string('owner_type'); // 'App\Models\Driver' ou 'App\Models\Vehicle'

            // Controle de upload/validação
            $table->unsignedBigInteger('uploaded_by_user_id')->nullable();
            $table->unsignedBigInteger('validated_by_user_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes para performance e integridade
            $table->index(['owner_id', 'owner_type']);
            $table->foreign('uploaded_by_user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('validated_by_user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
