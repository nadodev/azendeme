<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            
            // Tipo e categoria
            $table->enum('type', ['income', 'expense']); // receita ou despesa
            $table->unsignedBigInteger('category_id')->nullable();
            
            // Valores
            $table->decimal('amount', 10, 2); // Valor da transação
            $table->string('description'); // Descrição
            $table->text('notes')->nullable(); // Observações adicionais
            
            // Pagamento
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('completed');
            
            // Relacionamentos opcionais
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            
            // Dados temporais
            $table->date('transaction_date'); // Data da transação
            $table->timestamp('paid_at')->nullable(); // Quando foi pago
            
            // Controle
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            
            // Índices para performance
            $table->index(['professional_id', 'transaction_date']);
            $table->index(['professional_id', 'type']);
            $table->index('appointment_id');
            $table->index('category_id');
            $table->index('payment_method_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};
