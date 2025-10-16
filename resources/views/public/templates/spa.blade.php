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
            /* Cores Zen e Relaxantes - Spa/Estética */
            --brand: {{ $professional->templateSetting->primary_color ?? '#10B981' }};
            --brand-light: {{ $professional->templateSetting->primary_color ?? '#10B981' }}20;
            --secondary: {{ $professional->templateSetting->secondary_color ?? '#8B5CF6' }};
            --accent: {{ $professional->templateSetting->accent_color ?? '#06B6D4' }};
            --background: {{ $professional->templateSetting->background_color ?? '#F0FDF4' }};
            --text: {{ $professional->templateSetting->text_color ?? '#064E3B' }};
            
            --hero-primary: {{ $professional->templateSetting->hero_primary_color ?? '#10B981' }};
            --hero-bg: {{ $professional->templateSetting->hero_background_color ?? '#ECFDF5' }};
            --services-primary: {{ $professional->templateSetting->services_primary_color ?? '#10B981' }};
            --services-bg: {{ $professional->templateSetting->services_background_color ?? '#FFFFFF' }};
            --gallery-primary: {{ $professional->templateSetting->gallery_primary_color ?? '#8B5CF6' }};
            --gallery-bg: {{ $professional->templateSetting->gallery_background_color ?? '#F0FDF4' }};
            --booking-primary: {{ $professional->templateSetting->booking_primary_color ?? '#06B6D4' }};
            --booking-bg: {{ $professional->templateSetting->booking_background_color ?? '#D1FAE5' }};
        }
        
        /* Template Spa - Design zen, relaxante, natural */
        body {
            background: var(--background);
            color: var(--text);
            font-family: 'Inter', sans-serif;
        }
        
        /* Animações suaves */
        @keyframes breathe {
            0%, 100% { transform: scale(1); opacity: 0.6; }
            50% { transform: scale(1.05); opacity: 0.8; }
        }
        
        @keyframes float-gentle {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        /* Hero zen */
        .spa-hero {
            background: 
                radial-gradient(ellipse at top, rgba(16, 185, 129, 0.1) 0%, transparent 50%),
                radial-gradient(ellipse at bottom, rgba(139, 92, 246, 0.08) 0%, transparent 50%),
                linear-gradient(to bottom, #ECFDF5 0%, #F0FDF4 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        /* Círculos decorativos zen */
        .spa-hero::before,
        .spa-hero::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            animation: breathe 8s ease-in-out infinite;
        }
        
        .spa-hero::before {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
            top: -100px;
            right: -100px;
        }
        
        .spa-hero::after {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.12) 0%, transparent 70%);
            bottom: -50px;
            left: -50px;
            animation-delay: 2s;
        }
        
        /* Cards suaves */
        .spa-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(16, 185, 129, 0.1);
            border-radius: 24px;
            padding: 2rem;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .spa-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(16, 185, 129, 0.15);
            border-color: var(--brand);
        }
        
        /* Ícones flutuantes */
        .icon-gentle {
            animation: float-gentle 4s ease-in-out infinite;
        }
        
        /* Botões zen */
        .btn-spa {
            background: linear-gradient(135deg, var(--brand) 0%, var(--accent) 100%);
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 20px var(--brand-light);
        }
        
        .btn-spa:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px var(--brand-light);
        }
        
        /* Seções com espaçamento zen */
        .spa-section {
            padding: 6rem 0;
        }
        
        /* Galeria com efeito de foco */
        .spa-gallery-item {
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            transition: transform 0.5s ease;
        }
        
        .spa-gallery-item:hover {
            transform: scale(1.05);
            z-index: 10;
        }
        
        .spa-gallery-item img {
            filter: brightness(0.95);
            transition: filter 0.3s;
        }
        
        .spa-gallery-item:hover img {
            filter: brightness(1.05);
        }
        
        /* Formulário de agendamento zen */
        .spa-booking-form input,
        .spa-booking-form select,
        .spa-booking-form textarea {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(16, 185, 129, 0.2);
            border-radius: 16px;
            padding: 1rem 1.5rem;
            transition: all 0.3s;
        }
        
        .spa-booking-form input:focus,
        .spa-booking-form select:focus,
        .spa-booking-form textarea:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 4px var(--brand-light);
            outline: none;
        }
        
        /* Texto suave */
        .spa-title {
            background: linear-gradient(135deg, var(--brand), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body>
    @include('components.preview-banner')
    
    <!-- Hero Section -->
    <section class="spa-hero">
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <div class="icon-gentle mb-8 inline-block">
                    🧘
                </div>
                <h1 class="text-6xl md:text-7xl font-bold mb-6 spa-title">
                    {{ $professional->business_name }}
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-emerald-700 font-light">
                    {{ $professional->slogan ?? 'Bem-estar e equilíbrio para corpo e mente' }}
                </p>
                <div class="flex gap-4 justify-center">
                    <a href="#booking" class="btn-spa">
                        Agendar Agora
                    </a>
                    <a href="#services" class="btn-spa" style="background: white; color: var(--brand); box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                        Nossos Serviços
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="spa-section" style="background: var(--services-bg);">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold mb-4 spa-title">Nossos Tratamentos</h2>
                <p class="text-xl text-gray-600">Experiências únicas de bem-estar</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($services as $service)
                <div class="spa-card">
                    <div class="text-4xl mb-4">🌿</div>
                    <h3 class="text-2xl font-bold mb-3 text-emerald-900">{{ $service->name }}</h3>
                    <p class="text-gray-600 mb-4">{{ $service->description }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-3xl font-bold text-emerald-600">R$ {{ number_format($service->price, 2, ',', '.') }}</span>
                        <span class="text-sm text-gray-500">{{ $service->duration }}min</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    @if($gallery->count() > 0)
    <section id="gallery" class="spa-section" style="background: var(--gallery-bg);">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold mb-4 spa-title">Galeria Zen</h2>
                <p class="text-xl text-gray-600">Nosso espaço de tranquilidade</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($gallery as $image)
                <div class="spa-gallery-item">
                    <img src="{{ Storage::url($image->path) }}" alt="{{ $image->album->name ?? 'Galeria' }}" class="w-full h-64 object-cover">
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Booking Section -->
    <section id="booking" class="spa-section" style="background: var(--booking-bg);">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-5xl font-bold mb-4 spa-title">Agende sua Sessão</h2>
                    <p class="text-xl text-gray-600">Reserve um momento de autocuidado</p>
                </div>
                
                @include('public.sections.booking')
            </div>
        </div>
    </section>

    @include('public.sections.scripts')
</body>
</html>

