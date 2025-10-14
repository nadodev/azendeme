<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cash_registers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->date('date'); // Data do caixa
            $table->decimal('opening_balance', 10, 2)->default(0); // Saldo inicial
            $table->decimal('total_income', 10, 2)->default(0); // Total de entradas
            $table->decimal('total_expense', 10, 2)->default(0); // Total de saídas
            $table->decimal('closing_balance', 10, 2)->default(0); // Saldo final
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->unsignedBigInteger('opened_by')->nullable();
            $table->unsignedBigInteger('closed_by')->nullable();
            $table->text('notes')->nullable();
            
            // Foreign keys
            $table->foreign('opened_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('closed_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
            
            // Índice único para garantir apenas um caixa por dia/profissional
            $table->unique(['professional_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_registers');
    }
};
