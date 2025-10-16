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
            /* Cores Academia - Vermelho Energia + Laranja Vibrante + Ciano */
            --brand: {{ $professional->templateSetting->primary_color ?? '#DC2626' }};
            --brand-light: {{ $professional->templateSetting->primary_color ?? '#DC2626' }}20;
            --secondary: {{ $professional->templateSetting->secondary_color ?? '#F97316' }};
            --accent: {{ $professional->templateSetting->accent_color ?? '#0891B2' }};
            --background: {{ $professional->templateSetting->background_color ?? '#FFFFFF' }};
            --text: {{ $professional->templateSetting->text_color ?? '#18181B' }};
            
            --hero-primary: {{ $professional->templateSetting->hero_primary_color ?? '#DC2626' }};
            --hero-bg: {{ $professional->templateSetting->hero_background_color ?? '#FEF2F2' }};
            --services-primary: {{ $professional->templateSetting->services_primary_color ?? '#F97316' }};
            --services-bg: {{ $professional->templateSetting->services_background_color ?? '#FFFFFF' }};
            --gallery-primary: {{ $professional->templateSetting->gallery_primary_color ?? '#0891B2' }};
            --gallery-bg: {{ $professional->templateSetting->gallery_background_color ?? '#FFEDD5' }};
            --booking-primary: {{ $professional->templateSetting->booking_primary_color ?? '#DC2626' }};
            --booking-bg: {{ $professional->templateSetting->booking_background_color ?? '#FEE2E2' }};
        }
        
        /* Template Academia - Design energético, forte, motivacional */
        body {
            background: var(--background);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            font-weight: 600;
        }
        
        /* Animações energéticas */
        @keyframes pulse-energy {
            0%, 100% { 
                transform: scale(1); 
                box-shadow: 0 0 0 0 var(--brand-light);
            }
            50% { 
                transform: scale(1.02); 
                box-shadow: 0 0 40px var(--brand-light);
            }
        }
        
        @keyframes slide-up {
            from { 
                opacity: 0; 
                transform: translateY(40px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }
        
        @keyframes diagonal-move {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, -20px); }
        }
        
        /* Hero energético */
        .gym-hero {
            background: 
                linear-gradient(135deg, var(--hero-bg) 0%, var(--background) 100%),
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0h60v60H0z' fill='none'/%3E%3Cpath d='M30 30m-20 0a20 20 0 1 0 40 0a20 20 0 1 0-40 0' stroke='%23DC2626' stroke-width='1' fill='none' opacity='0.05'/%3E%3C/svg%3E");
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        /* Formas geométricas energéticas */
        .gym-hero::before,
        .gym-hero::after {
            content: '';
            position: absolute;
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
        }
        
        .gym-hero::before {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, var(--brand-light) 0%, transparent 70%);
            top: -100px;
            right: -100px;
            animation: diagonal-move 10s ease-in-out infinite;
        }
        
        .gym-hero::after {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(249, 115, 22, 0.1) 0%, transparent 70%);
            bottom: -100px;
            left: -100px;
            animation: diagonal-move 8s ease-in-out infinite reverse;
        }
        
        /* Cards fortes */
        .gym-card {
            background: linear-gradient(145deg, #FFFFFF, #F9FAFB);
            border: 2px solid transparent;
            border-radius: 20px;
            padding: 2rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .gym-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--brand) 0%, var(--secondary) 100%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .gym-card:hover {
            transform: translateY(-10px) scale(1.02);
            border-color: var(--brand);
            box-shadow: 0 25px 60px rgba(220, 38, 38, 0.2);
        }
        
        .gym-card:hover::before {
            opacity: 0.05;
        }
        
        /* Botões poderosos */
        .btn-gym {
            background: linear-gradient(135deg, var(--brand) 0%, var(--secondary) 100%);
            color: white;
            padding: 1.25rem 3rem;
            border-radius: 50px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
            box-shadow: 0 8px 25px var(--brand-light);
            position: relative;
            overflow: hidden;
        }
        
        .btn-gym::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, white 0%, var(--brand) 100%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .btn-gym:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px var(--brand-light);
        }
        
        .btn-gym:hover::before {
            opacity: 0.15;
        }
        
        .btn-gym span {
            position: relative;
            z-index: 1;
        }
        
        /* Texto forte */
        .gym-title {
            font-weight: 900;
            background: linear-gradient(135deg, var(--brand), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-transform: uppercase;
            letter-spacing: -1px;
        }
        
        /* Seções com energia */
        .gym-section {
            padding: 5rem 0;
            position: relative;
        }
        
        /* Galeria dinâmica */
        .gym-gallery-item {
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            transition: transform 0.4s ease;
        }
        
        .gym-gallery-item::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--brand) 0%, var(--secondary) 100%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .gym-gallery-item:hover {
            transform: scale(1.08) rotate(2deg);
            z-index: 10;
        }
        
        .gym-gallery-item:hover::after {
            opacity: 0.3;
        }
        
        /* Formulário energético */
        .gym-booking-form input,
        .gym-booking-form select,
        .gym-booking-form textarea {
            background: white;
            border: 3px solid #E5E7EB;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .gym-booking-form input:focus,
        .gym-booking-form select:focus,
        .gym-booking-form textarea:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 4px var(--brand-light);
            outline: none;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    @include('components.preview-banner')
    
    <!-- Hero Section -->
    <section class="gym-hero">
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-5xl mx-auto text-center">
                <div class="text-7xl mb-8">💪</div>
                <h1 class="text-6xl md:text-8xl font-black mb-6 gym-title">
                    {{ $professional->business_name }}
                </h1>
                <p class="text-2xl md:text-3xl mb-10 text-gray-700 font-bold uppercase tracking-wide">
                    {{ $professional->slogan ?? 'Transforme Seu Corpo, Transforme Sua Vida' }}
                </p>
                <div class="flex gap-6 justify-center">
                    <a href="#booking" class="btn-gym">
                        <span>Agendar Treino</span>
                    </a>
                    <a href="#services" class="btn-gym" style="background: white; color: var(--brand); box-shadow: 0 8px 25px rgba(0,0,0,0.15);">
                        <span>Ver Planos</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="gym-section" style="background: var(--services-bg);">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-6xl font-black mb-4 gym-title">Nossos Treinos</h2>
                <p class="text-2xl text-gray-600 font-bold uppercase">Supere Seus Limites</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($services as $service)
                <div class="gym-card">
                    <div class="text-5xl mb-4">🔥</div>
                    <h3 class="text-3xl font-black mb-3 text-gray-900 uppercase">{{ $service->name }}</h3>
                    <p class="text-gray-600 mb-6 font-semibold">{{ $service->description }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-4xl font-black text-red-600">R$ {{ number_format($service->price, 2, ',', '.') }}</span>
                        <span class="text-sm text-gray-500 font-bold uppercase">{{ $service->duration }}min</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    @if($gallery->count() > 0)
    <section id="gallery" class="gym-section" style="background: var(--gallery-bg);">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-6xl font-black mb-4 gym-title">Resultados Reais</h2>
                <p class="text-2xl text-gray-600 font-bold uppercase">Inspiração Pura</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($gallery as $image)
                <div class="gym-gallery-item">
                    <img src="{{ Storage::url($image->path) }}" alt="{{ $image->album->name ?? 'Galeria' }}" class="w-full h-72 object-cover">
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Booking Section -->
    <section id="booking" class="gym-section" style="background: var(--booking-bg);">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-6xl font-black mb-4 gym-title">Comece Agora!</h2>
                    <p class="text-2xl text-gray-600 font-bold uppercase">Sua Transformação Te Espera</p>
                </div>
                
                @include('public.sections.booking')
            </div>
        </div>
    </section>

    @include('public.sections.scripts')
</body>
</html>

