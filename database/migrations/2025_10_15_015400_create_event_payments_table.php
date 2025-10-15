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
        Schema::create('event_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('invoice_id')->nullable()->constrained('event_invoices')->onDelete('set null');
            $table->string('payment_number')->unique(); // Número do pagamento
            $table->date('payment_date'); // Data do pagamento
            $table->decimal('amount', 10, 2); // Valor do pagamento
            $table->enum('payment_method', ['dinheiro', 'cartao_credito', 'cartao_debito', 'pix', 'transferencia', 'cheque', 'outro']); // Método de pagamento
            $table->string('payment_reference')->nullable(); // Referência do pagamento (PIX, comprovante, etc.)
            $table->enum('status', ['pendente', 'confirmado', 'cancelado'])->default('pendente');
            $table->text('notes')->nullable(); // Observações
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_payments');
    }
};