<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventServiceNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'service_order_id',
        'note_number',
        'note_date',
        'description',
        'equipment_used',
        'hours_worked',
        'team_members',
        'observations',
        'issues_encountered',
        'solutions_applied',
        'client_feedback',
        'total_hours',
        'hourly_rate',
        'total_value',
        'status',
        'notes',
    ];

    protected $casts = [
        'note_date' => 'date',
        'total_hours' => 'decimal:2',
        'hourly_rate' => 'decimal:2',
        'total_value' => 'decimal:2',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function serviceOrder(): BelongsTo
    {
        return $this->belongsTo(EventServiceOrder::class);
    }

    /**
     * Get the status label.
     */
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'rascunho' => 'Rascunho',
            'enviada' => 'Enviada',
            'aprovada' => 'Aprovada',
            'rejeitada' => 'Rejeitada',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Get the status color class.
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'rascunho' => 'bg-gray-100 text-gray-800',
            'enviada' => 'bg-blue-100 text-blue-800',
            'aprovada' => 'bg-green-100 text-green-800',
            'rejeitada' => 'bg-red-100 text-red-800',
        ];

        return $colors[$this->status] ?? 'bg-gray-100 text-gray-800';
    }
}