<?php

namespace App\Console\Commands;

use App\Mail\AppointmentReminder;
use App\Models\Appointment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:send-reminders';
    protected $description = 'Envia lembretes de agendamentos 24h antes com link de confirmação';

    public function handle(): int
    {
        $targetDate = now()->addDay()->toDateString();

        $appointments = Appointment::with(['service', 'professional'])
            ->whereDate('start_time', $targetDate)
            ->where('status', 'confirmed')
            ->get();

        $this->info("Buscando agendamentos para {$targetDate}...");
        $this->info("Encontrados {$appointments->count()} agendamentos.");

        $sentCount = 0;
        $errorCount = 0;

        foreach ($appointments as $appointment) {
            // Verificar se tem e-mail no notes (formato: "Nome - Email - Telefone")
            $email = $this->extractEmailFromNotes($appointment->notes);
            
            if (!$email) {
                $this->warn("Agendamento #{$appointment->id} - E-mail não encontrado nas notas");
                continue;
            }

            // Gerar token de confirmação se não existir
            if (!$appointment->confirmation_token) {
                $appointment->confirmation_token = Str::uuid()->toString();
                $appointment->save();
            }

            $confirmUrl = route('appointment.confirm', ['token' => $appointment->confirmation_token]);

            try {
                Mail::to($email)->queue(new AppointmentReminder($appointment, $confirmUrl));
                $this->info("✅ Lembrete enviado para agendamento #{$appointment->id} - {$email}");
                $sentCount++;
            } catch (\Exception $e) {
                \Log::error('Erro ao enviar lembrete de agendamento: ' . $e->getMessage());
                $this->error("❌ Erro ao enviar lembrete para agendamento #{$appointment->id}: " . $e->getMessage());
                $errorCount++;
            }
        }

        $this->info("📊 Resumo: {$sentCount} enviados, {$errorCount} erros");
        return Command::SUCCESS;
    }

    /**
     * Extrair e-mail das notas do agendamento
     * Formato esperado: "Nome - email@exemplo.com - Telefone"
     */
    private function extractEmailFromNotes(?string $notes): ?string
    {
        if (!$notes) {
            return null;
        }

        // Regex para encontrar e-mail
        if (preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $notes, $matches)) {
            return $matches[0];
        }

        return null;
    }
}
