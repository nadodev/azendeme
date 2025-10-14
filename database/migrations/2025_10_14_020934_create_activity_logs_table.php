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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professional_id');
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // Quem fez a ação (admin/profissional)
            $table->string('action'); // created, updated, cancelled, confirmed, completed, etc.
            $table->string('entity_type'); // appointment, customer, service, etc.
            $table->unsignedBigInteger('entity_id')->nullable(); // ID da entidade afetada
            $table->json('old_values')->nullable(); // Valores anteriores
            $table->json('new_values')->nullable(); // Novos valores
            $table->text('description')->nullable(); // Descrição da ação
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();

            $table->index(['professional_id', 'created_at']);
            $table->index(['appointment_id']);
            $table->index(['customer_id']);
            $table->index(['action']);
            $table->index(['entity_type', 'entity_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};