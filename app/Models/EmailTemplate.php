<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'name',
        'subject',
        'content',
        'text_content',
        'type',
        'variables',
        'is_default',
        'active',
    ];

    protected $casts = [
        'variables' => 'array',
        'is_default' => 'boolean',
        'active' => 'boolean',
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
     * Scope para filtrar por tipo
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope para templates ativos
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Obter nome do tipo em português
     */
    public function getTypeNameAttribute(): string
    {
        $types = [
            'newsletter' => 'Newsletter',
            'promotion' => 'Promoção',
            'reminder' => 'Lembrete',
            'follow_up' => 'Follow-up',
            'custom' => 'Personalizada',
        ];

        return $types[$this->type] ?? ucfirst($this->type);
    }

    /**
     * Processar template com variáveis
     */
    public function processTemplate(array $variables = []): array
    {
        $subject = $this->subject;
        $content = $this->content;
        $textContent = $this->text_content;

        // Variáveis padrão
        $defaultVariables = [
            '{{professional_name}}' => 'Profissional',
            '{{professional_phone}}' => '',
            '{{professional_email}}' => '',
            '{{current_date}}' => now()->format('d/m/Y'),
            '{{current_year}}' => now()->year,
        ];

        // Mesclar com variáveis fornecidas
        $allVariables = array_merge($defaultVariables, $variables);

        // Substituir variáveis
        foreach ($allVariables as $placeholder => $value) {
            $subject = str_replace($placeholder, $value, $subject);
            $content = str_replace($placeholder, $value, $content);
            if ($textContent) {
                $textContent = str_replace($placeholder, $value, $textContent);
            }
        }

        return [
            'subject' => $subject,
            'content' => $content,
            'text_content' => $textContent,
        ];
    }
}