<?php

namespace App\Helpers;

class TemplateColors
{
    /**
     * Get default colors for each template
     */
    public static function getDefaults($template, $brandColor = null)
    {
        $defaults = [
            'clinic' => [
                'primary_color' => $brandColor ?? '#3B82F6',
                'secondary_color' => '#A78BFA',
                'accent_color' => '#7C3AED',
                'background_color' => '#FFFFFF',
                'text_color' => '#1F2937',
                'hero_primary_color' => $brandColor ?? '#2563EB',
                'hero_background_color' => '#F1F5F9',
                'services_primary_color' => '#059669',
                'services_background_color' => '#FFFFFF',
                'gallery_primary_color' => '#DC2626',
                'gallery_background_color' => '#FEF2F2',
                'booking_primary_color' => '#7C3AED',
                'booking_background_color' => '#F8FAFC',
            ],
            'barber' => [
                'primary_color' => '#D4AF37', // Dourado mais vibrante
                'secondary_color' => '#F4E4BC', // Dourado claro para contraste
                'accent_color' => '#B8860B', // Dourado escuro
                'background_color' => '#0F0F10',
                'text_color' => '#FFFFFF', // Branco puro para máximo contraste
                'hero_primary_color' => '#D4AF37', // Sempre dourado para barber
                'hero_background_color' => '#0F0F10',
                'services_primary_color' => '#D4AF37',
                'services_background_color' => '#1A1A1D',
                'gallery_primary_color' => '#D4AF37',
                'gallery_background_color' => '#0F0F10',
                'booking_primary_color' => '#D4AF37',
                'booking_background_color' => '#1A1A1D',
            ],
            'tattoo' => [
                'primary_color' => $brandColor ?? '#8B5CF6',
                'secondary_color' => '#C4B5FD', // Roxo mais claro para contraste
                'accent_color' => '#7C3AED',
                'background_color' => '#0F0F10',
                'text_color' => '#FFFFFF', // Branco puro para máximo contraste
                'hero_primary_color' => $brandColor ?? '#8B5CF6',
                'hero_background_color' => '#0F0F10',
                'services_primary_color' => '#A78BFA',
                'services_background_color' => '#1A1520',
                'gallery_primary_color' => '#8B5CF6',
                'gallery_background_color' => '#0F0F10',
                'booking_primary_color' => '#7C3AED',
                'booking_background_color' => '#1A1520',
            ],
            'salon' => [
                'primary_color' => '#F472B6', // Sempre rosa suave para salon
                'secondary_color' => '#FBCFE8', // Rosa muito claro
                'accent_color' => '#EC4899', // Rosa médio
                'background_color' => '#FFFFFF', // Branco puro
                'text_color' => '#4B5563', // Cinza médio para contraste suave
                'hero_primary_color' => '#F472B6', // Sempre rosa suave para salon
                'hero_background_color' => '#FEF7FF', // Fundo rosa extremamente claro
                'services_primary_color' => '#EC4899',
                'services_background_color' => '#FFFFFF',
                'gallery_primary_color' => '#F472B6',
                'gallery_background_color' => '#FEF7FF',
                'booking_primary_color' => '#EC4899',
                'booking_background_color' => '#FDF2F8', // Rosa muito claro
            ]
        ];

        return $defaults[$template] ?? $defaults['clinic'];
    }

    /**
     * Get template description
     */
    public static function getTemplateDescription($template)
    {
        $descriptions = [
            'clinic' => 'Clínica - Design limpo e profissional com cores azuis e verdes',
            'barber' => 'Barbearia - Estilo clássico com tons dourados sobre fundo escuro',
            'tattoo' => 'Tatuagem - Visual moderno e artístico com cores roxas',
            'salon' => 'Salão - Elegante e feminino com tons de rosa suave e claro'
        ];

        return $descriptions[$template] ?? $descriptions['clinic'];
    }

    /**
     * Get color names for better UX
     */
    public static function getColorNames()
    {
        return [
            'hero_primary_color' => 'Cor Principal do Hero',
            'hero_background_color' => 'Fundo do Hero',
            'services_primary_color' => 'Cor Principal dos Serviços',
            'services_background_color' => 'Fundo dos Serviços',
            'gallery_primary_color' => 'Cor Principal da Galeria',
            'gallery_background_color' => 'Fundo da Galeria',
            'booking_primary_color' => 'Cor Principal do Agendamento',
            'booking_background_color' => 'Fundo do Agendamento',
            'text_color' => 'Cor do Texto',
            'accent_color' => 'Cor de Destaque',
            'background_color' => 'Fundo Geral'
        ];
    }
}
