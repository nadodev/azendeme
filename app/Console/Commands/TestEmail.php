<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email} {--subject=Teste de E-mail}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testa o envio de e-mail do sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $subject = $this->option('subject');

        $this->info("Enviando e-mail de teste para: {$email}");
        $this->info("Assunto: {$subject}");

        try {
            Mail::raw('Este é um e-mail de teste do sistema AzendeMe. Se você recebeu esta mensagem, a configuração de e-mail está funcionando corretamente!', function ($message) use ($email, $subject) {
                $message->to($email)
                        ->subject($subject);
            });

            $this->info('✅ E-mail enviado com sucesso!');
            $this->info('Verifique sua caixa de entrada (e spam).');

        } catch (\Exception $e) {
            $this->error('❌ Erro ao enviar e-mail:');
            $this->error($e->getMessage());
            
            $this->info('');
            $this->info('💡 Dicas para resolver:');
            $this->info('1. Verifique as configurações no arquivo .env');
            $this->info('2. Para Gmail, use senha de app (não a senha normal)');
            $this->info('3. Verifique se a autenticação de 2 fatores está ativa');
            $this->info('4. Teste com MAIL_MAILER=log para debug');
            
            return 1;
        }

        return 0;
    }
}