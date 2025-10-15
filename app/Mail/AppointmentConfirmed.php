<?php

namespace App\Mail;

use App\Models\Appointment;
use App\Models\Professional;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
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
        return [];
    }
}
