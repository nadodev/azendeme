<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Professional;
use App\Models\Customer;
use App\Models\Event;
use App\Models\EventEquipment;
use App\Models\EventService;
use App\Models\EventServiceOrder;
use App\Models\EventBudget;
use App\Models\EventInvoice;
use Illuminate\Support\Facades\Hash;

class EventTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar profissional de teste
        $professional = Professional::firstOrCreate(
            ['email' => 'teste@eventos.com'],
            [
                'name' => 'Empresa de Eventos Teste',
                'slug' => 'empresa-eventos-teste',
                'phone' => '(11) 99999-9999',
                'business_type' => 'eventos',
            ]
        );

        // Criar cliente de teste
        $customer = Customer::firstOrCreate(
            ['email' => 'cliente@teste.com'],
            [
                'name' => 'João Silva',
                'phone' => '(11) 88888-8888',
                'professional_id' => $professional->id,
            ]
        );

        // Criar equipamentos de teste
        $equipamentos = [
            ['name' => 'Cabine de Fotos', 'hourly_rate' => 150.00],
            ['name' => 'Plataforma 360', 'hourly_rate' => 200.00],
            ['name' => 'Túnel de Fotos', 'hourly_rate' => 180.00],
        ];

        foreach ($equipamentos as $equipamento) {
            EventEquipment::firstOrCreate(
                [
                    'name' => $equipamento['name'],
                    'professional_id' => $professional->id,
                ],
                [
                    'description' => 'Equipamento para eventos',
                    'hourly_rate' => $equipamento['hourly_rate'],
                    'is_active' => true,
                ]
            );
        }

        // Criar evento de teste
        $event = Event::firstOrCreate(
            [
                'title' => 'Formatura 2025',
                'professional_id' => $professional->id,
            ],
            [
                'customer_id' => $customer->id,
                'type' => 'formatura',
                'description' => 'Evento de formatura com cabine de fotos',
                'event_date' => now()->addDays(30),
                'start_time' => now()->addDays(30)->setTime(18, 0),
                'end_time' => now()->addDays(30)->setTime(23, 0),
                'address' => 'Salão de Festas',
                'city' => 'São Paulo',
                'state' => 'SP',
                'status' => 'confirmado',
            ]
        );

        // Adicionar serviços ao evento
        $cabine = EventEquipment::where('name', 'Cabine de Fotos')->first();
        if ($cabine) {
            EventService::firstOrCreate(
                [
                    'event_id' => $event->id,
                    'equipment_id' => $cabine->id,
                ],
                [
                    'hours' => 5,
                    'total_value' => $cabine->hourly_rate * 5,
                ]
            );
        }

        // Criar orçamento
        $budget = EventBudget::firstOrCreate(
            [
                'event_id' => $event->id,
            ],
            [
                'budget_number' => 'ORC-' . date('Y') . '-001',
                'budget_date' => now(),
                'valid_until' => now()->addDays(15),
                'subtotal' => 750.00,
                'discount_percentage' => 0,
                'discount_value' => 0,
                'tax_percentage' => 0,
                'tax_value' => 0,
                'total' => 750.00,
                'status' => 'aprovado',
                'notes' => 'Orçamento aprovado para formatura',
            ]
        );

        // Criar OS
        $serviceOrder = EventServiceOrder::firstOrCreate(
            [
                'event_id' => $event->id,
            ],
            [
                'budget_id' => $budget->id,
                'order_number' => 'OS-' . date('Y') . '-001',
                'order_date' => now(),
                'scheduled_date' => $event->event_date,
                'scheduled_start_time' => $event->start_time,
                'scheduled_end_time' => $event->end_time,
                'description' => 'Ordem de Serviço para formatura com cabine de fotos',
                'equipment_list' => 'Cabine de Fotos - 5h',
                'employee_assignments' => 'Operador - 5h',
                'setup_instructions' => 'Montar cabine no salão principal',
                'special_requirements' => 'Tomada 220V próxima',
                'status' => 'concluida',
                'total_value' => 750.00,
                'completion_notes' => 'Serviço executado com sucesso',
            ]
        );

        $this->command->info('Dados de teste criados com sucesso!');
        $this->command->info('Evento ID: ' . $event->id);
        $this->command->info('OS ID: ' . $serviceOrder->id);
        $this->command->info('URL para testar: /panel/eventos/faturas/os/' . $serviceOrder->id . '/faturar');
    }
}
