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
        Schema::create('event_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('budget_id')->nullable()->constrained('event_budgets')->onDelete('set null');
            $table->string('contract_number')->unique(); // Número do contrato
            $table->date('contract_date'); // Data do contrato
            $table->date('start_date'); // Data de início
            $table->date('end_date'); // Data de término
            $table->text('terms_and_conditions'); // Termos e condições
            $table->text('payment_terms'); // Termos de pagamento
            $table->text('cancellation_policy'); // Política de cancelamento
            $table->text('liability_terms'); // Termos de responsabilidade
            $table->decimal('total_value', 10, 2); // Valor total
            $table->decimal('advance_payment', 10, 2)->default(0); // Pagamento antecipado
            $table->decimal('final_payment', 10, 2)->default(0); // Pagamento final
            $table->enum('status', ['rascunho', 'enviado', 'assinado', 'ativo', 'concluido', 'cancelado'])->default('rascunho');
            $table->date('signed_date')->nullable(); // Data de assinatura
            $table->text('signature_data')->nullable(); // Dados da assinatura digital
            $table->text('notes')->nullable(); // Observações
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_contracts');
    }
};