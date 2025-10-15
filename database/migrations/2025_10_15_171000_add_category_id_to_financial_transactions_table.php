<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('financial_transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('financial_transactions', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable()->after('type');
            }
        });

        // Se existir a coluna antiga, tenta copiar os valores
        if (Schema::hasColumn('financial_transactions', 'transaction_category_id') && Schema::hasColumn('financial_transactions', 'category_id')) {
            try {
                DB::statement('UPDATE financial_transactions SET category_id = transaction_category_id WHERE category_id IS NULL');
            } catch (\Throwable $e) {
                // ignora em bancos que não suportam
            }
        }
    }

    public function down(): void
    {
        Schema::table('financial_transactions', function (Blueprint $table) {
            if (Schema::hasColumn('financial_transactions', 'category_id')) {
                $table->dropColumn('category_id');
            }
        });
    }
};


