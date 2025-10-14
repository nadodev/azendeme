<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaction_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Ex: Serviços, Produtos, Aluguel, Energia, etc
            $table->enum('type', ['income', 'expense']); // receita ou despesa
            $table->string('color')->default('#6366F1'); // Cor para identificação visual
            $table->string('icon')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_categories');
    }
};
