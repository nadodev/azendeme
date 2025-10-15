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
        Schema::create('event_equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Nome do equipamento (ex: Cabine de Fotos, Plataforma 360, Túnel)
            $table->text('description')->nullable();
            $table->decimal('hourly_rate', 8, 2); // Valor por hora
            $table->integer('minimum_hours')->default(1); // Horas mínimas de contratação
            $table->boolean('is_active')->default(true);
            $table->text('setup_requirements')->nullable(); // Requisitos de montagem
            $table->text('technical_specs')->nullable(); // Especificações técnicas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_equipment');
    }
};