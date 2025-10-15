<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestBugReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bug-report:test {email=suporte@azendeme.com.br}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testa o envio de relatório de bugs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        $this->info("Testando relatório de bugs para: {$email}");

        try {
            // Dados de teste do relatório
            $bugData = [
                'name' => 'Usuário Teste',
                'email' => 'teste@teste.com',
                'subject' => 'Teste de Relatório de Bug',
                'description' => 'Este é um teste do sistema de relatório de bugs. Se você recebeu este e-mail, o sistema está funcionando corretamente!',
                'page_url' => 'http://localhost:8000/teste',
                'user_agent' => 'Mozilla/5.0 (Test Browser)',
                'source' => 'landing',
                'timestamp' => now()->format('d/m/Y H:i:s'),
                'ip_address' => '127.0.0.1'
            ];

            // Enviar e-mail para suporte
            Mail::send('emails.bug-report', $bugData, function ($message) use ($bugData, $email) {
                $message->to($email)
                        ->subject('[BUG REPORT] ' . $bugData['subject'])
                        ->replyTo($bugData['email'], $bugData['name']);
            });

            $this->info('✅ Relatório de bug enviado com sucesso!');
            $this->info('Verifique a caixa de entrada (e spam).');

        } catch (\Exception $e) {
            $this->error('❌ Erro ao enviar relatório de bug:');
            $this->error($e->getMessage());
            
            $this->info('');
            $this->info('💡 Possíveis soluções:');
            $this->info('1. Verifique se o template emails.bug-report existe');
            $this->info('2. Verifique as configurações de e-mail no .env');
            $this->info('3. Teste com MAIL_MAILER=log para debug');
            
            return 1;
        }

        return 0;
    }
}