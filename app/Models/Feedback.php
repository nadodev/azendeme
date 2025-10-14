<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    
    protected $fillable = [
        'professional_id',
        'feedback_request_id',
        'appointment_id',
        'customer_id',
        'service_id',
        'rating',
        'comment',
        'what_liked',
        'what_improve',
        'would_recommend',
        'visible_public',
        'approved',
    ];

    protected $casts = [
        'would_recommend' => 'boolean',
        'visible_public' => 'boolean',
        'approved' => 'boolean',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function feedbackRequest()
    {
        return $this->belongsTo(FeedbackRequest::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Scope para feedbacks públicos
     */
    public function scopePublic($query)
    {
        return $query->where('visible_public', true)
            ->where('approved', true);
    }

    /**
     * Scope para feedbacks por rating
     */
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Retorna estrelas em HTML
     */
    public function getStarsHtml()
    {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $html .= '<span class="text-yellow-400">★</span>';
            } else {
                $html .= '<span class="text-gray-300">★</span>';
            }
        }
        return $html;
    }
}
