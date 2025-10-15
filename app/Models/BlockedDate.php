<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlockedDate extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'professional_id',
        'blocked_date',
        'reason',
    ];

    protected $casts = [
        'blocked_date' => 'date',
    ];

    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }
}
