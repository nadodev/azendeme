<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use App\Models\TransactionCategory;
use App\Models\Professional;
use Illuminate\Database\Seeder;

class FinancialSeeder extends Seeder
{
    public function run(): void
    {
        $professional = Professional::first();
        
        if (!$professional) {
            $this->command->error('Nenhum profissional encontrado!');
            return;
        }

        // Criar métodos de pagamento
        $paymentMethods = [
            ['name' => 'Dinheiro', 'icon' => 'cash', 'active' => true, 'order' => 1],
            ['name' => 'PIX', 'icon' => 'pix', 'active' => true, 'order' => 2],
            ['name' => 'Cartão de Crédito', 'icon' => 'credit-card', 'active' => true, 'order' => 3],
            ['name' => 'Cartão de Débito', 'icon' => 'debit-card', 'active' => true, 'order' => 4],
            ['name' => 'Transferência Bancária', 'icon' => 'bank', 'active' => true, 'order' => 5],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::updateOrCreate(
                [
                    'professional_id' => $professional->id,
                    'name' => $method['name']
                ],
                $method
            );
        }

        // Criar categorias de transação
        $categories = [
            // Receitas
            ['name' => 'Serviços Prestados', 'type' => 'income', 'color' => '#10B981', 'icon' => 'service', 'active' => true],
            ['name' => 'Venda de Produtos', 'type' => 'income', 'color' => '#3B82F6', 'icon' => 'product', 'active' => true],
            ['name' => 'Outras Receitas', 'type' => 'income', 'color' => '#8B5CF6', 'icon' => 'money', 'active' => true],
            
            // Despesas
            ['name' => 'Aluguel', 'type' => 'expense', 'color' => '#EF4444', 'icon' => 'home', 'active' => true],
            ['name' => 'Insumos e Produtos', 'type' => 'expense', 'color' => '#F59E0B', 'icon' => 'box', 'active' => true],
            ['name' => 'Energia e Água', 'type' => 'expense', 'color' => '#EC4899', 'icon' => 'bolt', 'active' => true],
            ['name' => 'Marketing', 'type' => 'expense', 'color' => '#6366F1', 'icon' => 'megaphone', 'active' => true],
            ['name' => 'Outras Despesas', 'type' => 'expense', 'color' => '#64748B', 'icon' => 'receipt', 'active' => true],
        ];

        foreach ($categories as $category) {
            TransactionCategory::updateOrCreate(
                [
                    'professional_id' => $professional->id,
                    'name' => $category['name']
                ],
                $category
            );
        }

        $this->command->info('✅ Métodos de pagamento e categorias criados com sucesso!');
    }
}

