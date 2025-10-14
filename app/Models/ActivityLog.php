<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'appointment_id',
        'customer_id',
        'user_id',
        'action',
        'entity_type',
        'entity_id',
        'old_values',
        'new_values',
        'description',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relacionamento com Professional
     */
    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    /**
     * Relacionamento com Appointment
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Relacionamento com Customer
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relacionamento com User (quem fez a ação)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope para filtrar por profissional
     */
    public function scopeForProfessional($query, $professionalId)
    {
        return $query->where('professional_id', $professionalId);
    }

    /**
     * Scope para filtrar por ação
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope para filtrar por entidade
     */
    public function scopeByEntity($query, $entityType, $entityId = null)
    {
        $query = $query->where('entity_type', $entityType);
        
        if ($entityId) {
            $query->where('entity_id', $entityId);
        }
        
        return $query;
    }

    /**
     * Scope para logs recentes
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Obter o nome da ação em português
     */
    public function getActionNameAttribute(): string
    {
        $actions = [
            'created' => 'Criado',
            'updated' => 'Atualizado',
            'cancelled' => 'Cancelado',
            'confirmed' => 'Confirmado',
            'completed' => 'Concluído',
            'no_show' => 'Não Compareceu',
            'rescheduled' => 'Reagendado',
            'deleted' => 'Excluído',
            'payment_received' => 'Pagamento Recebido',
            'feedback_sent' => 'Feedback Enviado',
        ];

        return $actions[$this->action] ?? ucfirst($this->action);
    }

    /**
     * Obter o nome da entidade em português
     */
    public function getEntityNameAttribute(): string
    {
        $entities = [
            'appointment' => 'Agendamento',
            'customer' => 'Cliente',
            'service' => 'Serviço',
            'professional' => 'Profissional',
            'payment' => 'Pagamento',
        ];

        return $entities[$this->entity_type] ?? ucfirst($this->entity_type);
    }

    /**
     * Obter descrição formatada da ação
     */
    public function getFormattedDescriptionAttribute(): string
    {
        if ($this->description) {
            return $this->description;
        }

        $entityName = $this->entity_name;
        $actionName = $this->action_name;

        if ($this->appointment_id) {
            $appointment = $this->appointment;
            if ($appointment) {
                $customerName = $appointment->customer->name ?? 'Cliente';
                $serviceName = $appointment->service->name ?? 'Serviço';
                $date = $appointment->start_time ? \Carbon\Carbon::parse($appointment->start_time)->format('d/m/Y H:i') : 'Data não definida';
                
                return "{$actionName} agendamento de {$customerName} para {$serviceName} em {$date}";
            }
        }

        return "{$actionName} {$entityName}";
    }
}