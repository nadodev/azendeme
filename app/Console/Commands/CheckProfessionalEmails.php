<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Professional;

class CheckProfessionalEmails extends Command
{
    protected $signature = 'check:professional-emails';
    protected $description = 'Verificar e-mails duplicados na tabela professionals';

    public function handle()
    {
        $this->info('Verificando e-mails na tabela professionals...');
        
        $professionals = Professional::all();
        
        $this->info("Total de profissionais: {$professionals->count()}");
        
        foreach ($professionals as $professional) {
            $this->line("ID: {$professional->id} | Nome: {$professional->name} | Email: {$professional->email}");
        }
        
        // Verificar duplicatas
        $duplicates = Professional::select('email', \DB::raw('COUNT(*) as count'))
            ->groupBy('email')
            ->having('count', '>', 1)
            ->get();
            
        if ($duplicates->count() > 0) {
            $this->error('E-mails duplicados encontrados:');
            foreach ($duplicates as $dup) {
                $this->error("- {$dup->email} (aparece {$dup->count} vezes)");
            }
        } else {
            $this->info('✅ Nenhum e-mail duplicado encontrado.');
        }
        
        return 0;
    }
}
