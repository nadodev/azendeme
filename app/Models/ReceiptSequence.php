<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiptSequence extends Model
{
    protected $fillable = [
        'professional_id',
        'year',
        'month',
        'last_number',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    /**
     * Gera o próximo número de recibo para o profissional
     */
    public static function getNextNumber($professionalId)
    {
        $year = date('Y');
        $month = date('m');

        $sequence = self::firstOrCreate(
            [
                'professional_id' => $professionalId,
                'year' => $year,
                'month' => $month,
            ],
            ['last_number' => 0]
        );

        $sequence->increment('last_number');

        // Formato: REC-2025-10-00001
        return sprintf('REC-%04d-%02d-%05d', $year, $month, $sequence->last_number);
    }
}
