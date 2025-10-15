<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bio_pages', function (Blueprint $table) {
            $table->string('background_color')->default('#0b0b0e')->after('theme_color');
            $table->string('button_color')->default('#7c3aed')->after('background_color');
            // ensure avatar_path exists (already created), keep for clarity
        });
    }

    public function down(): void
    {
        Schema::table('bio_pages', function (Blueprint $table) {
            $table->dropColumn(['background_color', 'button_color']);
        });
    }
};


