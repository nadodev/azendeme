<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Mail\AppointmentReminder;
use Illuminate\Support\Facades\Mail;

class TestAppointmentReminders extends Command
{
    protected $signature = 'test:appointment-reminders {email?}';
    protected $description = 'Testar envio de lembretes de agendamento';

    public function handle()
    {
        $email = $this->argument('email');
        
        if (!$email) {
            $email = $this->ask('Digite o e-mail para teste');
        }
        
        // Buscar um agendamento existente ou criar um fictício
        $appointment = Appointment::with(['service', 'professional'])->first();
        
        if (!$appointment) {
            $this->error("Nenhum agendamento encontrado no banco de dados.");
            return 1;
        }
        
        $this->info("Testando lembrete de agendamento para: {$email}");
        $this->info("Agendamento: #{$appointment->id} - {$appointment->professional->business_name}");
        
        try {
            // Gerar token de confirmação
            $appointment->confirmation_token = \Illuminate\Support\Str::uuid()->toString();
            $appointment->save();
            
            $confirmUrl = route('appointment.confirm', ['token' => $appointment->confirmation_token]);
            
            // Enviar e-mail
            Mail::to($email)->send(new AppointmentReminder($appointment, $confirmUrl));
            
            $this->info("✅ E-mail de lembrete enviado com sucesso!");
            $this->info("🔗 URL de confirmação: {$confirmUrl}");
            
        } catch (\Exception $e) {
            $this->error("❌ Erro ao enviar e-mail: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
