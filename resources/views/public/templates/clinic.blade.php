<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $professional->business_name }} — {{ $professional->name }}</title>
    @include('partials.favicon')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            /* Cores globais */
            --brand: {{ $professional->templateSetting->primary_color ?? $professional->brand_color ?? '#3B82F6' }};
            --brand-light: {{ $professional->templateSetting->primary_color ?? $professional->brand_color ?? '#3B82F6' }}20;
            --secondary: {{ $professional->templateSetting->secondary_color ?? '#A78BFA' }};
            --accent: {{ $professional->templateSetting->accent_color ?? '#7C3AED' }};
            --background: {{ $professional->templateSetting->background_color ?? '#FFFFFF' }};
            --text: {{ $professional->templateSetting->text_color ?? '#1F2937' }};
            
            /* Cores por seção */
            --hero-primary: {{ $professional->templateSetting->hero_primary_color ?? $professional->templateSetting->primary_color ?? '#8B5CF6' }};
            --hero-bg: {{ $professional->templateSetting->hero_background_color ?? '#FAFBFC' }};
            --services-primary: {{ $professional->templateSetting->services_primary_color ?? '#10B981' }};
            --services-bg: {{ $professional->templateSetting->services_background_color ?? '#FFFFFF' }};
            --gallery-primary: {{ $professional->templateSetting->gallery_primary_color ?? '#EC4899' }};
            --gallery-bg: {{ $professional->templateSetting->gallery_background_color ?? '#F9FAFB' }};
            --booking-primary: {{ $professional->templateSetting->booking_primary_color ?? '#7C3AED' }};
            --booking-bg: {{ $professional->templateSetting->booking_background_color ?? '#F3F4F6' }};
        }
        
        body {
            background: var(--background);
            color: var(--text);
        }
        
        /* Animações */
        @keyframes float-y {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }
        
        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 var(--brand-light); }
            70% { box-shadow: 0 0 0 20px transparent; }
            100% { box-shadow: 0 0 0 0 transparent; }
        }
        
        /* Cards com efeito glassmorphism */
        .clinic-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .clinic-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 60px rgba(31, 38, 135, 0.15);
            border-color: var(--brand);
        }
        
        /* Gradiente de fundo */
        .clinic-hero {
            background: 
                radial-gradient(ellipse at top right, rgba(59, 130, 246, 0.12) 0%, transparent 50%),
                radial-gradient(ellipse at bottom left, rgba(34, 197, 94, 0.08) 0%, transparent 50%),
                linear-gradient(to bottom, #ffffff 0%, #f9fafb 100%);
        }
        
        /* Ícones com animação */
        .icon-float {
            animation: float-y 3s ease-in-out infinite;
        }
        
        /* Botão com efeito */
        .btn-clinic {
            background: linear-gradient(135deg, var(--brand) 0%, var(--accent) 100%);
            box-shadow: 0 4px 15px var(--brand-light);
            transition: all 0.3s;
            @if($professional->templateSetting->button_style == 'square')
                border-radius: 0;
            @elseif($professional->templateSetting->button_style == 'pill')
                border-radius: 9999px;
            @else
                border-radius: 0.75rem;
            @endif
        }
        
        .btn-clinic:hover {
            box-shadow: 0 8px 25px var(--brand-light);
            transform: translateY(-2px);
        }
        
        /* Service cards */
        .service-card-clinic {
            position: relative;
            overflow: hidden;
        }
        
        .service-card-clinic::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--brand), transparent);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s;
        }
        
        .service-card-clinic:hover::before {
            transform: scaleX(1);
        }
        
        /* Trust badges */
        .trust-badge {
            background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(249,250,251,0.9) 100%);
            border: 2px solid rgba(59, 130, 246, 0.1);
            transition: all 0.3s;
        }
        
        .trust-badge:hover {
            border-color: var(--brand);
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>
<body class="antialiased">
    
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100 shadow-sm">
      
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16 sm:h-20">
              
                <div class="flex items-center gap-3 sm:gap-4">
                    @if($professional->logo)
                        <img src="{{ asset('storage/' . $professional->logo) }}" alt="Logo" class="w-10 h-10 sm:w-14 sm:h-14 rounded-xl object-cover shadow-md">
                    @else
                        <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-xl grid place-content-center font-bold text-lg sm:text-xl text-white shadow-lg" style="background: linear-gradient(135deg, var(--brand) 0%, #2563EB 100%);">
                            {{ substr($professional->business_name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h1 class="font-bold text-lg sm:text-xl text-gray-900">{{ $professional->business_name }}</h1>
                        @if($professional->phone)
                            <a href="tel:{{ $professional->phone }}" class="text-xs sm:text-sm text-gray-600 hover:text-[var(--brand)] transition-colors flex items-center gap-1">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ $professional->phone }}
                            </a>
                        @endif
                    </div>
                </div>
                
                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="#inicio" class="text-gray-700 hover:text-[var(--brand)] font-semibold transition nav-link active">Início</a>
                    <a href="#servicos" class="text-gray-700 hover:text-[var(--brand)] font-semibold transition nav-link">Serviços</a>
                    <a href="#galeria" class="text-gray-700 hover:text-[var(--brand)] font-semibold transition nav-link">Galeria</a>
                    {{-- <a href="{{ route('blog.index', $professional->slug) }}" class="text-gray-700 hover:text-[var(--brand)] font-semibold transition nav-link">Blog</a> --}}
                    <a href="#agendar" class="text-gray-700 hover:text-[var(--brand)] font-semibold transition nav-link">Agendar</a>
                </nav>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg text-gray-700 hover:text-[var(--brand)] hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white/95 backdrop-blur-md">
                <nav class="py-4 space-y-2">
                    <a href="#inicio" class="block px-4 py-3 text-gray-700 hover:text-[var(--brand)] hover:bg-gray-50 font-semibold transition nav-link active">Início</a>
                    <a href="#servicos" class="block px-4 py-3 text-gray-700 hover:text-[var(--brand)] hover:bg-gray-50 font-semibold transition nav-link">Serviços</a>
                    <a href="#galeria" class="block px-4 py-3 text-gray-700 hover:text-[var(--brand)] hover:bg-gray-50 font-semibold transition nav-link">Galeria</a>
                    <a href="{{ route('blog.index', $professional->slug) }}" class="block px-4 py-3 text-gray-700 hover:text-[var(--brand)] hover:bg-gray-50 font-semibold transition nav-link">Blog</a>
                    <a href="#agendar" class="block px-4 py-3 text-gray-700 hover:text-[var(--brand)] hover:bg-gray-50 font-semibold transition nav-link">Agendar</a>
                </nav>
            </div>
        </div>
    </header>
    
    <!-- Hero -->
    <section id="inicio" class="py-12 lg:py-24 xl:py-32" style="background: var(--hero-bg, #FAFBFC)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-16 items-center">
                <div>
                    @if($professional->templateSetting->show_hero_badge && $professional->templateSetting->hero_badge)
                        <div class="inline-flex items-center px-3 lg:px-4 py-1.5 lg:py-2 rounded-full text-xs lg:text-sm font-semibold mb-4 lg:mb-6" style="background: var(--hero-primary, #8B5CF6)20; color: var(--hero-primary, #8B5CF6); border: 1px solid var(--hero-primary, #8B5CF6)40">
                            <svg class="w-3 h-3 lg:w-4 lg:h-4 mr-1 lg:mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            {{ $professional->templateSetting->hero_badge }}
                        </div>
                    @endif
                    <h2 class="text-3xl lg:text-5xl xl:text-6xl font-extrabold text-gray-900 mb-4 lg:mb-6 leading-tight">
                        {{ $professional->templateSetting->hero_title ?? $professional->business_name }}
                    </h2>
                    @if($professional->templateSetting->hero_subtitle)
                        <p class="text-lg lg:text-xl text-gray-600 mb-6 lg:mb-8 leading-relaxed">{{ $professional->templateSetting->hero_subtitle }}</p>
                    @elseif($professional->bio)
                        <p class="text-lg lg:text-xl text-gray-600 mb-6 lg:mb-8 leading-relaxed">{{ $professional->bio }}</p>
                    @else
                        <p class="text-lg lg:text-xl text-gray-600 mb-6 lg:mb-8 leading-relaxed">Cuidado profissional e atendimento de excelência para sua saúde e bem-estar.</p>
                    @endif
                    <div class="flex flex-wrap gap-3 lg:gap-4">
                        <a href="#agendar" class="inline-flex items-center px-6 lg:px-8 py-3 lg:py-4 rounded-lg lg:rounded-xl text-white font-bold text-base lg:text-lg shadow-lg hover:shadow-xl transition-all hover:scale-105" style="background: linear-gradient(135deg, var(--hero-primary, #8B5CF6) 0%, var(--accent, #7C3AED) 100%)">
                            Agendar Consulta
                            <svg class="w-4 h-4 lg:w-5 lg:h-5 ml-1 lg:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="#servicos" class="inline-flex items-center px-6 lg:px-8 py-3 lg:py-4 rounded-lg lg:rounded-xl bg-white border-2 border-gray-200 text-gray-700 font-bold text-base lg:text-lg hover:border-[var(--brand)] hover:text-[var(--brand)] transition-all">
                            Nossos Serviços
                        </a>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-3 lg:gap-6">
                    <div class="trust-badge rounded-xl lg:rounded-2xl p-4 lg:p-6 text-center">
                        <div class="w-12 h-12 lg:w-16 lg:h-16 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-3 lg:mb-4 icon-float">
                            <svg class="w-6 h-6 lg:w-8 lg:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-1 lg:mb-2 text-sm lg:text-base">Segurança</h4>
                        <p class="text-xs lg:text-sm text-gray-600">Protocolos rigorosos</p>
                    </div>
                    
                    <div class="trust-badge rounded-xl lg:rounded-2xl p-4 lg:p-6 text-center" style="margin-top: 1rem;">
                        <div class="w-12 h-12 lg:w-16 lg:h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-3 lg:mb-4 icon-float" style="animation-delay: 0.2s;">
                            <svg class="w-6 h-6 lg:w-8 lg:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-1 lg:mb-2 text-sm lg:text-base">Qualidade</h4>
                        <p class="text-xs lg:text-sm text-gray-600">Excelência garantida</p>
                    </div>
                    
                    <div class="trust-badge rounded-xl lg:rounded-2xl p-4 lg:p-6 text-center">
                        <div class="w-12 h-12 lg:w-16 lg:h-16 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-3 lg:mb-4 icon-float" style="animation-delay: 0.4s;">
                            <svg class="w-6 h-6 lg:w-8 lg:h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-1 lg:mb-2 text-sm lg:text-base">Equipe</h4>
                        <p class="text-xs lg:text-sm text-gray-600">Profissionais experientes</p>
                    </div>
                    
                    <div class="trust-badge rounded-xl lg:rounded-2xl p-4 lg:p-6 text-center" style="margin-top: 1rem;">
                        <div class="w-12 h-12 lg:w-16 lg:h-16 rounded-full bg-orange-100 flex items-center justify-center mx-auto mb-3 lg:mb-4 icon-float" style="animation-delay: 0.6s;">
                            <svg class="w-6 h-6 lg:w-8 lg:h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-1 lg:mb-2 text-sm lg:text-base">Pontualidade</h4>
                        <p class="text-xs lg:text-sm text-gray-600">Respeito ao seu tempo</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Serviços -->
    <section id="servicos" class="py-12 lg:py-24" style="background: var(--services-bg, #FFFFFF)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 lg:mb-16">
                <div class="inline-flex items-center px-3 lg:px-4 py-1.5 lg:py-2 rounded-full bg-blue-50 text-xs lg:text-sm font-semibold text-blue-600 mb-3 lg:mb-4">
                    O que oferecemos
                </div>
                <h3 class="text-3xl lg:text-4xl xl:text-5xl font-extrabold text-gray-900 mb-3 lg:mb-4">
                    {{ $professional->templateSetting->services_title ?? 'Nossos Serviços' }}
                </h3>
                <p class="text-lg lg:text-xl text-gray-600 max-w-2xl mx-auto">
                    {{ $professional->templateSetting->services_subtitle ?? 'Atendimento especializado com foco no seu bem-estar' }}
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @forelse($services as $service)
                    <div class="clinic-card service-card-clinic rounded-xl lg:rounded-2xl p-6 lg:p-8">
                        <div class="w-12 h-12 lg:w-14 lg:h-14 rounded-lg lg:rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center mb-4 lg:mb-6">
                            <svg class="w-6 h-6 lg:w-7 lg:h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h4 class="text-xl lg:text-2xl font-bold text-gray-900 mb-2 lg:mb-3">{{ $service->name }}</h4>
                        <p class="text-gray-600 mb-4 lg:mb-6 leading-relaxed text-sm lg:text-base">{{ $service->description }}</p>
                        <div class="flex items-center justify-between mb-4 lg:mb-6 pb-4 lg:pb-6 border-b border-gray-100">
                            <div class="flex items-center text-gray-500">
                                <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-1 lg:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="font-semibold text-sm lg:text-base">{{ $service->duration }} min</span>
                            </div>
                            <div class="text-xl lg:text-2xl font-extrabold text-[var(--brand)]">
                                R$ {{ number_format($service->price, 2, ',', '.') }}
                            </div>
                        </div>
                        <a href="#agendar" onclick="selectService({{ $service->id }})" class="block w-full text-center px-4 lg:px-6 py-2.5 lg:py-3 rounded-lg lg:rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 text-white font-bold hover:from-blue-700 hover:to-blue-600 transition-all shadow-lg hover:shadow-xl text-sm lg:text-base">
                            Agendar Agora
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8 lg:py-12">
                        <p class="text-gray-500 text-base lg:text-lg">Nenhum serviço disponível no momento.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Galeria -->
    @include('public.sections.gallery', ['gallery' => $gallery])
    @if($isPlan && !$isPlanOver)
        @include('public.sections.booking', ['services' => $services, 'professional' => $professional, 'employees' => $employees])
    @endif
    @include('public.sections.feedbacks', ['feedbacks' => $feedbacks])
    @include('public.sections.contact', ['professional' => $professional])
    @include('public.sections.footer', ['professional' => $professional])
    
    <!-- Gallery Modal -->
    <div id="gallery-modal" class="hidden fixed inset-0 bg-black/95 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="relative max-w-6xl w-full max-h-[90vh] flex flex-col">
            <!-- Close Button -->
            <button id="gallery-close-btn" class="absolute -top-12 right-0 text-white text-4xl hover:text-gray-300 transition-colors font-light z-10">&times;</button>
            
            <!-- Modal Content -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-full">
                <!-- Image Container -->
                <div class="flex-1 flex items-center justify-center bg-gray-50 p-8">
                    <img id="gallery-modal-img" src="" alt="" class="max-w-full max-h-[60vh] object-contain rounded-lg shadow-lg">
                </div>
                
                <!-- Content -->
                <div class="p-8 bg-white border-t border-gray-100">
                    <div class="text-center">
                        <h4 id="gallery-modal-title" class="text-3xl font-bold text-gray-900 mb-3"></h4>
                        <p id="gallery-modal-description" class="text-gray-600 text-lg leading-relaxed"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('public.sections.scripts', ['professional' => $professional])
    
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileMenu) {
                mobileMenu.classList.toggle('hidden');
            }
        });

        // Close mobile menu when clicking on a link
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', function() {
                const mobileMenu = document.getElementById('mobile-menu');
                if (mobileMenu) {
                    mobileMenu.classList.add('hidden');
                }
            });
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            
            if (mobileMenu && !mobileMenu.contains(event.target) && !mobileMenuBtn?.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
