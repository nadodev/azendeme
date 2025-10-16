<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointment;

class AppointmentReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $confirmUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment, string $confirmUrl)
    {
        $this->appointment = $appointment;
        $this->confirmUrl = $confirmUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📅 Lembrete de Agendamento - ' . $this->appointment->professional->business_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment-reminder',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $appt = $this->appointment;
        $dtStart = \Carbon\Carbon::parse($appt->start_time)->utc()->format('Ymd\THis\Z');
        $dtEnd = \Carbon\Carbon::parse($appt->end_time)->utc()->format('Ymd\THis\Z');
        $uid = 'apt-' . $appt->id . '@azendeme';
        $summary = 'Lembrete: ' . ($appt->service->name ?? 'Agendamento');
        $description = 'Confirme sua presença: ' . ($this->confirmUrl ?? '');
        $location = $appt->professional->business_name ?? 'Agendamento';

        $ics = "BEGIN:VCALENDAR\r\n" .
               "VERSION:2.0\r\n" .
               "CALSCALE:GREGORIAN\r\n" .
               "METHOD:PUBLISH\r\n" .
               "BEGIN:VEVENT\r\n" .
               "UID:$uid\r\n" .
               "DTSTAMP:$dtStart\r\n" .
               "DTSTART:$dtStart\r\n" .
               "DTEND:$dtEnd\r\n" .
               "SUMMARY:" . addslashes($summary) . "\r\n" .
               "DESCRIPTION:" . addslashes(str_replace(["\r","\n"],' ', $description)) . "\r\n" .
               "LOCATION:" . addslashes($location) . "\r\n" .
               "END:VEVENT\r\n" .
               "END:VCALENDAR\r\n";

        return [
            Attachment::fromData(fn() => $ics, 'lembrete-agendamento.ics')
                ->withMime('text/calendar; charset=UTF-8; method=PUBLISH')
        ];
    }
}
