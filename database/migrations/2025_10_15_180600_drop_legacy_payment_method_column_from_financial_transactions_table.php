<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('financial_transactions', 'payment_method')) {
            Schema::table('financial_transactions', function (Blueprint $table) {
                $table->dropColumn('payment_method');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('financial_transactions', 'payment_method')) {
            Schema::table('financial_transactions', function (Blueprint $table) {
                $table->string('payment_method')->nullable()->after('notes');
            });
        }
    }
};


