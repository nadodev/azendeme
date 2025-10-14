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
            --brand: {{ $professional->templateSetting->primary_color ?? $professional->brand_color ?? '#E91E63' }};
            --brand-light: {{ $professional->templateSetting->primary_color ?? $professional->brand_color ?? '#E91E63' }}33;
            --secondary: {{ $professional->templateSetting->secondary_color ?? '#F8BBD9' }};
            --accent: {{ $professional->templateSetting->accent_color ?? '#E91E63' }};
            --background: {{ $professional->templateSetting->background_color ?? '#FDF2F8' }};
            --text: {{ $professional->templateSetting->text_color ?? '#1F2937' }};
            
            /* Cores por seção */
            --hero-primary: {{ $professional->templateSetting->hero_primary_color ?? $professional->templateSetting->primary_color ?? '#E91E63' }};
            --hero-bg: {{ $professional->templateSetting->hero_background_color ?? '#FDF2F8' }};
            --services-primary: {{ $professional->templateSetting->services_primary_color ?? '#E91E63' }};
            --services-bg: {{ $professional->templateSetting->services_background_color ?? '#FFFFFF' }};
            --gallery-primary: {{ $professional->templateSetting->gallery_primary_color ?? '#E91E63' }};
            --gallery-bg: {{ $professional->templateSetting->gallery_background_color ?? '#FDF2F8' }};
            --booking-primary: {{ $professional->templateSetting->booking_primary_color ?? '#E91E63' }};
            --booking-bg: {{ $professional->templateSetting->booking_background_color ?? '#FCE7F3' }};
        }
        
        /* Template Salão - Design elegante, luxuoso, vibrante */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes shine {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        
        .salon-gradient {
            background: linear-gradient(135deg, var(--background) 0%, var(--hero-bg) 50%, var(--gallery-bg) 100%);
            position: relative;
            overflow: hidden;
        }
        
        .salon-gradient::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, var(--brand-light) 0%, transparent 70%);
            border-radius: 50%;
            top: -100px;
            right: -100px;
            animation: float 6s ease-in-out infinite;
        }
        
        .salon-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .salon-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }
        
        .nav-link {
            position: relative;
            color: #374151;
            font-weight: 600;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 50%;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--brand), #a855f7);
            transform: translateX(-50%);
            transition: width 0.3s ease;
            border-radius: 2px;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--brand);
        }
        
        .nav-link:hover::before, .nav-link.active::before {
            width: 100%;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--brand) 0%, #a855f7 100%);
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px var(--brand-light);
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .sparkle {
            position: relative;
        }
        
        .sparkle::after {
            content: '✨';
            position: absolute;
            top: -10px;
            right: -10px;
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="antialiased bg-gradient-to-br from-pink-50 via-purple-50 to-blue-50 text-gray-900">
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-pink-100 shadow-lg">
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
               
                <div class="flex items-center gap-4">
                    @if($professional->logo)
                        <img src="{{ asset('storage/' . $professional->logo) }}" alt="Logo" class="w-16 h-16 rounded-full object-cover ring-4 ring-pink-100">
                    @else
                        <div class="w-16 h-16 rounded-full grid place-content-center font-bold text-2xl text-white shadow-xl" style="background: linear-gradient(135deg, var(--brand) 0%, #a855f7 100%)">
                            {{ substr($professional->business_name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h1 class="font-bold text-2xl bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">
                            {{ $professional->business_name }}
                        </h1>
                        @if($professional->phone)
                            <a href="tel:{{ $professional->phone }}" class="text-sm text-gray-600 hover:text-pink-600 transition-colors flex items-center gap-1">
                                <span>💅</span> {{ $professional->phone }}
                            </a>
                        @endif
                    </div>
                </div>
                
                <nav class="hidden md:flex items-center gap-10">
                    <a href="#inicio" class="nav-link active">Início</a>
                    <a href="#servicos" class="nav-link">Serviços</a>
                    <a href="#galeria" class="nav-link">Galeria</a>
                    <a href="{{ route('blog.index', $professional->slug) }}" class="nav-link">Blog</a>
                    <a href="#agendar" class="nav-link">Agendar</a>
                    <a href="#contato" class="nav-link">Contato</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="inicio" class="py-24 relative" style="background: var(--hero-bg, #FDF2F8)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center relative z-10">
                <div class="text-center lg:text-left">
                    <div class="inline-block px-4 py-2 bg-white/80 backdrop-blur-sm rounded-full text-sm font-semibold text-pink-600 mb-6 shadow-lg">
                        ✨ Beleza & Bem-estar
                    </div>
                    <h2 class="text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                        <span class="bg-gradient-to-r from-pink-600 via-purple-600 to-blue-600 bg-clip-text text-transparent">
                            {{ $professional->business_name }}
                        </span>
                    </h2>
                    @if($professional->bio)
                        <p class="text-xl text-gray-700 mb-10 leading-relaxed">{{ $professional->bio }}</p>
                    @endif
                    <div class="flex flex-wrap gap-6 justify-center lg:justify-start">
                        <a href="#agendar" class="btn-primary inline-block">Agendar Agora</a>
                        <a href="#servicos" class="px-8 py-4 border-3 border-pink-300 rounded-full font-bold text-gray-800 hover:bg-white hover:shadow-xl transition-all">
                            Nossos Serviços
                        </a>
                    </div>
                </div>
                
                <div class="relative">
                    <div class="salon-card p-10 sparkle">
                        <h3 class="text-3xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent mb-6">
                            Sua transformação começa aqui
                        </h3>
                        <div class="space-y-5">
                            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-pink-50 to-purple-50 rounded-2xl">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-500 to-purple-500 grid place-content-center text-white text-xl">
                                    💇
                                </div>
                                <span class="text-gray-800 font-semibold">Cabelos com estilo único</span>
                            </div>
                            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-pink-50 to-purple-50 rounded-2xl">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-500 to-purple-500 grid place-content-center text-white text-xl">
                                    💅
                                </div>
                                <span class="text-gray-800 font-semibold">Unhas impecáveis</span>
                            </div>
                            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-pink-50 to-purple-50 rounded-2xl">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-500 to-purple-500 grid place-content-center text-white text-xl">
                                    ✨
                                </div>
                                <span class="text-gray-800 font-semibold">Tratamentos exclusivos</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('public.sections.services', ['services' => $services, 'professional' => $professional])
    @include('public.sections.gallery', ['gallery' => $gallery, 'professional' => $professional])
    @include('public.sections.booking', ['services' => $services, 'professional' => $professional])
    @include('public.sections.feedbacks', ['feedbacks' => $feedbacks])
    @include('public.sections.contact', ['professional' => $professional])
    @include('public.sections.footer', ['professional' => $professional])
    
    <!-- Gallery Modal -->
    <div id="gallery-modal" class="hidden fixed inset-0 bg-black/95 z-50 grid place-items-center p-4 backdrop-blur-sm">
        <div class="relative max-w-6xl w-full max-h-[90vh] flex flex-col">
            <!-- Close Button -->
            <button id="gallery-close-btn" class="absolute -top-12 right-0 text-white text-4xl hover:text-pink-400 transition-colors font-light z-10">&times;</button>
            
            <!-- Modal Content -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-full">
                <!-- Image Container -->
                <div class="flex-1 grid place-items-center bg-gradient-to-br from-pink-50 to-rose-50 p-8">
                    <img id="gallery-modal-img" src="" alt="" class="max-w-full max-h-[60vh] object-contain rounded-lg shadow-lg">
                </div>
                
                <!-- Content -->
                <div class="p-8 bg-white border-t border-pink-100">
                    <div class="text-center">
                        <h4 id="gallery-modal-title" class="text-3xl font-bold mb-3 text-gray-900"></h4>
                        <p id="gallery-modal-description" class="text-lg text-gray-600 leading-relaxed"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('public.sections.scripts', ['professional' => $professional])
</body>
</html>

