<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Mail\PlanUpgraded;
use App\Mail\PlanUpgradeNotification;
use Illuminate\Support\Facades\Mail;

class TestPlanUpgradeEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:plan-upgrade-emails {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testar envio de e-mails de upgrade de plano';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        if (!$email) {
            $email = $this->ask('Digite o e-mail para teste');
        }
        
        // Buscar usuário ou criar um fictício
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("Usuário com e-mail {$email} não encontrado.");
            $this->info("Criando usuário fictício para teste...");
            
            $user = new User();
            $user->id = 999;
            $user->name = 'Usuário Teste';
            $user->email = $email;
            $user->plan = 'free';
        }
        
        $this->info("Testando e-mails de upgrade de plano para: {$user->name} ({$user->email})");
        
        try {
            // Testar e-mail para o usuário
            $this->info("📧 Enviando e-mail para o usuário...");
            Mail::to($user->email)->send(new PlanUpgraded($user, 'free', 'premium'));
            $this->info("✅ E-mail para usuário enviado com sucesso!");
            
            // Testar e-mail para admin
            $adminEmail = config('mail.from.address');
            if ($adminEmail) {
                $this->info("📧 Enviando e-mail para admin ({$adminEmail})...");
                Mail::to($adminEmail)->send(new PlanUpgradeNotification($user, 'free', 'premium'));
                $this->info("✅ E-mail para admin enviado com sucesso!");
            } else {
                $this->warn("⚠️ E-mail de admin não configurado (MAIL_FROM_ADDRESS)");
            }
            
            $this->info("🎉 Teste concluído com sucesso!");
            
        } catch (\Exception $e) {
            $this->error("❌ Erro ao enviar e-mails: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
