<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailCampaignRecipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'customer_id',
        'email',
        'status',
        'sent_at',
        'delivered_at',
        'opened_at',
        'clicked_at',
        'bounced_at',
        'unsubscribed_at',
        'error_message',
        'tracking_data',
    ];

    protected $casts = [
        'tracking_data' => 'array',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'opened_at' => 'datetime',
        'clicked_at' => 'datetime',
        'bounced_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    /**
     * Relacionamento com Campaign
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(EmailCampaign::class, 'campaign_id');
    }

    /**
     * Relacionamento com Customer
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Scope para filtrar por status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Obter nome do status em português
     */
    public function getStatusNameAttribute(): string
    {
        $statuses = [
            'pending' => 'Pendente',
            'sent' => 'Enviado',
            'delivered' => 'Entregue',
            'opened' => 'Aberto',
            'clicked' => 'Clicado',
            'bounced' => 'Retornou',
            'unsubscribed' => 'Cancelou Inscrição',
        ];

        return $statuses[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Marcar como enviado
     */
    public function markAsSent(): void
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }

    /**
     * Marcar como entregue
     */
    public function markAsDelivered(): void
    {
        $this->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);
    }

    /**
     * Marcar como aberto
     */
    public function markAsOpened(): void
    {
        if ($this->status === 'delivered') {
            $this->update([
                'status' => 'opened',
                'opened_at' => now(),
            ]);
        }
    }

    /**
     * Marcar como clicado
     */
    public function markAsClicked(): void
    {
        if (in_array($this->status, ['delivered', 'opened'])) {
            $this->update([
                'status' => 'clicked',
                'clicked_at' => now(),
            ]);
        }
    }

    /**
     * Marcar como retornado
     */
    public function markAsBounced(string $errorMessage = null): void
    {
        $this->update([
            'status' => 'bounced',
            'bounced_at' => now(),
            'error_message' => $errorMessage,
        ]);
    }

    /**
     * Marcar como cancelou inscrição
     */
    public function markAsUnsubscribed(): void
    {
        $this->update([
            'status' => 'unsubscribed',
            'unsubscribed_at' => now(),
        ]);
    }
}