<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CheckOnboardingColumns extends Command
{
    protected $signature = 'check:onboarding-columns';
    protected $description = 'Verifica e adiciona colunas de onboarding se necessário';

    public function handle()
    {
        $this->info('Verificando colunas de onboarding na tabela users...');

        if (!Schema::hasColumn('users', 'onboarding_completed')) {
            $this->warn('Coluna onboarding_completed não existe. Adicionando...');
            
            Schema::table('users', function ($table) {
                $table->boolean('onboarding_completed')->default(false)->after('remember_token');
                $table->json('onboarding_steps')->nullable()->after('onboarding_completed');
            });
            
            $this->info('✓ Colunas adicionadas com sucesso!');
        } else {
            $this->info('✓ Coluna onboarding_completed já existe.');
        }

        if (!Schema::hasColumn('users', 'onboarding_steps')) {
            $this->warn('Coluna onboarding_steps não existe. Adicionando...');
            
            Schema::table('users', function ($table) {
                $table->json('onboarding_steps')->nullable()->after('onboarding_completed');
            });
            
            $this->info('✓ Coluna onboarding_steps adicionada com sucesso!');
        } else {
            $this->info('✓ Coluna onboarding_steps já existe.');
        }

        $this->info('Verificação concluída!');
        
        return 0;
    }
}
