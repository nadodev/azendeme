<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventCostCategory;
use App\Models\Professional;

class EventCostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $professional = Professional::first();
        
        if (!$professional) {
            $this->command->warn('Nenhum profissional encontrado. Execute o seeder de profissionais primeiro.');
            return;
        }

        $categories = [
            [
                'name' => 'Equipamentos',
                'description' => 'Custos relacionados a equipamentos de fotografia e eventos',
                'color' => '#3B82F6',
                'sort_order' => 1,
            ],
            [
                'name' => 'Transporte',
                'description' => 'Custos de transporte e deslocamento',
                'color' => '#10B981',
                'sort_order' => 2,
            ],
            [
                'name' => 'Alimentação',
                'description' => 'Custos com alimentação da equipe',
                'color' => '#F59E0B',
                'sort_order' => 3,
            ],
            [
                'name' => 'Hospedagem',
                'description' => 'Custos de hospedagem quando necessário',
                'color' => '#8B5CF6',
                'sort_order' => 4,
            ],
            [
                'name' => 'Materiais',
                'description' => 'Materiais diversos para eventos',
                'color' => '#EF4444',
                'sort_order' => 5,
            ],
            [
                'name' => 'Marketing',
                'description' => 'Custos de marketing e divulgação',
                'color' => '#EC4899',
                'sort_order' => 6,
            ],
            [
                'name' => 'Manutenção',
                'description' => 'Manutenção e reparos de equipamentos',
                'color' => '#6B7280',
                'sort_order' => 7,
            ],
            [
                'name' => 'Imprevistos',
                'description' => 'Custos imprevistos e emergências',
                'color' => '#F97316',
                'sort_order' => 8,
            ],
        ];

        foreach ($categories as $categoryData) {
            EventCostCategory::firstOrCreate(
                [
                    'professional_id' => $professional->id,
                    'name' => $categoryData['name'],
                ],
                [
                    'description' => $categoryData['description'],
                    'color' => $categoryData['color'],
                    'is_active' => true,
                    'sort_order' => $categoryData['sort_order'],
                ]
            );
        }

        $this->command->info('Categorias de custos criadas com sucesso!');
    }
}