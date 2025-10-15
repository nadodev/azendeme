<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class PlanUpgradeNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $oldPlan;
    public $newPlan;
    public $planDetails;
    public $upgradeTime;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $oldPlan, string $newPlan)
    {
        $this->user = $user;
        $this->oldPlan = $oldPlan;
        $this->newPlan = $newPlan;
        $this->planDetails = config('plans.' . $newPlan, []);
        $this->upgradeTime = now();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '💰 Novo Upgrade de Plano - ' . $this->user->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.plan-upgrade-notification',
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
