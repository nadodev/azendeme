<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'plan',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the professional associated with the user.
     */
    public function professional()
    {
        return $this->hasOne(Professional::class);
    }

    // Helpers de plano
    public function isFree(): bool { return $this->plan === 'free'; }
    public function isPremium(): bool { return $this->plan === 'premium'; }
    public function isMaster(): bool { return $this->plan === 'master'; }

    public function planLimits(): array
    {
        return (array) config('plans.' . ($this->plan ?? 'free') . '.limits', []);
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return Storage::disk('public')->url($this->avatar);
        }
        
        // Generate default avatar with initials
        $initials = collect(explode(' ', $this->name))
            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
            ->take(2)
            ->join('');
            
        return "https://ui-avatars.com/api/?name={$initials}&background=6366f1&color=ffffff&size=128";
    }
}
