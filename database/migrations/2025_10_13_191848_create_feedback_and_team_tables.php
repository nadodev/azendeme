<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Sistema de Feedback
        Schema::create('feedback_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->string('token')->unique(); // Token único para o link
            $table->enum('status', ['pending', 'completed', 'expired'])->default('pending');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->date('expires_at');
            $table->timestamps();
            
            $table->index(['token', 'status']);
        });

        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->foreignId('feedback_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->integer('rating')->unsigned(); // 1-5 estrelas
            $table->text('comment')->nullable();
            $table->text('what_liked')->nullable(); // O que mais gostou
            $table->text('what_improve')->nullable(); // O que pode melhorar
            $table->boolean('would_recommend')->default(true);
            $table->boolean('visible_public')->default(true); // Exibir na página pública
            $table->boolean('approved')->default(true); // Aprovação do profissional
            $table->timestamps();
            
            $table->index(['professional_id', 'rating', 'visible_public']);
        });

        // Configuração de Equipe/Profissionais
        Schema::table('professionals', function (Blueprint $table) {
            $table->boolean('is_team_mode')->default(false)->after('is_main');
            $table->json('team_member_ids')->nullable()->after('is_team_mode'); // IDs dos profissionais da equipe
        });

        // Adicionar campo de profissional responsável em availabilities
        Schema::table('availabilities', function (Blueprint $table) {
            $table->foreignId('assigned_professional_id')->nullable()->after('professional_id')->constrained('professionals')->onDelete('cascade');
        });

        // Notificações de Feedback
        Schema::create('feedback_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->foreignId('feedback_id')->constrained('feedbacks')->onDelete('cascade');
            $table->boolean('read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback_notifications');
        
        Schema::table('availabilities', function (Blueprint $table) {
            $table->dropForeign(['assigned_professional_id']);
            $table->dropColumn('assigned_professional_id');
        });

        Schema::table('professionals', function (Blueprint $table) {
            $table->dropColumn(['is_team_mode', 'team_member_ids']);
        });

        Schema::dropIfExists('feedbacks');
        Schema::dropIfExists('feedback_requests');
    }
};
