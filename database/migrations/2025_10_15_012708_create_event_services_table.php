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
        Schema::create('event_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('equipment_id')->constrained('event_equipment')->onDelete('cascade');
            $table->integer('hours'); // Quantidade de horas contratadas
            $table->decimal('hourly_rate', 8, 2); // Taxa por hora no momento da contratação
            $table->decimal('total_value', 10, 2); // Valor total (hours * hourly_rate)
            $table->text('notes')->nullable(); // Observações específicas para este serviço
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_services');
    }
};