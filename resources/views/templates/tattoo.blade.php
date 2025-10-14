<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Black Ink Studio — Template Demonstração</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --brand: #8B5CF6;
            --brand-light: #A78BFA;
            --brand-dark: #7C3AED;
            --brand-glow: #8B5CF640;
            --bg-color: #0F0F10;
            --text-color: #F5F5F5;
        }
        
        body {
            background: linear-gradient(135deg, var(--bg-color) 0%, #1A1520 50%, var(--bg-color) 100%);
            color: var(--text-color);
            font-family: 'Inter', -apple-system, sans-serif;
        }
        
        /* Textura grunge */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: 
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.3;
            pointer-events: none;
            z-index: 0;
        }
        
        .content-wrapper {
            position: relative;
            z-index: 1;
        }
        
        /* Animações */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes glow-pulse {
            0%, 100% { box-shadow: 0 0 20px rgba(139, 92, 246, 0.3); }
            50% { box-shadow: 0 0 30px rgba(139, 92, 246, 0.5); }
        }
        
        /* Cards com estilo urbano */
        .tattoo-card {
            background: linear-gradient(145deg, #1a1a1a 0%, #0f0f0f 100%);
            border: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .tattoo-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.03), transparent);
            transition: left 0.5s;
        }
        
        .tattoo-card:hover {
            border-color: var(--brand);
            box-shadow: 0 0 30px var(--brand-glow), 0 20px 60px rgba(0, 0, 0, 0.7);
            transform: translateY(-10px) scale(1.02);
        }
        
        .tattoo-card:hover::before {
            left: 100%;
        }
        
        /* Botão estilo urbano */
        .btn-tattoo {
            background: var(--brand);
            color: white;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 3px;
            padding: 1.25rem 3rem;
            position: relative;
            overflow: hidden;
            clip-path: polygon(0 0, calc(100% - 15px) 0, 100% 15px, 100% 100%, 15px 100%, 0 calc(100% - 15px));
            transition: all 0.3s;
        }
        
        .btn-tattoo::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.3), transparent 70%);
            transform: translateX(-100%) skewX(-15deg);
            transition: transform 0.6s;
        }
        
        .btn-tattoo:hover::before {
            transform: translateX(100%) skewX(-15deg);
        }
        
        .btn-tattoo:hover {
            box-shadow: 0 0 30px var(--brand-glow), 0 10px 40px rgba(0, 0, 0, 0.6);
            transform: translateY(-3px) scale(1.02);
        }
        
        /* Título com gradiente */
        .gradient-title {
            background: linear-gradient(135deg, var(--brand-light) 0%, var(--brand) 50%, var(--brand-dark) 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="antialiased">
    <div class="content-wrapper">
        <!-- Header -->
        <header class="sticky top-0 z-50 bg-black/80 backdrop-blur-xl border-b border-white/5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-24">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-purple-600 to-pink-600 grid place-content-center font-black text-2xl text-white shadow-lg" style="animation: glow-pulse 2s infinite;">
                            BI
                        </div>
                        <div>
                            <h1 class="font-black text-2xl gradient-title tracking-wider">BLACK INK STUDIO</h1>
                            <a href="tel:(11)97777-7777" class="text-xs text-gray-400 hover:text-purple-400 transition flex items-center gap-1">
                                <span>🎨</span> (11) 97777-7777
                            </a>
                        </div>
                    </div>
                    
                    <nav class="hidden md:flex items-center gap-10">
                        <a href="#inicio" class="text-gray-300 hover:text-purple-400 font-bold uppercase text-sm transition">Início</a>
                        <a href="#portfolio" class="text-gray-300 hover:text-purple-400 font-bold uppercase text-sm transition">Portfolio</a>
                        <a href="#estilos" class="text-gray-300 hover:text-purple-400 font-bold uppercase text-sm transition">Estilos</a>
                        <a href="#agendar" class="text-gray-300 hover:text-purple-400 font-bold uppercase text-sm transition">Agendar</a>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Hero -->
        <section id="inicio" class="py-24 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-900/20 to-pink-900/20"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <div class="inline-block px-4 py-2 bg-purple-500/20 border border-purple-500/30 rounded-lg text-sm font-black text-purple-400 mb-6 uppercase tracking-wider">
                            Arte Permanente
                        </div>
                        <h2 class="text-6xl lg:text-7xl font-black mb-6 leading-none">
                            <span class="gradient-title">ARTE QUE CONTA SUA HISTÓRIA</span>
                        </h2>
                        <p class="text-xl text-gray-300 mb-10 leading-relaxed">
                            Tatuagens personalizadas, ambiente higienizado e artistas experientes. Transforme sua ideia em arte permanente.
                        </p>
                        <div class="flex flex-wrap gap-6">
                            <a href="#agendar" class="btn-tattoo inline-block">Agendar Sessão</a>
                            <a href="#portfolio" class="px-8 py-5 border-2 border-purple-500 text-purple-400 font-black uppercase tracking-wider rounded-lg hover:bg-purple-500/10 transition">
                                Ver Portfolio
                            </a>
                        </div>
                    </div>
                    
                    <div class="relative" style="animation: float 6s ease-in-out infinite;">
                        <div class="tattoo-card rounded-3xl p-10">
                            <h3 class="text-3xl font-black gradient-title mb-8">Especialidades</h3>
                            <div class="space-y-5">
                                <div class="flex items-center gap-4 p-5 bg-white/5 rounded-xl border border-white/10">
                                    <span class="text-3xl">🎨</span>
                                    <span class="font-bold text-lg">Realismo & Fine Line</span>
                                </div>
                                <div class="flex items-center gap-4 p-5 bg-white/5 rounded-xl border border-white/10">
                                    <span class="text-3xl">⚫</span>
                                    <span class="font-bold text-lg">Blackwork & Pontilhismo</span>
                                </div>
                                <div class="flex items-center gap-4 p-5 bg-white/5 rounded-xl border border-white/10">
                                    <span class="text-3xl">🐉</span>
                                    <span class="font-bold text-lg">Oriental & Tradicional</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Estilos -->
        <section id="estilos" class="py-24 bg-gradient-to-b from-black to-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <div class="inline-block px-4 py-2 bg-purple-500/20 border border-purple-500/30 rounded-lg text-sm font-black text-purple-400 mb-4 uppercase tracking-wider">
                        Nossas Especialidades
                    </div>
                    <h3 class="text-5xl font-black gradient-title mb-4">ESTILOS DE TATUAGEM</h3>
                    <p class="text-xl text-gray-400">Do clássico ao contemporâneo</p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @php
                    $styles = [
                        ['name' => 'Realismo', 'description' => 'Tatuagens ultra-realistas com técnica avançada', 'duration' => '3-4h', 'price' => 400],
                        ['name' => 'Old School', 'description' => 'Clássico americano tradicional', 'duration' => '2-3h', 'price' => 300],
                        ['name' => 'Aquarela', 'description' => 'Efeitos de pintura aquarela vibrantes', 'duration' => '2-3h', 'price' => 350],
                        ['name' => 'Minimalista', 'description' => 'Designs clean e delicados', 'duration' => '1-2h', 'price' => 250],
                        ['name' => 'Blackwork', 'description' => 'Tinta preta sólida e geométrico', 'duration' => '3-5h', 'price' => 400],
                        ['name' => 'Oriental', 'description' => 'Dragões, carpas e tradição japonesa', 'duration' => '4-6h', 'price' => 500],
                    ];
                    @endphp
                    @foreach($styles as $style)
                        <div class="tattoo-card rounded-2xl p-8">
                            <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-purple-600 to-pink-600 grid place-content-center mb-6 mx-auto">
                                <span class="text-3xl">🎨</span>
                            </div>
                            <h4 class="text-2xl font-black text-center mb-3 gradient-title">{{ $style['name'] }}</h4>
                            <p class="text-gray-400 mb-6 text-center">{{ $style['description'] }}</p>
                            <div class="flex items-center justify-between mb-6 pb-6 border-b border-white/10">
                                <div class="text-gray-500 font-bold">⏱️ {{ $style['duration'] }}</div>
                                <div class="text-2xl font-black gradient-title">
                                    R$ {{ $style['price'] }}+
                                </div>
                            </div>
                            <a href="#agendar" class="btn-tattoo block text-center w-full text-sm py-3">
                                AGENDAR
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Portfolio -->
        <section id="portfolio" class="py-24 bg-black">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <div class="inline-block px-4 py-2 bg-purple-500/20 border border-purple-500/30 rounded-lg text-sm font-black text-purple-400 mb-4 uppercase tracking-wider">
                        Nossos Trabalhos
                    </div>
                    <h3 class="text-5xl font-black gradient-title mb-4">PORTFOLIO</h3>
                    <p class="text-xl text-gray-400">Arte que transforma pele em tela</p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    @for($i = 1; $i <= 6; $i++)
                        <div class="tattoo-card rounded-2xl overflow-hidden cursor-pointer group">
                            <img src="https://picsum.photos/400/500?random={{ $i + 20 }}" alt="Trabalho {{ $i }}" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500 brightness-90 group-hover:brightness-110">
                        </div>
                    @endfor
                </div>
            </div>
        </section>

        <!-- Agendamento -->
        <section id="agendar" class="py-24 bg-gradient-to-b from-gray-900 to-black">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <div class="inline-block px-4 py-2 bg-purple-500/20 border border-purple-500/30 rounded-lg text-sm font-black text-purple-400 mb-4 uppercase tracking-wider">
                        Reserve Agora
                    </div>
                    <h3 class="text-5xl font-black gradient-title mb-4">AGENDE SUA SESSÃO</h3>
                    <p class="text-xl text-gray-400">Vamos criar sua arte juntos</p>
                </div>
                
                <div class="tattoo-card rounded-3xl p-8">
                    <form class="space-y-6">
                        <div>
                            <label class="block text-sm font-black text-purple-400 mb-2 uppercase tracking-wider">Estilo de Tatuagem</label>
                            <select class="w-full px-4 py-3 rounded-lg bg-black border-2 border-purple-600/30 text-white focus:border-purple-500 focus:outline-none transition">
                                <option>Selecione um estilo...</option>
                                <option>Realismo - A partir de R$ 400</option>
                                <option>Old School - A partir de R$ 300</option>
                                <option>Blackwork - A partir de R$ 400</option>
                            </select>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-black text-purple-400 mb-2 uppercase tracking-wider">Data Preferida</label>
                                <input type="date" class="w-full px-4 py-3 rounded-lg bg-black border-2 border-purple-600/30 text-white focus:border-purple-500 focus:outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-black text-purple-400 mb-2 uppercase tracking-wider">Horário</label>
                                <select class="w-full px-4 py-3 rounded-lg bg-black border-2 border-purple-600/30 text-white focus:border-purple-500 focus:outline-none transition">
                                    <option>10:00</option>
                                    <option>14:00</option>
                                    <option>16:00</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-black text-purple-400 mb-2 uppercase tracking-wider">Seu Nome</label>
                            <input type="text" placeholder="Nome completo" class="w-full px-4 py-3 rounded-lg bg-black border-2 border-purple-600/30 text-white placeholder-gray-600 focus:border-purple-500 focus:outline-none transition">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-black text-purple-400 mb-2 uppercase tracking-wider">WhatsApp</label>
                            <input type="tel" placeholder="(00) 00000-0000" class="w-full px-4 py-3 rounded-lg bg-black border-2 border-purple-600/30 text-white placeholder-gray-600 focus:border-purple-500 focus:outline-none transition">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-black text-purple-400 mb-2 uppercase tracking-wider">Descrição da Ideia</label>
                            <textarea rows="4" placeholder="Conte-nos sobre sua ideia de tatuagem..." class="w-full px-4 py-3 rounded-lg bg-black border-2 border-purple-600/30 text-white placeholder-gray-600 focus:border-purple-500 focus:outline-none transition resize-none"></textarea>
                        </div>
                        
                        <button type="submit" class="btn-tattoo w-full text-lg">
                            SOLICITAR AGENDAMENTO 🎨
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-black text-gray-400 py-12 border-t border-white/5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="text-3xl font-black gradient-title mb-4">BLACK INK STUDIO</div>
                <p class="mb-6">Este é um template de demonstração do AzendaMe</p>
                <a href="{{ url('/') }}" class="inline-block px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-black rounded-lg hover:shadow-xl transition uppercase tracking-wider">
                    ← Voltar
                </a>
            </div>
        </footer>
    </div>
</body>
</html>
