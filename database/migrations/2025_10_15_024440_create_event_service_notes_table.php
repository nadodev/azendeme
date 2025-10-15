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
        Schema::create('event_service_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_order_id')->nullable()->constrained('event_service_orders')->onDelete('set null');
            $table->string('note_number')->unique(); // Número da nota
            $table->date('note_date'); // Data da nota
            $table->text('description'); // Descrição dos serviços prestados
            $table->text('equipment_used'); // Equipamentos utilizados
            $table->text('hours_worked'); // Horas trabalhadas
            $table->text('team_members'); // Membros da equipe
            $table->text('observations')->nullable(); // Observações
            $table->text('issues_encountered')->nullable(); // Problemas encontrados
            $table->text('solutions_applied')->nullable(); // Soluções aplicadas
            $table->text('client_feedback')->nullable(); // Feedback do cliente
            $table->decimal('total_hours', 8, 2); // Total de horas
            $table->decimal('hourly_rate', 8, 2); // Taxa por hora
            $table->decimal('total_value', 10, 2); // Valor total
            $table->enum('status', ['rascunho', 'enviada', 'aprovada', 'rejeitada'])->default('rascunho');
            $table->text('notes')->nullable(); // Observações adicionais
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_service_notes');
    }
};