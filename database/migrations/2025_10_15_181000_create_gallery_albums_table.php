<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_albums', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professional_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();

            $table->index(['professional_id', 'order']);
        });

        if (!Schema::hasColumn('galleries', 'album_id')) {
            Schema::table('galleries', function (Blueprint $table) {
                $table->unsignedBigInteger('album_id')->nullable()->after('professional_id');
                $table->index('album_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('galleries', 'album_id')) {
            Schema::table('galleries', function (Blueprint $table) {
                $table->dropIndex(['album_id']);
                $table->dropColumn('album_id');
            });
        }

        Schema::dropIfExists('gallery_albums');
    }
};


