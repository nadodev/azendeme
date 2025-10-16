<?php

namespace App\Helpers;

class TemplateCategories
{
    /**
     * Obter todas as categorias de templates disponíveis
     */
    public static function getCategories(): array
    {
        return [
            'clinic' => [
                'name' => 'Clínica / Saúde',
                'icon' => '🏥',
                'description' => 'Design profissional e confiável para clínicas médicas, odontológicas, fisioterapia, etc.',
                'colors' => self::getClinicColors(),
                'templates' => ['clinic', 'clinic-modern']
            ],
            'salon' => [
                'name' => 'Salão de Beleza',
                'icon' => '💇',
                'description' => 'Design elegante e luxuoso para salões de beleza, cabeleireiros, esmalterias.',
                'colors' => self::getSalonColors(),
                'templates' => ['salon', 'salon-luxury']
            ],
            'tattoo' => [
                'name' => 'Estúdio de Tatuagem',
                'icon' => '🎨',
                'description' => 'Design moderno e artístico para estúdios de tatuagem e piercing.',
                'colors' => self::getTattooColors(),
                'templates' => ['tattoo', 'tattoo-dark']
            ],
            'barber' => [
                'name' => 'Barbearia',
                'icon' => '✂️',
                'description' => 'Design masculino e sofisticado para barbearias.',
                'colors' => self::getBarberColors(),
                'templates' => ['barber', 'barber-vintage']
            ],
            'spa' => [
                'name' => 'Spa / Estética',
                'icon' => '🧘',
                'description' => 'Design relaxante e zen para spas, clínicas de estética e bem-estar.',
                'colors' => self::getSpaColors(),
                'templates' => ['spa']
            ],
            'gym' => [
                'name' => 'Academia / Personal',
                'icon' => '💪',
                'description' => 'Design energético e motivacional para academias e personal trainers.',
                'colors' => self::getGymColors(),
                'templates' => ['gym']
            ],
        ];
    }

    /**
     * Cores para Clínicas (Azul confiança + Verde saúde)
     */
    private static function getClinicColors(): array
    {
        return [
            'primary' => '#0369A1', // Azul profissional
            'secondary' => '#059669', // Verde saúde
            'accent' => '#06B6D4', // Ciano
            'background' => '#FFFFFF',
            'text' => '#0F172A',
            'hero_bg' => '#F0F9FF',
            'services_bg' => '#FFFFFF',
            'gallery_bg' => '#ECFDF5',
            'booking_bg' => '#F0F9FF',
        ];
    }

    /**
     * Cores para Salões (Rosa elegante + Dourado luxo)
     */
    private static function getSalonColors(): array
    {
        return [
            'primary' => '#EC4899', // Rosa vibrante
            'secondary' => '#F59E0B', // Dourado
            'accent' => '#A855F7', // Roxo
            'background' => '#FDF2F8',
            'text' => '#1F2937',
            'hero_bg' => '#FDF2F8',
            'services_bg' => '#FFFFFF',
            'gallery_bg' => '#FDF2F8',
            'booking_bg' => '#FCE7F3',
        ];
    }

    /**
     * Cores para Tatuagem (Escuro + Neon)
     */
    private static function getTattooColors(): array
    {
        return [
            'primary' => '#EF4444', // Vermelho intenso
            'secondary' => '#6366F1', // Índigo neon
            'accent' => '#F97316', // Laranja
            'background' => '#0F172A',
            'text' => '#F1F5F9',
            'hero_bg' => '#1E293B',
            'services_bg' => '#0F172A',
            'gallery_bg' => '#1E293B',
            'booking_bg' => '#334155',
        ];
    }

    /**
     * Cores para Barbearia (Marrom + Dourado vintage)
     */
    private static function getBarberColors(): array
    {
        return [
            'primary' => '#78350F', // Marrom escuro
            'secondary' => '#D97706', // Dourado/Âmbar
            'accent' => '#DC2626', // Vermelho vintage
            'background' => '#FAFAF9',
            'text' => '#1C1917',
            'hero_bg' => '#FEF3C7',
            'services_bg' => '#FFFFFF',
            'gallery_bg' => '#FEF3C7',
            'booking_bg' => '#FDE68A',
        ];
    }

    /**
     * Cores para Spa (Verde zen + Azul calmo)
     */
    private static function getSpaColors(): array
    {
        return [
            'primary' => '#10B981', // Verde esmeralda
            'secondary' => '#8B5CF6', // Lavanda
            'accent' => '#06B6D4', // Azul turquesa
            'background' => '#F0FDF4',
            'text' => '#064E3B',
            'hero_bg' => '#ECFDF5',
            'services_bg' => '#FFFFFF',
            'gallery_bg' => '#F0FDF4',
            'booking_bg' => '#D1FAE5',
        ];
    }

    /**
     * Cores para Academia (Laranja energia + Vermelho força)
     */
    private static function getGymColors(): array
    {
        return [
            'primary' => '#DC2626', // Vermelho energia
            'secondary' => '#F97316', // Laranja vibrante
            'accent' => '#0891B2', // Ciano
            'background' => '#FFFFFF',
            'text' => '#18181B',
            'hero_bg' => '#FEF2F2',
            'services_bg' => '#FFFFFF',
            'gallery_bg' => '#FFEDD5',
            'booking_bg' => '#FEE2E2',
        ];
    }

    /**
     * Obter cores de uma categoria específica
     */
    public static function getCategoryColors(string $category): array
    {
        $categories = self::getCategories();
        return $categories[$category]['colors'] ?? self::getClinicColors();
    }

    /**
     * Obter categoria por template
     */
    public static function getCategoryByTemplate(string $template): ?string
    {
        foreach (self::getCategories() as $key => $category) {
            if (in_array($template, $category['templates'])) {
                return $key;
            }
        }
        return null;
    }
}

