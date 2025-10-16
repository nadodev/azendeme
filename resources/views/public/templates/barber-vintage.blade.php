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
        @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Playfair+Display:ital,wght@0,700;1,700&display=swap');
        
        :root {
            /* Cores Barber Vintage - Retrô Clássico */
            --brand: {{ $professional->templateSetting->primary_color ?? '#8B4513' }};
            --secondary: {{ $professional->templateSetting->secondary_color ?? '#DAA520' }};
            --accent: {{ $professional->templateSetting->accent_color ?? '#B22222' }};
            --background: {{ $professional->templateSetting->background_color ?? '#F5F5DC' }};
            --text: {{ $professional->templateSetting->text_color ?? '#2F1810' }};
        }
        
        /* Template Barber Vintage - Estilo anos 1920-1950 */
        body {
            background: #F5F5DC;
            color: var(--text);
            font-family: 'Georgia', serif;
        }
        
        /* Textura vintage */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%238B4513' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.4;
            pointer-events: none;
            z-index: 0;
        }
        
        /* Hero vintage */
        .vintage-hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: 
                linear-gradient(180deg, #F5F5DC 0%, #E8DCC0 100%);
            position: relative;
            border-bottom: 5px solid #8B4513;
        }
        
        /* Ornamentos vintage */
        .vintage-ornament {
            width: 150px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #DAA520, transparent);
            margin: 2rem auto;
        }
        
        /* Cards vintage */
        .vintage-card {
            background: #FFFFFF;
            border: 3px solid #8B4513;
            border-radius: 0;
            padding: 2.5rem;
            position: relative;
            box-shadow: 
                8px 8px 0 rgba(139, 69, 19, 0.2),
                inset 0 0 0 1px rgba(218, 165, 32, 0.3);
            transition: all 0.3s;
        }
        
        .vintage-card::before,
        .vintage-card::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border: 2px solid #DAA520;
        }
        
        .vintage-card::before {
            top: 10px;
            left: 10px;
            border-right: none;
            border-bottom: none;
        }
        
        .vintage-card::after {
            bottom: 10px;
            right: 10px;
            border-left: none;
            border-top: none;
        }
        
        .vintage-card:hover {
            transform: translate(-4px, -4px);
            box-shadow: 
                12px 12px 0 rgba(139, 69, 19, 0.3),
                inset 0 0 0 1px rgba(218, 165, 32, 0.5);
        }
        
        /* Botões vintage */
        .btn-vintage {
            background: #8B4513;
            color: #F5F5DC;
            padding: 1rem 3rem;
            border: 3px solid #DAA520;
            font-family: 'Oswald', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            position: relative;
            transition: all 0.3s;
            box-shadow: 5px 5px 0 rgba(139, 69, 19, 0.3);
        }
        
        .btn-vintage:hover {
            background: #DAA520;
            color: #2F1810;
            transform: translate(-2px, -2px);
            box-shadow: 7px 7px 0 rgba(139, 69, 19, 0.3);
        }
        
        /* Tipografia vintage */
        .vintage-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-style: italic;
            color: #8B4513;
            text-shadow: 
                2px 2px 0 rgba(218, 165, 32, 0.3),
                4px 4px 0 rgba(139, 69, 19, 0.1);
        }
        
        /* Badge vintage */
        .vintage-badge {
            width: 120px;
            height: 120px;
            background: radial-gradient(circle, #DAA520 0%, #8B4513 100%);
            border: 5px solid #2F1810;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #F5F5DC;
            font-size: 48px;
            box-shadow: 
                0 0 0 3px #DAA520,
                inset 0 2px 4px rgba(0,0,0,0.3);
        }
        
        /* Listras de barbearia */
        .barber-stripes {
            background: repeating-linear-gradient(
                45deg,
                #8B4513,
                #8B4513 10px,
                #F5F5DC 10px,
                #F5F5DC 20px,
                #B22222 20px,
                #B22222 30px
            );
            height: 10px;
        }
    </style>
</head>
<body>
    @include('components.preview-banner')
    
    <!-- Listras de topo -->
    <div class="barber-stripes"></div>
    
    <!-- Hero Section -->
    <section class="vintage-hero">
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-5xl mx-auto text-center">
                <div class="vintage-badge mx-auto mb-8">
                    💈
                </div>
                <h1 class="text-7xl md:text-8xl vintage-title mb-4">
                    {{ $professional->business_name }}
                </h1>
                <div class="vintage-ornament"></div>
                <p class="text-2xl md:text-3xl text-amber-900 font-serif italic mb-10">
                    {{ $professional->slogan ?? 'Tradição e Estilo desde sempre' }}
                </p>
                <div class="flex gap-6 justify-center">
                    <a href="#booking" class="btn-vintage">Marcar Horário</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-24 bg-gradient-to-b from-stone-100 to-stone-200 relative z-10">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-6xl vintage-title mb-4">Nossos Serviços</h2>
                <div class="vintage-ornament"></div>
                <p class="text-xl text-amber-900 font-serif italic">Tradição e Qualidade</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($services as $service)
                <div class="vintage-card">
                    <div class="vintage-badge mx-auto mb-6" style="width: 80px; height: 80px;">
                        <span style="font-size: 32px;">✂️</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-center text-amber-900 uppercase tracking-wide" style="font-family: 'Oswald', sans-serif;">
                        {{ $service->name }}
                    </h3>
                    <p class="text-gray-700 mb-6 text-center">{{ $service->description }}</p>
                    <div class="flex justify-between items-center pt-6 border-t-2 border-amber-800">
                        <span class="text-3xl font-bold text-amber-900">R$ {{ number_format($service->price, 2, ',', '.') }}</span>
                        <span class="text-sm text-gray-600 font-semibold">{{ $service->duration }}min</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    @if($gallery->count() > 0)
    <section id="gallery" class="py-24 bg-stone-50 relative z-10">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-6xl vintage-title mb-4">Galeria</h2>
                <div class="vintage-ornament"></div>
                <p class="text-xl text-amber-900 font-serif italic">Nossos Trabalhos</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($gallery as $image)
                <div class="border-4 border-amber-900 overflow-hidden hover:border-amber-600 transition-all duration-300 group">
                    <img src="{{ Storage::url($image->path) }}" alt="{{ $image->album->name ?? 'Galeria' }}" class="w-full h-64 object-cover filter sepia hover:sepia-0 transition-all duration-500 group-hover:scale-110">
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Booking Section -->
    <section id="booking" class="py-24 bg-gradient-to-b from-stone-200 to-stone-100 relative z-10">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-6xl vintage-title mb-4">Agende seu Horário</h2>
                    <div class="vintage-ornament"></div>
                    <p class="text-xl text-amber-900 font-serif italic">Atendimento Premium</p>
                </div>
                
                @include('public.sections.booking')
            </div>
        </div>
    </section>

    <!-- Listras de rodapé -->
    <div class="barber-stripes"></div>

    @include('public.sections.scripts')
</body>
</html>

