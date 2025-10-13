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

            --brand: {{ $professional->brand_color ?? '#3B82F6' }};
            --brand-light: {{ $professional->brand_color ?? '#3B82F6' }}20;
        }
        
        body {
            background: #FAFBFC;
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
            background: linear-gradient(135deg, var(--brand) 0%, #2563EB 100%);
            box-shadow: 0 4px 15px var(--brand-light);
            transition: all 0.3s;
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
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-4">
                    @if($professional->logo)
                        <img src="{{ asset('storage/' . $professional->logo) }}" alt="Logo" class="w-14 h-14 rounded-xl object-cover shadow-md">
                    @else
                        <div class="w-14 h-14 rounded-xl grid place-content-center font-bold text-xl text-white shadow-lg" style="background: linear-gradient(135deg, var(--brand) 0%, #2563EB 100%);">
                            {{ substr($professional->business_name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h1 class="font-bold text-xl text-gray-900">{{ $professional->business_name }}</h1>
                        @if($professional->phone)
                            <a href="tel:{{ $professional->phone }}" class="text-sm text-gray-600 hover:text-[var(--brand)] transition-colors flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ $professional->phone }}
                            </a>
                        @endif
                    </div>
                </div>
                
                <nav class="hidden md:flex items-center gap-8">
                    <a href="#inicio" class="text-gray-700 hover:text-[var(--brand)] font-semibold transition nav-link active">Início</a>
                    <a href="#servicos" class="text-gray-700 hover:text-[var(--brand)] font-semibold transition nav-link">Serviços</a>
                    <a href="#galeria" class="text-gray-700 hover:text-[var(--brand)] font-semibold transition nav-link">Galeria</a>
                    <a href="#agendar" class="text-gray-700 hover:text-[var(--brand)] font-semibold transition nav-link">Agendar</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <section id="inicio" class="clinic-hero py-24 lg:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 border border-blue-100 text-sm font-semibold text-blue-600 mb-6">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Profissional e Confiável
                    </div>
                    <h2 class="text-5xl lg:text-6xl font-extrabold text-gray-900 mb-6 leading-tight">
                        {{ $professional->business_name }}
                    </h2>
                    @if($professional->bio)
                        <p class="text-xl text-gray-600 mb-8 leading-relaxed">{{ $professional->bio }}</p>
                    @else
                        <p class="text-xl text-gray-600 mb-8 leading-relaxed">Cuidado profissional e atendimento de excelência para sua saúde e bem-estar.</p>
                    @endif
                    <div class="flex flex-wrap gap-4">
                        <a href="#agendar" class="btn-clinic inline-flex items-center px-8 py-4 rounded-xl text-white font-bold text-lg">
                            Agendar Consulta
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="#servicos" class="inline-flex items-center px-8 py-4 rounded-xl bg-white border-2 border-gray-200 text-gray-700 font-bold text-lg hover:border-[var(--brand)] hover:text-[var(--brand)] transition-all">
                            Nossos Serviços
                        </a>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-6">
                    <div class="trust-badge rounded-2xl p-6 text-center">
                        <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-4 icon-float">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Segurança</h4>
                        <p class="text-sm text-gray-600">Protocolos rigorosos</p>
                    </div>
                    
                    <div class="trust-badge rounded-2xl p-6 text-center" style="margin-top: 2rem;">
                        <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4 icon-float" style="animation-delay: 0.2s;">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Qualidade</h4>
                        <p class="text-sm text-gray-600">Excelência garantida</p>
                    </div>
                    
                    <div class="trust-badge rounded-2xl p-6 text-center">
                        <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-4 icon-float" style="animation-delay: 0.4s;">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Equipe</h4>
                        <p class="text-sm text-gray-600">Profissionais experientes</p>
                    </div>
                    
                    <div class="trust-badge rounded-2xl p-6 text-center" style="margin-top: 2rem;">
                        <div class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center mx-auto mb-4 icon-float" style="animation-delay: 0.6s;">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Pontualidade</h4>
                        <p class="text-sm text-gray-600">Respeito ao seu tempo</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Serviços -->
    <section id="servicos" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 text-sm font-semibold text-blue-600 mb-4">
                    O que oferecemos
                </div>
                <h3 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4">Nossos Serviços</h3>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Atendimento especializado com foco no seu bem-estar</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($services as $service)
                    <div class="clinic-card service-card-clinic rounded-2xl p-8">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h4 class="text-2xl font-bold text-gray-900 mb-3">{{ $service->name }}</h4>
                        <p class="text-gray-600 mb-6 leading-relaxed">{{ $service->description }}</p>
                        <div class="flex items-center justify-between mb-6 pb-6 border-b border-gray-100">
                            <div class="flex items-center text-gray-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="font-semibold">{{ $service->duration }} min</span>
                            </div>
                            <div class="text-2xl font-extrabold text-[var(--brand)]">
                                R$ {{ number_format($service->price, 2, ',', '.') }}
                            </div>
                        </div>
                        <a href="#agendar" onclick="selectService({{ $service->id }})" class="block w-full text-center px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 text-white font-bold hover:from-blue-700 hover:to-blue-600 transition-all shadow-lg hover:shadow-xl">
                            Agendar Agora
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
    <section id="galeria" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 text-sm font-semibold text-blue-600 mb-4">
                    Conheça nosso trabalho
                </div>
                <h3 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4">Galeria</h3>
                <p class="text-xl text-gray-600">Resultados que transformam vidas</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                @forelse($gallery as $photo)
                    <div class="gallery-item clinic-card rounded-2xl overflow-hidden group cursor-pointer">
                        <img src="{{ $photo->image_path }}" alt="{{ $photo->title }}" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-blue-900/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                            <div class="text-white">
                                <h5 class="font-bold text-lg mb-1">{{ $photo->title }}</h5>
                                @if($photo->description)
                                    <p class="text-sm text-blue-100">{{ $photo->description }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    @for($i = 1; $i <= 6; $i++)
                        <div class="gallery-item clinic-card rounded-2xl overflow-hidden group cursor-pointer">
                            <img src="https://picsum.photos/400/500?random={{ $i }}" alt="Galeria {{ $i }}" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-blue-900/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                                <div class="text-white">
                                    <h5 class="font-bold text-lg">Nosso Trabalho</h5>
                                    <p class="text-sm text-blue-100">Qualidade e profissionalismo</p>
                                </div>
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </section>

    @include('public.sections.booking', ['services' => $services, 'professional' => $professional])
    @include('public.sections.contact', ['professional' => $professional])
    @include('public.sections.footer', ['professional' => $professional])
    
    <!-- Gallery Modal -->
    <div id="gallery-modal" class="hidden fixed inset-0 bg-black/90 z-50 items-center justify-center p-4">
        <div class="max-w-5xl w-full">
            <button id="gallery-close-btn" class="absolute top-4 right-4 text-white text-4xl hover:text-gray-300 transition-colors">&times;</button>
            <img id="gallery-modal-img" src="" alt="" class="w-full h-auto max-h-[80vh] object-contain rounded-lg">
            <div class="mt-4 text-center text-white">
                <h4 id="gallery-modal-title" class="text-2xl font-bold mb-2"></h4>
                <p id="gallery-modal-description" class="text-gray-300"></p>
            </div>
        </div>
    </div>

    @include('public.sections.scripts', ['professional' => $professional])
</body>
</html>
