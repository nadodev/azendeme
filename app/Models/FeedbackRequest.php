<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FeedbackRequest extends Model
{
    protected $fillable = [
        'professional_id',
        'appointment_id',
        'customer_id',
        'service_id',
        'token',
        'status',
        'sent_at',
        'completed_at',
        'expires_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'completed_at' => 'datetime',
        'expires_at' => 'date',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
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

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }

    /**
     * Gera um token único para o link de feedback
     */
    public static function generateToken()
    {
        do {
            $token = Str::random(32);
        } while (self::where('token', $token)->exists());

        return $token;
    }

    /**
     * Cria uma solicitação de feedback após agendamento concluído
     */
    public static function createFromAppointment(Appointment $appointment)
    {
        return self::create([
            'professional_id' => $appointment->professional_id,
            'appointment_id' => $appointment->id,
            'customer_id' => $appointment->customer_id,
            'service_id' => $appointment->service_id,
            'token' => self::generateToken(),
            'status' => 'pending',
            'expires_at' => Carbon::now()->addDays(30), // Expira em 30 dias
        ]);
    }

    /**
     * Gera a URL pública do formulário de feedback
     */
    public function getPublicUrl()
    {
        return url("/feedback/{$this->token}");
    }

    /**
     * Verifica se o link ainda é válido
     */
    public function isValid()
    {
        return $this->status === 'pending' 
            && $this->expires_at->isFuture();
    }

    /**
     * Marca como completado
     */
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }
}
