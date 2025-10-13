<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $professional->name }} — Agende Online</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        :root {
            --brand: {{ $professional->brand_color ?? '#6C63FF' }};
            --brand-light: {{ $professional->brand_color ?? '#6C63FF' }}22;
            --brand-rgb: 108, 99, 255;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .gradient-animate {
            background-size: 200% 200%;
            animation: gradient 15s ease infinite;
        }
        
        .nav-link {
            @apply text-gray-700 hover:text-[var(--brand)] transition-all duration-200 font-medium relative;
        }
        .nav-link:hover::after {
            content: '';
            @apply absolute bottom-0 left-0 right-0 h-0.5 bg-[var(--brand)];
        }
        .nav-link.active {
            @apply text-[var(--brand)] font-bold;
        }
        .nav-link.active::after {
            content: '';
            @apply absolute bottom-0 left-0 right-0 h-0.5 bg-[var(--brand)];
        }
        .page-section {
            @apply hidden;
        }
        .page-section.active {
            @apply block animate-fade-in;
        }
        .btn-primary {
            @apply inline-flex items-center px-6 py-3 text-white rounded-xl hover:scale-105 transition-all duration-300 font-semibold shadow-lg hover:shadow-2xl;
            background: linear-gradient(135deg, var(--brand) 0%, #E91E63 100%);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #E91E63 0%, var(--brand) 100%);
        }
        .service-card {
            @apply bg-white rounded-2xl p-6 border-2 border-transparent hover:border-[var(--brand)] hover:shadow-2xl transition-all duration-300 hover:-translate-y-2;
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(135deg, var(--brand), #E91E63, #48BB78) border-box;
        }
        .service-card:hover {
            box-shadow: 0 20px 50px rgba(var(--brand-rgb), 0.3);
        }
        .gallery-item {
            @apply relative overflow-hidden rounded-2xl group cursor-pointer shadow-lg hover:shadow-2xl transition-all duration-300;
        }
        .gallery-item img {
            @apply w-full h-64 object-cover transition-transform duration-700 group-hover:scale-125 group-hover:rotate-2;
        }
        .gallery-overlay {
            @apply absolute inset-0 bg-gradient-to-t from-purple-900/90 via-pink-900/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end p-6;
        }
        
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, var(--brand), #E91E63, #48BB78);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .glass-effect {
            @apply backdrop-blur-lg bg-white/80 border border-white/20;
        }
    </style>
</head>
<body class="antialiased bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    @if($professional->logo)
                        <img src="{{ asset('storage/' . $professional->logo) }}" alt="{{ $professional->name }}" class="w-12 h-12 rounded-full object-cover">
                    @else
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                            <span class="text-white font-bold text-xl">{{ substr($professional->name, 0, 1) }}</span>
                        </div>
                    @endif
                    <div>
                        <h1 class="font-bold text-lg text-gray-900">{{ $professional->business_name ?? $professional->name }}</h1>
                        <p class="text-xs text-gray-500">{{ $professional->phone }}</p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#" data-page="home" class="nav-link active">Início</a>
                    <a href="#" data-page="services" class="nav-link">Serviços</a>
                    <a href="#" data-page="gallery" class="nav-link">Galeria</a>
                    <a href="#" data-page="about" class="nav-link">Sobre</a>
                    <a href="#" data-page="booking" class="btn-primary">Agendar Agora</a>
                </nav>

                <!-- Mobile Menu Button -->
                <button class="md:hidden p-2" onclick="toggleMobileMenu()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100">
            <div class="px-4 py-3 space-y-2">
                <a href="#" data-page="home" class="block py-2 text-gray-600 hover:text-[var(--brand)]">Início</a>
                <a href="#" data-page="services" class="block py-2 text-gray-600 hover:text-[var(--brand)]">Serviços</a>
                <a href="#" data-page="gallery" class="block py-2 text-gray-600 hover:text-[var(--brand)]">Galeria</a>
                <a href="#" data-page="about" class="block py-2 text-gray-600 hover:text-[var(--brand)]">Sobre</a>
                <a href="#" data-page="booking" class="block py-2 text-[var(--brand)] font-semibold">Agendar Agora</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <!-- HOME PAGE -->
        <section id="home" class="page-section active">
            <!-- Hero Section -->
            <div class="relative bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 overflow-hidden">
                <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32 relative">
                    <div class="grid lg:grid-cols-2 gap-12 items-center">
                        <div class="space-y-6">
                            <div class="inline-block px-4 py-2 bg-white rounded-full shadow-sm">
                                <span class="text-sm font-semibold text-[var(--brand)]">✨ Agendamento Online</span>
                            </div>
                            <h2 class="text-4xl lg:text-6xl font-extrabold text-gray-900 leading-tight">
                                {{ $professional->business_name ?? $professional->name }}
                            </h2>
                            <p class="text-xl text-gray-600 leading-relaxed">
                                {{ $professional->bio ?? 'Transforme sua beleza com nossos serviços profissionais. Agende agora de forma rápida e prática.' }}
                            </p>
                            <div class="flex flex-wrap gap-4">
                                <a href="#" data-page="booking" class="btn-primary">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Agendar Horário
                                </a>
                                <a href="#" data-page="services" class="inline-flex items-center px-6 py-3 bg-white text-gray-700 rounded-lg hover:shadow-lg transition-all duration-200 font-semibold border-2 border-gray-200">
                                    Ver Serviços
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                            @if($professional->email)
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $professional->email }}
                                </div>
                            @endif
                        </div>
                        <div class="relative">
                            @if($professional->logo)
                                <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                                    <img src="{{ asset('storage/' . $professional->logo) }}" alt="{{ $professional->name }}" class="w-full h-96 object-cover">
                                </div>
                            @else
                                <div class="relative rounded-3xl overflow-hidden shadow-2xl bg-gradient-to-br from-purple-400 via-pink-400 to-blue-400 h-96 flex items-center justify-center">
                                    <span class="text-9xl font-bold text-white opacity-20">{{ substr($professional->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <!-- Decorative Elements -->
                            <div class="absolute -top-4 -right-4 w-24 h-24 bg-[var(--brand)] rounded-full opacity-20 blur-3xl"></div>
                            <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-pink-400 rounded-full opacity-20 blur-3xl"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Services Preview -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">Nossos Serviços em Destaque</h3>
                    <p class="text-gray-600">Conheça alguns dos nossos principais serviços</p>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($services->take(3) as $service)
                        <div class="service-card">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $service->name }}</h4>
                            <p class="text-gray-600 mb-4 text-sm">{{ Str::limit($service->description ?? 'Serviço profissional de qualidade', 80) }}</p>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">⏱️ {{ $service->duration }} min</span>
                                @if($service->price)
                                    <span class="font-bold text-[var(--brand)]">R$ {{ number_format($service->price, 2, ',', '.') }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-8">
                    <a href="#" data-page="services" class="text-[var(--brand)] font-semibold hover:underline">
                        Ver todos os serviços →
                    </a>
                </div>
            </div>
        </section>

        <!-- SERVICES PAGE -->
        <section id="services" class="page-section">
            <div class="bg-gradient-to-br from-gray-50 to-white py-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <h2 class="text-4xl font-bold text-gray-900 mb-4">Nossos Serviços</h2>
                        <p class="text-xl text-gray-600">Profissionais qualificados para cuidar de você</p>
                    </div>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($services as $service)
                            <div class="service-card">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    @if($service->active)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Disponível</span>
                                    @endif
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $service->name }}</h3>
                                @if($service->description)
                                    <p class="text-gray-600 mb-6">{{ $service->description }}</p>
                                @endif
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <div class="flex items-center text-gray-500">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="font-medium">{{ $service->duration }} min</span>
                                    </div>
                                    @if($service->price)
                                        <span class="text-2xl font-bold text-[var(--brand)]">R$ {{ number_format($service->price, 2, ',', '.') }}</span>
                                    @endif
                                </div>
                                <a href="#" data-page="booking" class="mt-6 w-full btn-primary justify-center">
                                    Agendar Este Serviço
                                </a>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <p class="text-gray-500">Nenhum serviço disponível no momento.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <!-- GALLERY PAGE -->
        <section id="gallery" class="page-section">
            <div class="bg-white py-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <h2 class="text-4xl font-bold text-gray-900 mb-4">Galeria de Trabalhos</h2>
                        <p class="text-xl text-gray-600">Veja alguns dos nossos trabalhos realizados</p>
                    </div>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($gallery as $photo)
                            <div class="gallery-item">
                                <img src="{{ $photo->image_path }}" alt="{{ $photo->title }}" loading="lazy">
                                <div class="gallery-overlay">
                                    <div class="text-white">
                                        <h4 class="font-bold text-lg">{{ $photo->title }}</h4>
                                        @if($photo->description)
                                            <p class="text-sm opacity-90">{{ $photo->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <!-- Placeholder images if no gallery -->
                            @for($i = 1; $i <= 6; $i++)
                                <div class="gallery-item">
                                    <img src="https://picsum.photos/400/300?random={{ $i }}" alt="Trabalho {{ $i }}" loading="lazy">
                                    <div class="gallery-overlay">
                                        <div class="text-white">
                                            <h4 class="font-bold text-lg">Nosso Trabalho</h4>
                                            <p class="text-sm opacity-90">Qualidade e dedicação</p>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <!-- ABOUT PAGE -->
        <section id="about" class="page-section">
            <div class="bg-gradient-to-br from-purple-50 to-white py-16">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                        <div class="grid md:grid-cols-2 gap-8">
                            <div class="p-12">
                                <h2 class="text-3xl font-bold text-gray-900 mb-6">Sobre Nós</h2>
                                <div class="space-y-4 text-gray-600">
                                    <p>{{ $professional->bio ?? 'Somos profissionais dedicados em oferecer os melhores serviços para nossos clientes. Com anos de experiência no mercado, buscamos sempre a excelência e a satisfação de quem confia em nosso trabalho.' }}</p>
                                    
                                    <div class="pt-6 space-y-3">
                                        <div class="flex items-center text-gray-700">
                                            <svg class="w-5 h-5 mr-3 text-[var(--brand)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            <span>{{ $professional->phone }}</span>
                                        </div>
                                        @if($professional->email)
                                            <div class="flex items-center text-gray-700">
                                                <svg class="w-5 h-5 mr-3 text-[var(--brand)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                                <span>{{ $professional->email }}</span>
                                            </div>
                                        @endif
                                        <div class="flex items-center text-gray-700">
                                            <svg class="w-5 h-5 mr-3 text-[var(--brand)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>Agendamento online disponível</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-8">
                                    <a href="#" data-page="booking" class="btn-primary">
                                        Agendar Agora
                                    </a>
                                </div>
                            </div>
                            <div class="relative h-full min-h-[400px]">
                                @if($professional->logo)
                                    <img src="{{ asset('storage/' . $professional->logo) }}" alt="{{ $professional->name }}" class="absolute inset-0 w-full h-full object-cover">
                                @else
                                    <div class="absolute inset-0 bg-gradient-to-br from-purple-400 to-pink-400"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- BOOKING PAGE -->
        <section id="booking" class="page-section">
            <div class="bg-gray-50 py-16">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <h2 class="text-4xl font-bold text-gray-900 mb-4">Agende Seu Horário</h2>
                        <p class="text-xl text-gray-600">Escolha o serviço, data e horário de sua preferência</p>
                    </div>

                    <div class="bg-white rounded-3xl shadow-xl p-8">
                        <form id="booking-form" class="space-y-6">
                            <!-- Selecionar Serviço -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Selecione o Serviço *</label>
                                <select id="service-select" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[var(--brand)] focus:border-transparent transition">
                                    <option value="">Escolha um serviço...</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" data-duration="{{ $service->duration }}">
                                            {{ $service->name }} ({{ $service->duration }}min) 
                                            @if($service->price)
                                                - R$ {{ number_format($service->price, 2, ',', '.') }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Selecionar Data -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Selecione a Data *</label>
                                <input type="date" id="date-select" required min="{{ date('Y-m-d') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[var(--brand)] focus:border-transparent transition">
                            </div>

                            <!-- Horários Disponíveis -->
                            <div id="time-slots-container" class="hidden">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Horários Disponíveis *</label>
                                <div id="time-slots" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3">
                                    <!-- Slots serão carregados via JavaScript -->
                                </div>
                                <input type="hidden" id="selected-time" required>
                            </div>

                            <!-- Dados do Cliente -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Seu Nome *</label>
                                    <input type="text" id="customer-name" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[var(--brand)] focus:border-transparent transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Telefone/WhatsApp *</label>
                                    <input type="tel" id="customer-phone" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[var(--brand)] focus:border-transparent transition">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">E-mail</label>
                                <input type="email" id="customer-email" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[var(--brand)] focus:border-transparent transition">
                            </div>

                            <!-- Mensagem de Erro/Sucesso -->
                            <div id="booking-message" class="hidden"></div>

                            <!-- Botão de Envio -->
                            <button type="submit" class="w-full btn-primary justify-center text-lg py-4">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Confirmar Agendamento
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="font-bold text-lg mb-4">{{ $professional->business_name ?? $professional->name }}</h3>
                    <p class="text-gray-400 text-sm">{{ Str::limit($professional->bio ?? 'Profissionais dedicados em oferecer os melhores serviços.', 100) }}</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Links Rápidos</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" data-page="home" class="hover:text-white transition">Início</a></li>
                        <li><a href="#" data-page="services" class="hover:text-white transition">Serviços</a></li>
                        <li><a href="#" data-page="gallery" class="hover:text-white transition">Galeria</a></li>
                        <li><a href="#" data-page="booking" class="hover:text-white transition">Agendar</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Contato</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>{{ $professional->phone }}</li>
                        @if($professional->email)
                            <li>{{ $professional->email }}</li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm text-gray-400">
                <p>© {{ date('Y') }} {{ $professional->business_name ?? $professional->name }}. Todos os direitos reservados.</p>
                <p class="mt-2">Powered by <a href="/" class="text-[var(--brand)] hover:underline">Agende.Me</a></p>
            </div>
        </div>
    </footer>

    <!-- Success Modal -->
    <div id="success-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Agendamento Confirmado!</h3>
            <p class="text-gray-600 mb-6" id="success-details"></p>
            <button onclick="closeSuccessModal()" class="btn-primary w-full justify-center">
                Entendi
            </button>
        </div>
    </div>

    <script>
        const professionalSlug = '{{ $professional->slug }}';
        
        // Navigation
        document.querySelectorAll('[data-page]').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const page = e.target.closest('[data-page]').getAttribute('data-page');
                showPage(page);
            });
        });

        function showPage(pageName) {
            // Hide all sections
            document.querySelectorAll('.page-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Show selected section
            document.getElementById(pageName).classList.add('active');
            
            // Update nav links
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('data-page') === pageName) {
                    link.classList.add('active');
                }
            });
            
            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
            
            // Close mobile menu
            document.getElementById('mobile-menu').classList.add('hidden');
        }

        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }

        // Booking System
        const serviceSelect = document.getElementById('service-select');
        const dateSelect = document.getElementById('date-select');
        const timeSlotsContainer = document.getElementById('time-slots-container');
        const timeSlotsDiv = document.getElementById('time-slots');
        const bookingForm = document.getElementById('booking-form');

        dateSelect.addEventListener('change', loadTimeSlots);
        serviceSelect.addEventListener('change', loadTimeSlots);

        async function loadTimeSlots() {
            const serviceId = serviceSelect.value;
            const date = dateSelect.value;
            
            if (!serviceId || !date) {
                timeSlotsContainer.classList.add('hidden');
                return;
            }

            try {
                const response = await fetch(`/${professionalSlug}/available-slots?service_id=${serviceId}&date=${date}`);
                const data = await response.json();
                
                timeSlotsDiv.innerHTML = '';
                
                if (data.slots && data.slots.length > 0) {
                    data.slots.forEach(slot => {
                        const button = document.createElement('button');
                        button.type = 'button';
                        button.className = 'px-4 py-3 border-2 border-gray-200 rounded-xl hover:border-[var(--brand)] hover:bg-purple-50 transition font-medium text-sm';
                        button.textContent = slot.time;
                        button.onclick = () => selectTimeSlot(slot.datetime, button);
                        timeSlotsDiv.appendChild(button);
                    });
                    timeSlotsContainer.classList.remove('hidden');
                } else {
                    timeSlotsDiv.innerHTML = '<p class="col-span-full text-center text-gray-500">Nenhum horário disponível para esta data.</p>';
                    timeSlotsContainer.classList.remove('hidden');
                }
            } catch (error) {
                console.error('Erro ao carregar horários:', error);
            }
        }

        function selectTimeSlot(datetime, button) {
            // Remove selection from all buttons
            timeSlotsDiv.querySelectorAll('button').forEach(btn => {
                btn.classList.remove('border-[var(--brand)]', 'bg-purple-50', 'text-[var(--brand)]', 'font-bold');
                btn.classList.add('border-gray-200');
            });
            
            // Mark selected button
            button.classList.remove('border-gray-200');
            button.classList.add('border-[var(--brand)]', 'bg-purple-50', 'text-[var(--brand)]', 'font-bold');
            document.getElementById('selected-time').value = datetime;
        }

        bookingForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = {
                service_id: serviceSelect.value,
                start_time: document.getElementById('selected-time').value,
                name: document.getElementById('customer-name').value,
                phone: document.getElementById('customer-phone').value,
                email: document.getElementById('customer-email').value || null,
            };

            try {
                const response = await fetch(`/${professionalSlug}/book`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (data.success) {
                    const serviceName = serviceSelect.options[serviceSelect.selectedIndex].text;
                    const date = new Date(formData.start_time);
                    const dateStr = date.toLocaleDateString('pt-BR');
                    const timeStr = date.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
                    
                    document.getElementById('success-details').textContent = 
                        `${serviceName} agendado para ${dateStr} às ${timeStr}. Entraremos em contato em breve!`;
                    
                    document.getElementById('success-modal').classList.remove('hidden');
                    bookingForm.reset();
                    timeSlotsContainer.classList.add('hidden');
                } else {
                    showMessage(data.message || 'Erro ao realizar agendamento', 'error');
                }
            } catch (error) {
                showMessage('Erro ao processar agendamento. Tente novamente.', 'error');
                console.error('Erro:', error);
            }
        });

        function showMessage(message, type) {
            const messageDiv = document.getElementById('booking-message');
            messageDiv.className = `p-4 rounded-xl ${type === 'error' ? 'bg-red-50 text-red-700 border-2 border-red-200' : 'bg-green-50 text-green-700 border-2 border-green-200'}`;
            messageDiv.textContent = message;
            messageDiv.classList.remove('hidden');
            
            setTimeout(() => {
                messageDiv.classList.add('hidden');
            }, 5000);
        }

        function closeSuccessModal() {
            document.getElementById('success-modal').classList.add('hidden');
            showPage('home');
        }
    </script>
</body>
</html>
