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
        Schema::create('event_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('cost_category_id')->constrained('event_cost_categories')->onDelete('cascade');
            $table->string('cost_number')->unique(); // Número do custo
            $table->date('cost_date'); // Data do custo
            $table->string('description'); // Descrição do custo
            $table->text('details')->nullable(); // Detalhes adicionais
            $table->decimal('amount', 10, 2); // Valor do custo
            $table->enum('cost_type', ['fixo', 'variavel', 'imprevisto'])->default('variavel'); // Tipo de custo
            $table->enum('payment_status', ['pendente', 'pago', 'parcelado'])->default('pendente'); // Status do pagamento
            $table->date('due_date')->nullable(); // Data de vencimento
            $table->string('supplier')->nullable(); // Fornecedor
            $table->string('invoice_number')->nullable(); // Número da nota fiscal
            $table->string('payment_reference')->nullable(); // Referência do pagamento
            $table->enum('status', ['rascunho', 'confirmado', 'pago', 'cancelado'])->default('rascunho');
            $table->text('notes')->nullable(); // Observações
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_costs');
    }
};