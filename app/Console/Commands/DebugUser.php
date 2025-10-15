<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class DebugUser extends Command
{
    protected $signature = 'debug:user {id}';
    protected $description = 'Debugar informações de um usuário';

    public function handle()
    {
        $userId = $this->argument('id');
        
        $user = User::find($userId);
        
        if (!$user) {
            $this->error("Usuário ID {$userId} não encontrado.");
            return 1;
        }
        
        $this->info("=== USUÁRIO ID {$userId} ===");
        $this->line("Nome: {$user->name}");
        $this->line("Email: {$user->email}");
        $this->line("Plan: {$user->plan}");
        
        if ($user->professional) {
            $this->info("=== PROFESSIONAL ASSOCIADO ===");
            $this->line("ID: {$user->professional->id}");
            $this->line("Nome: {$user->professional->name}");
            $this->line("Email: {$user->professional->email}");
            $this->line("Business Name: {$user->professional->business_name}");
            $this->line("Slug: {$user->professional->slug}");
        } else {
            $this->error("Usuário não tem professional associado!");
        }
        
        return 0;
    }
}
