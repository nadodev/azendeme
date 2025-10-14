<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $professional->name }} — Agende Online</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        :root {
            --brand: {{ $professional->brand_color ?? '#E91E63' }};
        }
    </style>
</head>
<body class="antialiased bg-white">
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm border-b border-gray-100 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    @if($professional->logo)
                        <img src="{{ asset('storage/' . $professional->logo) }}" alt="{{ $professional->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-[var(--brand)]">
                    @else
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-lg" style="background: var(--brand)">
                            {{ substr($professional->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h1 class="font-bold text-gray-900">{{ $professional->business_name ?? $professional->name }}</h1>
                        <p class="text-xs text-gray-500">{{ $professional->phone }}</p>
                    </div>
                </div>
                <nav class="hidden md:flex items-center gap-6">
                    <a href="#servicos" class="text-gray-600 hover:text-[var(--brand)] transition font-medium text-sm">Serviços</a>
                    <a href="#galeria" class="text-gray-600 hover:text-[var(--brand)] transition font-medium text-sm">Galeria</a>
                    <a href="#sobre" class="text-gray-600 hover:text-[var(--brand)] transition font-medium text-sm">Sobre</a>
                    <a href="#agendar" class="px-5 py-2 rounded-full text-white font-semibold text-sm shadow-lg hover:shadow-xl transition-all hover:scale-105" style="background: var(--brand)">
                        Agendar
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
        <!-- Decorative elements -->
        <div class="absolute top-0 left-0 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-0 right-0 w-72 h-72 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
        
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center px-4 py-2 bg-white rounded-full shadow-md mb-6">
                        <span class="w-2 h-2 rounded-full mr-2 animate-pulse" style="background: var(--brand)"></span>
                        <span class="text-sm font-semibold" style="color: var(--brand)">Agende Online</span>
                    </div>
                    <h2 class="text-4xl md:text-6xl font-extrabold mb-6 text-gray-900">
                        {{ $professional->business_name ?? $professional->name }}
                    </h2>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        {{ $professional->bio ?? 'Transforme sua beleza com nossos serviços profissionais. Qualidade, confiança e resultado garantido.' }}
                    </p>
                    <div class="flex flex-wrap gap-4 mb-8">
                        <a href="#agendar" class="group inline-flex items-center px-8 py-4 rounded-full font-bold shadow-xl hover:shadow-2xl transition-all hover:scale-105 text-white" style="background: var(--brand)">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Agendar Agora
                        </a>
                        <a href="#servicos" class="inline-flex items-center px-8 py-4 bg-white rounded-full font-bold border-2 border-gray-200 hover:border-[var(--brand)] hover:shadow-lg transition-all text-gray-700">
                            Ver Serviços
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>
                    </div>
                    <div class="flex items-center gap-8 text-sm text-gray-600">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white mr-2" style="background: var(--brand)">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span>Confirmação Imediata</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white mr-2" style="background: var(--brand)">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span>Fácil e Rápido</span>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    @if($professional->logo)
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl transform hover:scale-105 transition-transform duration-500">
                            <img src="{{ asset('storage/' . $professional->logo) }}" alt="{{ $professional->name }}" class="w-full h-96 object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        </div>
                    @else
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl bg-gradient-to-br from-purple-100 to-pink-100 h-96 flex items-center justify-center transform hover:scale-105 transition-transform duration-500">
                            <span class="text-9xl font-bold text-white opacity-40">{{ substr($professional->name, 0, 1) }}</span>
                        </div>
                    @endif
                    <!-- Floating badge -->
                    <div class="absolute -bottom-6 -right-6 bg-white rounded-2xl shadow-xl p-6 max-w-xs">
                        <div class="flex items-start gap-3">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white" style="background: var(--brand)">
                                ⭐
                            </div>
                            <div>
                                <div class="font-bold text-gray-900">Atendimento Premium</div>
                                <div class="text-sm text-gray-600">{{ $services->count() }} serviços disponíveis</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>

    <!-- Serviços -->
    <section id="servicos" class="py-20 bg-white relative overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-purple-100 to-transparent rounded-full blur-3xl opacity-20"></div>
        
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold mb-4 text-white shadow-lg" style="background: var(--brand)">
                    ✨ Nossos Serviços
                </span>
                <h3 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">O que fazemos por você</h3>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Serviços profissionais de qualidade com os melhores produtos e técnicas do mercado</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($services as $index => $service)
                    <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100 hover:border-[var(--brand)] relative overflow-hidden">
                        <!-- Gradient overlay on hover -->
                        <div class="absolute inset-0 bg-gradient-to-br from-[var(--brand)]/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="relative">
                            <div class="flex items-start justify-between mb-6">
                                <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-xl transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500" style="background: linear-gradient(135deg, var(--brand) 0%, rgba(var(--brand-rgb), 0.7) 100%)">
                                    <span class="text-2xl">{{ ['💅', '✨', '💆', '🌟', '💖', '👑'][$index % 6] }}</span>
                                </div>
                                @if($service->active)
                                    <span class="flex items-center gap-1 px-3 py-1 bg-green-50 text-green-700 text-xs font-semibold rounded-full border border-green-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                        Disponível
                                    </span>
                                @endif
                            </div>
                            
                            <h4 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-[var(--brand)] transition-colors">{{ $service->name }}</h4>
                            
                            @if($service->description)
                                <p class="text-gray-600 mb-6 leading-relaxed">{{ $service->description }}</p>
                            @else
                                <p class="text-gray-600 mb-6 leading-relaxed">Serviço profissional de alta qualidade realizado por especialistas.</p>
                            @endif
                            
                            <div class="flex items-center justify-between pt-4 border-t-2 border-gray-100">
                                <div class="flex items-center text-gray-600 font-medium">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-2 bg-gray-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    {{ $service->duration }} min
                                </div>
                                @if($service->price)
                                    <span class="text-2xl font-bold" style="color: var(--brand)">R$ {{ number_format($service->price, 2, ',', '.') }}</span>
                                @endif
                            </div>
                            
                            <a href="#agendar" class="mt-6 w-full inline-flex items-center justify-center px-6 py-3 rounded-full font-semibold bg-gray-50 text-gray-700 hover:bg-[var(--brand)] hover:text-white transition-all duration-300 group/btn">
                                Agendar Este Serviço
                                <svg class="w-4 h-4 ml-2 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="text-6xl mb-4">💫</div>
                        <p class="text-gray-500 text-lg">Nenhum serviço disponível no momento.</p>
                    </div>
                @endforelse
            </div>
            
            <!-- Call to action -->
            <div class="text-center mt-16">
                <p class="text-gray-600 mb-6">Não encontrou o que procura?</p>
                <a href="#agendar" class="inline-flex items-center px-8 py-4 rounded-full font-bold shadow-xl hover:shadow-2xl transition-all hover:scale-105 text-white" style="background: var(--brand)">
                    Entre em Contato
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Galeria -->
    <section id="galeria" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">Galeria</h3>
                <p class="text-gray-600 text-lg">Veja alguns dos nossos trabalhos</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @forelse($gallery as $photo)
                    <div class="relative group overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all">
                        <img src="{{ $photo->image_path }}" alt="{{ $photo->title }}" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                            <div class="text-white">
                                <h5 class="font-bold">{{ $photo->title }}</h5>
                                @if($photo->description)
                                    <p class="text-sm opacity-90">{{ $photo->description }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    @for($i = 1; $i <= 6; $i++)
                        <div class="relative group overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all">
                            <img src="https://picsum.photos/400/300?random={{ $i }}" alt="Trabalho {{ $i }}" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                <div class="text-white">
                                    <h5 class="font-bold">Nosso Trabalho</h5>
                                    <p class="text-sm opacity-90">Qualidade e dedicação</p>
                                </div>
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </section>

    <!-- Sobre -->
    <section id="sobre" class="py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                <div class="grid md:grid-cols-2">
                    <div class="p-10">
                        <h3 class="text-3xl font-bold text-gray-900 mb-6">Sobre Nós</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            {{ $professional->bio ?? 'Somos profissionais dedicados em oferecer os melhores serviços para nossos clientes. Com anos de experiência no mercado, buscamos sempre a excelência e a satisfação de quem confia em nosso trabalho.' }}
                        </p>
                        <div class="space-y-3 mb-8">
                            <div class="flex items-center text-gray-700">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 text-white" style="background: var(--brand)">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <span>{{ $professional->phone }}</span>
                            </div>
                            @if($professional->email)
                                <div class="flex items-center text-gray-700">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 text-white" style="background: var(--brand)">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <span>{{ $professional->email }}</span>
                                </div>
                            @endif
                        </div>
                        <a href="#agendar" class="inline-flex items-center px-6 py-3 rounded-full text-white font-semibold shadow-lg hover:shadow-xl transition-all hover:scale-105" style="background: var(--brand)">
                            Agendar Agora
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                    <div class="relative h-64 md:h-auto">
                        @if($professional->logo)
                            <img src="{{ asset('storage/' . $professional->logo) }}" alt="{{ $professional->name }}" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center text-white text-8xl font-bold" style="background: linear-gradient(135deg, var(--brand) 0%, rgba(0,0,0,0.1) 100%)">
                                {{ substr($professional->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Agendamento -->
    <section id="agendar" class="py-20 bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold mb-4 text-white shadow-lg" style="background: var(--brand)">
                    📅 Agendamento Online
                </span>
                <h3 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Agende Seu Horário</h3>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Selecione o serviço, escolha a data no calendário e confirme seu agendamento</p>
            </div>
            
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="grid lg:grid-cols-2 gap-0">
                    <!-- Calendário -->
                    <div class="p-8 bg-gradient-to-br from-purple-50 to-pink-50">
                        <h4 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <span class="w-10 h-10 rounded-xl flex items-center justify-center text-white mr-3 shadow-lg" style="background: var(--brand)">
                                📅
                            </span>
                            Escolha a Data
                        </h4>
                        <div id="calendar-container" class="bg-white rounded-2xl p-6 shadow-lg">
                            <div class="flex items-center justify-between mb-6">
                                <button type="button" id="prev-month" class="p-2 hover:bg-gray-100 rounded-lg transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                                <h5 id="calendar-month" class="text-lg font-bold text-gray-900"></h5>
                                <button type="button" id="next-month" class="p-2 hover:bg-gray-100 rounded-lg transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="grid grid-cols-7 gap-2 mb-2">
                                <div class="text-center text-xs font-semibold text-gray-500">Dom</div>
                                <div class="text-center text-xs font-semibold text-gray-500">Seg</div>
                                <div class="text-center text-xs font-semibold text-gray-500">Ter</div>
                                <div class="text-center text-xs font-semibold text-gray-500">Qua</div>
                                <div class="text-center text-xs font-semibold text-gray-500">Qui</div>
                                <div class="text-center text-xs font-semibold text-gray-500">Sex</div>
                                <div class="text-center text-xs font-semibold text-gray-500">Sáb</div>
                            </div>
                            <div id="calendar-days" class="grid grid-cols-7 gap-2"></div>
                            <div class="mt-6 flex items-center justify-center gap-6 text-xs">
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded border-2 border-[var(--brand)] bg-[var(--brand)]/10"></div>
                                    <span class="text-gray-600">Disponível</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded bg-gray-200"></div>
                                    <span class="text-gray-600">Indisponível</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulário -->
                    <div class="p-8">
                        <form id="booking-form" class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Serviço *</label>
                                <select id="service-select" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[var(--brand)] focus:ring-2 focus:ring-[var(--brand)]/20 transition-all">
                                    <option value="">Escolha um serviço...</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" data-duration="{{ $service->duration }}">
                                            {{ $service->name }} ({{ $service->duration }}min)
                                            @if($service->price) - R$ {{ number_format($service->price, 2, ',', '.') }} @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="selected-date-display" class="hidden p-4 bg-[var(--brand)]/10 rounded-xl border-2 border-[var(--brand)]/20">
                                <div class="text-sm text-gray-600 mb-1">Data selecionada:</div>
                                <div id="selected-date-text" class="text-lg font-bold" style="color: var(--brand)"></div>
                            </div>

                            <div id="time-slots-container" class="hidden">
                                <label class="block text-sm font-bold text-gray-700 mb-3">Horários Disponíveis *</label>
                                <div id="time-slots" class="grid grid-cols-3 gap-2 max-h-64 overflow-y-auto"></div>
                                <input type="hidden" id="selected-time" required>
                                <input type="hidden" id="selected-date-value">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Nome *</label>
                                    <input type="text" id="customer-name" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[var(--brand)] focus:ring-2 focus:ring-[var(--brand)]/20 transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Telefone *</label>
                                    <input type="tel" id="customer-phone" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[var(--brand)] focus:ring-2 focus:ring-[var(--brand)]/20 transition-all">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">E-mail</label>
                                <input type="email" id="customer-email" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[var(--brand)] focus:ring-2 focus:ring-[var(--brand)]/20 transition-all">
                            </div>

                            <div id="booking-message" class="hidden"></div>

                            <button type="submit" class="w-full py-4 rounded-xl text-white font-bold text-lg shadow-xl hover:shadow-2xl transition-all hover:scale-105" style="background: var(--brand)">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Confirmar Agendamento
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12" style="background: var(--brand)">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8 mb-8 text-white">
                <div>
                    <h4 class="font-bold text-lg mb-3">{{ $professional->business_name ?? $professional->name }}</h4>
                    <p class="text-white/80 text-sm">{{ Str::limit($professional->bio ?? 'Profissionais dedicados.', 100) }}</p>
                </div>
                <div>
                    <h5 class="font-semibold mb-3">Links</h5>
                    <ul class="space-y-2 text-sm text-white/80">
                        <li><a href="#servicos" class="hover:text-white transition">Serviços</a></li>
                        <li><a href="#galeria" class="hover:text-white transition">Galeria</a></li>
                        <li><a href="#sobre" class="hover:text-white transition">Sobre</a></li>
                        <li><a href="#agendar" class="hover:text-white transition">Agendar</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-semibold mb-3">Contato</h5>
                    <ul class="space-y-2 text-sm text-white/80">
                        <li>{{ $professional->phone }}</li>
                        @if($professional->email)
                            <li>{{ $professional->email }}</li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/20 pt-6 text-center text-white/60 text-sm">
                <p>© {{ date('Y') }} {{ $professional->business_name ?? $professional->name }}. Todos os direitos reservados.</p>
                <p class="mt-1">Powered by <a href="/" class="text-white hover:underline">AzendaMe</a></p>
            </div>
        </div>
    </footer>

    <!-- Modal de Sucesso -->
    <div id="success-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 text-center transform scale-95 transition-transform" id="modal-content">
            <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 text-white text-3xl" style="background: var(--brand)">
                ✓
            </div>
            <h4 class="text-2xl font-bold text-gray-900 mb-2">Agendamento Confirmado!</h4>
            <p class="text-gray-600 mb-6" id="success-details"></p>
            <button onclick="closeSuccessModal()" class="px-8 py-3 rounded-full text-white font-bold shadow-lg hover:shadow-xl transition-all" style="background: var(--brand)">
                Entendi
            </button>
        </div>
    </div>

    <script>
        const professionalSlug = '{{ $professional->slug }}';
        const serviceSelect = document.getElementById('service-select');
        const dateSelect = document.getElementById('date-select');
        const timeSlotsContainer = document.getElementById('time-slots-container');
        const timeSlotsDiv = document.getElementById('time-slots');
        const bookingForm = document.getElementById('booking-form');

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

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
                        button.className = 'px-4 py-2 border-2 border-gray-200 rounded-lg hover:border-[var(--brand)] hover:bg-[var(--brand)] hover:text-white transition-all font-medium text-sm';
                        button.textContent = slot.time;
                        button.onclick = () => selectTimeSlot(slot.datetime, button);
                        timeSlotsDiv.appendChild(button);
                    });
                    timeSlotsContainer.classList.remove('hidden');
                } else {
                    timeSlotsDiv.innerHTML = '<p class="col-span-full text-center text-gray-500 py-4">Nenhum horário disponível</p>';
                    timeSlotsContainer.classList.remove('hidden');
                }
            } catch (error) {
                console.error('Erro ao carregar horários:', error);
            }
        }

        function selectTimeSlot(datetime, button) {
            timeSlotsDiv.querySelectorAll('button').forEach(btn => {
                btn.className = 'px-4 py-2 border-2 border-gray-200 rounded-lg hover:border-[var(--brand)] hover:bg-[var(--brand)] hover:text-white transition-all font-medium text-sm';
            });
            
            button.style.borderColor = 'var(--brand)';
            button.style.background = 'var(--brand)';
            button.style.color = 'white';
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
                        `${serviceName} agendado para ${dateStr} às ${timeStr}`;
                    
                    document.getElementById('success-modal').classList.remove('hidden');
                    setTimeout(() => {
                        document.getElementById('modal-content').classList.add('scale-100');
                        document.getElementById('modal-content').classList.remove('scale-95');
                    }, 10);
                    
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
            document.getElementById('modal-content').classList.add('scale-95');
            document.getElementById('modal-content').classList.remove('scale-100');
            setTimeout(() => {
                document.getElementById('success-modal').classList.add('hidden');
            }, 200);
        }
    </script>
</body>
</html>
