<?php

namespace App\Console\Commands;

use App\Mail\EventReminder;
use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendEventReminders extends Command
{
    protected $signature = 'events:send-reminders';
    protected $description = 'Envia lembretes de eventos 24h antes com link de confirmação';

    public function handle(): int
    {
        $targetDate = now()->addDay()->toDateString();

        $events = Event::with(['customer', 'professional'])
            ->whereDate('event_date', $targetDate)
            ->get();

        foreach ($events as $event) {
            if (!$event->confirmation_token) {
                $event->confirmation_token = Str::uuid()->toString();
                $event->save();
            }

            $confirmUrl = route('event.confirm', ['token' => $event->confirmation_token]);

            if ($event->customer && $event->customer->email) {
                try {
                    Mail::to($event->customer->email)->queue(new EventReminder($event, $confirmUrl));
                    $this->info("Lembrete enviado para evento #{$event->id} - {$event->customer->email}");
                } catch (\Exception $e) {
                    \Log::error('Erro ao enviar lembrete de evento: ' . $e->getMessage());
                    $this->error("Erro ao enviar lembrete para evento #{$event->id}: " . $e->getMessage());
                }
            }
        }

        return Command::SUCCESS;
    }
}


