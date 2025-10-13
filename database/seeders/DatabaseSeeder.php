<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Availability;
use App\Models\BlockedDate;
use App\Models\Customer;
use App\Models\Gallery;
use App\Models\Professional;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criar usuário administrador
        $user = User::create([
            'name' => 'Admin Demo',
            'email' => 'admin@agende.me',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Criar profissional
        $professional = Professional::create([
            'name' => 'Beleza da Ana',
            'slug' => 'beleza-da-ana',
            'email' => 'ana@belezadaana.com',
            'phone' => '(11) 98765-4321',
            'business_name' => 'Studio Beleza da Ana',
            'bio' => 'Especializada em design de sobrancelhas, micropigmentação e cílios. Mais de 10 anos de experiência transformando a beleza natural das minhas clientes.',
            'brand_color' => '#E91E63',
            'active' => true,
        ]);

        // Criar serviços
        $services = [
            [
                'name' => 'Design de Sobrancelhas',
                'description' => 'Modelagem completa de sobrancelhas com técnica profissional',
                'duration' => 45,
                'price' => 80.00,
            ],
            [
                'name' => 'Micropigmentação de Sobrancelhas',
                'description' => 'Técnica de micropigmentação fio a fio para sobrancelhas naturais',
                'duration' => 120,
                'price' => 450.00,
            ],
            [
                'name' => 'Aplicação de Cílios Fio a Fio',
                'description' => 'Alongamento de cílios com técnica fio a fio',
                'duration' => 90,
                'price' => 180.00,
            ],
            [
                'name' => 'Limpeza de Pele',
                'description' => 'Limpeza profunda facial com extração e hidratação',
                'duration' => 60,
                'price' => 120.00,
            ],
            [
                'name' => 'Depilação Facial',
                'description' => 'Depilação completa do rosto',
                'duration' => 30,
                'price' => 50.00,
            ],
        ];

        foreach ($services as $serviceData) {
            Service::create(array_merge($serviceData, [
                'professional_id' => $professional->id,
                'active' => true,
            ]));
        }

        // Criar disponibilidade (Segunda a Sexta: 9h-18h, Sábado: 9h-14h)
        $availabilities = [
            ['day_of_week' => 1, 'start_time' => '09:00', 'end_time' => '18:00'], // Segunda
            ['day_of_week' => 2, 'start_time' => '09:00', 'end_time' => '18:00'], // Terça
            ['day_of_week' => 3, 'start_time' => '09:00', 'end_time' => '18:00'], // Quarta
            ['day_of_week' => 4, 'start_time' => '09:00', 'end_time' => '18:00'], // Quinta
            ['day_of_week' => 5, 'start_time' => '09:00', 'end_time' => '18:00'], // Sexta
            ['day_of_week' => 6, 'start_time' => '09:00', 'end_time' => '14:00'], // Sábado
        ];

        foreach ($availabilities as $availability) {
            Availability::create(array_merge($availability, [
                'professional_id' => $professional->id,
                'slot_duration' => 30,
            ]));
        }

        // Criar data bloqueada (exemplo: feriado)
        BlockedDate::create([
            'professional_id' => $professional->id,
            'blocked_date' => now()->addDays(15),
            'reason' => 'Feriado - Fechado',
        ]);

        // Criar fotos na galeria (usando placeholders)
        $galleryImages = [
            ['title' => 'Design de Sobrancelhas', 'description' => 'Resultado perfeito'],
            ['title' => 'Micropigmentação', 'description' => 'Técnica fio a fio'],
            ['title' => 'Cílios Fio a Fio', 'description' => 'Olhar marcante'],
            ['title' => 'Limpeza de Pele', 'description' => 'Pele renovada'],
            ['title' => 'Depilação', 'description' => 'Resultado impecável'],
            ['title' => 'Antes e Depois', 'description' => 'Transformação completa'],
        ];

        foreach ($galleryImages as $index => $img) {
            Gallery::create([
                'professional_id' => $professional->id,
                'image_path' => 'https://picsum.photos/400/300?random=' . ($index + 1),
                'title' => $img['title'],
                'description' => $img['description'],
                'order' => $index,
            ]);
        }

        // Criar clientes demo
        $customers = [
            [
                'name' => 'Maria Silva',
                'phone' => '(11) 98765-1111',
                'email' => 'maria@email.com',
                'notes' => 'Prefere horários da manhã',
            ],
            [
                'name' => 'Juliana Santos',
                'phone' => '(11) 98765-2222',
                'email' => 'juliana@email.com',
                'notes' => 'Pele sensível',
            ],
            [
                'name' => 'Carolina Oliveira',
                'phone' => '(11) 98765-3333',
                'email' => 'carolina@email.com',
            ],
            [
                'name' => 'Beatriz Costa',
                'phone' => '(11) 98765-4444',
                'email' => 'beatriz@email.com',
            ],
            [
                'name' => 'Amanda Ferreira',
                'phone' => '(11) 98765-5555',
                'email' => 'amanda@email.com',
                'notes' => 'Cliente VIP',
            ],
        ];

        $createdCustomers = [];
        foreach ($customers as $customerData) {
            $createdCustomers[] = Customer::create(array_merge($customerData, [
                'professional_id' => $professional->id,
            ]));
        }

        // Criar agendamentos demo
        $servicesList = Service::where('professional_id', $professional->id)->get();
        
        // Agendamentos passados
        for ($i = 10; $i > 0; $i--) {
            $date = now()->subDays($i);
            if ($date->dayOfWeek !== 0) { // Não domingos
                Appointment::create([
                    'professional_id' => $professional->id,
                    'service_id' => $servicesList->random()->id,
                    'customer_id' => $createdCustomers[array_rand($createdCustomers)]->id,
                    'start_time' => $date->setTime(rand(9, 16), [0, 30][rand(0, 1)]),
                    'end_time' => $date->copy()->addMinutes($servicesList->random()->duration),
                    'status' => ['completed', 'completed', 'completed', 'cancelled'][rand(0, 3)],
                ]);
            }
        }

        // Agendamentos futuros
        for ($i = 1; $i <= 15; $i++) {
            $date = now()->addDays($i);
            if ($date->dayOfWeek !== 0 && $date->dayOfWeek !== 7) { // Não domingo
                $service = $servicesList->random();
                $startTime = $date->setTime(rand(9, 15), [0, 30][rand(0, 1)]);
                
                Appointment::create([
                    'professional_id' => $professional->id,
                    'service_id' => $service->id,
                    'customer_id' => $createdCustomers[array_rand($createdCustomers)]->id,
                    'start_time' => $startTime,
                    'end_time' => $startTime->copy()->addMinutes($service->duration),
                    'status' => ['pending', 'confirmed', 'confirmed'][rand(0, 2)],
                ]);
            }
        }

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('📧 Email: admin@agende.me');
        $this->command->info('🔑 Password: password');
        $this->command->info('🔗 Professional URL: /beleza-da-ana');
    }
}
