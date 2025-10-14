<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            // Adiciona colunas faltantes
            $table->decimal('min_purchase', 10, 2)->nullable()->after('promo_code');
            $table->integer('max_uses_per_customer')->nullable()->after('max_uses');
        });
    }

    public function down(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->dropColumn(['min_purchase', 'max_uses_per_customer']);
        });
    }
};
