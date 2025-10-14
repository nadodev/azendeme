<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'name',
        'subject',
        'content',
        'text_content',
        'status',
        'type',
        'target_criteria',
        'schedule_settings',
        'scheduled_at',
        'sent_at',
        'total_recipients',
        'sent_count',
        'delivered_count',
        'opened_count',
        'clicked_count',
        'bounced_count',
        'unsubscribed_count',
        'notes',
    ];

    protected $casts = [
        'target_criteria' => 'array',
        'schedule_settings' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    /**
     * Relacionamento com Professional
     */
    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    /**
     * Relacionamento com Recipients
     */
    public function recipients(): HasMany
    {
        return $this->hasMany(EmailCampaignRecipient::class, 'campaign_id');
    }

    /**
     * Scope para filtrar por profissional
     */
    public function scopeForProfessional($query, $professionalId)
    {
        return $query->where('professional_id', $professionalId);
    }

    /**
     * Scope para filtrar por status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope para filtrar por tipo
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Obter estatísticas da campanha
     */
    public function getStatsAttribute(): array
    {
        return [
            'delivery_rate' => $this->total_recipients > 0 ? round(($this->delivered_count / $this->total_recipients) * 100, 2) : 0,
            'open_rate' => $this->delivered_count > 0 ? round(($this->opened_count / $this->delivered_count) * 100, 2) : 0,
            'click_rate' => $this->delivered_count > 0 ? round(($this->clicked_count / $this->delivered_count) * 100, 2) : 0,
            'bounce_rate' => $this->total_recipients > 0 ? round(($this->bounced_count / $this->total_recipients) * 100, 2) : 0,
            'unsubscribe_rate' => $this->delivered_count > 0 ? round(($this->unsubscribed_count / $this->delivered_count) * 100, 2) : 0,
        ];
    }

    /**
     * Obter nome do status em português
     */
    public function getStatusNameAttribute(): string
    {
        $statuses = [
            'draft' => 'Rascunho',
            'scheduled' => 'Agendada',
            'sending' => 'Enviando',
            'sent' => 'Enviada',
            'cancelled' => 'Cancelada',
        ];

        return $statuses[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Obter nome do tipo em português
     */
    public function getTypeNameAttribute(): string
    {
        $types = [
            'newsletter' => 'Newsletter',
            'promotion' => 'Promoção',
            'reminder' => 'Lembrete',
            'follow_up' => 'Follow-up',
            'custom' => 'Personalizada',
        ];

        return $types[$this->type] ?? ucfirst($this->type);
    }

    /**
     * Verificar se a campanha pode ser editada
     */
    public function canBeEdited(): bool
    {
        return in_array($this->status, ['draft', 'scheduled']);
    }

    /**
     * Verificar se a campanha pode ser cancelada
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['scheduled', 'sending']);
    }

    /**
     * Verificar se a campanha pode ser enviada
     */
    public function canBeSent(): bool
    {
        return $this->status === 'draft' && $this->total_recipients > 0;
    }

    /**
     * Obter destinatários baseados nos critérios
     */
    public function getTargetRecipients()
    {
        $query = Customer::where('professional_id', $this->professional_id)
            ->where('email', '!=', null)
            ->where('email', '!=', '');

        if ($this->target_criteria) {
            // Filtrar por critérios específicos
            if (isset($this->target_criteria['has_appointments'])) {
                if ($this->target_criteria['has_appointments']) {
                    $query->whereHas('appointments');
                } else {
                    $query->whereDoesntHave('appointments');
                }
            }

            if (isset($this->target_criteria['last_appointment_days'])) {
                $days = $this->target_criteria['last_appointment_days'];
                $query->whereHas('appointments', function ($q) use ($days) {
                    $q->where('start_time', '>=', now()->subDays($days));
                });
            }

            if (isset($this->target_criteria['appointment_status'])) {
                $query->whereHas('appointments', function ($q) {
                    $q->where('status', $this->target_criteria['appointment_status']);
                });
            }

            if (isset($this->target_criteria['services'])) {
                $query->whereHas('appointments.service', function ($q) {
                    $q->whereIn('id', $this->target_criteria['services']);
                });
            }
        }

        return $query->get();
    }

    /**
     * Processar template com variáveis
     */
    public function processTemplate(array $variables = []): array
    {
        $subject = $this->subject;
        $content = $this->content;
        $textContent = $this->text_content;

        // Variáveis padrão
        $defaultVariables = [
            '{{professional_name}}' => $this->professional->name ?? 'Profissional',
            '{{professional_phone}}' => $this->professional->phone ?? '',
            '{{professional_email}}' => $this->professional->email ?? '',
            '{{current_date}}' => now()->format('d/m/Y'),
            '{{current_year}}' => now()->year,
        ];

        // Mesclar com variáveis fornecidas
        $allVariables = array_merge($defaultVariables, $variables);

        // Substituir variáveis
        foreach ($allVariables as $placeholder => $value) {
            $subject = str_replace($placeholder, $value, $subject);
            $content = str_replace($placeholder, $value, $content);
            if ($textContent) {
                $textContent = str_replace($placeholder, $value, $textContent);
            }
        }

        return [
            'subject' => $subject,
            'content' => $content,
            'text_content' => $textContent,
        ];
    }
}