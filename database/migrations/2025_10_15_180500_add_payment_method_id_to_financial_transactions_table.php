<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('financial_transactions', 'payment_method_id')) {
            Schema::table('financial_transactions', function (Blueprint $table) {
                $table->unsignedBigInteger('payment_method_id')->nullable()->after('notes');
                $table->index('payment_method_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('financial_transactions', 'payment_method_id')) {
            Schema::table('financial_transactions', function (Blueprint $table) {
                $table->dropIndex(['payment_method_id']);
                $table->dropColumn('payment_method_id');
            });
        }
    }
};


