<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventCommercialProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'proposal_number',
        'proposal_date',
        'valid_until',
        'executive_summary',
        'event_description',
        'services_offered',
        'equipment_included',
        'team_structure',
        'timeline',
        'deliverables',
        'terms_and_conditions',
        'payment_schedule',
        'total_value',
        'discount_percentage',
        'discount_value',
        'final_value',
        'status',
        'rejection_reason',
        'notes',
    ];

    protected $casts = [
        'proposal_date' => 'date',
        'valid_until' => 'date',
        'total_value' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'final_value' => 'decimal:2',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the status label.
     */
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'rascunho' => 'Rascunho',
            'enviada' => 'Enviada',
            'em_analise' => 'Em Análise',
            'aprovada' => 'Aprovada',
            'rejeitada' => 'Rejeitada',
            'expirada' => 'Expirada',
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
            'em_analise' => 'bg-yellow-100 text-yellow-800',
            'aprovada' => 'bg-green-100 text-green-800',
            'rejeitada' => 'bg-red-100 text-red-800',
            'expirada' => 'bg-orange-100 text-orange-800',
        ];

        return $colors[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Check if proposal is expired.
     */
    public function getIsExpiredAttribute()
    {
        return $this->valid_until < now()->toDateString();
    }

    /**
     * Check if proposal is approved.
     */
    public function getIsApprovedAttribute()
    {
        return $this->status === 'aprovada';
    }
}