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
            /* Cores Tattoo Dark - Ultra Escuro com Neon */
            --brand: {{ $professional->templateSetting->primary_color ?? '#DC2626' }};
            --secondary: {{ $professional->templateSetting->secondary_color ?? '#A855F7' }};
            --accent: {{ $professional->templateSetting->accent_color ?? '#10B981' }};
            --background: {{ $professional->templateSetting->background_color ?? '#000000' }};
            --text: {{ $professional->templateSetting->text_color ?? '#F1F5F9' }};
        }
        
        /* Template Tattoo Dark - Ultra dark com neon */
        body {
            background: #000000;
            color: var(--text);
            font-family: 'Inter', sans-serif;
        }
        
        /* Textura grunge escura */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: 
                url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.02' fill-rule='evenodd'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }
        
        /* Hero dark */
        .dark-hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: radial-gradient(ellipse at center, #1a1a1a 0%, #000000 100%);
            position: relative;
        }
        
        /* Efeito neon */
        @keyframes neon-pulse {
            0%, 100% {
                text-shadow: 
                    0 0 10px var(--brand),
                    0 0 20px var(--brand),
                    0 0 30px var(--brand),
                    0 0 40px var(--brand);
            }
            50% {
                text-shadow: 
                    0 0 20px var(--brand),
                    0 0 30px var(--brand),
                    0 0 40px var(--brand),
                    0 0 50px var(--brand),
                    0 0 60px var(--brand);
            }
        }
        
        /* Cards dark */
        .dark-card {
            background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%);
            border: 1px solid #333;
            border-radius: 16px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .dark-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(220, 38, 38, 0.1), transparent);
            transition: left 0.5s;
        }
        
        .dark-card:hover::before {
            left: 100%;
        }
        
        .dark-card:hover {
            border-color: var(--brand);
            transform: translateY(-8px);
            box-shadow: 
                0 0 20px rgba(220, 38, 38, 0.3),
                0 20px 40px rgba(0, 0, 0, 0.8);
        }
        
        /* Botões neon */
        .btn-dark {
            background: var(--brand);
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
            box-shadow: 0 0 20px rgba(220, 38, 38, 0.5);
        }
        
        .btn-dark:hover {
            box-shadow: 
                0 0 30px rgba(220, 38, 38, 0.8),
                0 0 40px rgba(220, 38, 38, 0.5);
            transform: translateY(-2px);
        }
        
        /* Título neon */
        .dark-title {
            font-weight: 900;
            color: var(--brand);
            animation: neon-pulse 3s ease-in-out infinite;
        }
        
        /* Ícones neon */
        .icon-dark {
            width: 60px;
            height: 60px;
            background: #1a1a1a;
            border: 2px solid var(--brand);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brand);
            font-size: 28px;
            box-shadow: 0 0 15px rgba(220, 38, 38, 0.5);
        }
        
        /* Linhas neon */
        .neon-line {
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--brand), transparent);
            box-shadow: 0 0 10px var(--brand);
        }
    </style>
</head>
<body>
    @include('components.preview-banner')
    
    <!-- Hero Section -->
    <section class="dark-hero">
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-5xl mx-auto text-center">
                <div class="inline-block px-6 py-2 bg-red-950/50 border border-red-800 rounded-full text-red-400 font-bold text-sm mb-8 uppercase tracking-wider">
                    ⚡ Arte na Pele ⚡
                </div>
                <h1 class="text-7xl md:text-9xl dark-title mb-6" style="font-family: 'Impact', sans-serif;">
                    {{ $professional->business_name }}
                </h1>
                <div class="neon-line max-w-md mx-auto mb-8"></div>
                <p class="text-2xl md:text-3xl mb-10 text-gray-400 uppercase tracking-wide">
                    {{ $professional->slogan ?? 'Transformando pele em arte' }}
                </p>
                <div class="flex gap-6 justify-center">
                    <a href="#booking" class="btn-dark">Agendar Sessão</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-24 relative z-10">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-6xl dark-title mb-6" style="font-family: 'Impact', sans-serif;">NOSSOS TRABALHOS</h2>
                <div class="neon-line max-w-xs mx-auto"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($services as $service)
                <div class="dark-card">
                    <div class="icon-dark mb-6">🔥</div>
                    <h3 class="text-2xl font-bold mb-3 text-white uppercase tracking-wide">{{ $service->name }}</h3>
                    <p class="text-gray-400 mb-6">{{ $service->description }}</p>
                    <div class="flex justify-between items-center pt-6 border-t border-gray-800">
                        <span class="text-3xl font-bold text-red-500">R$ {{ number_format($service->price, 2, ',', '.') }}</span>
                        <span class="text-sm text-gray-500">{{ $service->duration }}min</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    @if($gallery->count() > 0)
    <section id="gallery" class="py-24 bg-black/50 relative z-10">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-6xl dark-title mb-6" style="font-family: 'Impact', sans-serif;">GALERIA</h2>
                <div class="neon-line max-w-xs mx-auto"></div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($gallery as $image)
                <div class="aspect-square overflow-hidden rounded-lg border-2 border-gray-800 hover:border-red-600 transition-all duration-500 group">
                    <img src="{{ Storage::url($image->path) }}" alt="{{ $image->album->name ?? 'Galeria' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 filter grayscale group-hover:grayscale-0">
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Booking Section -->
    <section id="booking" class="py-24 relative z-10">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-6xl dark-title mb-6" style="font-family: 'Impact', sans-serif;">AGENDE SUA SESSÃO</h2>
                    <div class="neon-line max-w-xs mx-auto mb-6"></div>
                    <p class="text-2xl text-gray-400 uppercase">Marque sua arte</p>
                </div>
                
                @include('public.sections.booking')
            </div>
        </div>
    </section>

    @include('public.sections.scripts')
</body>
</html>

