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
        Schema::table('event_invoices', function (Blueprint $table) {
            $table->foreignId('service_order_id')->nullable()->after('budget_id')->constrained('event_service_orders')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_invoices', function (Blueprint $table) {
            $table->dropForeign(['service_order_id']);
            $table->dropColumn('service_order_id');
        });
    }
};