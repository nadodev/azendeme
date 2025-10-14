<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Programa de Fidelidade - Configuração
        Schema::create('loyalty_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Nome do programa
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->integer('points_per_visit')->default(10); // Pontos por visita
            $table->decimal('points_per_currency', 10, 2)->default(1); // Pontos por real gasto
            $table->integer('points_expiry_days')->nullable(); // Dias para expirar pontos
            $table->timestamps();
        });

        // Pontos dos Clientes
        Schema::create('loyalty_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->integer('points')->default(0);
            $table->integer('total_earned')->default(0); // Total ganho histórico
            $table->integer('total_redeemed')->default(0); // Total resgatado histórico
            $table->timestamps();
            
            $table->unique(['professional_id', 'customer_id']);
        });

        // Histórico de Pontos
        Schema::create('loyalty_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('type', ['earned', 'redeemed', 'expired', 'adjusted']);
            $table->integer('points'); // Positivo para ganho, negativo para uso
            $table->text('description')->nullable();
            $table->date('expires_at')->nullable();
            $table->timestamps();
            
            $table->index(['customer_id', 'type']);
        });

        // Recompensas (prêmios que podem ser resgatados)
        Schema::create('loyalty_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('points_required'); // Pontos necessários
            $table->enum('reward_type', ['discount_percentage', 'discount_fixed', 'free_service', 'product']);
            $table->decimal('discount_value', 10, 2)->nullable(); // Valor do desconto
            $table->foreignId('free_service_id')->nullable()->constrained('services')->onDelete('set null');
            $table->boolean('active')->default(true);
            $table->integer('max_redemptions')->nullable(); // Limite de resgates
            $table->integer('current_redemptions')->default(0);
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->timestamps();
        });

        // Resgate de Recompensas
        Schema::create('loyalty_redemptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('reward_id')->constrained('loyalty_rewards')->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('points_used');
            $table->enum('status', ['pending', 'used', 'expired', 'cancelled'])->default('pending');
            $table->string('redemption_code')->unique();
            $table->date('expires_at')->nullable();
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
        });

        // Promoções e Pacotes
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['discount', 'package', 'bonus_points', 'free_service']);
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->decimal('discount_fixed', 10, 2)->nullable();
            $table->integer('bonus_points')->nullable();
            $table->json('service_ids')->nullable(); // Serviços incluídos
            $table->json('target_customer_ids')->nullable(); // Clientes específicos
            $table->enum('target_segment', ['all', 'new', 'loyal', 'inactive', 'vip'])->default('all');
            $table->boolean('active')->default(true);
            $table->date('valid_from');
            $table->date('valid_until');
            $table->integer('max_uses')->nullable();
            $table->integer('current_uses')->default(0);
            $table->string('promo_code')->nullable()->unique();
            $table->boolean('auto_send')->default(false); // Envio automático
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });

        // Uso de Promoções
        Schema::create('promotion_uses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotion_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('discount_applied', 10, 2)->nullable();
            $table->timestamps();
        });

        // Links de Redes Sociais
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->enum('platform', ['instagram', 'facebook', 'tiktok', 'whatsapp', 'twitter', 'youtube']);
            $table->string('url');
            $table->boolean('show_booking_button')->default(true);
            $table->boolean('active')->default(true);
            $table->integer('click_count')->default(0);
            $table->timestamps();
        });

        // Segmentação de Clientes (para análise e marketing)
        Schema::create('customer_segments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->enum('segment', ['new', 'active', 'loyal', 'vip', 'inactive', 'at_risk']);
            $table->integer('visit_count')->default(0);
            $table->decimal('total_spent', 10, 2)->default(0);
            $table->decimal('average_ticket', 10, 2)->default(0);
            $table->date('last_visit')->nullable();
            $table->date('first_visit')->nullable();
            $table->integer('days_since_last_visit')->nullable();
            $table->timestamps();
            
            $table->unique(['professional_id', 'customer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_segments');
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('promotion_uses');
        Schema::dropIfExists('promotions');
        Schema::dropIfExists('loyalty_redemptions');
        Schema::dropIfExists('loyalty_rewards');
        Schema::dropIfExists('loyalty_transactions');
        Schema::dropIfExists('loyalty_points');
        Schema::dropIfExists('loyalty_programs');
    }
};
