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
        Schema::create('event_budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('budget_number')->unique(); // Número do orçamento
            $table->date('valid_until'); // Válido até
            $table->decimal('equipment_total', 10, 2)->default(0); // Total dos equipamentos
            $table->decimal('employees_total', 10, 2)->default(0); // Total dos funcionários
            $table->decimal('subtotal', 10, 2)->default(0); // Subtotal
            $table->decimal('discount_percentage', 5, 2)->default(0); // Desconto em %
            $table->decimal('discount_value', 10, 2)->default(0); // Valor do desconto
            $table->decimal('total', 10, 2)->default(0); // Total final
            $table->enum('status', ['rascunho', 'enviado', 'aprovado', 'rejeitado', 'expirado'])->default('rascunho');
            $table->text('notes')->nullable();
            $table->text('terms')->nullable(); // Termos e condições
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_budgets');
    }
};