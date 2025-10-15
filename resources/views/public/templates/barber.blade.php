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
            --brand: {{ $professional->templateSetting->primary_color ?? $professional->brand_color ?? '#C9A050' }};
            --brand-light: {{ $professional->templateSetting->primary_color ?? $professional->brand_color ?? '#C9A050' }}40;
            --brand-dark: {{ $professional->templateSetting->primary_color ?? $professional->brand_color ?? '#C9A050' }}CC;
            --secondary: {{ $professional->templateSetting->secondary_color ?? '#E5C576' }};
            --accent: {{ $professional->templateSetting->accent_color ?? '#C9A050' }};
            --background: {{ $professional->templateSetting->background_color ?? '#0F0F10' }};
            --text: {{ $professional->templateSetting->text_color ?? '#F8F8F8' }};
            
            /* Cores por seção */
            --hero-primary: {{ $professional->templateSetting->hero_primary_color ?? $professional->templateSetting->primary_color ?? '#C9A050' }};
            --hero-bg: {{ $professional->templateSetting->hero_background_color ?? '#0F0F10' }};
            --services-primary: {{ $professional->templateSetting->services_primary_color ?? '#C9A050' }};
            --services-bg: {{ $professional->templateSetting->services_background_color ?? '#1A1A1D' }};
            --gallery-primary: {{ $professional->templateSetting->gallery_primary_color ?? '#C9A050' }};
            --gallery-bg: {{ $professional->templateSetting->gallery_background_color ?? '#0F0F10' }};
            --booking-primary: {{ $professional->templateSetting->booking_primary_color ?? '#C9A050' }};
            --booking-bg: {{ $professional->templateSetting->booking_background_color ?? '#1A1A1D' }};
            
            /* Cores específicas do template barber */
            --dark: #1A1A1D;
            --darker: #0F0F10;
            --light: #F8F8F8;
        }
        
        body {
            background: linear-gradient(135deg, var(--background) 0%, var(--dark) 50%, var(--background) 100%);
            color: var(--text);
            font-family: 'Inter', -apple-system, sans-serif;
        }
        
        /* Textura sutil */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(201, 160, 80, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(201, 160, 80, 0.03) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }
        
        .wrapper {
            position: relative;
            z-index: 1;
        }
        
        /* Animações modernas */
        @keyframes shine {
            0%, 100% { 
                text-shadow: 0 0 20px rgba(201, 160, 80, 0.3);
            }
            50% { 
                text-shadow: 0 0 30px rgba(201, 160, 80, 0.6), 0 0 50px rgba(201, 160, 80, 0.3);
            }
        }
        
        @keyframes float-gentle {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }
        
        @keyframes fade-slide {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        /* Cards modernos */
        .modern-card {
            background: linear-gradient(135deg, rgba(26, 26, 29, 0.9) 0%, rgba(15, 15, 16, 0.9) 100%);
            border: 1px solid rgba(201, 160, 80, 0.15);
            backdrop-filter: blur(20px);
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.05);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            overflow: hidden;
        }
        
        .modern-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(201, 160, 80, 0.05), transparent);
            transition: left 0.6s;
        }
        
        .modern-card:hover {
            border-color: var(--brand);
            box-shadow: 
                0 0 40px rgba(201, 160, 80, 0.25),
                0 30px 80px rgba(0, 0, 0, 0.6);
            transform: translateY(-10px);
        }
        
        .modern-card:hover::before {
            left: 100%;
        }
        
        /* Botões modernos */
        .btn-modern {
            background: linear-gradient(135deg, var(--brand-light) 0%, var(--brand) 100%);
            color: #0F0F10;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            position: relative;
            overflow: hidden;
            box-shadow: 
                0 10px 30px rgba(201, 160, 80, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            transition: all 0.3s;
        }
        
        .btn-modern::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.5s, height 0.5s;
        }
        
        .btn-modern:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .btn-modern:hover {
            box-shadow: 
                0 15px 40px rgba(201, 160, 80, 0.5),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
        }
        
        /* Título gradiente */
        .gradient-title {
            background: linear-gradient(135deg, #FFFFFF 0%, var(--brand-light) 30%, var(--brand) 60%, #FFFFFF 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-shift 4s ease infinite;
        }
        
        /* Header moderno */
        .modern-header {
            background: rgba(15, 15, 16, 0.95);
            backdrop-filter: blur(30px) saturate(180%);
            border-bottom: 1px solid rgba(201, 160, 80, 0.1);
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.5);
        }
        
        /* Links de navegação */
        .nav-link {
            position: relative;
            transition: all 0.3s;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--brand);
            box-shadow: 0 0 10px var(--brand);
            transition: width 0.3s;
        }
        
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
        
        /* Badge moderno */
        .modern-badge {
            background: linear-gradient(135deg, rgba(201, 160, 80, 0.15) 0%, rgba(201, 160, 80, 0.05) 100%);
            border: 1px solid rgba(201, 160, 80, 0.3);
            color: var(--brand-light);
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: 0.75rem;
            backdrop-filter: blur(10px);
        }
        
        /* Serviço card */
        .service-card {
            background: linear-gradient(135deg, rgba(26, 26, 29, 0.95) 0%, rgba(15, 15, 16, 0.95) 100%);
            border: 1px solid rgba(201, 160, 80, 0.1);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
        }
        
        .service-card::before {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(135deg, var(--brand), transparent, var(--brand));
            border-radius: 22px;
            opacity: 0;
            transition: opacity 0.4s;
            z-index: -1;
        }
        
        .service-card:hover {
            transform: translateY(-12px) scale(1.02);
            border-color: var(--brand);
            box-shadow: 
                0 0 50px rgba(201, 160, 80, 0.3),
                0 30px 80px rgba(0, 0, 0, 0.7);
        }
        
        .service-card:hover::before {
            opacity: 1;
        }
        
        /* Galeria moderna */
        .gallery-item-modern {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            border: 1px solid rgba(201, 160, 80, 0.2);
            transition: all 0.5s;
        }
        
        .gallery-item-modern::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--brand) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.4s;
            z-index: 10;
        }
        
        .gallery-item-modern:hover {
            border-color: var(--brand);
            box-shadow: 0 0 40px rgba(201, 160, 80, 0.4);
            transform: scale(1.05);
        }
        
        .gallery-item-modern:hover::before {
            opacity: 0.3;
        }
        
        .gallery-item-modern img {
            transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        
        .gallery-item-modern:hover img {
            transform: scale(1.15);
        }
        
        /* Divisor elegante */
        .elegant-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--brand), transparent);
            position: relative;
            margin: 2rem 0;
        }
        
        .elegant-divider::before {
            content: '◆';
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background: var(--darker);
            padding: 0 1rem;
            color: var(--brand);
            font-size: 1.25rem;
        }
        
        /* Ícone de qualidade */
        .quality-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--brand-light) 0%, var(--brand) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            box-shadow: 
                0 10px 30px rgba(201, 160, 80, 0.3),
                inset 0 2px 0 rgba(255, 255, 255, 0.2);
            transition: all 0.4s;
        }
        
        .quality-icon:hover {
            transform: rotateY(180deg) scale(1.1);
            box-shadow: 0 15px 40px rgba(201, 160, 80, 0.5);
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <!-- Header -->
        <header class="modern-header sticky top-0 z-50">
           
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative flex items-center justify-between h-16 lg:h-20">
                    @if(($isDemo ?? true))
                        <div class="absolute top-1 right-1 sm:top-2 sm:right-2 lg:top-3 lg:right-3">
                            <span class="inline-flex items-center gap-1 lg:gap-2 px-2 lg:px-3 py-1 lg:py-1.5 rounded-full text-xs lg:text-sm font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200 shadow-sm">
                                <svg class="w-3 h-3 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/></svg>
                                <span class="hidden sm:inline">Versão de Demonstração</span>
                                <span class="sm:hidden">Demo</span>
                            </span>
                        </div>
                    @endif
                    <div class="flex items-center gap-2 lg:gap-4">
                        @if($professional->logo)
                            <img src="{{ asset('storage/' . $professional->logo) }}" alt="Logo" class="w-10 h-10 lg:w-14 lg:h-14 rounded-full object-cover border-2 border-[var(--brand)]" style="box-shadow: 0 0 20px rgba(201, 160, 80, 0.4);">
                        @else
                            <div class="w-10 h-10 lg:w-14 lg:h-14 rounded-full grid place-content-center font-black text-lg lg:text-xl border-2 border-[var(--brand)]" style="background: linear-gradient(135deg, var(--brand-light) 0%, var(--brand) 100%); color: var(--darker); box-shadow: 0 0 20px rgba(201, 160, 80, 0.4);">
                                {{ substr($professional->business_name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h1 class="font-black text-lg lg:text-xl uppercase tracking-wide text-white">
                                {{ $professional->business_name }}
                            </h1>
                            @if($professional->phone)
                                <a href="tel:{{ $professional->phone }}" class="text-xs lg:text-sm text-[var(--brand)] hover:text-[var(--brand-light)] transition-colors flex items-center gap-1">
                                    <span>📞</span> {{ $professional->phone }}
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Desktop Navigation -->
                    <nav class="hidden md:flex items-center gap-6 lg:gap-8">
                        <a href="#inicio" class="nav-link text-gray-300 hover:text-white font-semibold text-sm tracking-wide transition active">Início</a>
                        <a href="#servicos" class="nav-link text-gray-300 hover:text-white font-semibold text-sm tracking-wide transition">Serviços</a>
                        <a href="#galeria" class="nav-link text-gray-300 hover:text-white font-semibold text-sm tracking-wide transition">Galeria</a>
                        {{-- <a href="{{ route('blog.index', $professional->slug) }}" class="nav-link text-gray-300 hover:text-white font-semibold text-sm tracking-wide transition">Blog</a> --}}
                        <a href="#agendar" class="nav-link text-gray-300 hover:text-white font-semibold text-sm tracking-wide transition">Agendar</a>
                    </nav>

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg text-gray-300 hover:text-white hover:bg-gray-800/50 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>

                <!-- Mobile Navigation -->
                <div id="mobile-menu" class="hidden md:hidden border-t border-gray-800/50 bg-gray-900/95 backdrop-blur-md">
                    <nav class="py-4 space-y-2">
                        <a href="#inicio" class="block px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800/50 font-semibold transition nav-link active">Início</a>
                        <a href="#servicos" class="block px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800/50 font-semibold transition nav-link">Serviços</a>
                        <a href="#galeria" class="block px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800/50 font-semibold transition nav-link">Galeria</a>
                        <a href="#agendar" class="block px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-800/50 font-semibold transition nav-link">Agendar</a>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Hero -->
        <section id="inicio" class="min-h-screen flex items-center relative overflow-hidden py-12 lg:py-20" style="background: var(--hero-bg, #0F0F10)">
            <!-- Efeitos de fundo -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-1/4 right-1/4 w-64 h-64 lg:w-96 lg:h-96 bg-[var(--brand)] rounded-full filter blur-3xl" style="animation: float-gentle 8s ease-in-out infinite;"></div>
                <div class="absolute bottom-1/3 left-1/3 w-64 h-64 lg:w-96 lg:h-96 bg-[var(--brand-dark)] rounded-full filter blur-3xl" style="animation: float-gentle 10s ease-in-out infinite; animation-delay: 1s;"></div>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid lg:grid-cols-2 gap-8 lg:gap-16 items-center">
                    <div style="animation: fade-slide 0.8s ease-out;">
                        <div class="modern-badge inline-flex items-center gap-1 lg:gap-2 mb-6 lg:mb-8 text-xs lg:text-sm px-3 lg:px-4 py-1.5 lg:py-2">
                            <span class="text-lg lg:text-xl">💈</span>
                            <span>Excelência em Cada Detalhe</span>
                        </div>
                        
                        <h2 class="text-4xl lg:text-6xl xl:text-7xl font-black mb-4 lg:mb-6 leading-tight">
                            <span class="block text-white text-3xl lg:text-4xl xl:text-5xl">Bem-vindo à</span>
                            <span class="block gradient-title text-4xl lg:text-6xl xl:text-7xl 2xl:text-8xl uppercase">
                                {{ $professional->business_name }}
                            </span>
                        </h2>
                        
                        <div class="elegant-divider"></div>
                        
                        @if($professional->bio)
                            <p class="text-xl text-gray-300 mb-10 leading-relaxed">
                                {{ $professional->bio }}
                            </p>
                        @else
                            <p class="text-xl text-gray-300 mb-10 leading-relaxed">
                                Onde estilo encontra tradição. Cortes modernos executados com precisão e dedicação por profissionais apaixonados.
                            </p>
                        @endif
                        
                        <div class="flex flex-wrap gap-6">
                            <a href="#agendar" class="btn-modern inline-block">Agendar Agora</a>
                            <a href="#servicos" class="px-8 py-4 border-2 border-[var(--brand)]/40 rounded-full font-bold text-white hover:bg-[var(--brand)]/10 hover:border-[var(--brand)] transition-all uppercase tracking-wide">
                                Ver Serviços
                            </a>
                        </div>
                    </div>
                    
                    <div class="modern-card rounded-3xl p-10" style="animation: fade-slide 1s ease-out;">
                        <h3 class="text-4xl font-black mb-8 text-white text-center">
                            Por Que Nos Escolher?
                        </h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-start gap-5 p-6 bg-gradient-to-r from-[var(--brand)]/10 to-transparent rounded-2xl border-l-4 border-[var(--brand)] hover:bg-[var(--brand)]/5 transition-all">
                                <div class="quality-icon text-4xl">💈</div>
                                <div class="flex-1">
                                    <h4 class="text-white font-bold text-xl mb-2">Profissionais Especializados</h4>
                                    <p class="text-gray-400 leading-relaxed">Equipe altamente qualificada com anos de experiência em cortes clássicos e modernos.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-5 p-6 bg-gradient-to-r from-[var(--brand)]/10 to-transparent rounded-2xl border-l-4 border-[var(--brand)] hover:bg-[var(--brand)]/5 transition-all">
                                <div class="quality-icon text-4xl">✨</div>
                                <div class="flex-1">
                                    <h4 class="text-white font-bold text-xl mb-2">Produtos Premium</h4>
                                    <p class="text-gray-400 leading-relaxed">Utilizamos apenas produtos de alta qualidade para garantir o melhor resultado.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-5 p-6 bg-gradient-to-r from-[var(--brand)]/10 to-transparent rounded-2xl border-l-4 border-[var(--brand)] hover:bg-[var(--brand)]/5 transition-all">
                                <div class="quality-icon text-4xl">🏆</div>
                                <div class="flex-1">
                                    <h4 class="text-white font-bold text-xl mb-2">Ambiente Moderno</h4>
                                    <p class="text-gray-400 leading-relaxed">Espaço confortável e sofisticado para você relaxar enquanto cuida do visual.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Serviços -->
        <section id="servicos" class="py-24 relative" style="background: var(--services-bg, #1A1A1D)">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-16">
                    <div class="modern-badge inline-flex items-center gap-2 mb-6">
                        <span class="text-xl">✂</span>
                        <span>Nossos Serviços</span>
                    </div>
                    <h3 class="text-5xl lg:text-6xl font-black mb-4">
                        <span class="text-white">O Que</span>
                        <span class="gradient-title block text-6xl lg:text-7xl">Oferecemos</span>
                    </h3>
                    <div class="elegant-divider max-w-md mx-auto"></div>
                    <p class="text-gray-400 text-lg max-w-2xl mx-auto mt-6">
                        Do clássico ao contemporâneo, cuidamos de cada detalhe para você sair satisfeito.
                    </p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($services as $service)
                        <div class="service-card p-8 group">
                            <div class="text-6xl mb-6 text-center group-hover:scale-110 transition-transform duration-500">💈</div>
                            <h4 class="text-2xl font-bold text-white mb-4 text-center">{{ $service->name }}</h4>
                            <p class="text-gray-400 mb-6 text-center leading-relaxed">{{ $service->description }}</p>
                            
                            <div class="flex items-center justify-between mb-6 pb-6 border-b border-white/10">
                                <span class="text-gray-400 font-semibold flex items-center gap-2">
                                    <span class="text-xl">⏱</span>
                                    {{ $service->duration }} min
                                </span>
                                <span class="text-3xl font-black gradient-title">R$ {{ number_format($service->price, 2, ',', '.') }}</span>
                            </div>
                            
                            <a href="#agendar" onclick="selectService({{ $service->id }})" class="block w-full text-center px-6 py-3 bg-gradient-to-r from-[var(--brand-light)] to-[var(--brand)] text-[var(--darker)] font-bold uppercase tracking-wide rounded-full hover:shadow-2xl transition-all">
                                Agendar
                            </a>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <p class="text-gray-500 text-lg">Nenhum serviço disponível no momento.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Galeria -->
        <section id="galeria" class="py-24" style="background: var(--gallery-bg, #0F0F10)">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <div class="modern-badge inline-flex items-center gap-2 mb-6">
                        <span class="text-xl">📸</span>
                        <span>Portfolio</span>
                    </div>
                    <h3 class="text-5xl lg:text-6xl font-black mb-4">
                        <span class="gradient-title text-6xl lg:text-7xl">Nossos</span>
                        <span class="text-white block">Trabalhos</span>
                    </h3>
                    <div class="elegant-divider max-w-md mx-auto"></div>
                    <p class="text-gray-400 text-lg max-w-2xl mx-auto mt-6">
                        Confira alguns dos nossos melhores trabalhos e inspire-se para o seu próximo visual.
                    </p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    @forelse($gallery as $photo)
                        <div class="gallery-item-modern gallery-item group cursor-pointer relative">
                            <img src="{{ $photo->image_path }}" alt="{{ $photo->title }}" class="w-full h-80 object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end p-6 z-20">
                                <div class="text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                    <h5 class="font-black text-xl mb-2 gradient-title">{{ $photo->title }}</h5>
                                    @if($photo->description)
                                        <p class="text-sm text-gray-300">{{ $photo->description }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        @for($i = 1; $i <= 6; $i++)
                            <div class="gallery-item-modern gallery-item group cursor-pointer relative">
                                <img src="https://picsum.photos/400/500?random={{ $i }}" alt="Galeria {{ $i }}" class="w-full h-80 object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end p-6 z-20">
                                    <div class="text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                        <h5 class="font-black text-xl gradient-title">Nosso Trabalho</h5>
                                        <p class="text-sm text-gray-300">Corte Premium #{{{ $i }}}</p>
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
            <button id="gallery-close-btn" class="absolute -top-12 right-0 text-white text-4xl hover:text-[var(--brand)] transition-colors font-light z-10">&times;</button>
            
            <!-- Modal Content -->
            <div class="bg-gray-900 rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-full border border-gray-700">
                <!-- Image Container -->
                <div class="flex-1 flex items-center justify-center bg-gray-800 p-8">
                    <img id="gallery-modal-img" src="" alt="" class="max-w-full max-h-[60vh] object-contain rounded-lg shadow-2xl">
                </div>
                
                <!-- Content -->
                <div class="p-8 bg-gray-900 border-t border-gray-700">
                    <div class="text-center">
                        <h4 id="gallery-modal-title" class="text-3xl font-black mb-3 gradient-title"></h4>
                        <p id="gallery-modal-description" class="text-gray-300 text-lg leading-relaxed"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('public.sections.scripts', ['professional' => $professional])
    
    <script>
        // Scroll suave para links de navegação
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    
                    // Atualizar link ativo
                    document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                }
            });
        });

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
