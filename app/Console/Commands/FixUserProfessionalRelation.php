<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Professional;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixUserProfessionalRelation extends Command
{
    protected $signature = 'fix:user-professional';
    protected $description = 'Verifica e corrige relação User-Professional';

    public function handle()
    {
        $this->info('🔍 Verificando estrutura das tabelas...');
        
        // Verificar colunas de professionals
        $professionalColumns = Schema::getColumnListing('professionals');
        $this->info('Colunas de professionals: ' . implode(', ', $professionalColumns));
        
        $hasUserId = in_array('user_id', $professionalColumns);
        $this->info($hasUserId ? '✅ Coluna user_id existe' : '❌ Coluna user_id NÃO existe');
        
        if (!$hasUserId) {
            $this->error('Execute a migration para adicionar user_id primeiro!');
            $this->info('php artisan migrate');
            return 1;
        }
        
        // Verificar users sem professional
        $usersWithoutProfessional = User::doesntHave('professional')->count();
        $this->info("👥 Usuários sem professional: $usersWithoutProfessional");
        
        // Verificar professionals sem user_id
        $professionalsWithoutUser = Professional::whereNull('user_id')->count();
        $this->info("🏢 Professionals sem user_id: $professionalsWithoutUser");
        
        if ($professionalsWithoutUser > 0) {
            if ($this->confirm('Deseja tentar vincular professionals órfãos com users existentes?')) {
                $this->fixOrphanProfessionals();
            }
        }
        
        if ($usersWithoutProfessional > 0) {
            if ($this->confirm('Deseja criar professionals para users que não têm?')) {
                $this->createMissingProfessionals();
            }
        }
        
        $this->info('✅ Verificação concluída!');
        return 0;
    }
    
    private function fixOrphanProfessionals()
    {
        $orphans = Professional::whereNull('user_id')->get();
        
        foreach ($orphans as $professional) {
            // Tentar encontrar user pelo email
            $user = User::where('email', $professional->email)->first();
            
            if ($user) {
                $professional->update(['user_id' => $user->id]);
                $this->info("✅ Professional {$professional->name} vinculado ao user {$user->email}");
            } else {
                $this->warn("⚠️  Professional {$professional->name} ({$professional->email}) sem user correspondente");
            }
        }
    }
    
    private function createMissingProfessionals()
    {
        $users = User::doesntHave('professional')->get();
        
        foreach ($users as $user) {
            $slug = \Illuminate\Support\Str::slug($user->name) . '-' . $user->id;
            
            Professional::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'slug' => $slug,
                'email' => $user->email,
                'active' => true,
            ]);
            
            $this->info("✅ Professional criado para user {$user->email}");
        }
    }
}
