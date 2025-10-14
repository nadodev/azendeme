<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlertSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'alert_type',
        'enabled',
        'channels',
        'conditions',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'channels' => 'array',
        'conditions' => 'array',
    ];

    /**
     * Relacionamento com Professional
     */
    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    /**
     * Scope para filtrar por profissional
     */
    public function scopeForProfessional($query, $professionalId)
    {
        return $query->where('professional_id', $professionalId);
    }

    /**
     * Scope para alertas habilitados
     */
    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    /**
     * Obter nome do tipo em português
     */
    public function getAlertTypeNameAttribute(): string
    {
        $types = [
            'new_appointment' => 'Novo Agendamento',
            'cancelled_appointment' => 'Agendamento Cancelado',
            'new_customer' => 'Novo Cliente',
            'payment_received' => 'Pagamento Recebido',
            'appointment_reminder' => 'Lembrete de Agendamento',
            'no_show' => 'Cliente Não Compareceu',
            'feedback_received' => 'Feedback Recebido',
            'service_completed' => 'Serviço Concluído',
        ];

        return $types[$this->alert_type] ?? ucfirst($this->alert_type);
    }
}