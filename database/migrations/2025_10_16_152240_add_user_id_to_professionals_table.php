<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('professionals', function (Blueprint $table) {
            if (!Schema::hasColumn('professionals', 'user_id')) {
                $table->foreignId('user_id')->after('id')->constrained('users')->onDelete('cascade');
                $table->index('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('professionals', function (Blueprint $table) {
            if (Schema::hasColumn('professionals', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropIndex(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};
