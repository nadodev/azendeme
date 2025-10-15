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
        Schema::create('event_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('budget_id')->nullable()->constrained('event_budgets')->onDelete('set null');
            $table->string('invoice_number')->unique(); // Número da fatura
            $table->date('invoice_date'); // Data da fatura
            $table->date('due_date'); // Data de vencimento
            $table->decimal('subtotal', 10, 2)->default(0); // Subtotal
            $table->decimal('discount_percentage', 5, 2)->default(0); // Desconto em %
            $table->decimal('discount_value', 10, 2)->default(0); // Valor do desconto
            $table->decimal('tax_percentage', 5, 2)->default(0); // Imposto em %
            $table->decimal('tax_value', 10, 2)->default(0); // Valor do imposto
            $table->decimal('total', 10, 2)->default(0); // Total final
            $table->enum('status', ['rascunho', 'enviada', 'paga', 'vencida', 'cancelada'])->default('rascunho');
            $table->text('notes')->nullable(); // Observações
            $table->text('payment_terms')->nullable(); // Termos de pagamento
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_invoices');
    }
};