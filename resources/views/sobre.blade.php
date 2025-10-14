<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sobre o aZendame — Sistema Completo de Agendamentos</title>
    <meta name="description" content="Conheça o aZendame, o sistema mais completo de agendamentos para profissionais. Funcionalidades, benefícios e como funciona.">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900" rel="stylesheet" />
    <style>
        :root {
            --primary: #2563EB;
            --primary-dark: #1D4ED8;
            --secondary: #8B5CF6;
            --accent: #EC4899;
            --dark: #0F172A;
        }
        
        @keyframes gradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 8s ease infinite;
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .feature-card {
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.2);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    
    <!-- Header Fixo -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-xl border-b border-gray-200">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                        <img src="{{ asset('favicon-16x16.png') }}" alt="aZendeMe" class="w-8 h-8">
                    </div>
                    <span class="text-2xl font-black">
                        <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">aZendeMe</span>
                    </span>
                </a>
                
                <div class="hidden lg:flex items-center gap-8">
                    <a href="{{ url('/') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Início</a>
                    <a href="{{ url('/funcionalidades') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Funcionalidades</a>
                    <a href="{{ url('/#como-funciona') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Como Funciona</a>
                    <a href="{{ url('/#templates') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Templates</a>
                    <a href="{{ url('/#precos') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Preços</a>
                    <a href="{{ url('/sobre') }}" class="text-blue-600 font-medium">Sobre</a>
                    {{-- <a href="{{ url('/#depoimentos') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Depoimentos</a> --}}
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="{{ url('/#demo') }}" class="px-6 py-3 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg transform hover:scale-105 transition">
                        Solicitar Demonstração
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 overflow-hidden">
        <!-- Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(37,99,235,0.1),transparent_50%),radial-gradient(circle_at_70%_60%,rgba(139,92,246,0.1),transparent_50%)]"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold mb-6">
                    🚀 Sistema Completo de Agendamentos
                </div>
                
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-black mb-6 leading-tight">
                    Conheça o
                    <span class="block bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent animate-gradient">
                        aZendeme
                    </span>
                </h1>
                
                <p class="text-xl text-gray-600 mb-8 leading-relaxed max-w-4xl mx-auto">
                    O sistema mais completo e intuitivo para gerenciar agendamentos, clientes e todo o seu negócio. 
                    Desenvolvido para profissionais que buscam excelência e praticidade.
                </p>
            </div>
        </div>
    </section>

    <!-- O que é o aZendame -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl md:text-5xl font-black mb-6">
                        O que é o <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">aZendeme</span>?
                    </h2>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        O aZendeme é uma plataforma completa de gestão de agendamentos desenvolvida especificamente 
                        para profissionais de beleza, saúde e serviços. Nossa missão é simplificar e otimizar 
                        todos os processos do seu negócio.
                    </p>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Com mais de 20 funcionalidades integradas, oferecemos uma solução all-in-one que vai 
                        desde o agendamento básico até relatórios avançados e programas de fidelidade.
                    </p>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center p-6 bg-blue-50 rounded-xl">
                            <div class="text-3xl font-black text-blue-600 mb-2">20+</div>
                            <div class="text-sm text-gray-600">Funcionalidades</div>
                        </div>
                        <div class="text-center p-6 bg-purple-50 rounded-xl">
                            <div class="text-3xl font-black text-purple-600 mb-2">4</div>
                            <div class="text-sm text-gray-600">Templates</div>
                        </div>
                        <div class="text-center p-6 bg-pink-50 rounded-xl">
                            <div class="text-3xl font-black text-pink-600 mb-2">100%</div>
                            <div class="text-sm text-gray-600">Personalizável</div>
                        </div>
                        <div class="text-center p-6 bg-green-50 rounded-xl">
                            <div class="text-3xl font-black text-green-600 mb-2">24/7</div>
                            <div class="text-sm text-gray-600">Suporte</div>
                        </div>
                    </div>
                </div>
                
                <div class="relative animate-float">
                    <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-200">
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-blue-600 to-purple-600 rounded-full blur-2xl opacity-60"></div>
                        <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full blur-2xl opacity-40"></div>
                        
                        <div class="relative">
                            <h3 class="text-2xl font-bold mb-6 text-center">Interface do Sistema</h3>
                            
                            <!-- Mock Interface -->
                            <div class="space-y-4">
                                <!-- Header -->
                                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg text-white">
                                    <h4 class="font-bold">aZendeme Dashboard</h4>
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 bg-white/20 rounded-full"></div>
                                        <span class="text-sm">Admin</span>
                                    </div>
                                </div>
                                
                                <!-- Stats -->
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="bg-blue-50 p-3 rounded-lg text-center">
                                        <div class="text-lg font-bold text-blue-600">156</div>
                                        <div class="text-xs text-gray-600">Clientes</div>
                                    </div>
                                    <div class="bg-green-50 p-3 rounded-lg text-center">
                                        <div class="text-lg font-bold text-green-600">89</div>
                                        <div class="text-xs text-gray-600">Agendamentos</div>
                                    </div>
                                    <div class="bg-purple-50 p-3 rounded-lg text-center">
                                        <div class="text-lg font-bold text-purple-600">R$ 4.2k</div>
                                        <div class="text-xs text-gray-600">Receita</div>
                                    </div>
                                </div>
                                
                                <!-- Recent Activity -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h5 class="font-semibold mb-3">Atividade Recente</h5>
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-2 text-sm">
                                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                            <span>Novo agendamento - Maria Silva</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-sm">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                            <span>Cliente confirmado - João Costa</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-sm">
                                            <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                                            <span>Pagamento recebido - R$ 150</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Screenshots Detalhados -->
    <section class="py-24 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black mb-4">
                    Veja o <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">aZendeme</span> em ação
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Interface intuitiva, design moderno e funcionalidades poderosas em uma experiência única
                </p>
            </div>

            <!-- Screenshots Grid -->
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Dashboard Screenshot -->
                <div class="feature-card bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                    <div class="mb-6">
                        <div class="bg-white rounded-xl shadow-lg p-4 border border-gray-200">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="flex gap-1.5">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                </div>
                                <div class="ml-4 text-sm text-gray-500 font-mono">Dashboard</div>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg text-white">
                                    <h4 class="font-bold">Dashboard</h4>
                                    <div class="w-6 h-6 bg-white/20 rounded-full"></div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="bg-blue-50 p-2 rounded text-center">
                                        <div class="text-sm font-bold text-blue-600">24</div>
                                        <div class="text-xs text-gray-600">Hoje</div>
                                    </div>
                                    <div class="bg-green-50 p-2 rounded text-center">
                                        <div class="text-sm font-bold text-green-600">R$ 2.4k</div>
                                        <div class="text-xs text-gray-600">Receita</div>
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 p-3 rounded">
                                    <div class="text-xs font-semibold mb-2">Agenda</div>
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2 text-xs">
                                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>
                                            <span>09:00 - Maria</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-xs">
                                            <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
                                            <span>10:30 - João</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Dashboard Inteligente</h3>
                    <p class="text-gray-600 text-sm">Controle total do seu negócio com métricas em tempo real e agenda visual.</p>
                </div>

                <!-- Agenda Screenshot -->
                <div class="feature-card bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                    <div class="mb-6">
                        <div class="bg-white rounded-xl shadow-lg p-4 border border-gray-200">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="flex gap-1.5">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                </div>
                                <div class="ml-4 text-sm text-gray-500 font-mono">Agenda</div>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg text-white">
                                    <h4 class="font-bold">Agenda</h4>
                                    <div class="w-6 h-6 bg-white/20 rounded-full"></div>
                                </div>
                                
                                <div class="grid grid-cols-7 gap-1">
                                    @for($i = 1; $i <= 21; $i++)
                                        <div class="aspect-square rounded text-xs flex items-center justify-center {{ in_array($i, [3, 7, 12, 18]) ? 'bg-gray-200' : 'bg-purple-100 hover:bg-purple-200' }} transition">
                                            {{ $i }}
                                        </div>
                                    @endfor
                                </div>
                                
                                <div class="bg-gray-50 p-3 rounded">
                                    <div class="text-xs font-semibold mb-2">Hoje - 15/01</div>
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2 text-xs">
                                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>
                                            <span>09:00 - Maria</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-xs">
                                            <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
                                            <span>14:00 - Ana</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Agenda Visual</h3>
                    <p class="text-gray-600 text-sm">Calendário intuitivo com visualização clara de todos os agendamentos.</p>
                </div>

                <!-- Clientes Screenshot -->
                <div class="feature-card bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                    <div class="mb-6">
                        <div class="bg-white rounded-xl shadow-lg p-4 border border-gray-200">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="flex gap-1.5">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                </div>
                                <div class="ml-4 text-sm text-gray-500 font-mono">Clientes</div>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-pink-600 to-purple-600 rounded-lg text-white">
                                    <h4 class="font-bold">Clientes</h4>
                                    <div class="w-6 h-6 bg-white/20 rounded-full"></div>
                                </div>
                                
                                <div class="space-y-2">
                                    <div class="flex items-center gap-3 p-2 bg-gray-50 rounded">
                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-bold">M</div>
                                        <div>
                                            <div class="text-sm font-semibold">Maria Silva</div>
                                            <div class="text-xs text-gray-600">5 agendamentos</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 p-2 bg-gray-50 rounded">
                                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-xs font-bold">J</div>
                                        <div>
                                            <div class="text-sm font-semibold">João Costa</div>
                                            <div class="text-xs text-gray-600">3 agendamentos</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 p-2 bg-gray-50 rounded">
                                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white text-xs font-bold">A</div>
                                        <div>
                                            <div class="text-sm font-semibold">Ana Lima</div>
                                            <div class="text-xs text-gray-600">8 agendamentos</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Gestão de Clientes</h3>
                    <p class="text-gray-600 text-sm">Cadastro completo com histórico e preferências de cada cliente.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Galeria de Screenshots -->
    <section class="py-24 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black mb-4">
                    Galeria de <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">Screenshots</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Explore todas as funcionalidades do aZendeme através de imagens reais do sistema
                </p>
            </div>

            <!-- Screenshots Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                $screenshots = [
                    [
                        'title' => 'Painel Principal',
                        'desc' => 'Dashboard com métricas em tempo real, agenda do dia e resumo financeiro',
                        'image' => asset('telas/tela01.png'),
                        'gradient' => 'from-blue-500 to-cyan-500',
                        'icon' => '📊'
                    ],
                    [
                        'title' => 'Agenda Completa',
                        'desc' => 'Calendário visual com agendamentos, confirmações e gestão de horários',
                        'image' => asset('telas/tela04.png'),
                        'gradient' => 'from-purple-500 to-pink-500',
                        'icon' => '📅'
                    ],
                    [
                        'title' => 'Base de Clientes',
                        'desc' => 'Cadastro completo com histórico, preferências e dados de contato',
                        'image' => asset('telas/clientes.png'),
                        'gradient' => 'from-pink-500 to-rose-500',
                        'icon' => '👥'
                    ],
                    [
                        'title' => 'Serviços & Profissionais',
                        'desc' => 'Configure serviços, preços, duração e gerencie sua equipe',
                        'image' => asset('telas/servicos.png'),
                        'gradient' => 'from-yellow-500 to-orange-500',
                        'icon' => '✂️'
                    ],
                    [
                        'title' => 'Programa de Fidelidade',
                        'desc' => 'Sistema de pontos, recompensas e descontos para clientes fiéis',
                        'image' => asset('telas/fidelidade.png'),
                        'gradient' => 'from-red-500 to-pink-500',
                        'icon' => '🎁'
                    ],
                    [
                        'title' => 'Promoções & Cupons',
                        'desc' => 'Crie campanhas promocionais e gerencie códigos de desconto',
                        'image' => asset('telas/cupons.png'),
                        'gradient' => 'from-amber-500 to-yellow-500',
                        'icon' => '🎉'
                    ],
                    [
                        'title' => 'Avaliações & Feedbacks',
                        'desc' => 'Colete e gerencie avaliações dos clientes sobre seus serviços',
                        'image' => asset('telas/feedbacks.png'),
                        'gradient' => 'from-indigo-500 to-purple-500',
                        'icon' => '⭐'
                    ],
                    [
                        'title' => 'Centro Financeiro',
                        'desc' => 'Controle de receitas, despesas, pagamentos e fluxo de caixa',
                        'image' => asset('telas/tela02.png'),
                        'gradient' => 'from-green-500 to-emerald-500',
                        'icon' => '💰'
                    ],
                    [
                        'title' => 'Relatórios Detalhados',
                        'desc' => 'Analytics avançados com métricas de vendas e performance',
                        'image' => asset('telas/relatorio-financeiro.png'),
                        'gradient' => 'from-cyan-500 to-blue-500',
                        'icon' => '📈'
                    ],
                    [
                        'title' => 'Configurações Gerais',
                        'desc' => 'Personalize cores, textos, horários e funcionalidades do sistema',
                        'image' => asset('telas/configuracoes.png'),
                        'gradient' => 'from-violet-500 to-purple-500',
                        'icon' => '⚙️'
                    ],
                    [
                        'title' => 'Templates & Personalização',
                        'desc' => 'Escolha entre 4 templates e personalize cores e textos',
                        'image' => asset('telas/templates.png'),
                        'gradient' => 'from-emerald-500 to-teal-500',
                        'icon' => '🎨'
                    ],
                    [
                        'title' => 'Central de Alertas',
                        'desc' => 'Notificações de novos agendamentos, cancelamentos e clientes',
                        'image' => asset('telas/alertas.png'),
                        'gradient' => 'from-orange-500 to-red-500',
                        'icon' => '🔔'
                    ],
                    [
                        'title' => 'Relatórios Financeiros',
                        'desc' => 'Análise de receitas por método de pagamento e período',
                        'image' => asset('telas/relatorio-financeiro.png'),
                        'gradient' => 'from-green-500 to-lime-500',
                        'icon' => '💹'
                    ],
                    [
                        'title' => 'Analytics de Serviços',
                        'desc' => 'Métricas de serviços mais agendados e performance por profissional',
                        'image' => asset('telas/servicos-2.png'),
                        'gradient' => 'from-purple-500 to-fuchsia-500',
                        'icon' => '📊'
                    ],
                    [
                        'title' => 'Dashboard de Performance',
                        'desc' => 'Visão geral completa com métricas de crescimento e tendências',
                        'image' => asset('telas/performance.png'),
                        'gradient' => 'from-rose-500 to-pink-500',
                        'icon' => '🚀'
                    ]
                ];
                @endphp

                @foreach($screenshots as $screenshot)
                <div class="feature-card bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300">
                    <!-- Screenshot Image -->
                    <div class="mb-6">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                            <div class="flex items-center gap-2 p-3 bg-gray-50 border-b border-gray-200">
                                <div class="flex gap-1.5">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                </div>
                                <div class="ml-4 text-sm text-gray-500 font-mono">{{ $screenshot['title'] }}</div>
                            </div>
                            
                            <!-- Screenshot Image -->
                            <div class="relative cursor-pointer" onclick="openScreenshotModal('{{ $screenshot['image'] }}', '{{ $screenshot['title'] }}', '{{ $screenshot['desc'] }}')">
                                <img src="{{ $screenshot['image'] }}" 
                                     alt="{{ $screenshot['title'] }}" 
                                     class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300">
                                
                                <!-- Overlay with gradient -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                                
                                <!-- Title overlay -->
                                <div class="absolute bottom-4 left-4 right-4">
                                    <div class="bg-white/90 backdrop-blur-sm rounded-lg p-3">
                                        <h4 class="font-bold text-sm text-gray-900">{{ $screenshot['title'] }}</h4>
                                        <p class="text-xs text-gray-600 mt-1">{{ $screenshot['desc'] }}</p>
                                    </div>
                                </div>
                                
                                <!-- Zoom icon -->
                                <div class="absolute top-4 right-4 w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300">
                                    <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="text-center">
                        <div class="w-12 h-12 bg-gradient-to-br {{ $screenshot['gradient'] }} rounded-xl flex items-center justify-center text-2xl mb-4 mx-auto shadow-lg">
                            {{ $screenshot['icon'] }}
                        </div>
                        <h3 class="text-lg font-bold mb-2">{{ $screenshot['title'] }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $screenshot['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- CTA Section -->
            <div class="text-center mt-16">
                <h3 class="text-2xl md:text-3xl font-bold mb-4">
                    Gostou do que viu?
                </h3>
                <p class="text-lg text-gray-600 mb-8">
                    Agende uma demonstração e veja todas essas funcionalidades em ação
                </p>
                <a href="{{ url('/#demo') }}" class="inline-block px-8 py-4 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white rounded-xl font-bold text-lg hover:shadow-2xl transform hover:scale-105 transition">
                    🚀 Agendar Demonstração
                </a>
            </div>
        </div>
    </section>

    <!-- Benefícios -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black mb-4">
                    Por que escolher o <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">aZendeme</span>?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Desenvolvido pensando nas necessidades reais dos profissionais
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                $benefits = [
                    [
                        'icon' => '⚡',
                        'title' => 'Setup em 5 minutos',
                        'desc' => 'Configure seu sistema rapidamente e comece a usar imediatamente.'
                    ],
                    [
                        'icon' => '🎨',
                        'title' => 'Totalmente personalizável',
                        'desc' => 'Cores, textos, imagens e muito mais. Seu sistema, sua identidade.'
                    ],
                    [
                        'icon' => '📱',
                        'title' => 'Responsivo e moderno',
                        'desc' => 'Funciona perfeitamente em computador, tablet e celular.'
                    ],
                    [
                        'icon' => '🔒',
                        'title' => 'Seguro e confiável',
                        'desc' => 'Seus dados protegidos com criptografia e backup automático.'
                    ],
                    [
                        'icon' => '🚀',
                        'title' => 'Atualizações constantes',
                        'desc' => 'Novas funcionalidades e melhorias sempre disponíveis.'
                    ],
                    [
                        'icon' => '💬',
                        'title' => 'Suporte especializado',
                        'desc' => 'Equipe técnica pronta para ajudar quando precisar.'
                    ]
                ];
                @endphp
                
                @foreach($benefits as $benefit)
                <div class="feature-card bg-white rounded-2xl p-8 border-2 border-gray-100 hover:border-blue-200">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-500 rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-lg">
                        {{ $benefit['icon'] }}
                    </div>
                    <h3 class="text-2xl font-bold mb-3">{{ $benefit['title'] }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $benefit['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="py-24 bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                Pronto para transformar seu negócio?
            </h2>
            <p class="text-xl text-blue-100 mb-8 leading-relaxed">
                Junte-se a centenas de profissionais que já escolheram o aZendeme para gerenciar seus agendamentos
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url('/#demo') }}" class="px-10 py-5 bg-white text-purple-600 rounded-xl font-bold text-lg hover:shadow-2xl transform hover:scale-105 transition">
                    🚀 Solicitar Demonstração
                </a>
                <a href="{{ url('/#precos') }}" class="px-10 py-5 bg-white/20 text-white rounded-xl font-bold text-lg border-2 border-white hover:bg-white/30 transition">
                    💰 Ver Preços
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                            <span class="text-white font-black text-xl">aZ</span>
                        </div>
                        <span class="text-2xl font-black">
                            <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">aZendeme</span>
                        </span>
                    </div>
                    <p class="text-gray-400 mb-6 max-w-md">
                        Sistema completo de agendamentos para profissionais. Transforme seu negócio com tecnologia e praticidade.
                    </p>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Links Rápidos</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/') }}" class="text-gray-400 hover:text-white transition">Início</a></li>
                        <li><a href="{{ url('/sobre') }}" class="text-gray-400 hover:text-white transition">Sobre</a></li>
                        <li><a href="{{ url('/funcionalidades') }}" class="text-gray-400 hover:text-white transition">Funcionalidades</a></li>
                        <li><a href="{{ url('/#precos') }}" class="text-gray-400 hover:text-white transition">Preços</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Contato</h3>
                    <ul class="space-y-2">
                        <li class="text-gray-400">suporte@azendame.com</li>
                        <li class="text-gray-400">(49) 99919-5407</li>
                        <li class="text-gray-400">Joaçaba, SC</li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} aZendeme. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Screenshot Modal -->
    <div id="screenshot-modal" class="hidden fixed inset-0 bg-black/95 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="relative max-w-6xl w-full max-h-[90vh] flex flex-col">
            <!-- Close Button -->
            <button id="screenshot-close-btn" class="absolute -top-12 right-0 text-white text-4xl hover:text-gray-300 transition-colors font-light z-10">&times;</button>
            
            <!-- Modal Content -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-full">
                <!-- Image Container -->
                <div class="flex-1 flex items-center justify-center bg-gray-50 p-8">
                    <img id="screenshot-modal-img" src="" alt="" class="max-w-full max-h-[70vh] object-contain rounded-lg shadow-lg">
                </div>
                
                <!-- Content -->
                <div class="p-8 bg-white border-t border-gray-100">
                    <div class="text-center">
                        <h4 id="screenshot-modal-title" class="text-3xl font-bold text-gray-900 mb-3"></h4>
                        <p id="screenshot-modal-description" class="text-gray-600 text-lg leading-relaxed"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Screenshot Modal Functions
        function openScreenshotModal(imageSrc, title, description) {
            const modal = document.getElementById('screenshot-modal');
            const modalImg = document.getElementById('screenshot-modal-img');
            const modalTitle = document.getElementById('screenshot-modal-title');
            const modalDescription = document.getElementById('screenshot-modal-description');
            
            modalImg.src = imageSrc;
            modalImg.alt = title;
            modalTitle.textContent = title;
            modalDescription.textContent = description;
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeScreenshotModal() {
            const modal = document.getElementById('screenshot-modal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Event Listeners
        document.getElementById('screenshot-close-btn').addEventListener('click', closeScreenshotModal);
        
        // Close modal when clicking outside
        document.getElementById('screenshot-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeScreenshotModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeScreenshotModal();
            }
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>
