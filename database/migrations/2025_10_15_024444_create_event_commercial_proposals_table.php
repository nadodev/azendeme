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
        Schema::create('event_commercial_proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('proposal_number')->unique(); // Número da proposta
            $table->date('proposal_date'); // Data da proposta
            $table->date('valid_until'); // Válida até
            $table->text('executive_summary'); // Resumo executivo
            $table->text('event_description'); // Descrição do evento
            $table->text('services_offered'); // Serviços oferecidos
            $table->text('equipment_included'); // Equipamentos incluídos
            $table->text('team_structure'); // Estrutura da equipe
            $table->text('timeline'); // Cronograma
            $table->text('deliverables'); // Entregáveis
            $table->text('terms_and_conditions'); // Termos e condições
            $table->text('payment_schedule'); // Cronograma de pagamento
            $table->decimal('total_value', 10, 2); // Valor total
            $table->decimal('discount_percentage', 5, 2)->default(0); // Percentual de desconto
            $table->decimal('discount_value', 10, 2)->default(0); // Valor do desconto
            $table->decimal('final_value', 10, 2); // Valor final
            $table->enum('status', ['rascunho', 'enviada', 'em_analise', 'aprovada', 'rejeitada', 'expirada'])->default('rascunho');
            $table->text('rejection_reason')->nullable(); // Motivo da rejeição
            $table->text('notes')->nullable(); // Observações
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_commercial_proposals');
    }
};