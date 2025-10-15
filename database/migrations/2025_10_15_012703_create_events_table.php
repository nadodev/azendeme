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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['formatura', 'aniversario', 'casamento', 'carnaval', 'corporativo', 'outro']);
            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code')->nullable();
            $table->enum('status', ['orcamento', 'confirmado', 'em_andamento', 'concluido', 'cancelado'])->default('orcamento');
            $table->decimal('total_value', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('final_value', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->text('equipment_notes')->nullable();
            $table->text('setup_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};