<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            if (!Schema::hasColumn('employees', 'cpf')) {
                $table->string('cpf', 14)->nullable()->after('phone');
                $table->index('cpf');
            }
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            if (Schema::hasColumn('employees', 'cpf')) {
                $table->dropIndex(['cpf']);
                $table->dropColumn('cpf');
            }
        });
    }
};
