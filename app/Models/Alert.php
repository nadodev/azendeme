<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'type',
        'title',
        'message',
        'data',
        'priority',
        'status',
        'read_at',
        'archived_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'archived_at' => 'datetime',
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
     * Scope para alertas não lidos
     */
    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }

    /**
     * Scope para alertas por tipo
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope para alertas por prioridade
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope para alertas recentes
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Marcar como lido
     */
    public function markAsRead(): void
    {
        $this->update([
            'status' => 'read',
            'read_at' => now(),
        ]);
    }

    /**
     * Marcar como arquivado
     */
    public function markAsArchived(): void
    {
        $this->update([
            'status' => 'archived',
            'archived_at' => now(),
        ]);
    }

    /**
     * Obter nome do tipo em português
     */
    public function getTypeNameAttribute(): string
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

        return $types[$this->type] ?? ucfirst($this->type);
    }

    /**
     * Obter nome da prioridade em português
     */
    public function getPriorityNameAttribute(): string
    {
        $priorities = [
            'low' => 'Baixa',
            'medium' => 'Média',
            'high' => 'Alta',
            'urgent' => 'Urgente',
        ];

        return $priorities[$this->priority] ?? ucfirst($this->priority);
    }

    /**
     * Obter cor da prioridade
     */
    public function getPriorityColorAttribute(): string
    {
        $colors = [
            'low' => 'text-gray-600 bg-gray-100',
            'medium' => 'text-blue-600 bg-blue-100',
            'high' => 'text-orange-600 bg-orange-100',
            'urgent' => 'text-red-600 bg-red-100',
        ];

        return $colors[$this->priority] ?? 'text-gray-600 bg-gray-100';
    }

    /**
     * Obter ícone do tipo
     */
    public function getTypeIconAttribute(): string
    {
        $icons = [
            'new_appointment' => '📅',
            'cancelled_appointment' => '❌',
            'new_customer' => '👤',
            'payment_received' => '💰',
            'appointment_reminder' => '⏰',
            'no_show' => '🚫',
            'feedback_received' => '⭐',
            'service_completed' => '✅',
        ];

        return $icons[$this->type] ?? '📢';
    }
}