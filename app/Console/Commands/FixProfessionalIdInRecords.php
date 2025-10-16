<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class FixProfessionalIdInRecords extends Command
{
    protected $signature = 'fix:professional-id';
    protected $description = 'Corrige professional_id nos registros (de user_id para professional->id)';

    public function handle()
    {
        $this->info('🔍 Verificando inconsistências em professional_id...');
        
        $users = User::with('professional')->get();
        
        if ($users->isEmpty()) {
            $this->error('Nenhum usuário encontrado!');
            return 1;
        }
        
        $tablesFixed = 0;
        $recordsFixed = 0;
        
        // Tabelas que têm professional_id
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
            'blog_tags',
            'seo_settings',
            'template_settings',
            'social_links',
            'bio_pages',
            'waitlists',
        ];
        
        foreach ($users as $user) {
            if (!$user->professional) {
                $this->warn("⚠️  User {$user->id} ({$user->email}) não tem professional");
                continue;
            }
            
            $userId = $user->id;
            $professionalId = $user->professional->id;
            
            // Se user_id == professional_id, não precisa corrigir
            if ($userId === $professionalId) {
                continue;
            }
            
            $this->info("\n👤 User: {$user->name} (id: {$userId})");
            $this->info("   Professional ID correto: {$professionalId}");
            
            foreach ($tables as $table) {
                // Verifica se a tabela existe
                if (!DB::getSchemaBuilder()->hasTable($table)) {
                    continue;
                }
                
                // Verifica se a coluna professional_id existe
                if (!DB::getSchemaBuilder()->hasColumn($table, 'professional_id')) {
                    continue;
                }
                
                // Conta registros com professional_id incorreto (= user_id)
                $count = DB::table($table)
                    ->where('professional_id', $userId)
                    ->count();
                
                if ($count > 0) {
                    // Atualiza para o professional_id correto
                    DB::table($table)
                        ->where('professional_id', $userId)
                        ->update(['professional_id' => $professionalId]);
                    
                    $this->line("   ✅ {$table}: {$count} registros corrigidos");
                    $recordsFixed += $count;
                    $tablesFixed++;
                }
            }
        }
        
        $this->newLine();
        $this->info("✅ Correção concluída!");
        $this->info("   📊 Tabelas afetadas: {$tablesFixed}");
        $this->info("   📝 Registros corrigidos: {$recordsFixed}");
        
        return 0;
    }
}
