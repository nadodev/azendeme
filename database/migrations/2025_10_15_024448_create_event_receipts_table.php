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
        Schema::create('event_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_id')->nullable()->constrained('event_payments')->onDelete('set null');
            $table->string('receipt_number')->unique(); // Número do recibo
            $table->date('receipt_date'); // Data do recibo
            $table->text('description'); // Descrição do pagamento
            $table->decimal('amount', 10, 2); // Valor recebido
            $table->enum('payment_method', ['dinheiro', 'cartao_credito', 'cartao_debito', 'pix', 'transferencia', 'cheque', 'outro']); // Método de pagamento
            $table->string('payment_reference')->nullable(); // Referência do pagamento
            $table->text('payer_name'); // Nome do pagador
            $table->string('payer_document')->nullable(); // CPF/CNPJ do pagador
            $table->text('payer_address')->nullable(); // Endereço do pagador
            $table->text('services_description'); // Descrição dos serviços
            $table->enum('status', ['rascunho', 'emitido', 'pago', 'cancelado'])->default('rascunho');
            $table->text('notes')->nullable(); // Observações
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_receipts');
    }
};