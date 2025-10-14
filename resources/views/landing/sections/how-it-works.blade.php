<!-- Como Funciona -->
<section id="como-funciona" class="py-24 bg-gradient-to-br from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-block px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold mb-4">
                ⚡ Processo Simples
            </div>
            <h2 class="text-4xl md:text-5xl font-black mb-4">
                Como funciona o
                <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">AzendeMe</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Em poucos passos, seu negócio estará online com agendamentos profissionais
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12 items-center mb-20">
            <!-- Timeline -->
            <div class="space-y-8">
                @php
$steps = [
                    [
                        'number' => '01',
                        'title' => 'Solicite uma Demonstração',
                        'desc' => 'Preencha o formulário ou fale conosco pelo WhatsApp para conhecer o aZendame.',
                        'icon' => '👤',
                        'color' => 'purple'
                    ],
                    [
                        'number' => '02',
                        'title' => 'Contratação pelo WhatsApp',
                        'desc' => 'Fechamos o plano e ativamos sua conta rapidamente pelo WhatsApp.',
                        'icon' => '💬',
                        'color' => 'indigo'
                    ],
                    [
                        'number' => '03',
                        'title' => 'Configure seu Negócio',
                        'desc' => 'Adicione serviços, horários, profissionais e personalize as cores da sua marca.',
                        'icon' => '⚙️',
                        'color' => 'blue'
                    ],
                    [
                        'number' => '04',
                        'title' => 'Escolha seu Template',
                        'desc' => 'Selecione entre Clínica, Salão/Spa, Tatuagem ou Barbearia. Todos personalizáveis.',
                        'icon' => '🎨',
                        'color' => 'pink'
                    ],
                    [
                        'number' => '05',
                        'title' => 'Compartilhe seu Link',
                        'desc' => 'Receba seu link personalizado (aZendame/seu-negocio) e compartilhe nas redes.',
                        'icon' => '🔗',
                        'color' => 'green'
                    ],
                    [
                        'number' => '06',
                        'title' => 'Receba Agendamentos',
                        'desc' => 'Clientes escolhem data e horário. Você recebe alertas e gerencia tudo no painel.',
                        'icon' => '📅',
                        'color' => 'orange'
                    ]
                ];
                @endphp

                @foreach($steps as $step)
                <div class="flex gap-6 group">
                    <div class="shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-{{ $step['color'] }}-500 to-{{ $step['color'] }}-600 rounded-2xl flex items-center justify-center text-white font-black text-xl shadow-lg group-hover:scale-110 transition">
                            {{ $step['icon'] }}
                        </div>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-{{ $step['color'] }}-600 mb-1">PASSO {{ $step['number'] }}</div>
                        <h3 class="text-2xl font-bold mb-2">{{ $step['title'] }}</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Visual -->
            <div class="relative">
                <div class="bg-white rounded-3xl shadow-2xl p-8 border-2 border-gray-100">
                    <div class="text-center mb-8">
                        <div class="text-6xl mb-4">🚀</div>
                        <h3 class="text-2xl font-bold mb-2">Comece Agora!</h3>
                        <p class="text-gray-600">Leva apenas 5 minutos para configurar</p>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-3 p-4 bg-purple-50 rounded-xl">
                            <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white">✓</div>
                            <span class="font-semibold">Sem Taxa de Instalação</span>
                        </div>
                        <div class="flex items-center gap-3 p-4 bg-blue-50 rounded-xl">
                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white">✓</div>
                            <span class="font-semibold">Suporte em Português</span>
                        </div>
                        <div class="flex items-center gap-3 p-4 bg-green-50 rounded-xl">
                            <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white">✓</div>
                            <span class="font-semibold">Atualizações Gratuitas</span>
                        </div>
                        <div class="flex items-center gap-3 p-4 bg-pink-50 rounded-xl">
                            <div class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center text-white">✓</div>
                            <span class="font-semibold">Dados Seguros</span>
                        </div>
                    </div>

                    <a href="#demo" class="block mt-8 px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl font-bold text-center hover:shadow-xl transform hover:scale-105 transition">
                        Começar Agora Grátis
                    </a>
                </div>

                <!-- Decoration -->
                <div class="absolute -bottom-6 -right-6 w-40 h-40 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full blur-3xl opacity-20 -z-10"></div>
                <div class="absolute -top-6 -left-6 w-32 h-32 bg-gradient-to-br from-blue-600 to-purple-600 rounded-full blur-3xl opacity-20 -z-10"></div>
            </div>
        </div>

        <!-- Detalhes do Sistema -->
        <div class="bg-gradient-to-br from-purple-600 to-pink-600 rounded-3xl p-12 text-white">
            <div class="text-center mb-12">
                <h3 class="text-3xl md:text-4xl font-black mb-4">O que você pode fazer com o sistema?</h3>
                <p class="text-purple-100 text-lg">Veja alguns exemplos práticos do dia a dia</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                $examples = [
                    ['title' => 'Cliente agenda online', 'desc' => 'Escolhe serviço, data e horário disponível sem precisar ligar ou mandar mensagem'],
                    ['title' => 'Você confirma ou ajusta', 'desc' => 'Recebe notificação, confirma ou sugere outro horário pelo painel'],
                    ['title' => 'Lembretes automáticos', 'desc' => 'Sistema envia e-mail 24h e 3h antes para evitar faltas'],
                    ['title' => 'Cliente chega', 'desc' => 'Marca como "Atendido" e registra pagamento no centro financeiro'],
                    ['title' => 'Gera feedback', 'desc' => 'Envia link de avaliação. Cliente responde e você aprova para mostrar publicamente'],
                    ['title' => 'Acumula pontos', 'desc' => 'Cliente ganha pontos de fidelidade automaticamente e pode trocar por descontos']
                ];
                @endphp

                @foreach($examples as $example)
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition">
                    <h4 class="font-bold text-lg mb-2">{{ $example['title'] }}</h4>
                    <p class="text-purple-100 text-sm">{{ $example['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

