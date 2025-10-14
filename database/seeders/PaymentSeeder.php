<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Appointment;
use App\Models\PaymentMethod;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Verificar se existem métodos de pagamento
        $paymentMethods = PaymentMethod::all();
        if ($paymentMethods->isEmpty()) {
            // Criar métodos de pagamento básicos
            $paymentMethods = collect([
                PaymentMethod::create(['name' => 'PIX', 'description' => 'Pagamento via PIX']),
                PaymentMethod::create(['name' => 'Cartão de Crédito', 'description' => 'Pagamento via cartão de crédito']),
                PaymentMethod::create(['name' => 'Cartão de Débito', 'description' => 'Pagamento via cartão de débito']),
                PaymentMethod::create(['name' => 'Dinheiro', 'description' => 'Pagamento em dinheiro']),
            ]);
        }

        // Obter agendamentos existentes
        $appointments = Appointment::where('professional_id', 1)->get();
        
        if ($appointments->isEmpty()) {
            $this->command->info('Nenhum agendamento encontrado. Execute o AppointmentSeeder primeiro.');
            return;
        }

        // Criar pagamentos para os agendamentos
        foreach ($appointments as $appointment) {
            // 80% dos agendamentos têm pagamento
            if (rand(1, 100) <= 80) {
                $paymentMethod = $paymentMethods->random();
                $amount = $appointment->total_price ?? rand(50, 200);
                
                // 90% dos pagamentos são concluídos
                $status = rand(1, 100) <= 90 ? 'completed' : 'pending';
                
                Payment::create([
                    'appointment_id' => $appointment->id,
                    'payment_method_id' => $paymentMethod->id,
                    'amount' => $amount,
                    'status' => $status,
                    'paid_at' => $status === 'completed' ? $appointment->start_time->addMinutes(rand(0, 30)) : null,
                    'created_at' => $appointment->start_time->subDays(rand(0, 7)),
                ]);
            }
        }

        $this->command->info('Pagamentos criados com sucesso!');
    }
}