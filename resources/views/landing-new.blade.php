<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>aZendeme — Sistema Completo de Agendamentos para Profissionais</title>
    <meta name="description" content="Sistema profissional de agendamentos com sua marca. Fidelidade, promoções, feedbacks, redes sociais e muito mais. Solicite uma demonstração!">
    @include('partials.favicon')
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
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 8s ease infinite;
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .slide-in-up {
            animation: slideInUp 0.6s ease-out forwards;
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
            box-shadow: 0 20px 40px rgba(139, 92, 246, 0.2);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    @php
        // Flags para mostrar/ocultar seções da Landing
        $showHowItWorks = $showHowItWorks ?? true;
        $showScreenshots = $showScreenshots ?? true;
        $showTemplates = $showTemplates ?? true;
        $showPricing = $showPricing ?? true;
        $showTestimonials =  false; // "feedbacks"
        $showDemoForm = $showDemoForm ?? true;
        $showFooter = $showFooter ?? true;
    @endphp
    
    <!-- Header Fixo -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-xl border-b border-gray-200">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 sm:h-20">
                <a href="#inicio" class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-white font-black text-xl">aZ</span>
                    </div>
                    <span class="text-2xl font-black">
                        <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">aZendeme</span>
                    </span>
                </a>
                
                <div class="hidden lg:flex items-center gap-8">
                    <a href="#funcionalidades" class="text-gray-700 hover:text-purple-600 font-medium transition">Funcionalidades</a>
                    <a href="#como-funciona" class="text-gray-700 hover:text-purple-600 font-medium transition">Como Funciona</a>
                    <a href="#templates" class="text-gray-700 hover:text-purple-600 font-medium transition">Templates</a>
                    <a href="#precos" class="text-gray-700 hover:text-purple-600 font-medium transition">Preços</a>
                    <a href="/sobre" class="text-gray-700 hover:text-purple-600 font-medium transition">Sobre</a>
                    {{-- <a href="#depoimentos" class="text-gray-700 hover:text-purple-600 font-medium transition">Depoimentos</a> --}}
                </div>
                
                <div class="flex items-center gap-2">
                    <a href="#demo" class="hidden sm:inline-flex sm:text-sm px-4 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg transform hover:scale-105 transition">
                        Solicitar Demonstração
                    </a>
                    <button id="mobile-menu-toggle" aria-label="Abrir menu" class="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                        <svg id="icon-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 5h14a1 1 0 100-2H3a1 1 0 100 2zm14 4H3a1 1 0 100 2h14a1 1 0 100-2zm0 6H3a1 1 0 100 2h14a1 1 0 100-2z" clip-rule="evenodd"/></svg>
                        <svg id="icon-close" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="lg:hidden hidden border-t border-gray-200 bg-white/95 backdrop-blur-xl">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex flex-col gap-2">
                    <a href="#funcionalidades" class="px-3 py-2 rounded-lg text-gray-800 hover:bg-gray-100 font-medium">Funcionalidades</a>
                    <a href="#como-funciona" class="px-3 py-2 rounded-lg text-gray-800 hover:bg-gray-100 font-medium">Como Funciona</a>
                    <a href="#templates" class="px-3 py-2 rounded-lg text-gray-800 hover:bg-gray-100 font-medium">Templates</a>
                    <a href="#precos" class="px-3 py-2 rounded-lg text-gray-800 hover:bg-gray-100 font-medium">Preços</a>
                    <a href="/sobre" class="px-3 py-2 rounded-lg text-gray-800 hover:bg-gray-100 font-medium">Sobre</a>
                    <a href="#demo" class="mt-2 px-4 py-3 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white rounded-xl font-semibold text-center">Solicitar Demonstração</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="inicio" class="relative pt-32 pb-20 overflow-hidden">
        <!-- Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(139,92,246,0.1),transparent_50%),radial-gradient(circle_at_70%_60%,rgba(236,72,153,0.1),transparent_50%)]"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Texto -->
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold mb-6">
                        ✨ Sistema Completo de Agendamentos
                    </div>
                    
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-black mb-6 leading-tight">
                        Transforme seu negócio com
                        <span class="block bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent animate-gradient">
                            aZendeme
                        </span>
                    </h1>
                    
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Sistema profissional all-in-one com sua marca: Agenda, Fidelidade, Promoções, Feedbacks, Redes Sociais e muito mais!
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start mb-12">
                        <a href="#demo" class="px-8 py-4 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white rounded-xl font-bold text-lg hover:shadow-2xl transform hover:scale-105 transition">
                            🚀 Solicitar Demonstração
                        </a>
                        <a href="#funcionalidades" class="px-8 py-4 bg-white text-purple-600 rounded-xl font-bold text-lg border-2 border-purple-600 hover:bg-purple-50 transition">
                            📋 Ver Todas as Funcionalidades
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 max-w-md mx-auto lg:mx-0">
                        <div class="text-center">
                            <div class="text-3xl font-black text-purple-600">20+</div>
                            <div class="text-sm text-gray-600">Funcionalidades</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-black text-pink-600">4</div>
                            <div class="text-sm text-gray-600">Templates</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-black text-blue-600">100%</div>
                            <div class="text-sm text-gray-600">Personalizável</div>
                        </div>
                    </div>
                </div>
                
                <!-- Imagem/Demo Visual -->
                <div class="relative animate-float">
                    <div class="relative bg-white rounded-3xl shadow-2xl p-8 border border-gray-200">
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full blur-2xl opacity-60"></div>
                        <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-gradient-to-br from-blue-600 to-purple-600 rounded-full blur-2xl opacity-40"></div>
                        
                        <div class="relative">
                            <div class="flex items-center gap-2 mb-6">
                                <div class="flex gap-1.5">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                </div>
                                <div class="ml-4 text-sm text-gray-500 font-mono">azendeme.com/seu-negocio</div>
                            </div>
                            
                            <!-- Mini Screenshot -->
                            <div class="space-y-4">
                                <div class="h-3 bg-gray-200 rounded-full w-3/4"></div>
                                <div class="h-3 bg-gray-200 rounded-full w-full"></div>
                                <div class="h-3 bg-gray-200 rounded-full w-2/3"></div>
                                
                                <div class="grid grid-cols-7 gap-2 my-6">
                                    @for($i = 1; $i <= 28; $i++)
                                        <div class="aspect-square rounded-lg {{ in_array($i, [3, 7, 12, 18, 26]) ? 'bg-gray-200' : 'bg-purple-100 hover:bg-purple-200' }} transition"></div>
                                    @endfor
                                </div>
                                
                                <div class="flex gap-3">
                                    <div class="flex-1 h-12 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg"></div>
                                    <div class="flex-1 h-12 bg-gray-100 rounded-lg"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Funcionalidades Principais -->
    <section id="funcionalidades" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black mb-4">
                    Tudo que você precisa em
                    <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">um só lugar</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Sistema completo com mais de 20 funcionalidades profissionais para gerenciar seu negócio
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                $features = [
                    [
                        'icon' => '📅',
                        'title' => 'Agenda Inteligente',
                        'desc' => 'Gerencie horários, confirmações, cancelamentos e recorrências. Visualização em calendário completo.',
                        'gradient' => 'from-blue-500 to-cyan-500'
                    ],
                    [
                        'icon' => '👥',
                        'title' => 'Gestão de Clientes',
                        'desc' => 'Cadastro completo com histórico de agendamentos, preferências e notas personalizadas.',
                        'gradient' => 'from-purple-500 to-pink-500'
                    ],
                    [
                        'icon' => '✂️',
                        'title' => 'Serviços & Profissionais',
                        'desc' => 'Cadastre serviços com valores, duração e profissionais responsáveis. Suporte multi-usuário.',
                        'gradient' => 'from-pink-500 to-rose-500'
                    ],
                    [
                        'icon' => '🎁',
                        'title' => 'Programa de Fidelidade',
                        'desc' => 'Acumule pontos por visita e valor gasto. Crie recompensas personalizadas para clientes fiéis.',
                        'gradient' => 'from-yellow-500 to-orange-500'
                    ],
                    [
                        'icon' => '🎉',
                        'title' => 'Promoções & Cupons',
                        'desc' => 'Crie campanhas segmentadas com cupons de desconto. Alcance clientes inativos e fidelize ativos.',
                        'gradient' => 'from-red-500 to-pink-500'
                    ],
                    [
                        'icon' => '⭐',
                        'title' => 'Sistema de Feedbacks',
                        'desc' => 'Colete avaliações dos clientes com aprovação. Exiba depoimentos na sua página pública.',
                        'gradient' => 'from-amber-500 to-yellow-500'
                    ],
                    [
                        'icon' => '📱',
                        'title' => 'Redes Sociais',
                        'desc' => 'Link direto de agendamento, QR Code personalizado e integração com Instagram, Facebook e mais.',
                        'gradient' => 'from-indigo-500 to-purple-500'
                    ],
                    [
                        'icon' => '💰',
                        'title' => 'Centro Financeiro',
                        'desc' => 'Controle completo de receitas, despesas, caixa diário e emissão de recibos digitais.',
                        'gradient' => 'from-green-500 to-emerald-500'
                    ],
                    [
                        'icon' => '🔗',
                        'title' => 'Links Rápidos',
                        'desc' => 'Crie links de agendamento direto para compartilhar em stories, bio e campanhas.',
                        'gradient' => 'from-cyan-500 to-blue-500'
                    ],
                    [
                        'icon' => '⏰',
                        'title' => 'Fila de Espera',
                        'desc' => 'Gerencie lista de espera e notifique clientes quando houver cancelamentos.',
                        'gradient' => 'from-violet-500 to-purple-500'
                    ],
                    [
                        'icon' => '📊',
                        'title' => 'Relatórios & Analytics',
                        'desc' => 'Dashboard com métricas, serviços mais vendidos, horários populares e muito mais.',
                        'gradient' => 'from-blue-500 to-indigo-500'
                    ],
                    [
                        'icon' => '🎨',
                        'title' => '4 Templates Profissionais',
                        'desc' => 'Clínica, Salão, Tatuagem e Barbearia. Totalmente personalizáveis com suas cores.',
                        'gradient' => 'from-pink-500 to-purple-500'
                    ]
                ];
                @endphp
                
                @foreach($features as $feature)
                <div class="feature-card bg-white rounded-2xl p-8 border-2 border-gray-100 hover:border-purple-200">
                    <div class="w-16 h-16 bg-gradient-to-br {{ $feature['gradient'] }} rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-lg">
                        {{ $feature['icon'] }}
                    </div>
                    <h3 class="text-2xl font-bold mb-3">{{ $feature['title'] }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $feature['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Botão para ver funcionalidades completas -->
    <section class="py-16 bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h3 class="text-3xl md:text-4xl font-black text-white mb-4">
                Quer conhecer TODAS as funcionalidades do <span class="text-yellow-300">aZendeme</span> em detalhes?
            </h3>
            <p class="text-xl text-blue-100 mb-8">
                Veja a lista completa com exemplos práticos de como cada recurso funciona
            </p>
            <a href="{{ url('/funcionalidades') }}" class="inline-block px-10 py-5 bg-white text-purple-600 rounded-xl font-bold text-lg hover:shadow-2xl transform hover:scale-105 transition">
                📚 Ver Lista Completa de Funcionalidades
            </a>
        </div>
    </section>

    @if($showHowItWorks)
        @include('landing.sections.how-it-works')
    @endif
    @if($showScreenshots)
        @include('landing.sections.screenshots')
    @endif
    @if($showTemplates)
        @include('landing.sections.templates')
    @endif
    @if($showPricing)
        @include('landing.sections.pricing')
    @endif
    @if($showTestimonials)
        @include('landing.sections.testimonials')
    @endif
    @if($showDemoForm)
        @include('landing.sections.demo-form')
    @endif
    @if($showFooter)
        @include('landing.sections.footer')
    @endif
    
    <script>
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

        // Mobile menu toggle
        const toggle = document.getElementById('mobile-menu-toggle');
        const menu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('icon-open');
        const iconClose = document.getElementById('icon-close');

        if (toggle && menu && iconOpen && iconClose) {
            toggle.addEventListener('click', () => {
                menu.classList.toggle('hidden');
                iconOpen.classList.toggle('hidden');
                iconClose.classList.toggle('hidden');
            });

            // Close menu when clicking a link
            menu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    if (!menu.classList.contains('hidden')) {
                        menu.classList.add('hidden');
                        iconOpen.classList.remove('hidden');
                        iconClose.classList.add('hidden');
                    }
                });
            });
        }
    </script>
</body>
</html>

