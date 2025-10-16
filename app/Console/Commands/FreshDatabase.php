<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FreshDatabase extends Command
{
    protected $signature = 'db:fresh-seed';
    protected $description = 'Reseta o banco de dados e popula com dados de teste';

    public function handle()
    {
        if (!$this->confirm('⚠️  ATENÇÃO: Isso vai apagar TODOS os dados do banco! Deseja continuar?')) {
            $this->info('Operação cancelada.');
            return 0;
        }
        
        $this->info('🗑️  Limpando banco de dados...');
        $this->call('migrate:fresh');
        
        $this->newLine();
        $this->info('🌱 Populando banco de dados...');
        $this->call('db:seed');
        
        $this->newLine();
        $this->info('✅ Banco de dados resetado e populado com sucesso!');
        
        return 0;
    }
}
