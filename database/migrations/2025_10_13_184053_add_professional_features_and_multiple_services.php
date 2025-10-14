<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Adicionar campos ao professionals
        Schema::table('professionals', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('bio');
            $table->string('specialty')->nullable()->after('photo');
            $table->decimal('commission_percentage', 5, 2)->default(0)->after('specialty');
            $table->boolean('is_main')->default(true)->after('commission_percentage');
        });

        // Adicionar campos aos services
        Schema::table('services', function (Blueprint $table) {
            $table->foreignId('assigned_professional_id')->nullable()->after('professional_id')->constrained('professionals')->onDelete('set null');
            $table->boolean('allows_multiple')->default(false)->after('active');
        });

        // Tabela para agendamentos com múltiplos serviços
        Schema::create('appointment_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->integer('duration');
            $table->foreignId('assigned_professional_id')->nullable()->constrained('professionals')->onDelete('set null');
            $table->timestamps();
        });

        // Tabela de comissões
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->foreignId('financial_transaction_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('service_amount', 10, 2);
            $table->decimal('commission_percentage', 5, 2);
            $table->decimal('commission_amount', 10, 2);
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->date('period_start');
            $table->date('period_end');
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['professional_id', 'status']);
            $table->index(['period_start', 'period_end']);
        });
    }

    public function down(): void
    {
        Schema::table('professionals', function (Blueprint $table) {
            $table->dropColumn(['photo', 'specialty', 'commission_percentage', 'is_main']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['assigned_professional_id']);
            $table->dropColumn(['assigned_professional_id', 'allows_multiple']);
        });

        Schema::dropIfExists('commissions');
        Schema::dropIfExists('appointment_services');
    }
};
