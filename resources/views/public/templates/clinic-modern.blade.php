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
            /* Cores Clínica Modern - Minimalista e Clean */
            --brand: {{ $professional->templateSetting->primary_color ?? '#0284C7' }};
            --brand-light: {{ $professional->templateSetting->primary_color ?? '#0284C7' }}15;
            --secondary: {{ $professional->templateSetting->secondary_color ?? '#14B8A6' }};
            --accent: {{ $professional->templateSetting->accent_color ?? '#8B5CF6' }};
            --background: {{ $professional->templateSetting->background_color ?? '#FAFAFA' }};
            --text: {{ $professional->templateSetting->text_color ?? '#111827' }};
        }
        
        /* Template Clinic Modern - Ultra minimalista */
        body {
            background: var(--background);
            color: var(--text);
            font-family: 'Inter', sans-serif;
        }
        
        /* Hero minimalista */
        .modern-hero {
            min-height: 90vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #FFFFFF 0%, #F8FAFC 100%);
            position: relative;
            overflow: hidden;
        }
        
        .modern-hero::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, var(--brand-light) 0%, transparent 70%);
            top: -100px;
            right: -100px;
            border-radius: 50%;
        }
        
        /* Cards flat e limpos */
        .modern-card {
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            padding: 2rem;
            transition: all 0.3s ease;
        }
        
        .modern-card:hover {
            border-color: var(--brand);
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06);
        }
        
        /* Botões minimalistas */
        .btn-modern {
            background: var(--brand);
            color: white;
            padding: 0.875rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .btn-modern:hover {
            background: var(--secondary);
            transform: translateY(-2px);
        }
        
        /* Tipografia clean */
        .modern-title {
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.1;
        }
        
        /* Ícones minimalistas */
        .icon-modern {
            width: 48px;
            height: 48px;
            background: var(--brand-light);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brand);
            font-size: 24px;
        }
    </style>
</head>
<body>
    @include('components.preview-banner')
    
    <!-- Hero Section -->
    <section class="modern-hero">
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl">
                <div class="inline-block px-4 py-2 bg-sky-50 text-sky-700 rounded-full text-sm font-semibold mb-6">
                    ✨ Saúde em Primeiro Lugar
                </div>
                <h1 class="text-6xl md:text-7xl modern-title mb-6 text-gray-900">
                    {{ $professional->business_name }}
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl">
                    {{ $professional->slogan ?? 'Cuidando da sua saúde com excelência e profissionalismo' }}
                </p>
                <div class="flex gap-4">
                    <a href="#booking" class="btn-modern">Agendar Consulta</a>
                    <a href="#services" class="px-8 py-3 border-2 border-gray-300 rounded-lg font-semibold hover:border-gray-900 transition-colors">
                        Nossos Serviços
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="max-w-2xl mb-16">
                <h2 class="text-5xl modern-title mb-4 text-gray-900">Nossos Serviços</h2>
                <p class="text-xl text-gray-600">Atendimento especializado para cuidar de você</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($services as $service)
                <div class="modern-card">
                    <div class="icon-modern mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-900">{{ $service->name }}</h3>
                    <p class="text-gray-600 mb-4 text-sm">{{ $service->description }}</p>
                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <span class="text-2xl font-bold text-sky-600">R$ {{ number_format($service->price, 2, ',', '.') }}</span>
                        <span class="text-sm text-gray-500">{{ $service->duration }}min</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    @if($gallery->count() > 0)
    <section id="gallery" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="max-w-2xl mb-16">
                <h2 class="text-5xl modern-title mb-4 text-gray-900">Estrutura</h2>
                <p class="text-xl text-gray-600">Ambiente moderno e confortável</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($gallery as $image)
                <div class="aspect-square overflow-hidden rounded-lg">
                    <img src="{{ Storage::url($image->path) }}" alt="{{ $image->album->name ?? 'Galeria' }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Booking Section -->
    <section id="booking" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-5xl modern-title mb-4 text-gray-900">Agende sua Consulta</h2>
                    <p class="text-xl text-gray-600">Escolha o melhor horário para você</p>
                </div>
                
                @include('public.sections.booking')
            </div>
        </div>
    </section>

    @include('public.sections.scripts')
</body>
</html>

