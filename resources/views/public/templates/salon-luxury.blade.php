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
            /* Cores Salon Luxury - Luxo com Dourado */
            --brand: {{ $professional->templateSetting->primary_color ?? '#D946EF' }};
            --secondary: {{ $professional->templateSetting->secondary_color ?? '#F59E0B' }};
            --accent: {{ $professional->templateSetting->accent_color ?? '#EC4899' }};
            --background: {{ $professional->templateSetting->background_color ?? '#FFFBEB' }};
            --text: {{ $professional->templateSetting->text_color ?? '#78350F' }};
        }
        
        /* Template Salon Luxury - Extremamente luxuoso */
        body {
            background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 50%, #FFFBEB 100%);
            color: var(--text);
            font-family: 'Playfair Display', 'Georgia', serif;
        }
        
        /* Hero com brilho dourado */
        .luxury-hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: 
                radial-gradient(circle at top right, rgba(217, 70, 239, 0.1) 0%, transparent 50%),
                radial-gradient(circle at bottom left, rgba(245, 158, 11, 0.15) 0%, transparent 50%);
            position: relative;
        }
        
        .luxury-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: 
                radial-gradient(circle, rgba(245, 158, 11, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: sparkle 20s linear infinite;
        }
        
        @keyframes sparkle {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.6; }
        }
        
        /* Cards com bordas douradas */
        .luxury-card {
            background: linear-gradient(145deg, #FFFFFF, #FFFEF5);
            border: 2px solid;
            border-image: linear-gradient(135deg, #F59E0B, #D946EF, #F59E0B) 1;
            border-radius: 20px;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .luxury-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.1) 0%, transparent 70%);
            animation: rotate 10s linear infinite;
        }
        
        @keyframes rotate {
            100% { transform: rotate(360deg); }
        }
        
        .luxury-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 
                0 25px 50px rgba(245, 158, 11, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.9);
        }
        
        /* Botões luxuosos */
        .btn-luxury {
            background: linear-gradient(135deg, #D946EF 0%, #F59E0B 100%);
            color: white;
            padding: 1rem 3rem;
            border-radius: 50px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-family: 'Inter', sans-serif;
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
        }
        
        .btn-luxury::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #F59E0B 0%, #D946EF 100%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .btn-luxury:hover::before {
            opacity: 1;
        }
        
        .btn-luxury span {
            position: relative;
            z-index: 1;
        }
        
        /* Tipografia elegante */
        .luxury-title {
            font-family: 'Playfair Display', serif;
            font-weight: 900;
            font-style: italic;
            background: linear-gradient(135deg, #D946EF, #F59E0B);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Ícones com dourado */
        .icon-luxury {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #F59E0B 0%, #D946EF 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
        }
    </style>
</head>
<body>
    @include('components.preview-banner')
    
    <!-- Hero Section -->
    <section class="luxury-hero">
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-5xl mx-auto text-center">
                <div class="inline-block px-6 py-2 bg-gradient-to-r from-amber-100 to-pink-100 rounded-full text-amber-800 font-bold text-sm mb-8">
                    ✨ EXPERIÊNCIA PREMIUM ✨
                </div>
                <h1 class="text-7xl md:text-8xl luxury-title mb-6">
                    {{ $professional->business_name }}
                </h1>
                <p class="text-2xl md:text-3xl mb-10 text-amber-800 font-serif italic">
                    {{ $professional->slogan ?? 'Onde beleza encontra luxo' }}
                </p>
                <div class="flex gap-6 justify-center">
                    <a href="#booking" class="btn-luxury">
                        <span>Agendar Horário</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-24" style="background: linear-gradient(180deg, #FFFBEB 0%, #FFFFFF 50%, #FFFBEB 100%);">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-6xl luxury-title mb-6">Nossos Tratamentos</h2>
                <p class="text-2xl text-amber-800">Exclusividade e Sofisticação</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($services as $service)
                <div class="luxury-card">
                    <div class="icon-luxury mb-6 mx-auto">💎</div>
                    <h3 class="text-2xl font-bold mb-4 text-center text-amber-900">{{ $service->name }}</h3>
                    <p class="text-gray-700 mb-6 text-center">{{ $service->description }}</p>
                    <div class="flex justify-between items-center pt-6 border-t-2 border-amber-200">
                        <span class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-600 to-amber-500">R$ {{ number_format($service->price, 2, ',', '.') }}</span>
                        <span class="text-sm text-amber-600 font-semibold">{{ $service->duration }}min</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    @if($gallery->count() > 0)
    <section id="gallery" class="py-24 bg-gradient-to-br from-pink-50 to-amber-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-6xl luxury-title mb-6">Galeria</h2>
                <p class="text-2xl text-amber-800">Momentos de Beleza</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($gallery as $image)
                <div class="aspect-square overflow-hidden rounded-2xl border-4 border-amber-200/50 hover:border-fuchsia-400 transition-all duration-500">
                    <img src="{{ Storage::url($image->path) }}" alt="{{ $image->album->name ?? 'Galeria' }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-700">
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Booking Section -->
    <section id="booking" class="py-24" style="background: linear-gradient(180deg, #FFFBEB 0%, #FEF3C7 100%);">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-6xl luxury-title mb-6">Agende seu Momento</h2>
                    <p class="text-2xl text-amber-800">Você merece o melhor</p>
                </div>
                
                @include('public.sections.booking')
            </div>
        </div>
    </section>

    @include('public.sections.scripts')
</body>
</html>

