<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $professional->business_name }} — {{ $professional->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            /* Cores globais */
            --brand: {{ $professional->templateSetting->primary_color ?? $professional->brand_color ?? '#8B5CF6' }};
            --brand-light: {{ $professional->templateSetting->secondary_color ?? '#A78BFA' }};
            --brand-dark: {{ $professional->templateSetting->accent_color ?? '#7C3AED' }};
            --brand-glow: {{ $professional->templateSetting->primary_color ?? $professional->brand_color ?? '#8B5CF6' }}40;
            --secondary: {{ $professional->templateSetting->secondary_color ?? '#A78BFA' }};
            --accent: {{ $professional->templateSetting->accent_color ?? '#7C3AED' }};
            --background: {{ $professional->templateSetting->background_color ?? '#0F0F10' }};
            --text: {{ $professional->templateSetting->text_color ?? '#F5F5F5' }};
            
            /* Cores por seção */
            --hero-primary: {{ $professional->templateSetting->hero_primary_color ?? $professional->templateSetting->primary_color ?? '#8B5CF6' }};
            --hero-bg: {{ $professional->templateSetting->hero_background_color ?? '#0F0F10' }};
            --services-primary: {{ $professional->templateSetting->services_primary_color ?? '#8B5CF6' }};
            --services-bg: {{ $professional->templateSetting->services_background_color ?? '#1A1520' }};
            --gallery-primary: {{ $professional->templateSetting->gallery_primary_color ?? '#8B5CF6' }};
            --gallery-bg: {{ $professional->templateSetting->gallery_background_color ?? '#0F0F10' }};
            --booking-primary: {{ $professional->templateSetting->booking_primary_color ?? '#8B5CF6' }};
            --booking-bg: {{ $professional->templateSetting->booking_background_color ?? '#1A1520' }};
            
            /* Compatibilidade com variáveis antigas */
            --bg-color: var(--background);
            --text-color: var(--text);
        }
        
        body {
            background: linear-gradient(135deg, var(--background) 0%, #1A1520 50%, var(--background) 100%);
            color: var(--text);
            font-family: 'Inter', -apple-system, sans-serif;
        }
        
        /* Textura grunge */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: 
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.3;
            pointer-events: none;
            z-index: 0;
        }
        
        .content-wrapper {
            position: relative;
            z-index: 1;
        }
        
        /* Animações */
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes glow-pulse {
            0%, 100% { 
                box-shadow: 0 0 20px rgba(139, 92, 246, 0.3);
            }
            50% { 
                box-shadow: 0 0 30px rgba(139, 92, 246, 0.5);
            }
        }
        
        /* Efeito de tinta escorrendo */
        .ink-drip {
            position: absolute;
            bottom: -10px;
            left: 0;
            right: 0;
            height: 20px;
            background: linear-gradient(180deg, var(--brand) 0%, transparent 100%);
            opacity: 0.3;
            filter: url(#drip);
        }
        
        /* Cards com estilo urbano */
        .tattoo-card {
            background: linear-gradient(145deg, #1a1a1a 0%, #0f0f0f 100%);
            border: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .tattoo-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.03), transparent);
            transition: left 0.5s;
        }
        
        .tattoo-card:hover {
            border-color: var(--brand);
            box-shadow: 
                0 0 30px var(--brand-glow),
                0 20px 60px rgba(0, 0, 0, 0.7);
            transform: translateY(-10px) scale(1.02);
        }
        
        .tattoo-card:hover::before {
            left: 100%;
        }
        
        /* Botão estilo urbano */
        .btn-tattoo {
            background: var(--brand);
            color: white;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 3px;
            padding: 1.25rem 3rem;
            position: relative;
            overflow: hidden;
            clip-path: polygon(0 0, calc(100% - 15px) 0, 100% 15px, 100% 100%, 15px 100%, 0 calc(100% - 15px));
            transition: all 0.3s;
        }
        
        .btn-tattoo::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.3), transparent 70%);
            transform: translateX(-100%) skewX(-15deg);
            transition: transform 0.6s;
        }
        
        .btn-tattoo:hover::before {
            transform: translateX(100%) skewX(-15deg);
        }
        
        .btn-tattoo:hover {
            box-shadow: 
                0 0 30px var(--brand-glow),
                0 10px 40px rgba(0, 0, 0, 0.6);
            transform: translateY(-3px) scale(1.02);
        }
        
        /* Título com gradiente */
        .gradient-title {
            background: linear-gradient(135deg, var(--brand-light) 0%, var(--brand) 50%, var(--brand-dark) 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-shift 4s ease infinite;
            font-weight: 900;
        }
        
        /* Título simples colorido */
        .brand-title {
            color: var(--brand);
            font-weight: 900;
        }
        
        /* Cards de serviço */
        .service-card-tattoo {
            background: linear-gradient(135deg, rgba(26, 26, 26, 0.9) 0%, rgba(15, 15, 15, 0.9) 100%);
            border: 2px solid rgba(255, 255, 255, 0.05);
            clip-path: polygon(0 0, calc(100% - 25px) 0, 100% 25px, 100% 100%, 25px 100%, 0 calc(100% - 25px));
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
        }
        
        .service-card-tattoo::after {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(45deg, var(--brand), transparent, var(--brand));
            clip-path: polygon(0 0, calc(100% - 25px) 0, 100% 25px, 100% 100%, 25px 100%, 0 calc(100% - 25px));
            opacity: 0;
            transition: opacity 0.4s;
            z-index: -1;
        }
        
        .service-card-tattoo:hover {
            transform: translateY(-12px) scale(1.03);
            border-color: var(--brand);
            box-shadow: 
                0 0 40px var(--brand-glow),
                0 25px 70px rgba(0, 0, 0, 0.8);
        }
        
        .service-card-tattoo:hover::after {
            opacity: 1;
        }
        
        /* Galeria com efeito */
        .gallery-tattoo {
            position: relative;
            overflow: hidden;
            clip-path: polygon(20px 0, 100% 0, 100% calc(100% - 20px), calc(100% - 20px) 100%, 0 100%, 0 20px);
        }
        
        .gallery-tattoo::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--brand) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.4s;
            z-index: 10;
        }
        
        .gallery-tattoo:hover::before {
            opacity: 0.5;
        }
        
        .gallery-tattoo img {
            transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        
        .gallery-tattoo:hover img {
            transform: scale(1.15) rotate(2deg);
        }
        
        /* Divisor estilizado */
        .tattoo-divider {
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--brand), transparent);
            position: relative;
            margin: 3rem 0;
        }
        
        .tattoo-divider::before {
            content: '⚡';
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background: #0a0a0a;
            padding: 0 1.5rem;
            font-size: 2rem;
            color: var(--brand);
            animation: neon-pulse 2s ease-in-out infinite;
        }
        
        /* Header fixo estilizado */
        .tattoo-header {
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        }
        
        /* Link de navegação */
        .nav-link-tattoo {
            position: relative;
            padding-bottom: 5px;
        }
        
        .nav-link-tattoo::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--brand);
            transition: width 0.3s;
            box-shadow: 0 0 10px var(--brand);
        }
        
        .nav-link-tattoo:hover::after,
        .nav-link-tattoo.active::after {
            width: 100%;
        }
    </style>
