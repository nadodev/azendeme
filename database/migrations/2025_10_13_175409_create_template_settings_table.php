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
        Schema::create('template_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            
            // Cores do template
            $table->string('primary_color')->default('#8B5CF6');
            $table->string('secondary_color')->default('#A78BFA');
            $table->string('accent_color')->default('#7C3AED');
            $table->string('background_color')->default('#0F0F10');
            $table->string('text_color')->default('#F5F5F5');
            
            // Textos personalizáveis
            $table->string('hero_title')->nullable();
            $table->text('hero_subtitle')->nullable();
            $table->string('hero_badge')->nullable();
            
            $table->string('services_title')->nullable();
            $table->text('services_subtitle')->nullable();
            
            $table->string('gallery_title')->nullable();
            $table->text('gallery_subtitle')->nullable();
            
            $table->string('contact_title')->nullable();
            $table->text('contact_subtitle')->nullable();
            
            // Configurações adicionais
            $table->boolean('show_hero_badge')->default(true);
            $table->boolean('show_dividers')->default(true);
            $table->string('button_style')->default('rounded'); // rounded, square, pill
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_settings');
    }
};
