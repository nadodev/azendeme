<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('availabilities', function (Blueprint $table) {
            if (!Schema::hasColumn('availabilities', 'employee_id')) {
                $table->unsignedBigInteger('employee_id')->nullable()->index()->after('professional_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('availabilities', function (Blueprint $table) {
            if (Schema::hasColumn('availabilities', 'employee_id')) {
                $table->dropColumn('employee_id');
            }
        });
    }
};


