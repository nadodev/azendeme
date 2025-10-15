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
        Schema::create('event_cost_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Nome da categoria
            $table->text('description')->nullable(); // Descrição
            $table->string('color')->default('#8B5CF6'); // Cor para identificação visual
            $table->boolean('is_active')->default(true); // Se está ativa
            $table->integer('sort_order')->default(0); // Ordem de exibição
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_cost_categories');
    }
};