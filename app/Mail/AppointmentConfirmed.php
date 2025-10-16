<?php

namespace App\Mail;

use App\Models\Appointment;
use App\Models\Professional;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Agendamento Confirmado - ' . $this->appointment->service->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $professional = Professional::where('user_id', auth()->user()->id)->firstOrFail();
        
        return new Content(
            view: 'emails.appointment-confirmed',
            with: [
                'appointment' => $this->appointment,
                'customer' => $this->appointment->customer,
                'slug' => $professional->slug,
                'service' => $this->appointment->service,
                'professional' => $this->appointment->professional,
            ],
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
        $summary = 'Agendamento: ' . ($appt->service->name ?? 'Serviço');
        $description = 'Cliente: ' . ($appt->customer->name ?? '-') . "\n" . 'Telefone: ' . ($appt->customer->phone ?? '-');
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
            Attachment::fromData(fn() => $ics, 'agendamento.ics')
                ->withMime('text/calendar; charset=UTF-8; method=PUBLISH')
        ];
    }
}
