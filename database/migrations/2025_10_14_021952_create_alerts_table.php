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
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professional_id');
            $table->string('type'); // new_appointment, cancelled_appointment, new_customer, payment_received, etc.
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); // Dados adicionais do alerta
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['unread', 'read', 'archived'])->default('unread');
            $table->timestamp('read_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();

            $table->index(['professional_id', 'status']);
            $table->index(['type']);
            $table->index(['priority']);
            $table->index(['created_at']);
        });

        // Tabela para configurações de alertas por profissional
        Schema::create('alert_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professional_id');
            $table->string('alert_type'); // Tipo de alerta
            $table->boolean('enabled')->default(true); // Se o alerta está habilitado
            $table->json('channels')->nullable(); // Canais de notificação (email, sms, push, etc.)
            $table->json('conditions')->nullable(); // Condições específicas para o alerta
            $table->timestamps();

            $table->unique(['professional_id', 'alert_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alert_settings');
        Schema::dropIfExists('alerts');
    }
};