</head>
<body>
    @php $isDemo = $isDemo ?? true; @endphp
    @if($isDemo)
        <div class="fixed top-0 left-0 right-0 z-50">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mt-3 flex justify-center">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/></svg>
                        Versão de Demonstração
                    </span>
                </div>
            </div>
        </div>
        <div class="h-10"></div>
    @endif
    <div class="content-wrapper">
        <!-- SVG Filter para efeito de tinta -->
        <svg width="0" height="0" style="position: absolute;">
            <defs>
                <filter id="drip" x="-50%" y="-50%" width="200%" height="200%">
                    <feTurbulence type="fractalNoise" baseFrequency="0.01" numOctaves="2" result="noise"/>
                    <feDisplacementMap in="SourceGraphic" in2="noise" scale="8" />
                </filter>
            </defs>
        </svg>

        <!-- Header -->
        <header class="tattoo-header sticky top-0 z-50">
            @if(($isDemo ?? true))
            <div class="absolute top-2 left-3 sm:top-6 sm:left-3">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs sm:text-sm font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/></svg>
                    Versão de Demonstração
                </span>
            </div>
        @endif
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative flex items-center justify-between h-24">
                  
                    <div class="flex items-center gap-5">
                        @if($professional->logo)
                            <img src="{{ asset('storage/' . $professional->logo) }}" alt="Logo" class="w-16 h-16 object-cover" style="clip-path: polygon(15px 0, 100% 0, 100% calc(100% - 15px), calc(100% - 15px) 100%, 0 100%, 0 15px); filter: drop-shadow(0 0 10px var(--brand));">
                        @else
                            <div class="w-16 h-16 grid place-content-center font-black text-3xl text-white bg-[var(--brand)] relative" style="clip-path: polygon(15px 0, 100% 0, 100% calc(100% - 15px), calc(100% - 15px) 100%, 0 100%, 0 15px); box-shadow: 0 0 20px var(--brand);">
                                {{ substr($professional->business_name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h1 class="font-black text-2xl uppercase tracking-widest text-white">
                                {{ $professional->business_name }}
                            </h1>
                            @if($professional->phone)
                                <a href="tel:{{ $professional->phone }}" class="text-sm text-gray-400 hover:text-[var(--brand)] transition-colors flex items-center gap-2 mt-1">
                                    <span>📞</span> {{ $professional->phone }}
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    <nav class="hidden md:flex items-center gap-10">
                        <a href="#inicio" class="nav-link-tattoo text-gray-300 hover:text-white font-bold uppercase text-sm tracking-widest transition active">Início</a>
                        <a href="#servicos" class="nav-link-tattoo text-gray-300 hover:text-white font-bold uppercase text-sm tracking-widest transition">Trabalhos</a>
                        <a href="#galeria" class="nav-link-tattoo text-gray-300 hover:text-white font-bold uppercase text-sm tracking-widest transition">Portfolio</a>
                        <a href="{{ route('blog.index', $professional->slug) }}" class="nav-link-tattoo text-gray-300 hover:text-white font-bold uppercase text-sm tracking-widest transition">Blog</a>
                        <a href="#agendar" class="nav-link-tattoo text-gray-300 hover:text-white font-bold uppercase text-sm tracking-widest transition">Agendar</a>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Hero -->
        <section id="inicio" class="min-h-screen flex items-center relative overflow-hidden" style="background: linear-gradient(135deg, #0a0a0a 0%, #1a0a0a 50%, #0a0a0a 100%);">
            <!-- Efeitos de fundo -->
            <div class="absolute inset-0 opacity-20">
                <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-[var(--brand)] rounded-full filter blur-3xl animate-pulse" style="animation-duration: 4s;"></div>
                <div class="absolute bottom-1/3 right-1/3 w-96 h-96 bg-red-900 rounded-full filter blur-3xl" style="animation: float 6s ease-in-out infinite;"></div>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 relative z-10">
                <div class="grid lg:grid-cols-2 gap-20 items-center">
                    <div style="animation: slide-up 0.8s ease-out;">
                        @if($settings->show_hero_badge && ($settings->hero_badge || true))
                        <div class="inline-flex items-center gap-3 px-8 py-3 bg-white/5 border border-[var(--brand)]/30 mb-10 backdrop-blur-sm" style="clip-path: polygon(10px 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%, 0 10px);">
                            <span class="text-3xl">🎨</span>
                            <span class="text-white font-black uppercase tracking-widest text-sm">{{ $settings->hero_badge ?? 'Arte & Identidade' }}</span>
                        </div>
                        @endif
                        
                        <h2 class="text-7xl lg:text-8xl font-black mb-6 leading-none uppercase">
                            <span class="block text-white">{{ $settings->hero_title ?? 'INK' }}</span>
                            <span class="block gradient-title">
                                {{ $professional->business_name }}
                            </span>
                        </h2>
                        
                        @if($settings->show_dividers)
                        <div class="tattoo-divider"></div>
                        @endif
                        
                        @if($settings->hero_subtitle)
                            <p class="text-2xl text-gray-300 mb-12 leading-relaxed">
                                {{ $settings->hero_subtitle }}
                            </p>
                        @elseif($professional->bio)
                            <p class="text-2xl text-gray-300 mb-12 leading-relaxed">
                                {{ $professional->bio }}
                            </p>
                        @else
                            <p class="text-2xl text-gray-300 mb-12 leading-relaxed">
                                Transformamos sua história em arte permanente. Cada traço é único, cada tattoo é uma obra.
                            </p>
                        @endif
                        
                        <div class="flex flex-wrap gap-8">
                            <a href="#agendar" class="btn-tattoo inline-block">Agendar Sessão</a>
                            <a href="#galeria" class="px-10 py-5 border-2 border-white/20 font-black text-white hover:bg-white/10 hover:border-[var(--brand)] transition-all uppercase tracking-widest backdrop-blur-sm">
                                Ver Portfolio
                            </a>
                        </div>
                    </div>
                    
                    <div class="tattoo-card p-12 rounded-2xl" style="animation: slide-up 1s ease-out;">
                        <h3 class="text-4xl font-black uppercase mb-8 tracking-wider flex items-center gap-4" style="color: #FFFFFF;">
                            <span class="text-5xl brand-title">⚡</span>
                            Nossa Essência
                        </h3>
                        
                        <div class="space-y-8">
                            <div class="flex items-start gap-5 p-6 bg-gradient-to-r from-[var(--brand)]/10 to-transparent border-l-4 border-[var(--brand)] hover:bg-[var(--brand)]/5 transition-all rounded-xl">
                                <div class="text-5xl">🎨</div>
                                <div>
                                    <h4 class="font-black text-xl mb-3 uppercase tracking-wide brand-title">Arte 100% Exclusiva</h4>
                                    <p class="leading-relaxed" style="color: #D1D5DB;">Cada tattoo é desenhada especialmente para você. Sua história merece ser única.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-5 p-6 bg-gradient-to-r from-[var(--brand)]/10 to-transparent border-l-4 border-[var(--brand)] hover:bg-[var(--brand)]/5 transition-all rounded-xl">
                                <div class="text-5xl">🛡️</div>
                                <div>
                                    <h4 class="font-black text-xl mb-3 uppercase tracking-wide brand-title">Máxima Segurança</h4>
                                    <p class="leading-relaxed" style="color: #D1D5DB;">Equipamentos descartáveis, ambiente esterilizado e todos os protocolos de saúde.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-5 p-6 bg-gradient-to-r from-[var(--brand)]/10 to-transparent border-l-4 border-[var(--brand)] hover:bg-[var(--brand)]/5 transition-all rounded-xl">
                                <div class="text-5xl">⭐</div>
                                <div>
                                    <h4 class="font-black text-xl mb-3 uppercase tracking-wide brand-title">Artistas Renomados</h4>
                                    <p class="leading-relaxed" style="color: #D1D5DB;">Anos de experiência e paixão pela arte corporal em cada projeto.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="ink-drip"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Serviços -->
        <section id="servicos" class="py-32 relative" style="background: var(--services-bg, #1A1520)">
            <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,%3Csvg width=\'100\' height=\'100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M0 0L50 50L100 0\' stroke=\'%23fff\' fill=\'none\'/%3E%3C/svg%3E'); background-size: 100px 100px;"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-20">
                    <span class="inline-flex items-center gap-3 px-8 py-3 bg-[var(--brand)]/10 border border-[var(--brand)]/30 font-black uppercase tracking-widest text-sm mb-8 backdrop-blur-sm" style="clip-path: polygon(10px 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%, 0 10px); color: var(--brand);">
                        <span class="text-2xl">⚡</span>
                        Nossos Trabalhos
                    </span>
                    <h3 class="text-6xl lg:text-7xl font-black mb-6 uppercase">
                        <span style="color: #FFFFFF;">Estilos &</span>
                        <span class="gradient-title block">Serviços</span>
                    </h3>
                    <p class="text-xl max-w-2xl mx-auto" style="color: #D1D5DB;">Do realismo ao old school, do minimalista ao tribal. Sua visão, nossa arte.</p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
                    @forelse($services as $service)
                        <div class="service-card-tattoo p-10 group">
                            <div class="text-7xl mb-8 group-hover:scale-125 transition-transform duration-500 text-center" style="filter: drop-shadow(0 0 10px var(--brand));">🖤</div>
                            <h4 class="text-3xl font-black mb-5 uppercase text-center tracking-wider" style="color: #FFFFFF;">{{ $service->name }}</h4>
                            <p class="mb-8 leading-relaxed text-center text-lg" style="color: #D1D5DB;">{{ $service->description }}</p>
                            
                            <div class="flex items-center justify-between mb-8 pb-6 border-b border-white/10" style="color: #E5E7EB;">
                                <span class="font-bold flex items-center gap-2">
                                    <span class="text-2xl">⏱</span>
                                    <span>{{ $service->duration }} min</span>
                                </span>
                                <span class="text-3xl font-black neon-title">R$ {{ number_format($service->price, 2, ',', '.') }}</span>
                            </div>
                            
                            <a href="#agendar" onclick="selectService({{ $service->id }})" class="block w-full text-center px-8 py-4 bg-[var(--brand)] text-white font-black uppercase tracking-widest hover:shadow-2xl transition-all" style="clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));">
                                Agendar Agora
                            </a>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-16">
                            <p class="text-gray-500 text-xl">Nenhum serviço disponível no momento.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Galeria -->
        <section id="galeria" class="py-32" style="background: var(--gallery-bg, #0F0F10)">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-20">
                    <span class="inline-flex items-center gap-3 px-8 py-3 bg-[var(--brand)]/10 border border-[var(--brand)]/30 text-[var(--brand)] font-black uppercase tracking-widest text-sm mb-8 backdrop-blur-sm" style="clip-path: polygon(10px 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%, 0 10px);">
                        <span class="text-2xl">📸</span>
                        Portfolio
                    </span>
                    <h3 class="text-6xl lg:text-7xl font-black mb-6 uppercase">
                        <span class="neon-title">Nossos</span>
                        <span class="text-white block">Trabalhos</span>
                    </h3>
                    <p class="text-gray-400 text-xl max-w-2xl mx-auto">Confira algumas das artes que já marcaram história na pele de nossos clientes.</p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                    @forelse($gallery as $photo)
                        <div class="gallery-tattoo gallery-item group cursor-pointer relative">
                            <img src="{{ $photo->image_path }}" alt="{{ $photo->title }}" class="w-full h-96 object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end p-8 z-20">
                                <div class="text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                    <h5 class="font-black text-2xl uppercase mb-3 neon-title">{{ $photo->title }}</h5>
                                    @if($photo->description)
                                        <p class="text-sm text-gray-300 leading-relaxed">{{ $photo->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="absolute top-4 right-4 bg-[var(--brand)] text-white px-4 py-2 font-black text-xs uppercase tracking-wider opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20" style="clip-path: polygon(5px 0, 100% 0, 100% calc(100% - 5px), calc(100% - 5px) 100%, 0 100%, 0 5px);">
                                Ver Maior
                            </div>
                        </div>
                    @empty
                        @for($i = 1; $i <= 6; $i++)
                            <div class="gallery-tattoo gallery-item group cursor-pointer relative">
                                <img src="https://picsum.photos/400/500?random={{ $i }}" alt="Trabalho {{ $i }}" class="w-full h-96 object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end p-8 z-20">
                                    <div class="text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                        <h5 class="font-black text-2xl uppercase mb-3 neon-title">Arte #{{ $i }}</h5>
                                        <p class="text-sm text-gray-300">Trabalho exclusivo do estúdio</p>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    @endforelse
                </div>
            </div>
        </section>

        @include('public.sections.booking', ['services' => $services, 'professional' => $professional])
        @include('public.sections.feedbacks', ['feedbacks' => $feedbacks])
        @include('public.sections.contact', ['professional' => $professional])
        @include('public.sections.footer', ['professional' => $professional])
    </div>
    
    <!-- Gallery Modal -->
    <div id="gallery-modal" class="hidden fixed inset-0 bg-black/95 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="relative max-w-6xl w-full max-h-[90vh] flex flex-col">
            <!-- Close Button -->
            <button id="gallery-close-btn" class="absolute -top-12 right-0 text-white text-4xl hover:text-[var(--brand)] transition-colors font-light z-10" style="text-shadow: 0 0 10px var(--brand);">&times;</button>
            
            <!-- Modal Content -->
            <div class="bg-gradient-to-b from-[#1a1a1a] to-[#0a0a0a] rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-full border-2 border-[var(--brand)]/30" style="clip-path: polygon(30px 0, 100% 0, 100% calc(100% - 30px), calc(100% - 30px) 100%, 0 100%, 0 30px);">
                <!-- Image Container -->
                <div class="flex-1 flex items-center justify-center bg-gray-900 p-8">
                    <img id="gallery-modal-img" src="" alt="" class="max-w-full max-h-[60vh] object-contain rounded-lg shadow-2xl">
                </div>
                
                <!-- Content -->
                <div class="p-8 bg-gradient-to-b from-[#1a1a1a] to-[#0a0a0a] border-t border-[var(--brand)]/20">
                    <div class="text-center">
                        <h4 id="gallery-modal-title" class="text-3xl font-black mb-3 neon-title uppercase tracking-wider"></h4>
                        <p id="gallery-modal-description" class="text-gray-300 text-lg leading-relaxed"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('public.sections.scripts', ['professional' => $professional])
    
    <script>
        // Scroll suave para links de navegação
        document.querySelectorAll('.nav-link-tattoo').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    
                    // Atualizar link ativo
                    document.querySelectorAll('.nav-link-tattoo').forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
