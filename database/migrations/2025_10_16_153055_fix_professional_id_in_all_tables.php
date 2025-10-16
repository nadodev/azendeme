<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        // Corrige professional_id em todas as tabelas
        // Problema: registros antigos usam user_id quando deveriam usar user->professional->id
        
        $users = User::with('professional')->get();
        
        foreach ($users as $user) {
            if (!$user->professional) {
                continue;
            }
            
            $userId = $user->id;
            $professionalId = $user->professional->id;
            
            // Se são iguais, não precisa corrigir
            if ($userId === $professionalId) {
                continue;
            }
            
            // Lista de tabelas para corrigir
            $tables = [
                'services',
                'employees',
                'customers',
                'appointments',
                'availabilities',
                'blocked_dates',
                'galleries',
                'gallery_albums',
                'events',
                'event_equipment',
                'event_cost_categories',
                'payment_methods',
                'transaction_categories',
                'financial_transactions',
                'commissions',
                'feedbacks',
                'feedback_requests',
                'loyalty_programs',
                'loyalty_rewards',
                'promotions',
                'quick_booking_links',
                'email_campaigns',
                'customer_segments',
                'blog_posts',
                'blog_categories',
                'seo_settings',
                'template_settings',
                'social_links',
                'bio_pages',
                'waitlists',
            ];
            
            foreach ($tables as $table) {
                // Verifica se tabela e coluna existem
                if (!Schema::hasTable($table) || !Schema::hasColumn($table, 'professional_id')) {
                    continue;
                }
                
                // Atualiza registros com professional_id incorreto
                DB::table($table)
                    ->where('professional_id', $userId)
                    ->update(['professional_id' => $professionalId]);
            }
        }
    }

    public function down(): void
    {
        // Não há volta - os dados corrigidos são os corretos
    }
};
