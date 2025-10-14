<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barbearia do Carlos — Template Demonstração</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --brand: #C9A050;
            --brand-light: #E5C576;
            --brand-dark: #8B6F3E;
            --dark: #1A1A1D;
            --darker: #0F0F10;
            --light: #F8F8F8;
        }
        
        body {
            background: linear-gradient(135deg, #0F0F10 0%, #1A1A1D 50%, #0F0F10 100%);
            color: #F8F8F8;
            font-family: 'Inter', -apple-system, sans-serif;
        }
        
        /* Textura sutil */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(201, 160, 80, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(201, 160, 80, 0.03) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }
        
        .wrapper {
            position: relative;
            z-index: 1;
        }
        
        /* Animações modernas */
        @keyframes shine {
            0%, 100% { text-shadow: 0 0 20px rgba(201, 160, 80, 0.3); }
            50% { text-shadow: 0 0 30px rgba(201, 160, 80, 0.6), 0 0 50px rgba(201, 160, 80, 0.3); }
        }
        
        @keyframes float-gentle {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }
        
        /* Cards modernos */
        .modern-card {
            background: linear-gradient(135deg, rgba(26, 26, 29, 0.9) 0%, rgba(15, 15, 16, 0.9) 100%);
            border: 1px solid rgba(201, 160, 80, 0.15);
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.05);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            overflow: hidden;
        }
        
        .modern-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(201, 160, 80, 0.05), transparent);
            transition: left 0.6s;
        }
        
        .modern-card:hover {
            border-color: var(--brand);
            box-shadow: 0 0 40px rgba(201, 160, 80, 0.25), 0 30px 80px rgba(0, 0, 0, 0.6);
            transform: translateY(-10px);
        }
        
        .modern-card:hover::before {
            left: 100%;
        }
        
        /* Botões modernos */
        .btn-modern {
            background: linear-gradient(135deg, var(--brand-light) 0%, var(--brand) 100%);
            color: #0F0F10;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(201, 160, 80, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.2);
            transition: all 0.3s;
        }
        
        .btn-modern::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.5s, height 0.5s;
        }
        
        .btn-modern:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .btn-modern:hover {
            box-shadow: 0 15px 40px rgba(201, 160, 80, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
        }
        
        /* Título gradiente */
        .gradient-title {
            background: linear-gradient(135deg, #FFFFFF 0%, var(--brand-light) 30%, var(--brand) 60%, #FFFFFF 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shine 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="antialiased">
    <div class="wrapper">
        <!-- Header -->
        <header class="sticky top-0 z-50 bg-black/90 backdrop-blur-xl border-b border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-24">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-amber-600 to-yellow-700 grid place-content-center font-black text-2xl text-black shadow-lg">
                            BC
                        </div>
                        <div>
                            <h1 class="font-black text-2xl gradient-title tracking-wider">BARBEARIA DO CARLOS</h1>
                            <a href="tel:(11)96666-6666" class="text-xs text-gray-400 hover:text-amber-500 transition flex items-center gap-1">
                                <span>✂️</span> (11) 96666-6666
                            </a>
                        </div>
                    </div>
                    
                    <nav class="hidden md:flex items-center gap-10">
                        <a href="#inicio" class="text-gray-300 hover:text-amber-500 font-bold uppercase text-sm transition">Início</a>
                        <a href="#servicos" class="text-gray-300 hover:text-amber-500 font-bold uppercase text-sm transition">Serviços</a>
                        <a href="#galeria" class="text-gray-300 hover:text-amber-500 font-bold uppercase text-sm transition">Galeria</a>
                        <a href="#agendar" class="text-gray-300 hover:text-amber-500 font-bold uppercase text-sm transition">Agendar</a>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Hero -->
        <section id="inicio" class="py-24 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-900/20 to-orange-900/20"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <div class="inline-block px-4 py-2 bg-amber-500/20 border border-amber-500/30 rounded-lg text-sm font-black text-amber-400 mb-6 uppercase tracking-wider">
                            Tradição & Estilo
                        </div>
                        <h2 class="text-6xl lg:text-7xl font-black mb-6 leading-none">
                            <span class="gradient-title">MAIS QUE UM CORTE, UMA EXPERIÊNCIA</span>
                        </h2>
                        <p class="text-xl text-gray-300 mb-10 leading-relaxed">
                            Cortes clássicos e modernos, barbas bem feitas e um ambiente onde você pode relaxar enquanto cuida da aparência.
                        </p>
                        <div class="flex flex-wrap gap-6">
                            <a href="#agendar" class="btn-modern inline-block">Agendar Agora</a>
                            <a href="#servicos" class="px-8 py-5 border-2 border-amber-500 text-amber-400 font-black uppercase tracking-wider rounded-full hover:bg-amber-500/10 transition">
                                Nossos Serviços
                            </a>
                        </div>
                    </div>
                    
                    <div class="relative" style="animation: float-gentle 6s ease-in-out infinite;">
                        <div class="modern-card rounded-3xl p-10">
                            <h3 class="text-3xl font-black gradient-title mb-8">O que oferecemos</h3>
                            <div class="space-y-5">
                                <div class="flex items-center gap-4 p-5 bg-white/5 rounded-xl border border-white/10">
                                    <span class="text-3xl">✂️</span>
                                    <span class="font-bold text-lg">Cortes Modernos & Clássicos</span>
                                </div>
                                <div class="flex items-center gap-4 p-5 bg-white/5 rounded-xl border border-white/10">
                                    <span class="text-3xl">🧔</span>
                                    <span class="font-bold text-lg">Barba com Navalha</span>
                                </div>
                                <div class="flex items-center gap-4 p-5 bg-white/5 rounded-xl border border-white/10">
                                    <span class="text-3xl">⭐</span>
                                    <span class="font-bold text-lg">Tratamentos Especiais</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Serviços -->
        <section id="servicos" class="py-24 bg-gradient-to-b from-black to-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <div class="inline-block px-4 py-2 bg-amber-500/20 border border-amber-500/30 rounded-lg text-sm font-black text-amber-400 mb-4 uppercase tracking-wider">
                        Nossos Serviços
                    </div>
                    <h3 class="text-5xl font-black gradient-title mb-4">CUIDADOS PARA O HOMEM MODERNO</h3>
                    <p class="text-xl text-gray-400">Qualidade e tradição em cada atendimento</p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @php
                    $services = [
                        ['name' => 'Corte Tradicional', 'description' => 'Corte clássico com tesoura e máquina', 'duration' => 30, 'price' => 45],
                        ['name' => 'Corte + Barba', 'description' => 'Combo completo com acabamento perfeito', 'duration' => 45, 'price' => 70],
                        ['name' => 'Barba Completa', 'description' => 'Aparar, desenhar e finalizar com navalha', 'duration' => 25, 'price' => 40],
                        ['name' => 'Degradê + Desenho', 'description' => 'Corte moderno com detalhes personalizados', 'duration' => 40, 'price' => 60],
                        ['name' => 'Sobrancelha', 'description' => 'Design e limpeza de sobrancelhas', 'duration' => 15, 'price' => 20],
                        ['name' => 'Combo Premium', 'description' => 'Corte + Barba + Sobrancelha + Finalização', 'duration' => 60, 'price' => 95],
                    ];
                    @endphp
                    @foreach($services as $service)
                        <div class="modern-card rounded-2xl p-8">
                            <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-amber-600 to-yellow-700 grid place-content-center mb-6 mx-auto">
                                <span class="text-3xl">✂️</span>
                            </div>
                            <h4 class="text-2xl font-black text-center mb-3 gradient-title">{{ $service['name'] }}</h4>
                            <p class="text-gray-400 mb-6 text-center">{{ $service['description'] }}</p>
                            <div class="flex items-center justify-between mb-6 pb-6 border-b border-white/10">
                                <div class="text-gray-500 font-bold">⏱️ {{ $service['duration'] }} min</div>
                                <div class="text-2xl font-black gradient-title">
                                    R$ {{ number_format($service['price'], 2, ',', '.') }}
                                </div>
                            </div>
                            <a href="#agendar" class="btn-modern block text-center w-full text-sm py-3">
                                AGENDAR
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Galeria -->
        <section id="galeria" class="py-24 bg-black">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <div class="inline-block px-4 py-2 bg-amber-500/20 border border-amber-500/30 rounded-lg text-sm font-black text-amber-400 mb-4 uppercase tracking-wider">
                        Nossos Trabalhos
                    </div>
                    <h3 class="text-5xl font-black gradient-title mb-4">GALERIA</h3>
                    <p class="text-xl text-gray-400">Veja alguns dos nossos cortes</p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    @for($i = 1; $i <= 6; $i++)
                        <div class="modern-card rounded-2xl overflow-hidden cursor-pointer group">
                            <img src="https://picsum.photos/400/500?random={{ $i + 30 }}" alt="Corte {{ $i }}" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500 brightness-90 group-hover:brightness-110">
                        </div>
                    @endfor
                </div>
            </div>
        </section>

        <!-- Agendamento -->
        <section id="agendar" class="py-24 bg-gradient-to-b from-gray-900 to-black">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <div class="inline-block px-4 py-2 bg-amber-500/20 border border-amber-500/30 rounded-lg text-sm font-black text-amber-400 mb-4 uppercase tracking-wider">
                        Reserve Agora
                    </div>
                    <h3 class="text-5xl font-black gradient-title mb-4">AGENDE SEU HORÁRIO</h3>
                    <p class="text-xl text-gray-400">Reserve seu lugar na cadeira</p>
                </div>
                
                <div class="modern-card rounded-3xl p-8">
                    <form class="space-y-6">
                        <div>
                            <label class="block text-sm font-black text-amber-400 mb-2 uppercase tracking-wider">Escolha o Serviço</label>
                            <select class="w-full px-4 py-3 rounded-lg bg-black border-2 border-amber-600/30 text-white focus:border-amber-500 focus:outline-none transition">
                                <option>Selecione...</option>
                                <option>Corte Tradicional - R$ 45,00</option>
                                <option>Corte + Barba - R$ 70,00</option>
                                <option>Combo Premium - R$ 95,00</option>
                            </select>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-black text-amber-400 mb-2 uppercase tracking-wider">Data</label>
                                <input type="date" class="w-full px-4 py-3 rounded-lg bg-black border-2 border-amber-600/30 text-white focus:border-amber-500 focus:outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-black text-amber-400 mb-2 uppercase tracking-wider">Horário</label>
                                <select class="w-full px-4 py-3 rounded-lg bg-black border-2 border-amber-600/30 text-white focus:border-amber-500 focus:outline-none transition">
                                    <option>09:00</option>
                                    <option>10:00</option>
                                    <option>14:00</option>
                                    <option>16:00</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-black text-amber-400 mb-2 uppercase tracking-wider">Seu Nome</label>
                            <input type="text" placeholder="Nome completo" class="w-full px-4 py-3 rounded-lg bg-black border-2 border-amber-600/30 text-white placeholder-gray-600 focus:border-amber-500 focus:outline-none transition">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-black text-amber-400 mb-2 uppercase tracking-wider">WhatsApp</label>
                            <input type="tel" placeholder="(00) 00000-0000" class="w-full px-4 py-3 rounded-lg bg-black border-2 border-amber-600/30 text-white placeholder-gray-600 focus:border-amber-500 focus:outline-none transition">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-black text-amber-400 mb-2 uppercase tracking-wider">Barbeiro de Preferência (Opcional)</label>
                            <select class="w-full px-4 py-3 rounded-lg bg-black border-2 border-amber-600/30 text-white focus:border-amber-500 focus:outline-none transition">
                                <option>Sem preferência</option>
                                <option>Carlos (Dono)</option>
                                <option>João</option>
                                <option>Pedro</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn-modern w-full text-lg">
                            CONFIRMAR AGENDAMENTO ✂️
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-black text-gray-400 py-12 border-t border-white/5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="text-3xl font-black gradient-title mb-4">BARBEARIA DO CARLOS</div>
                <p class="mb-6">Este é um template de demonstração do AzendaMe</p>
                <a href="{{ url('/') }}" class="inline-block px-8 py-3 bg-gradient-to-r from-amber-600 to-yellow-700 text-black font-black rounded-full hover:shadow-xl transition uppercase tracking-wider">
                    ← Voltar
                </a>
            </div>
        </footer>
    </div>
</body>
</html>
