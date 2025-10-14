<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{LoyaltyProgram, LoyaltyReward, SocialLink};

class LoyaltySeeder extends Seeder
{
    public function run(): void
    {
        // Criar programa de fidelidade
        $program = LoyaltyProgram::create([
            'professional_id' => 1,
            'name' => 'Programa Fidelidade VIP',
            'description' => 'Ganhe pontos a cada visita e resgate recompensas exclusivas!',
            'active' => true,
            'points_per_visit' => 10,
            'points_per_currency' => 1, // 1 ponto por real gasto
            'points_expiry_days' => 365,
        ]);

        // Criar recompensas
        LoyaltyReward::create([
            'professional_id' => 1,
            'name' => '10% de Desconto',
            'description' => 'Desconto de 10% no próximo agendamento',
            'points_required' => 50,
            'reward_type' => 'discount_percentage',
            'discount_value' => 10,
            'active' => true,
        ]);

        LoyaltyReward::create([
            'professional_id' => 1,
            'name' => 'R$ 20 de Desconto',
            'description' => 'R$ 20 de desconto no próximo agendamento',
            'points_required' => 100,
            'reward_type' => 'discount_fixed',
            'discount_value' => 20,
            'active' => true,
        ]);

        LoyaltyReward::create([
            'professional_id' => 1,
            'name' => 'Serviço Grátis',
            'description' => 'Um serviço grátis de sua escolha',
            'points_required' => 200,
            'reward_type' => 'free_service',
            'active' => true,
        ]);

        // Links de redes sociais
        SocialLink::create([
            'professional_id' => 1,
            'platform' => 'instagram',
            'url' => 'https://instagram.com/agendeme',
            'show_booking_button' => true,
            'active' => true,
        ]);

        SocialLink::create([
            'professional_id' => 1,
            'platform' => 'facebook',
            'url' => 'https://facebook.com/agendeme',
            'show_booking_button' => true,
            'active' => true,
        ]);
    }
}

