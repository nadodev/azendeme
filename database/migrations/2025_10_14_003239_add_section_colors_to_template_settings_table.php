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
        Schema::table('template_settings', function (Blueprint $table) {
            // Cores por seção
            $table->string('hero_primary_color')->default('#8B5CF6')->after('text_color');
            $table->string('hero_background_color')->default('#FAFBFC')->after('hero_primary_color');
            
            $table->string('services_primary_color')->default('#10B981')->after('hero_background_color');
            $table->string('services_background_color')->default('#FFFFFF')->after('services_primary_color');
            
            $table->string('gallery_primary_color')->default('#EC4899')->after('services_background_color');
            $table->string('gallery_background_color')->default('#F9FAFB')->after('gallery_primary_color');
            
            $table->string('booking_primary_color')->default('#7C3AED')->after('gallery_background_color');
            $table->string('booking_background_color')->default('#F3F4F6')->after('booking_primary_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_settings', function (Blueprint $table) {
            $table->dropColumn([
                'hero_primary_color',
                'hero_background_color',
                'services_primary_color',
                'services_background_color',
                'gallery_primary_color',
                'gallery_background_color',
                'booking_primary_color',
                'booking_background_color',
            ]);
        });
    }
};