<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Espaço Juliana Spa — Template Demonstração</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --brand: #E91E63;
            --brand-light: #E91E6333;
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
            background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 50%, #f3e8ff 100%);
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-24">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full grid place-content-center font-bold text-2xl text-white shadow-xl" style="background: linear-gradient(135deg, var(--brand) 0%, #a855f7 100%)">
                        J
                    </div>
                    <div>
                        <h1 class="font-bold text-2xl bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">
                            Espaço Juliana
                        </h1>
                        <a href="tel:(11)98888-8888" class="text-sm text-gray-600 hover:text-pink-600 transition-colors flex items-center gap-1">
                            <span>💅</span> (11) 98888-8888
                        </a>
                    </div>
                </div>
                
                <!-- Menu Desktop -->
                <nav class="hidden md:flex items-center gap-10">
                    <a href="#inicio" class="nav-link active">Início</a>
                    <a href="#servicos" class="nav-link">Serviços</a>
                    <a href="#galeria" class="nav-link">Galeria</a>
                    <a href="#agendar" class="nav-link">Agendar</a>
                </nav>

                <!-- Menu Mobile -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-700 hover:text-pink-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="inicio" class="salon-gradient py-24 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center relative z-10">
                <div class="text-center lg:text-left">
                    <div class="inline-block px-4 py-2 bg-white/80 backdrop-blur-sm rounded-full text-sm font-semibold text-pink-600 mb-6 shadow-lg">
                        ✨ Beleza & Bem-estar
                    </div>
                    <h2 class="text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                        <span class="bg-gradient-to-r from-pink-600 via-purple-600 to-blue-600 bg-clip-text text-transparent">
                            Espaço Juliana
                        </span>
                    </h2>
                    <p class="text-xl text-gray-700 mb-10 leading-relaxed">Transformamos sua beleza em arte. Tratamentos exclusivos com profissionais especializados em um ambiente acolhedor.</p>
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

    <!-- Serviços -->
    <section id="servicos" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-block px-4 py-2 bg-pink-100 rounded-full text-sm font-bold text-pink-600 mb-4">
                    O que oferecemos
                </div>
                <h3 class="text-4xl lg:text-5xl font-extrabold mb-4 bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">Nossos Serviços</h3>
                <p class="text-xl text-gray-600">Beleza e cuidado personalizado para você</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                $services = [
                    ['name' => 'Manicure & Pedicure', 'description' => 'Unhas perfeitas com técnicas especializadas e produtos de qualidade', 'duration' => 60, 'price' => 80],
                    ['name' => 'Escova & Hidratação', 'description' => 'Cabelos brilhantes e sedosos com tratamento profundo', 'duration' => 90, 'price' => 120],
                    ['name' => 'Design de Sobrancelhas', 'description' => 'Sobrancelhas modeladas e desenhadas perfeitamente', 'duration' => 30, 'price' => 60],
                    ['name' => 'Massagem Relaxante', 'description' => 'Relaxamento total do corpo com técnicas exclusivas', 'duration' => 60, 'price' => 150],
                    ['name' => 'Limpeza de Pele', 'description' => 'Pele limpa, renovada e radiante', 'duration' => 75, 'price' => 180],
                    ['name' => 'Alongamento de Cílios', 'description' => 'Cílios volumosos e alongados com técnica fio a fio', 'duration' => 120, 'price' => 200],
                ];
                @endphp
                @foreach($services as $service)
                    <div class="salon-card p-8">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-pink-100 to-purple-100 grid place-content-center mb-6 mx-auto">
                            <span class="text-3xl">💅</span>
                        </div>
                        <h4 class="text-2xl font-bold text-gray-900 mb-3 text-center">{{ $service['name'] }}</h4>
                        <p class="text-gray-600 mb-6 text-center leading-relaxed">{{ $service['description'] }}</p>
                        <div class="flex items-center justify-between mb-6 pb-6 border-b border-pink-100">
                            <div class="flex items-center text-gray-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="font-semibold">{{ $service['duration'] }} min</span>
                            </div>
                            <div class="text-2xl font-extrabold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">
                                R$ {{ number_format($service['price'], 2, ',', '.') }}
                            </div>
                        </div>
                        <a href="#agendar" class="btn-primary block text-center w-full">
                            Agendar
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Galeria -->
    <section id="galeria" class="py-24 salon-gradient">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-block px-4 py-2 bg-white/80 backdrop-blur-sm rounded-full text-sm font-bold text-pink-600 mb-4">
                    Nossos trabalhos
                </div>
                <h3 class="text-4xl lg:text-5xl font-extrabold mb-4 bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">Galeria</h3>
                <p class="text-xl text-gray-700">Veja alguns dos nossos resultados</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                @for($i = 1; $i <= 6; $i++)
                    <div class="salon-card overflow-hidden cursor-pointer group">
                        <img src="https://picsum.photos/400/500?random={{ $i + 10 }}" alt="Trabalho {{ $i }}" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- Agendamento -->
    <section id="agendar" class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <div class="inline-block px-4 py-2 bg-pink-100 rounded-full text-sm font-bold text-pink-600 mb-4">
                    Fácil e Rápido
                </div>
                <h3 class="text-4xl lg:text-5xl font-extrabold mb-4 bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">Agende seu Horário</h3>
                <p class="text-xl text-gray-600">Reserve o melhor momento para você</p>
            </div>
            
            <div class="salon-card p-8">
                <form class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Escolha o Serviço</label>
                        <select class="w-full px-4 py-3 rounded-full border-2 border-pink-200 focus:border-pink-500 focus:outline-none transition">
                            <option>Selecione...</option>
                            <option>Manicure & Pedicure - R$ 80,00</option>
                            <option>Escova & Hidratação - R$ 120,00</option>
                            <option>Design de Sobrancelhas - R$ 60,00</option>
                        </select>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Data</label>
                            <input type="date" class="w-full px-4 py-3 rounded-full border-2 border-pink-200 focus:border-pink-500 focus:outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Horário</label>
                            <select class="w-full px-4 py-3 rounded-full border-2 border-pink-200 focus:border-pink-500 focus:outline-none transition">
                                <option>09:00</option>
                                <option>10:00</option>
                                <option>14:00</option>
                                <option>16:00</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Seu Nome</label>
                        <input type="text" placeholder="Nome completo" class="w-full px-4 py-3 rounded-full border-2 border-pink-200 focus:border-pink-500 focus:outline-none transition">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">WhatsApp</label>
                        <input type="tel" placeholder="(00) 00000-0000" class="w-full px-4 py-3 rounded-full border-2 border-pink-200 focus:border-pink-500 focus:outline-none transition">
                    </div>
                    
                    <button type="submit" class="btn-primary w-full text-lg py-4">
                        Confirmar Agendamento ✨
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="text-2xl font-bold bg-gradient-to-r from-pink-400 to-purple-400 bg-clip-text text-transparent mb-4">Espaço Juliana</div>
            <p class="mb-6">Este é um template de demonstração do AzendaMe</p>
            <a href="{{ url('/') }}" class="inline-block px-8 py-3 bg-gradient-to-r from-pink-600 to-purple-600 text-white rounded-full font-semibold hover:shadow-xl transition">
                ← Voltar para Landing Page
            </a>
        </div>
    </footer>

</body>
</html>
