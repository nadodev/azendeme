<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Alterar a coluna reward_type para aceitar os valores corretos
        DB::statement("ALTER TABLE loyalty_rewards MODIFY COLUMN reward_type ENUM('percentage', 'fixed', 'free_service', 'product') NOT NULL");
    }

    public function down(): void
    {
        // Reverter para os valores antigos
        DB::statement("ALTER TABLE loyalty_rewards MODIFY COLUMN reward_type ENUM('discount_percentage', 'discount_fixed', 'free_service', 'product') NOT NULL");
    }
};
