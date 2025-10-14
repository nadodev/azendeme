<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>aZendame — Agendamento online em minutos | Sistema de agendamentos para profissionais</title>
    <meta name="description" content="Agendamentos 24/7 para salões, maquiadores, tatuadores e barbearias. Páginas lindas, lembretes e relatórios. Demonstração gratuita.">
    <link rel="canonical" href="{{ url('/fase3/marketing') }}">
    <meta name="robots" content="index,follow,max-image-preview:large">
    <meta name="author" content="aZendame">
    <meta name="theme-color" content="#2563EB">
    <meta name="keywords" content="agendamento online,sistema de agendamentos,salão de beleza,maquiagem,tatuagem,barbearia,agenda online,lembretes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.favicon')
    @vite(['resources/css/app.css','resources/js/app.js'])
    <meta property="og:type" content="website">
    <meta property="og:title" content="aZendame — Agendamento online em minutos">
    <meta property="og:description" content="Clientes marcando. Você lucrando. Converta mais com sua página de agendamentos.">
    <meta property="og:url" content="{{ url('/fase3/marketing') }}">
    <meta property="og:site_name" content="aZendame">
    <meta property="og:image" content="{{ asset('og-image.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="aZendame — Agendamento online em minutos">
    <meta name="twitter:description" content="Clientes marcando. Você lucrando. Demonstração gratuita.">
    <meta name="twitter:image" content="{{ asset('og-image.jpg') }}">
    @php
        $ldOrg = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'aZendame',
            'url' => url('/'),
            'logo' => asset('favicon-16x16.png'),
        ];
        $ldSite = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'aZendame',
            'url' => url('/'),
        ];
        $ldFaq = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => [
                [
                    '@type' => 'Question',
                    'name' => 'Como o aZendame ajuda a receber mais clientes?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Você recebe uma página profissional para agendamentos 24/7, com lembretes e relatórios.'
                    ]
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Posso testar gratuitamente?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Sim. Clique em Demonstração Gratuita e fale com nosso time para ativarmos sua conta demo.'
                    ]
                ]
            ]
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($ldOrg, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
    <script type="application/ld+json">{!! json_encode($ldSite, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
    <script type="application/ld+json">{!! json_encode($ldFaq, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
</head>
<body class="bg-gray-50 text-gray-900">
    <!-- HERO DE VENDAS -->
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_10%_0%,rgba(59,130,246,.15),transparent_40%),radial-gradient(circle_at_90%_20%,rgba(168,85,247,.18),transparent_45%),radial-gradient(circle_at_50%_100%,rgba(236,72,153,.15),transparent_45%)]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16 relative">
            <header class="flex items-center justify-between mb-10" role="banner">
                <a href="/" class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600 rounded-xl flex items-center justify-center shadow">
                        <img src="{{ asset('favicon-16x16.png') }}" alt="aZendeMe" class="w-8 h-8">
                    </div>
                    <span class="text-xl font-black bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">aZendeMe</span>
                </a>
                <nav class="hidden md:flex items-center gap-6">
                    <a href="#beneficios" class="text-gray-700 hover:text-purple-600 font-medium">Benefícios</a>
                    <a href="#recursos" class="text-gray-700 hover:text-purple-600 font-medium">Recursos</a>
                    <a href="#precos" class="text-gray-700 hover:text-purple-600 font-medium">Preços</a>
                    <a href="{{ route('sobre') }}" class="text-gray-700 hover:text-purple-600 font-medium">sobre</a>
                    <a href="#faq" class="text-gray-700 hover:text-purple-600 font-medium">FAQ</a>
                </nav>
                <a href="#demo" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg" aria-label="Solicitar demonstração gratuita">Demonstração Gratuita</a>
            </header>

            <div class="grid lg:grid-cols-2 gap-10 items-center">
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-purple-100 text-purple-700 font-semibold text-sm mb-5">Para Salões • Maquiagem • Tatuagem • Barbearia</div>
                    <h1 class="text-5xl md:text-6xl font-black leading-tight mb-5">A página de agendamento que <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">enche sua agenda</span>.</h1>
                    <p class="text-xl text-gray-700 mb-8">Em minutos no ar. Seus clientes marcam 24/7. Você foca em atender e lucrar.</p>
                    <ul class="space-y-3 text-gray-700 mb-8">
                        <li class="flex items-start gap-3"><span>✅</span> Visual premium com sua marca e cores</li>
                        <li class="flex items-start gap-3"><span>✅</span> Link para WhatsApp, Instagram e Google</li>
                        <li class="flex items-start gap-3"><span>✅</span> Lembretes, relatórios e suporte humano</li>
                    </ul>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#demo" class="px-8 py-4 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white rounded-xl font-bold text-lg hover:shadow-2xl">Quero Vender Mais</a>
                        <a href="/landing-new#templates" class="px-8 py-4 bg-white border-2 border-purple-600 text-purple-600 rounded-xl font-bold text-lg hover:bg-purple-50">Ver Templates</a>
                    </div>
                    <div class="mt-6 text-sm text-gray-500">Sem cartão. Sem compromisso.</div>
                </div>

                <!-- Mosaico Chamativo -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 rounded-2xl p-6 h-40 md:h-48 bg-gradient-to-br from-pink-500 to-rose-500 text-white shadow-xl">
                        <div class="text-2xl font-extrabold">Salão & Maquiagem</div>
                        <div class="opacity-90">Agenda cheia sem mensagens</div>
                    </div>
                    <div class="rounded-2xl p-6 h-40 bg-gradient-to-br from-blue-600 to-indigo-600 text-white shadow-xl">
                        <div class="text-2xl font-extrabold">Barbearia</div>
                        <div class="opacity-90">Fila organizada e fidelização</div>
                    </div>
                    <div class="rounded-2xl p-6 h-40 bg-gradient-to-br from-purple-600 to-fuchsia-600 text-white shadow-xl">
                        <div class="text-2xl font-extrabold">Tatuagem</div>
                        <div class="opacity-90">Consultas e aprovações rápidas</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefícios -->
    <section class="py-20" aria-labelledby="beneficios">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 id="beneficios" class="text-4xl md:text-5xl font-black mb-4">Por que escolher o aZendame?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">A solução completa que transforma sua forma de trabalhar e faz seu negócio crescer exponencialmente</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="group bg-white rounded-3xl border border-gray-200 p-8 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center text-white text-2xl mb-6 group-hover:scale-110 transition-transform">🗓️</div>
                    <h3 class="font-bold text-2xl mb-4 text-gray-900">Organização Total</h3>
                    <p class="text-gray-600 text-lg leading-relaxed">Agenda clara e sem conflitos. Visualize horários, confirme e cancele em um clique. Nunca mais perca um agendamento.</p>
                    <div class="mt-6 flex items-center text-blue-600 font-semibold">
                        <span>Saiba mais</span>
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
                <div class="group bg-white rounded-3xl border border-gray-200 p-8 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center text-white text-2xl mb-6 group-hover:scale-110 transition-transform">⚡</div>
                    <h3 class="font-bold text-2xl mb-4 text-gray-900">Agilidade Máxima</h3>
                    <p class="text-gray-600 text-lg leading-relaxed">Receba agendamentos 24/7 e reduza o tempo com mensagens e ligações. Foque no que realmente importa: atender bem.</p>
                    <div class="mt-6 flex items-center text-purple-600 font-semibold">
                        <span>Saiba mais</span>
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
                <div class="group bg-white rounded-3xl border border-gray-200 p-8 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl flex items-center justify-center text-white text-2xl mb-6 group-hover:scale-110 transition-transform">📈</div>
                    <h3 class="font-bold text-2xl mb-4 text-gray-900">Mais Clientes</h3>
                    <p class="text-gray-600 text-lg leading-relaxed">Página linda com seu nome e cores. Experiência de agendamento que converte visitantes em clientes fiéis.</p>
                    <div class="mt-6 flex items-center text-pink-600 font-semibold">
                        <span>Saiba mais</span>
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Depoimentos -->
    <section class="py-20 bg-gradient-to-br from-gray-50 to-white" aria-labelledby="depoimentos">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 id="depoimentos" class="text-4xl md:text-5xl font-black mb-4">Resultados reais de quem usa</h2>
                <p class="text-xl text-gray-600">Veja como o aZendame está transformando negócios todos os dias</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="group bg-white rounded-3xl border border-gray-200 p-8 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-pink-400 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-lg">M</div>
                        <div class="ml-4">
                            <div class="font-bold text-lg">Maria Silva</div>
                            <div class="text-sm text-gray-500">Salão de Beleza</div>
                        </div>
                    </div>
                    <div class="text-4xl text-yellow-400 mb-4">⭐⭐⭐⭐⭐</div>
                    <p class="text-gray-700 text-lg leading-relaxed mb-6">"Comecei ontem e já recebi 6 agendamentos sem responder mensagens. Meus clientes adoram a praticidade!"</p>
                    <div class="bg-green-50 rounded-xl p-4">
                        <div class="text-sm font-semibold text-green-800">+300% agendamentos</div>
                        <div class="text-xs text-green-600">em apenas 1 semana</div>
                    </div>
                </div>
                <div class="group bg-white rounded-3xl border border-gray-200 p-8 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-500 rounded-full flex items-center justify-center text-white font-bold text-lg">J</div>
                        <div class="ml-4">
                            <div class="font-bold text-lg">João Santos</div>
                            <div class="text-sm text-gray-500">Barbearia</div>
                        </div>
                    </div>
                    <div class="text-4xl text-yellow-400 mb-4">⭐⭐⭐⭐⭐</div>
                    <p class="text-gray-700 text-lg leading-relaxed mb-6">"Minha agenda ficou organizada e os clientes adoram a praticidade. Nunca mais confusão de horários!"</p>
                    <div class="bg-blue-50 rounded-xl p-4">
                        <div class="text-sm font-semibold text-blue-800">-80% tempo</div>
                        <div class="text-xs text-blue-600">organizando agenda</div>
                    </div>
                </div>
                <div class="group bg-white rounded-3xl border border-gray-200 p-8 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-lg">A</div>
                        <div class="ml-4">
                            <div class="font-bold text-lg">Ana Costa</div>
                            <div class="text-sm text-gray-500">Tatuadora</div>
                        </div>
                    </div>
                    <div class="text-4xl text-yellow-400 mb-4">⭐⭐⭐⭐⭐</div>
                    <p class="text-gray-700 text-lg leading-relaxed mb-6">"A página personalizada elevou minha marca. Muito lindo e simples. Meus clientes ficam impressionados!"</p>
                    <div class="bg-purple-50 rounded-xl p-4">
                        <div class="text-sm font-semibold text-purple-800">+150% conversão</div>
                        <div class="text-xs text-purple-600">de visitantes em clientes</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Comparativo -->
    <section class="py-20 bg-white" aria-labelledby="comparativo">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 id="comparativo" class="text-4xl md:text-5xl font-black mb-4">Por que somos diferentes?</h2>
                <p class="text-xl text-gray-600">Veja como o aZendame se destaca da concorrência</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center text-white text-2xl mx-auto mb-4">🎨</div>
                    <h3 class="font-bold text-lg mb-2">Visual Personalizado</h3>
                    <p class="text-gray-600 text-sm">Templates únicos para cada segmento</p>
                    <div class="mt-4">
                        <div class="text-green-600 font-bold">aZendame: ✅</div>
                        <div class="text-red-500 text-sm">Concorrentes: ⚠️ Limitado</div>
                    </div>
                </div>
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center text-white text-2xl mx-auto mb-4">💎</div>
                    <h3 class="font-bold text-lg mb-2">Experiência Premium</h3>
                    <p class="text-gray-600 text-sm">Interface moderna e intuitiva</p>
                    <div class="mt-4">
                        <div class="text-green-600 font-bold">aZendame: ✅</div>
                        <div class="text-red-500 text-sm">Concorrentes: ⚠️ Genérica</div>
                    </div>
                </div>
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center text-white text-2xl mx-auto mb-4">🤝</div>
                    <h3 class="font-bold text-lg mb-2">Suporte Nacional</h3>
                    <p class="text-gray-600 text-sm">Atendimento humano especializado</p>
                    <div class="mt-4">
                        <div class="text-green-600 font-bold">aZendame: ✅</div>
                        <div class="text-red-500 text-sm">Concorrentes: ⚠️ Demorado</div>
                    </div>
                </div>
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl flex items-center justify-center text-white text-2xl mx-auto mb-4">📊</div>
                    <h3 class="font-bold text-lg mb-2">Analytics Avançado</h3>
                    <p class="text-gray-600 text-sm">Relatórios detalhados e dashboards</p>
                    <div class="mt-4">
                        <div class="text-green-600 font-bold">aZendame: ✅</div>
                        <div class="text-red-500 text-sm">Concorrentes: ⚠️ Básico</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Segmentos (Salão, Maquiagem, Tattoo, Barber) -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-black text-center mb-12">Feito para o seu segmento</h2>
            <div class="grid md:grid-cols-4 gap-6">
                <div class="rounded-2xl border border-gray-200 p-6 text-center">
                    <div class="text-4xl mb-3">💇‍♀️</div>
                    <div class="font-bold">Salão</div>
                    <p class="text-sm text-gray-600">Cabelos, unhas e estética com agenda simples e bonita.</p>
                </div>
                <div class="rounded-2xl border border-gray-200 p-6 text-center">
                    <div class="text-4xl mb-3">💄</div>
                    <div class="font-bold">Maquiagem</div>
                    <p class="text-sm text-gray-600">Propostas e confirmações rápidas para seu evento.</p>
                </div>
                <div class="rounded-2xl border border-gray-200 p-6 text-center">
                    <div class="text-4xl mb-3">🖋️</div>
                    <div class="font-bold">Tatuagem</div>
                    <p class="text-sm text-gray-600">Consultas, sinal e aprovação em um só lugar.</p>
                </div>
                <div class="rounded-2xl border border-gray-200 p-6 text-center">
                    <div class="text-4xl mb-3">🧔</div>
                    <div class="font-bold">Barbearia</div>
                    <p class="text-sm text-gray-600">Fila organizada, horários claros e fidelização.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Como Funciona -->
    <section class="py-20" aria-labelledby="como-funciona">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 id="como-funciona" class="text-4xl font-black mb-3">Como funciona o aZendame</h2>
                <p class="text-lg text-gray-600">Em 3 passos simples, você está vendendo mais</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">1</div>
                    <h3 class="font-bold text-xl mb-2">Configure em minutos</h3>
                    <p class="text-gray-600">Escolha seu template, adicione serviços e horários. Tudo pronto em poucos cliques.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">2</div>
                    <h3 class="font-bold text-xl mb-2">Compartilhe seu link</h3>
                    <p class="text-gray-600">Envie o link da sua página para clientes. Eles agendam 24/7, você recebe notificações.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-rose-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">3</div>
                    <h3 class="font-bold text-xl mb-2">Receba mais clientes</h3>
                    <p class="text-gray-600">Agenda organizada, lembretes automáticos e relatórios que mostram seu crescimento.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Recursos Avançados -->
    <section class="py-20 bg-white" aria-labelledby="recursos">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 id="recursos" class="text-4xl font-black mb-3">Recursos que fazem a diferença</h2>
                <p class="text-lg text-gray-600">Tudo que você precisa para crescer seu negócio</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-gray-50 rounded-2xl p-6">
                    <div class="text-3xl mb-3">📱</div>
                    <h3 class="font-bold text-lg mb-2">Responsivo e rápido</h3>
                    <p class="text-gray-600">Funciona perfeitamente no celular, tablet e computador. Carregamento instantâneo.</p>
                </div>
                <div class="bg-gray-50 rounded-2xl p-6">
                    <div class="text-3xl mb-3">🔔</div>
                    <h3 class="font-bold text-lg mb-2">Lembretes automáticos</h3>
                    <p class="text-gray-600">SMS e WhatsApp para reduzir faltas. Seus clientes nunca esquecem do agendamento.</p>
                </div>
                <div class="bg-gray-50 rounded-2xl p-6">
                    <div class="text-3xl mb-3">📊</div>
                    <h3 class="font-bold text-lg mb-2">Relatórios detalhados</h3>
                    <p class="text-gray-600">Veja quanto faturou, serviços mais procurados e crescimento mensal.</p>
                </div>
                <div class="bg-gray-50 rounded-2xl p-6">
                    <div class="text-3xl mb-3">🎁</div>
                    <h3 class="font-bold text-lg mb-2">Programa de fidelidade</h3>
                    <p class="text-gray-600">Pontos, descontos e promoções. Fidelize clientes e aumente o ticket médio.</p>
                </div>
                <div class="bg-gray-50 rounded-2xl p-6">
                    <div class="text-3xl mb-3">🛡️</div>
                    <h3 class="font-bold text-lg mb-2">Seguro e confiável</h3>
                    <p class="text-gray-600">Dados protegidos, backup automático e suporte técnico especializado.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Captura de Email -->
    <section class="py-20 bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900" aria-labelledby="captura-email">
        <div class="max-w-5xl mx-auto text-center px-4">
            <div class="mb-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-purple-100 text-purple-700 font-semibold text-sm mb-6">📧 Newsletter Exclusiva</div>
                <h2 id="captura-email" class="text-4xl md:text-5xl font-black text-white mb-4">Receba dicas que fazem a diferença</h2>
                <p class="text-xl text-gray-300 mb-8 max-w-3xl mx-auto">Insights exclusivos sobre como aumentar suas vendas, organizar melhor seu negócio e conquistar mais clientes</p>
            </div>
            
            <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8 border border-white/20">
                <form class="max-w-2xl mx-auto" action="#" method="POST" id="email-capture">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-4 mb-6">
                        <input type="text" name="name" placeholder="Seu nome completo" required 
                               class="px-6 py-4 rounded-xl border-0 text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-purple-500 bg-white/90 backdrop-blur-sm">
                        <input type="email" name="email" placeholder="Seu melhor e-mail" required 
                               class="px-6 py-4 rounded-xl border-0 text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-purple-500 bg-white/90 backdrop-blur-sm">
                    </div>
                    <div class="mb-6">
                        <select name="segment" required class="w-full px-6 py-4 rounded-xl border-0 text-gray-900 focus:ring-2 focus:ring-purple-500 bg-white/90 backdrop-blur-sm">
                            <option value="">Selecione seu segmento</option>
                            <option value="salon">Salão de Beleza</option>
                            <option value="makeup">Maquiagem</option>
                            <option value="tattoo">Tatuagem</option>
                            <option value="barber">Barbearia</option>
                            <option value="other">Outro</option>
                        </select>
                    </div>
                    <button type="submit" 
                            class="w-full md:w-auto px-10 py-4 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white rounded-xl font-bold text-lg hover:shadow-2xl transition-all transform hover:scale-105">
                        🚀 Quero receber as dicas
                    </button>
                    <p class="text-sm text-gray-400 mt-4">✅ Sem spam • ✅ Cancele quando quiser • ✅ Dicas práticas toda semana</p>
                </form>
            </div>
            
            <div class="mt-8 grid md:grid-cols-3 gap-6 text-center">
                <div class="text-white">
                    <div class="text-2xl font-bold">500+</div>
                    <div class="text-sm text-gray-300">Profissionais já recebem</div>
                </div>
                <div class="text-white">
                    <div class="text-2xl font-bold">95%</div>
                    <div class="text-sm text-gray-300">Taxa de satisfação</div>
                </div>
                <div class="text-white">
                    <div class="text-2xl font-bold">1x/semana</div>
                    <div class="text-sm text-gray-300">Frequência das dicas</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Preços -->
    <section class="py-20" aria-labelledby="precos">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 id="precos" class="text-4xl font-black mb-3">Planos que cabem no seu bolso</h2>
                <p class="text-lg text-gray-600">Comece grátis e evolua conforme cresce</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Plano Iniciante -->
                <div class="bg-white rounded-2xl border border-gray-200 p-8 relative">
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold mb-2">Iniciante</h3>
                        <div class="text-4xl font-black text-gray-900 mb-1">R$ 79</div>
                        <div class="text-gray-500">/mês</div>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3"><span class="text-green-500">✅</span> Até 50 agendamentos/mês</li>
                        <li class="flex items-center gap-3"><span class="text-green-500">✅</span> 1 profissional</li>
                        <li class="flex items-center gap-3"><span class="text-green-500">✅</span> 2 templates</li>
                        <li class="flex items-center gap-3"><span class="text-green-500">✅</span> Lembretes por e-mail</li>
                        <li class="flex items-center gap-3"><span class="text-green-500">✅</span> Galeria de fotos</li>
                        <li class="flex items-center gap-3"><span class="text-green-500">✅</span> Subdomínio</li>
                    </ul>
                    <a href="https://wa.me/5549999195407?text=Quero%20o%20plano%20Iniciante%20do%20aZendame" target="_blank" 
                       class="w-full block text-center px-6 py-3 bg-gray-900 text-white rounded-xl font-bold hover:bg-gray-800">
                        Começar agora
                    </a>
                </div>

                <!-- Plano Profissional -->
                <div class="bg-white rounded-2xl border-2 border-purple-500 p-8 relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white px-4 py-1 rounded-full text-sm font-bold">Mais Popular</span>
                    </div>
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold mb-2">Profissional</h3>
                        <div class="text-4xl font-black text-gray-900 mb-1">R$ 129</div>
                        <div class="text-gray-500">/mês</div>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3"><span class="text-green-500">✅</span> Agendamentos ilimitados</li>
                        <li class="flex items-center gap-3"><span class="text-green-500">✅</span> Até 4 profissionais</li>
                        <li class="flex items-center gap-3"><span class="text-green-500">✅</span> Todos os 4 templates</li>
                        <li class="flex items-center gap-3"><span class="text-green-500">✅</span> Programa de Fidelidade</li>
                        <li class="flex items-center gap-3"><span class="text-green-500">✅</span> Promoções & Cupons</li>
                        <li class="flex items-center gap-3"><span class="text-green-500">✅</span> Relatórios & Analytics</li>
                        <li class="flex items-center gap-3"><span class="text-green-500">✅</span> Centro Financeiro</li>
                    </ul>
                    <a href="https://wa.me/5549999195407?text=Quero%20o%20plano%20Profissional%20do%20aZendame" target="_blank" 
                       class="w-full block text-center px-6 py-3 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white rounded-xl font-bold hover:shadow-lg">
                        Escolher Profissional
                    </a>
                </div>

                <!-- Plano Enterprise -->
                <div class="bg-white rounded-2xl border border-gray-200 p-8 relative">
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold mb-2">Enterprise</h3>
                        <div class="text-4xl font-black text-gray-900 mb-1">R$ 199</div>
                        <div class="text-gray-500">/mês</div>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3"><span class="text-green-500">✅</span> Tudo do Profissional</li>
                        <li class="flex items-center gap-3"><span class="text-green-500">✅</span> Profissionais ilimitados</li>
                        <li class="flex items-center gap-3"><span class="text-green-500">✅</span> Multi-unidades</li>
                        <li class="flex items-center gap-3"><span class="text-green-500">✅</span> API de integração</li>
                        <li class="flex items-center gap-3"><span class="text-green-500">✅</span> Domínio próprio</li>
                        <li class="flex items-center gap-3"><span class="text-green-500">✅</span> Suporte prioritário 24/7</li>
                        <li class="flex items-center gap-3"><span class="text-green-500">✅</span> Treinamento personalizado</li>
                    </ul>
                    <a href="https://wa.me/5549999195407?text=Quero%20o%20plano%20Enterprise%20do%20aZendame" target="_blank" 
                       class="w-full block text-center px-6 py-3 bg-gray-900 text-white rounded-xl font-bold hover:bg-gray-800">
                        Falar com Vendas
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-20 bg-white" aria-labelledby="faq">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 id="faq" class="text-4xl font-black mb-3">Perguntas frequentes</h2>
                <p class="text-lg text-gray-600">Tire suas dúvidas sobre o aZendame</p>
            </div>
            <div class="space-y-6">
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="font-bold text-lg mb-2">Quanto tempo leva para configurar?</h3>
                    <p class="text-gray-600">Menos de 10 minutos! Você escolhe o template, adiciona seus serviços e horários, e já está recebendo agendamentos.</p>
                </div>
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="font-bold text-lg mb-2">Posso testar antes de pagar?</h3>
                    <p class="text-gray-600">Sim! Oferecemos demonstração gratuita. Você pode testar todas as funcionalidades por 7 dias sem compromisso.</p>
                </div>
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="font-bold text-lg mb-2">Funciona no celular?</h3>
                    <p class="text-gray-600">Perfeitamente! O aZendame é 100% responsivo. Seus clientes agendam pelo celular, tablet ou computador.</p>
                </div>
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="font-bold text-lg mb-2">E se eu precisar de ajuda?</h3>
                    <p class="text-gray-600">Temos suporte humano especializado. WhatsApp, e-mail e chat. Resolvemos suas dúvidas rapidamente.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section id="demo" class="py-20 bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600" aria-labelledby="cta-demo">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h3 id="cta-demo" class="text-3xl md:text-4xl font-black text-white mb-4">Pronto para vender mais?</h3>
            <p class="text-lg text-blue-100 mb-8">Solicite sua demonstração gratuita agora mesmo</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="https://wa.me/5549999195407?text=Quero%20uma%20demonstra%C3%A7%C3%A3o%20do%20aZendame" target="_blank" 
                   class="inline-block px-10 py-4 bg-white text-purple-600 rounded-xl font-bold text-lg hover:shadow-2xl">
                    📱 Falar no WhatsApp
                </a>
                <a href="mailto:contato@azendame.com.br?subject=Quero%20uma%20demonstração%20do%20aZendame" 
                   class="inline-block px-10 py-4 bg-transparent border-2 border-white text-white rounded-xl font-bold text-lg hover:bg-white hover:text-purple-600">
                    ✉️ Enviar E-mail
                </a>
            </div>
            <div class="mt-6 text-sm text-blue-100">Sem cartão. Sem compromisso. Resposta em até 2 horas.</div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600 rounded-xl grid place-content-center">
                            <span class="text-white font-black text-sm">aZ</span>
                        </div>
                        <span class="text-xl font-black">aZendame</span>
                    </div>
                    <p class="text-gray-400">O sistema de agendamentos que faz seu negócio crescer.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Produto</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#beneficios" class="hover:text-white">Benefícios</a></li>
                        <li><a href="#recursos" class="hover:text-white">Recursos</a></li>
                        <li><a href="#precos" class="hover:text-white">Preços</a></li>
                        <li><a href="#faq" class="hover:text-white">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Suporte</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="/ajuda" class="hover:text-white">Central de Ajuda</a></li>
                        <li><a href="https://wa.me/5549999195407" target="_blank" class="hover:text-white">WhatsApp</a></li>
                        <li><a href="mailto:contato@azendame.com.br" class="hover:text-white">E-mail</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Legal</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="/termos" class="hover:text-white">Termos de Uso</a></li>
                        <li><a href="/privacidade" class="hover:text-white">Privacidade</a></li>
                        <li><a href="/cookies" class="hover:text-white">Cookies</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 aZendame. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        // Captura de email
        document.getElementById('email-capture').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = {
                name: formData.get('name'),
                email: formData.get('email'),
                segment: formData.get('segment')
            };
            
            // Aqui você pode integrar com seu sistema de email marketing
            fetch('/api/capture-email', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mostrar mensagem de sucesso mais elegante
                    const button = this.querySelector('button[type="submit"]');
                    const originalText = button.innerHTML;
                    button.innerHTML = '✅ Cadastrado com sucesso!';
                    button.classList.add('bg-green-600');
                    button.classList.remove('from-blue-600', 'via-purple-600', 'to-pink-600');
                    
                    // Limpar formulário
                    this.reset();
                    
                    // Restaurar botão após 3 segundos
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.classList.remove('bg-green-600');
                        button.classList.add('from-blue-600', 'via-purple-600', 'to-pink-600');
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                const button = this.querySelector('button[type="submit"]');
                const originalText = button.innerHTML;
                button.innerHTML = '❌ Erro ao cadastrar';
                button.classList.add('bg-red-600');
                button.classList.remove('from-blue-600', 'via-purple-600', 'to-pink-600');
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('bg-red-600');
                    button.classList.add('from-blue-600', 'via-purple-600', 'to-pink-600');
                }, 3000);
            });
        });

        // Smooth scroll para links internos
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>

