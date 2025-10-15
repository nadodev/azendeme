<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventReminder extends Mailable
{
    use Queueable, SerializesModels;

    public Event $event;
    public string $confirmationUrl;

    public function __construct(Event $event, string $confirmationUrl)
    {
        $this->event = $event;
        $this->confirmationUrl = $confirmationUrl;
    }

    public function build(): self
    {
        return $this->subject('Lembrete do seu evento: ' . $this->event->title)
            ->view('emails.events.reminder')
            ->with([
                'event' => $this->event,
                'confirmationUrl' => $this->confirmationUrl,
            ]);
    }
}


