<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Campos para agendamento recorrente
            $table->boolean('is_recurring')->default(false)->after('notes');
            $table->enum('recurrence_type', ['weekly', 'biweekly', 'monthly'])->nullable()->after('is_recurring');
            $table->integer('recurrence_interval')->nullable()->after('recurrence_type'); // quantas vezes repetir
            $table->date('recurrence_end_date')->nullable()->after('recurrence_interval');
            $table->foreignId('parent_appointment_id')->nullable()->constrained('appointments')->onDelete('cascade')->after('recurrence_end_date');
        });

        // Tabela de fila de espera
        Schema::create('waitlist', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->date('preferred_date')->nullable();
            $table->time('preferred_time_start')->nullable();
            $table->time('preferred_time_end')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['waiting', 'notified', 'converted', 'expired'])->default('waiting');
            $table->timestamp('notified_at')->nullable();
            $table->timestamps();
            
            $table->index(['professional_id', 'status']);
        });

        // Tabela para links de agendamento rápido
        Schema::create('quick_booking_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('token')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->integer('max_uses')->nullable();
            $table->integer('uses_count')->default(0);
            $table->date('expires_at')->nullable();
            $table->timestamps();
            
            $table->index(['professional_id', 'active']);
            $table->index('token');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['parent_appointment_id']);
            $table->dropColumn([
                'is_recurring',
                'recurrence_type',
                'recurrence_interval',
                'recurrence_end_date',
                'parent_appointment_id'
            ]);
        });
        
        Schema::dropIfExists('waitlist');
        Schema::dropIfExists('quick_booking_links');
    }
};
