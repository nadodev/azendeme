<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Professional;
use App\Models\Service;
use App\Models\Employee;
use App\Models\Customer;
use App\Models\Availability;
use App\Models\PaymentMethod;
use App\Models\TransactionCategory;
use App\Models\Appointment;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database seguindo os Requisitos Funcionais (RF01-RF06)
     */
    public function run(): void
    {
        $this->command->info('🚀 Iniciando população do banco de dados...');
        $this->command->info('📋 Seguindo Requisitos Funcionais RF01-RF06');
        $this->command->newLine();
        
        // ============================================
        // RF01: USUÁRIO 1 + PROFESSIONAL (1:1)
        // ============================================
        $this->command->info('👤 USUÁRIO 1: Salão da Maria...');
        
        $user1 = User::create([
            'name' => 'Maria Silva',
            'email' => 'maria@salao.com',
            'password' => Hash::make('password'),
            'role' => 'usuario',
            'plan' => 'premium',
        ]);
        
        $professional1 = Professional::create([
            'user_id' => $user1->id,
            'name' => 'Salão da Maria',
            'slug' => 'salao-da-maria',
            'email' => 'contato@salaodamaria.com',
            'phone' => '(11) 98765-4321',
            'brand_color' => '#E91E63',
            'template' => 'salon',
            'business_name' => 'Salão da Maria - Beleza e Estilo',
            'bio' => 'Salão especializado em cabelos, unhas e estética facial. Mais de 10 anos de experiência.',
            'active' => true,
        ]);

        $this->command->info("  ✅ User ID: {$user1->id} → Professional ID: {$professional1->id}");
        
        // RF03: Cadastro de Funcionários (com CPF)
        $this->command->info('  👥 Criando funcionários (RF03)...');
        
        $emp1_1 = Employee::create([
            'professional_id' => $professional1->id,
            'name' => 'Ana Souza',
            'email' => 'ana@salaodamaria.com',
            'phone' => '(11) 98888-1111',
            'cpf' => '123.456.789-01',
            'color' => '#FF6B9D',
            'active' => true,
            'show_in_booking' => true,
        ]);
        
        $emp1_2 = Employee::create([
            'professional_id' => $professional1->id,
            'name' => 'Carla Santos',
            'email' => 'carla@salaodamaria.com',
            'phone' => '(11) 98888-2222',
            'cpf' => '987.654.321-09',
            'color' => '#C44569',
            'active' => true,
            'show_in_booking' => true,
        ]);
        
        $this->command->info("    ✅ {$emp1_1->name} (CPF: {$emp1_1->cpf})");
        $this->command->info("    ✅ {$emp1_2->name} (CPF: {$emp1_2->cpf})");
        
        // RF04: Cadastro de Serviços (pode ou não ter funcionário vinculado)
        $this->command->info('  📋 Criando serviços (RF04)...');
        
        // Serviço 1: VINCULADO a funcionário específico
        $servico1_1 = Service::create([
            'professional_id' => $professional1->id,
            'name' => 'Corte de Cabelo Feminino',
            'description' => 'Corte moderno com acabamento profissional',
            'duration' => 60,
                'price' => 80.00,
            'active' => true,
        ]);
        $emp1_1->services()->attach($servico1_1->id);
        $this->command->info("    ✅ {$servico1_1->name} → Vinculado a: {$emp1_1->name}");
        
        // Serviço 2: VINCULADO a outro funcionário
        $servico1_2 = Service::create([
            'professional_id' => $professional1->id,
            'name' => 'Manicure e Pedicure',
            'description' => 'Cuidados completos para mãos e pés',
                'duration' => 90,
            'price' => 60.00,
            'active' => true,
        ]);
        $emp1_2->services()->attach($servico1_2->id);
        $this->command->info("    ✅ {$servico1_2->name} → Vinculado a: {$emp1_2->name}");
        
        // Serviço 3: SEM funcionário vinculado (apenas profissional)
        $servico1_3 = Service::create([
            'professional_id' => $professional1->id,
            'name' => 'Escova Progressiva',
            'description' => 'Alisamento e hidratação profunda (feito pelo profissional)',
            'duration' => 120,
            'price' => 250.00,
                'active' => true,
        ]);
        $this->command->info("    ✅ {$servico1_3->name} → SEM funcionário (apenas profissional)");
        
        // RF05: Cadastro de Disponibilidade (funcionário OU profissional)
        $this->command->info('  ⏰ Criando disponibilidades (RF05)...');
        
        // Disponibilidade DO PROFISSIONAL (geral, employee_id = NULL)
        for ($day = 1; $day <= 5; $day++) {
            Availability::create([
                'professional_id' => $professional1->id,
                'employee_id' => null, // Profissional
                'day_of_week' => $day,
                'start_time' => '09:00:00',
                'end_time' => '18:00:00',
                'slot_duration' => 30,
            ]);
        }
        $this->command->info("    ✅ Segunda a Sexta (09:00-18:00) → Profissional");
        
        // Disponibilidade ESPECÍFICA do Funcionário 1
        Availability::create([
            'professional_id' => $professional1->id,
            'employee_id' => $emp1_1->id,
            'day_of_week' => 6, // Sábado
            'start_time' => '09:00:00',
            'end_time' => '14:00:00',
            'slot_duration' => 30,
        ]);
        $this->command->info("    ✅ Sábado (09:00-14:00) → Funcionário: {$emp1_1->name}");
        
        // Clientes
        $this->command->info('  👤 Criando clientes...');
        
        $customer1_1 = Customer::create([
            'professional_id' => $professional1->id,
            'name' => 'Juliana Oliveira',
            'email' => 'juliana@email.com',
            'phone' => '(11) 99999-1111',
        ]);
        
        // RF06: Agendamento
        $this->command->info('  📅 Criando agendamento exemplo (RF06)...');
        
        $appointment1 = Appointment::create([
            'professional_id' => $professional1->id,
            'service_id' => $servico1_1->id,
            'employee_id' => $emp1_1->id, // Serviço vinculado a funcionário
            'customer_id' => $customer1_1->id,
            'start_time' => Carbon::now()->next('Monday')->setTime(10, 0),
            'end_time' => Carbon::now()->next('Monday')->setTime(11, 0),
            'status' => 'confirmed',
            'notes' => 'Agendamento de teste para ' . $customer1_1->name,
        ]);
        $this->command->info("    ✅ Agendamento: {$servico1_1->name} com {$emp1_1->name}");
        
        // Métodos de pagamento
        PaymentMethod::create(['professional_id' => $professional1->id, 'name' => 'Dinheiro', 'active' => true]);
        PaymentMethod::create(['professional_id' => $professional1->id, 'name' => 'PIX', 'active' => true]);
        
        // Categorias de transação
        TransactionCategory::create(['professional_id' => $professional1->id, 'name' => 'Serviços', 'type' => 'income', 'color' => '#10B981']);
        
        // ============================================
        // RF01: USUÁRIO 2 + PROFESSIONAL (1:1)
        // ============================================
        $this->command->newLine();
        $this->command->info('👤 USUÁRIO 2: Clínica Dr. João...');
        
        $user2 = User::create([
            'name' => 'João Pereira',
            'email' => 'joao@clinica.com',
            'password' => Hash::make('password'),
            'role' => 'usuario',
            'plan' => 'master',
        ]);
        
        $professional2 = Professional::create([
            'user_id' => $user2->id,
            'name' => 'Clínica Estética Dr. João',
            'slug' => 'clinica-dr-joao',
            'email' => 'contato@clinicadrjoao.com',
            'phone' => '(11) 97654-3210',
            'brand_color' => '#3B82F6',
            'template' => 'clinic',
            'business_name' => 'Clínica Estética Dr. João Pereira',
            'bio' => 'Tratamentos estéticos avançados com tecnologia de ponta.',
            'active' => true,
        ]);
        
        $this->command->info("  ✅ User ID: {$user2->id} → Professional ID: {$professional2->id}");
        
        // RF03: Cadastro de Funcionários (com CPF)
        $this->command->info('  👥 Criando funcionários (RF03)...');
        
        $emp2_1 = Employee::create([
            'professional_id' => $professional2->id,
            'name' => 'Dra. Fernanda Lima',
            'email' => 'fernanda@clinicadrjoao.com',
            'phone' => '(11) 97777-1111',
            'cpf' => '111.222.333-44',
            'color' => '#3B82F6',
            'active' => true,
            'show_in_booking' => true,
        ]);
        
        $emp2_2 = Employee::create([
            'professional_id' => $professional2->id,
            'name' => 'Rafael Alves',
            'email' => 'rafael@clinicadrjoao.com',
            'phone' => '(11) 97777-2222',
            'cpf' => '555.666.777-88',
            'color' => '#8B5CF6',
            'active' => true,
            'show_in_booking' => true,
        ]);
        
        $this->command->info("    ✅ {$emp2_1->name} (CPF: {$emp2_1->cpf})");
        $this->command->info("    ✅ {$emp2_2->name} (CPF: {$emp2_2->cpf})");
        
        // RF04: Cadastro de Serviços
        $this->command->info('  📋 Criando serviços (RF04)...');
        
        // Serviço 1: VINCULADO a funcionária
        $servico2_1 = Service::create([
            'professional_id' => $professional2->id,
            'name' => 'Limpeza de Pele Profunda',
            'description' => 'Limpeza completa com extração e máscara',
            'duration' => 90,
            'price' => 150.00,
            'active' => true,
        ]);
        $emp2_1->services()->attach($servico2_1->id);
        $this->command->info("    ✅ {$servico2_1->name} → Vinculado a: {$emp2_1->name}");
        
        // Serviço 2: VINCULADO a outro funcionário
        $servico2_2 = Service::create([
            'professional_id' => $professional2->id,
            'name' => 'Design de Sobrancelhas',
            'description' => 'Modelagem completa de sobrancelhas',
            'duration' => 45,
            'price' => 80.00,
            'active' => true,
        ]);
        $emp2_2->services()->attach($servico2_2->id);
        $this->command->info("    ✅ {$servico2_2->name} → Vinculado a: {$emp2_2->name}");
        
        // Serviço 3: SEM funcionário (feito pelo profissional/dono)
        $servico2_3 = Service::create([
            'professional_id' => $professional2->id,
            'name' => 'Harmonização Facial',
            'description' => 'Preenchimento com ácido hialurônico (Dr. João)',
            'duration' => 60,
            'price' => 800.00,
            'active' => true,
        ]);
        $this->command->info("    ✅ {$servico2_3->name} → SEM funcionário (Dr. João - profissional)");
        
        // RF05: Cadastro de Disponibilidade
        $this->command->info('  ⏰ Criando disponibilidades (RF05)...');
        
        // Disponibilidade DO PROFISSIONAL
        for ($day = 1; $day <= 5; $day++) {
            Availability::create([
                'professional_id' => $professional2->id,
                'employee_id' => null,
                'day_of_week' => $day,
                'start_time' => '08:00:00',
                'end_time' => '17:00:00',
                'slot_duration' => 30,
            ]);
        }
        $this->command->info("    ✅ Segunda a Sexta (08:00-17:00) → Profissional");
        
        // Disponibilidade ESPECÍFICA de Funcionário
        Availability::create([
            'professional_id' => $professional2->id,
            'employee_id' => $emp2_1->id,
            'day_of_week' => 6,
            'start_time' => '08:00:00',
            'end_time' => '12:00:00',
            'slot_duration' => 30,
        ]);
        $this->command->info("    ✅ Sábado (08:00-12:00) → Funcionária: {$emp2_1->name}");
        
        // Cliente
        $customer2_1 = Customer::create([
            'professional_id' => $professional2->id,
            'name' => 'Mariana Rodrigues',
            'email' => 'mariana@email.com',
            'phone' => '(11) 96666-1111',
        ]);
        
        // RF06: Agendamento
        $this->command->info('  📅 Criando agendamento exemplo (RF06)...');
        
        $appointment2 = Appointment::create([
            'professional_id' => $professional2->id,
            'service_id' => $servico2_1->id,
            'employee_id' => $emp2_1->id,
            'customer_id' => $customer2_1->id,
            'start_time' => Carbon::now()->next('Tuesday')->setTime(10, 0),
            'end_time' => Carbon::now()->next('Tuesday')->setTime(11, 30),
            'status' => 'confirmed',
            'notes' => 'Agendamento de teste para ' . $customer2_1->name,
        ]);
        $this->command->info("    ✅ Agendamento: {$servico2_1->name} com {$emp2_1->name}");
        
        // Métodos de pagamento
        PaymentMethod::create(['professional_id' => $professional2->id, 'name' => 'Cartão', 'active' => true]);
        PaymentMethod::create(['professional_id' => $professional2->id, 'name' => 'Transferência', 'active' => true]);
        
        // Categorias
        TransactionCategory::create(['professional_id' => $professional2->id, 'name' => 'Consultas', 'type' => 'income', 'color' => '#059669']);
        
        // ============================================
        // RESUMO
        // ============================================
        $this->command->newLine();
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('✅ BANCO DE DADOS POPULADO COM SUCESSO!');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->newLine();
        
        $this->command->info('📊 RESUMO - Requisitos Funcionais Implementados:');
        $this->command->newLine();
        
        $this->command->info('✅ RF01: Usuário ↔ Professional (1:1)');
        $this->command->info('✅ RF02: Autenticação (login com email/senha)');
        $this->command->info('✅ RF03: Funcionários (com Nome, Email, Telefone, CPF)');
        $this->command->info('✅ RF04: Serviços (com/sem funcionário vinculado)');
        $this->command->info('✅ RF05: Disponibilidade (funcionário OU profissional)');
        $this->command->info('✅ RF06: Agendamento (serviço + funcionário/profissional + data/hora + cliente)');
        $this->command->newLine();
        
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('👤 USUÁRIO 1: Salão da Maria');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('   📧 Email: maria@salao.com');
        $this->command->info('   🔑 Senha: password');
        $this->command->info('   🆔 User ID: ' . $user1->id);
        $this->command->info('   🏢 Professional ID: ' . $professional1->id);
        $this->command->info('   🔗 Página: /salao-da-maria');
        $this->command->newLine();
        $this->command->info('   Serviços:');
        $this->command->info('   • Corte de Cabelo → Ana Souza (funcionária)');
        $this->command->info('   • Manicure → Carla Santos (funcionária)');
        $this->command->info('   • Escova Progressiva → Profissional (sem funcionário)');
        $this->command->newLine();
        
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('👤 USUÁRIO 2: Clínica Dr. João');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('   📧 Email: joao@clinica.com');
        $this->command->info('   🔑 Senha: password');
        $this->command->info('   🆔 User ID: ' . $user2->id);
        $this->command->info('   🏢 Professional ID: ' . $professional2->id);
        $this->command->info('   🔗 Página: /clinica-dr-joao');
        $this->command->newLine();
        $this->command->info('   Serviços:');
        $this->command->info('   • Limpeza de Pele → Dra. Fernanda (funcionária)');
        $this->command->info('   • Design de Sobrancelhas → Rafael (funcionário)');
        $this->command->info('   • Harmonização Facial → Dr. João (profissional)');
        $this->command->newLine();
        
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('🚀 COMO TESTAR:');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('1. Acesse: /login');
        $this->command->info('2. Faça login com maria@salao.com ou joao@clinica.com');
        $this->command->info('3. Veja apenas SEUS cadastros no painel');
        $this->command->info('4. Acesse as páginas públicas:');
        $this->command->info('   • /salao-da-maria');
        $this->command->info('   • /clinica-dr-joao');
        $this->command->info('5. Teste o agendamento público (RF06)');
        $this->command->newLine();
    }
}
