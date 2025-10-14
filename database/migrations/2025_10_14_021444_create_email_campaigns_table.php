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
        Schema::create('email_campaigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professional_id');
            $table->string('name'); // Nome da campanha
            $table->string('subject'); // Assunto do e-mail
            $table->text('content'); // Conteúdo HTML do e-mail
            $table->text('text_content')->nullable(); // Versão texto do e-mail
            $table->enum('status', ['draft', 'scheduled', 'sending', 'sent', 'cancelled'])->default('draft');
            $table->enum('type', ['newsletter', 'promotion', 'reminder', 'follow_up', 'custom'])->default('custom');
            $table->json('target_criteria')->nullable(); // Critérios de segmentação
            $table->json('schedule_settings')->nullable(); // Configurações de agendamento
            $table->timestamp('scheduled_at')->nullable(); // Quando enviar
            $table->timestamp('sent_at')->nullable(); // Quando foi enviado
            $table->integer('total_recipients')->default(0); // Total de destinatários
            $table->integer('sent_count')->default(0); // Quantos foram enviados
            $table->integer('delivered_count')->default(0); // Quantos foram entregues
            $table->integer('opened_count')->default(0); // Quantos abriram
            $table->integer('clicked_count')->default(0); // Quantos clicaram
            $table->integer('bounced_count')->default(0); // Quantos retornaram
            $table->integer('unsubscribed_count')->default(0); // Quantos cancelaram inscrição
            $table->text('notes')->nullable(); // Notas da campanha
            $table->timestamps();

            $table->index(['professional_id', 'status']);
            $table->index(['scheduled_at']);
            $table->index(['type']);
        });

        // Tabela para rastrear envios individuais
        Schema::create('email_campaign_recipients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('customer_id');
            $table->string('email');
            $table->enum('status', ['pending', 'sent', 'delivered', 'opened', 'clicked', 'bounced', 'unsubscribed'])->default('pending');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('clicked_at')->nullable();
            $table->timestamp('bounced_at')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->json('tracking_data')->nullable(); // Dados de rastreamento
            $table->timestamps();

            $table->foreign('campaign_id')->references('id')->on('email_campaigns')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->index(['campaign_id', 'status']);
            $table->index(['email']);
        });

        // Tabela para templates de e-mail
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professional_id');
            $table->string('name'); // Nome do template
            $table->string('subject'); // Assunto padrão
            $table->text('content'); // Conteúdo HTML
            $table->text('text_content')->nullable(); // Versão texto
            $table->enum('type', ['newsletter', 'promotion', 'reminder', 'follow_up', 'custom'])->default('custom');
            $table->json('variables')->nullable(); // Variáveis disponíveis no template
            $table->boolean('is_default')->default(false); // Template padrão
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->index(['professional_id', 'type']);
            $table->index(['is_default']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_templates');
        Schema::dropIfExists('email_campaign_recipients');
        Schema::dropIfExists('email_campaigns');
    }
};