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
        Schema::create('event_service_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('budget_id')->nullable()->constrained('event_budgets')->onDelete('set null');
            $table->string('order_number')->unique(); // Número da OS
            $table->date('order_date'); // Data da OS
            $table->date('scheduled_date'); // Data agendada para execução
            $table->time('scheduled_start_time'); // Horário de início
            $table->time('scheduled_end_time'); // Horário de término
            $table->text('description')->nullable(); // Descrição dos serviços
            $table->text('equipment_list')->nullable(); // Lista de equipamentos
            $table->text('employee_assignments')->nullable(); // Atribuições de funcionários
            $table->text('setup_instructions')->nullable(); // Instruções de montagem
            $table->text('special_requirements')->nullable(); // Requisitos especiais
            $table->enum('status', ['rascunho', 'agendada', 'em_execucao', 'concluida', 'cancelada'])->default('rascunho');
            $table->text('completion_notes')->nullable(); // Notas de conclusão
            $table->text('issues_encountered')->nullable(); // Problemas encontrados
            $table->decimal('total_value', 10, 2)->default(0); // Valor total da OS
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_service_orders');
    }
};