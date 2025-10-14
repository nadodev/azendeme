<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Adicionar campos para recibos nas transações financeiras
        Schema::table('financial_transactions', function (Blueprint $table) {
            $table->string('receipt_number')->unique()->nullable()->after('id');
            $table->string('receipt_pdf_path')->nullable()->after('notes');
            $table->timestamp('receipt_issued_at')->nullable()->after('receipt_pdf_path');
        });

        // Criar tabela para controle de sequência de recibos
        Schema::create('receipt_sequences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->integer('year');
            $table->integer('month');
            $table->integer('last_number')->default(0);
            $table->timestamps();
            
            $table->unique(['professional_id', 'year', 'month']);
        });

        // Criar tabela para períodos de caixa (diário, semanal, mensal)
        Schema::create('cash_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->enum('period_type', ['daily', 'weekly', 'monthly']);
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('opening_balance', 10, 2)->default(0);
            $table->decimal('total_income', 10, 2)->default(0);
            $table->decimal('total_expense', 10, 2)->default(0);
            $table->decimal('closing_balance', 10, 2)->default(0);
            $table->integer('total_transactions')->default(0);
            $table->integer('total_appointments')->default(0);
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamp('closed_at')->nullable();
            $table->foreignId('closed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->string('report_pdf_path')->nullable();
            $table->timestamps();
            
            $table->index(['professional_id', 'period_type', 'status']);
            $table->index(['period_start', 'period_end']);
        });

        // Adicionar campos ao appointments para melhor controle
        Schema::table('appointments', function (Blueprint $table) {
            $table->decimal('total_price', 10, 2)->nullable()->after('notes');
            $table->integer('total_duration')->nullable()->after('total_price');
            $table->boolean('has_multiple_services')->default(false)->after('total_duration');
        });
    }

    public function down(): void
    {
        Schema::table('financial_transactions', function (Blueprint $table) {
            $table->dropColumn(['receipt_number', 'receipt_pdf_path', 'receipt_issued_at']);
        });

        Schema::dropIfExists('receipt_sequences');
        Schema::dropIfExists('cash_periods');

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['total_price', 'total_duration', 'has_multiple_services']);
        });
    }
};
