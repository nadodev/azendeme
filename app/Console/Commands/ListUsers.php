<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ListUsers extends Command
{
    protected $signature = 'list:users';
    protected $description = 'Listar todos os usuários';

    public function handle()
    {
        $users = User::all();
        
        $this->info("Total de usuários: {$users->count()}");
        
        foreach ($users as $user) {
            $this->line("ID: {$user->id} | Nome: {$user->name} | Email: {$user->email}");
        }
        
        return 0;
    }
}
