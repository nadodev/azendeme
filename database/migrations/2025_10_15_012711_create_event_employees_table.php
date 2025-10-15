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
        Schema::create('event_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Nome do funcionário
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('role'); // Função (ex: Fotógrafo, Operador, Assistente)
            $table->decimal('hourly_rate', 8, 2); // Valor por hora
            $table->integer('hours'); // Quantidade de horas trabalhadas
            $table->decimal('total_value', 10, 2); // Valor total (hours * hourly_rate)
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_employees');
    }
};