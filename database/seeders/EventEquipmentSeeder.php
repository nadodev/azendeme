<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventEquipment;
use App\Models\Professional;

class EventEquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $professional = Professional::first();
        
        if (!$professional) {
            $this->command->info('Nenhum profissional encontrado. Execute primeiro o DatabaseSeeder.');
            return;
        }

        $equipment = [
            [
                'name' => 'Cabine de Fotos',
                'description' => 'Cabine de fotos profissional com fundo personalizado, iluminação LED e impressão instantânea.',
                'hourly_rate' => 150.00,
                'minimum_hours' => 2,
                'setup_requirements' => 'Espaço mínimo de 3x3m, tomada 220V, acesso para montagem.',
                'technical_specs' => 'Câmera DSLR, impressora térmica, iluminação LED, tela touch para personalização.',
            ],
            [
                'name' => 'Plataforma 360°',
                'description' => 'Plataforma rotativa para fotos e vídeos em 360 graus com iluminação profissional.',
                'hourly_rate' => 200.00,
                'minimum_hours' => 3,
                'setup_requirements' => 'Espaço mínimo de 4x4m, tomada 220V, piso nivelado.',
                'technical_specs' => 'Plataforma motorizada, 8 câmeras GoPro, iluminação ring LED, sistema de controle remoto.',
            ],
            [
                'name' => 'Túnel de Fotos',
                'description' => 'Túnel interativo com efeitos visuais e sonoros para fotos dinâmicas.',
                'hourly_rate' => 180.00,
                'minimum_hours' => 2,
                'setup_requirements' => 'Espaço mínimo de 6x3m, tomada 220V, área coberta.',
                'technical_specs' => 'Estrutura inflável, sistema de som, iluminação colorida, câmeras automáticas.',
            ],
            [
                'name' => 'Estúdio Portátil',
                'description' => 'Estúdio fotográfico completo com fundos, iluminação e equipamentos profissionais.',
                'hourly_rate' => 120.00,
                'minimum_hours' => 2,
                'setup_requirements' => 'Espaço mínimo de 4x3m, tomada 220V, área coberta.',
                'technical_specs' => 'Câmera DSLR, 3 pontos de luz, fundos variados, computador para edição.',
            ],
            [
                'name' => 'Drone para Eventos',
                'description' => 'Drone profissional para filmagens aéreas e fotos panorâmicas do evento.',
                'hourly_rate' => 250.00,
                'minimum_hours' => 1,
                'setup_requirements' => 'Área aberta, sem obstáculos aéreos, autorização para voo.',
                'technical_specs' => 'Drone DJI Phantom 4, câmera 4K, baterias extras, controle remoto.',
            ],
            [
                'name' => 'Fotobooth Vintage',
                'description' => 'Cabine de fotos com tema vintage, acessórios e impressão em papel fotográfico.',
                'hourly_rate' => 100.00,
                'minimum_hours' => 2,
                'setup_requirements' => 'Espaço mínimo de 2x2m, tomada 110V, mesa para acessórios.',
                'technical_specs' => 'Câmera instantânea, impressora térmica, acessórios vintage, iluminação suave.',
            ],
        ];

        foreach ($equipment as $item) {
            EventEquipment::create([
                'professional_id' => $professional->id,
                'name' => $item['name'],
                'description' => $item['description'],
                'hourly_rate' => $item['hourly_rate'],
                'minimum_hours' => $item['minimum_hours'],
                'setup_requirements' => $item['setup_requirements'],
                'technical_specs' => $item['technical_specs'],
                'is_active' => true,
            ]);
        }

        $this->command->info('Equipamentos de eventos criados com sucesso!');
    }
}