<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Agende.Me — Seu negócio, sua agenda, seu tempo</title>
        <meta name="description" content="Agendamentos online simples e profissionais. Crie sua conta grátis e organize sua agenda com a sua marca.">
        @vite(['resources/css/app.css','resources/js/app.js'])
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700|inter:400,500,600" rel="stylesheet" />
        <style>
            :root { --brand:#6C63FF; --brand-600:#5a52e6; --accent:#48BB78; }
            html{scroll-behavior:smooth}
            .reveal{opacity:1; transform:none; transition:opacity .6s ease,transform .6s ease}
            .reveal.show{opacity:1; transform:none}
            @keyframes floaty{0%,100%{transform:translateY(0)}50%{transform:translateY(-12px)}}
            @keyframes blob{0%,100%{border-radius:42% 58% 63% 37%/41% 39% 61% 59%}50%{border-radius:58% 42% 35% 65%/60% 62% 38% 40%}}
            @keyframes gradientShift{0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}}
            @keyframes glowPulse{0%,100%{box-shadow:0 0 0 0 rgba(108,99,255,.35)}50%{box-shadow:0 0 40px 8px rgba(108,99,255,.35)}}
            .u-underline{position:relative}
            .u-underline:after{content:"";position:absolute;left:0;bottom:-6px;height:2px;width:100%;background:currentColor;transform:scaleX(0);transform-origin:left;transition:transform .3s ease}
            .u-underline:hover:after{transform:scaleX(1)}
            /* Scroll indicator */
            @keyframes pulseCircle{0%{box-shadow:0 0 0 0 rgba(108,99,255,.45)}70%{box-shadow:0 0 0 14px rgba(108,99,255,0)}100%{box-shadow:0 0 0 0 rgba(108,99,255,0)}}
            @keyframes bounceY{0%,100%{transform:translate(-50%,0)}50%{transform:translate(-50%,6px)}}
            .scroll-indicator{animation:pulseCircle 2.2s ease-out infinite}
            .scroll-indicator svg{position:absolute;left:50%;transform:translateX(-50%);animation:bounceY 1.6s ease-in-out infinite}
            @media (prefers-reduced-motion: reduce){
                *{animation:none!important;transition:none!important}
            }
        </style>
    </head>
    <body class="antialiased text-slate-900">
        <header class="sticky top-0 z-40 bg-white/60 backdrop-blur-xl border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <a href="#inicio" class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-[var(--brand)] text-white grid place-content-center font-bold">A</div>
                    <span class="font-semibold text-slate-900">Agende<span class="text-[var(--brand)]">.Me</span></span>
                </a>
                <nav class="hidden md:flex items-center gap-6 text-sm">
                    <a href="#inicio" class="hover:text-[var(--brand)] u-underline">Início</a>
                    <a href="#recursos" class="hover:text-[var(--brand)] u-underline">Recursos</a>
                    <a href="#demo" class="hover:text-[var(--brand)] u-underline">Demonstração</a>
                    <a href="#planos" class="hover:text-[var(--brand)] u-underline">Planos</a>
                    <a href="#contato" class="hover:text-[var(--brand)] u-underline">Contato</a>
                </nav>
                <div class="flex items-center gap-3">
                    <a href="{{ url('/login') }}" class="hidden sm:inline-block px-4 py-2 text-[var(--brand)] font-medium">Login</a>
                    <a href="{{ url('/register') }}" class="inline-block rounded-md px-4 py-2 bg-[var(--brand)] hover:bg-[var(--brand-600)] text-white font-medium shadow">Testar agora</a>
                </div>
            </div>
        </header>

        <main id="inicio">
            <section class="relative overflow-hidden">
                <div class="absolute inset-0 -z-10 bg-gradient-to-b from-white via-indigo-50 to-emerald-50"></div>
                <div class="absolute inset-x-0 top-[-200px] -z-10 h-[480px] bg-[radial-gradient(60%_60%_at_50%_40%,rgba(108,99,255,0.25),rgba(108,99,255,0)_60%)]"></div>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
                    <div class="grid lg:grid-cols-2 gap-12 items-center">
                        <div class="relative z-10">
                            <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 bg-[var(--brand)]/10 text-[var(--brand)] text-xs font-medium mb-4 ring-1 ring-[var(--brand)]/20">Seu negócio, sua agenda, seu tempo</div>
                            <h1 class="font-extrabold leading-tight text-4xl sm:text-6xl mb-5 text-transparent bg-clip-text bg-gradient-to-r from-[var(--brand)] via-indigo-500 to-emerald-500" style="background-size:200% 200%; animation:gradientShift 8s ease infinite">Agende seus clientes sem complicação.</h1>
                            <p class="text-slate-600 text-lg mb-8">O sistema que organiza sua agenda e impulsiona seu negócio. Agendamentos online com a sua marca, lembretes automáticos e painel simples de usar.</p>
                            <div class="flex items-center gap-4 mb-10">
                                <a href="{{ url('/register') }}" class="inline-flex items-center gap-2 rounded-xl px-6 py-3 bg-[var(--brand)] hover:bg-[var(--brand-600)] text-white font-semibold shadow-lg ring-2 ring-[var(--brand)]/30 hover:ring-[var(--brand)]/50 transition" style="animation:glowPulse 3.5s ease-in-out infinite">Crie sua conta grátis</a>
                                <a href="#demo" class="text-[var(--brand)] font-medium u-underline">Ver demonstração</a>
                            </div>
                            <ul class="grid sm:grid-cols-2 gap-3 text-sm text-slate-700">
                                <li class="flex items-start gap-2"><span class="mt-1 w-5 h-5 rounded-full bg-[var(--accent)]/15 text-[var(--accent)] grid place-content-center">✓</span> Agenda, clientes e comunicação em um só lugar</li>
                                <li class="flex items-start gap-2"><span class="mt-1 w-5 h-5 rounded-full bg-[var(--accent)]/15 text-[var(--accent)] grid place-content-center">✓</span> Personalização white label</li>
                                <li class="flex items-start gap-2"><span class="mt-1 w-5 h-5 rounded-full bg-[var(--accent)]/15 text-[var(--accent)] grid place-content-center">✓</span> Lembretes por e-mail/WhatsApp</li>
                                <li class="flex items-start gap-2"><span class="mt-1 w-5 h-5 rounded-full bg-[var(--accent)]/15 text-[var(--accent)] grid place-content-center">✓</span> Multiusuário para equipes</li>
                            </ul>
                        </div>
                        <div class="relative z-10" id="hero-cal">
                            <div class="rounded-3xl border border-white/60 bg-white/80 backdrop-blur-xl shadow-[0_30px_100px_-30px_rgba(108,99,255,0.35)] p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <h3 class="font-semibold">Calendário</h3>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-medium bg-[var(--brand)]/10 text-[var(--brand)] ring-1 ring-[var(--brand)]/20">Demonstração</span>
                                    </div>
                                    <span class="text-xs text-slate-500">Agende.Me</span>
                                </div>
                                <div class="grid grid-cols-7 gap-1 text-center text-xs text-slate-500 mb-2">
                                    <span>Dom</span><span>Seg</span><span>Ter</span><span>Qua</span><span>Qui</span><span>Sex</span><span>Sáb</span>
                                </div>
                                <div class="grid grid-cols-7 gap-1 mb-6">
                                    @for($i=1;$i<=28;$i++)
                                        <button type="button" data-day="{{ $i }}" class="date-cell aspect-square text-sm rounded-md border border-slate-200 hover:border-[var(--brand)] hover:text-[var(--brand)] bg-white">{{ $i }}</button>
                                    @endfor
                                </div>
                                <form id="mini-booking" class="grid gap-3">
                                    <div class="grid grid-cols-2 gap-3">
                                        <select id="hour" class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm">
                                            <option>09:00</option>
                                            <option>10:00</option>
                                            <option>14:00</option>
                                            <option>16:00</option>
                                        </select>
                                        <input id="name" type="text" placeholder="Seu nome" class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm" />
                                    </div>
                                    <input id="phone" type="tel" placeholder="Telefone" class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm" />
                                    <div class="flex items-center gap-3 flex-wrap">
                                        <button type="button" id="confirm" class="rounded-md px-4 py-2 bg-[var(--accent)] hover:bg-emerald-600 text-white text-sm font-medium shadow">Confirmar agendamento</button>
                                        <div class="flex items-center gap-2 text-xs text-slate-500 ml-auto">
                                            <span class="inline-block w-3 h-3 rounded-full bg-white border border-slate-300"></span> Disponível
                                            <span class="inline-block w-3 h-3 rounded-full bg-slate-200 border border-slate-300 ml-4"></span> Reservado
                                        </div>
                                    </div>
                                    <p id="confirm-msg" class="hidden text-sm text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-md px-3 py-2"></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- scroll indicator -->
            <div class="relative w-full">
                <a href="#demo" class="absolute left-1/2 -translate-x-1/2 mt-4 block w-12 h-12 rounded-full bg-white/80 border border-[var(--brand)]/30 scroll-indicator">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 5v14m0 0l-5-5m5 5l5-5" stroke="rgb(108,99,255)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>

            <!-- Modal de confirmação (hero) -->
            <div id="booking-modal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm">
                <div class="absolute inset-0 grid place-items-center p-4">
                    <div class="w-full max-w-md rounded-2xl bg-white shadow-xl border border-slate-200 p-6">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="font-semibold text-slate-900">Agendamento confirmado</h3>
                            <button id="booking-close" class="text-slate-400 hover:text-slate-600">✕</button>
                        </div>
                        <p class="text-slate-600 text-sm mb-4">Enviamos uma confirmação e enviaremos lembretes automaticamente.</p>
                        <div class="rounded-xl border border-slate-200 p-4 bg-gradient-to-br from-emerald-50 to-white">
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <div class="text-slate-500">Dia</div>
                                    <div id="bm-day" class="font-semibold"></div>
                                </div>
                                <div>
                                    <div class="text-slate-500">Horário</div>
                                    <div id="bm-hour" class="font-semibold"></div>
                                </div>
                                <div class="col-span-2">
                                    <div class="text-slate-500">Cliente</div>
                                    <div id="bm-name" class="font-semibold"></div>
                                </div>
                            </div>
                        </div>
                        <button id="booking-ok" class="mt-5 w-full rounded-md px-4 py-2 bg-[var(--brand)] hover:bg-[var(--brand-600)] text-white text-sm font-medium">Ok, entendi</button>
                    </div>
                </div>
            </div>

            <section id="demo" class="py-24 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center max-w-3xl mx-auto mb-16 reveal">
                        <span class="inline-block mb-3 px-3 py-1 text-xs font-medium rounded-full bg-[var(--brand)]/10 text-[var(--brand)] ring-1 ring-[var(--brand)]/20">Demonstração interativa</span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-[var(--brand)] via-indigo-500 to-emerald-500 mb-2" style="background-size:200% 200%; animation:gradientShift 8s ease infinite">Veja como é fácil agendar com o Agende.Me</h2>
                        <p class="text-slate-600">Escolha o dia, selecione o horário, preencha e receba confirmação. Simples e rápido.</p>
                        <div class="h-1 w-24 mx-auto mt-4 rounded-full bg-gradient-to-r from-[var(--brand)] to-emerald-500"></div>
                    </div>
                    <div class="grid lg:grid-cols-2 gap-12 items-stretch">
                        <div class="reveal">
                            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-[0_20px_60px_-20px_rgba(15,23,42,0.25)]">
                                <div class="flex gap-2 mb-6">
                                    <button class="demo-tab active rounded-full px-4 py-2 text-sm bg-[var(--brand)] text-white" data-panel="reports">Relatórios</button>
                                    <button class="demo-tab rounded-full px-4 py-2 text-sm bg-slate-100 text-slate-700" data-panel="gallery">Galeria</button>
                                    <button class="demo-tab rounded-full px-4 py-2 text-sm bg-slate-100 text-slate-700" data-panel="reminders">Lembretes</button>
                                </div>
                                <div class="demo-panels">
                                    <div class="demo-panel" data-panel="reports">
                                        <div class="rounded-2xl border border-slate-200 p-5 bg-gradient-to-br from-indigo-50 to-white">
                                            <h4 class="font-semibold mb-4">Visão geral</h4>
                                            <div class="grid grid-cols-3 gap-3 mb-4">
                                                <div class="rounded-xl bg-white border border-slate-200 p-3 text-center">
                                                    <div class="text-2xl font-bold text-[var(--brand)]">1.2k</div>
                                                    <div class="text-xs text-slate-500">Agendamentos</div>
                                                </div>
                                                <div class="rounded-xl bg-white border border-slate-200 p-3 text-center">
                                                    <div class="text-2xl font-bold text-emerald-500">98%</div>
                                                    <div class="text-xs text-slate-500">Comparecimentos</div>
                                                </div>
                                                <div class="rounded-xl bg-white border border-slate-200 p-3 text-center">
                                                    <div class="text-2xl font-bold text-indigo-500">+32%</div>
                                                    <div class="text-xs text-slate-500">Crescimento</div>
                                                </div>
                                            </div>
                                            <div class="h-36 grid grid-cols-12 gap-1 items-end">
                                                @for($i=1;$i<=12;$i++)
                                                    <div class="bg-[var(--brand)]/30 rounded-t-md" style="height: {{ 20 + ($i*5)%80 }}%"></div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <div class="demo-panel hidden" data-panel="gallery">
                                        <div class="rounded-2xl border border-slate-200 p-5 bg-gradient-to-br from-emerald-50 to-white">
                                            <h4 class="font-semibold mb-4">Galeria de fotos</h4>
                                            <div class="grid grid-cols-3 gap-3">
                                                @for($i=1;$i<=6;$i++)
                                                    <div class="aspect-square rounded-xl bg-slate-100 overflow-hidden">
                                                        <div class="w-full h-full bg-gradient-to-br from-slate-200 to-white"></div>
                                                    </div>
                                                @endfor
                                            </div>
                                            <p class="text-slate-600 text-sm mt-4">Publique trabalhos, ambientes e resultados para inspirar seus clientes.</p>
                                        </div>
                                    </div>
                                    <div class="demo-panel hidden" data-panel="reminders">
                                        <div class="rounded-2xl border border-slate-200 p-5 bg-gradient-to-br from-sky-50 to-white">
                                            <h4 class="font-semibold mb-4">Lembretes automáticos</h4>
                                            <ul class="grid gap-2 text-sm text-slate-700">
                                                <li>Envio por e-mail e WhatsApp</li>
                                                <li>Janelas configuráveis (24h, 3h, 1h)</li>
                                                <li>Texto personalizável com variáveis</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reveal">
                            <ol class="relative pl-8">
                                <div class="absolute left-2 top-0 bottom-0 w-px bg-gradient-to-b from-[var(--brand)]/40 to-emerald-400/40"></div>
                                <li class="mb-6 group">
                                    <div class="flex items-start gap-4">
                                        <div class="shrink-0 w-8 h-8 rounded-full grid place-content-center bg-[var(--brand)] text-white text-xs font-semibold shadow">1</div>
                                        <div class="rounded-2xl p-5 border border-slate-100 bg-white shadow-[0_8px_30px_-12px_rgba(15,23,42,0.15)] group-hover:-translate-y-0.5 transition">
                                            <h4 class="font-semibold mb-1">Crie sua conta</h4>
                                            <p class="text-slate-600 text-sm">Leva menos de 2 minutos e é grátis para começar.</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-6 group">
                                    <div class="flex items-start gap-4">
                                        <div class="shrink-0 w-8 h-8 rounded-full grid place-content-center bg-emerald-500 text-white text-xs font-semibold shadow">2</div>
                                        <div class="rounded-2xl p-5 border border-slate-100 bg-white shadow-[0_8px_30px_-12px_rgba(15,23,42,0.15)] group-hover:-translate-y-0.5 transition">
                                            <h4 class="font-semibold mb-1">Cadastre serviços</h4>
                                            <p class="text-slate-600 text-sm">Defina agenda, valores e duração dos atendimentos.</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-6 group">
                                    <div class="flex items-start gap-4">
                                        <div class="shrink-0 w-8 h-8 rounded-full grid place-content-center bg-indigo-500 text-white text-xs font-semibold shadow">3</div>
                                        <div class="rounded-2xl p-5 border border-slate-100 bg-white shadow-[0_8px_30px_-12px_rgba(15,23,42,0.15)] group-hover:-translate-y-0.5 transition">
                                            <h4 class="font-semibold mb-1">Compartilhe o link</h4>
                                            <p class="text-slate-600 text-sm">Envie no WhatsApp, Instagram ou site.</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="group">
                                    <div class="flex items-start gap-4">
                                        <div class="shrink-0 w-8 h-8 rounded-full grid place-content-center bg-sky-500 text-white text-xs font-semibold shadow">4</div>
                                        <div class="rounded-2xl p-5 border border-slate-100 bg-white shadow-[0_8px_30px_-12px_rgba(15,23,42,0.15)] group-hover:-translate-y-0.5 transition">
                                            <h4 class="font-semibold mb-1">Receba agendamentos</h4>
                                            <p class="text-slate-600 text-sm">Confirmações automáticas e lembretes para evitar faltas.</p>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section id="recursos" class="py-24 bg-slate-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-bold text-center mb-14 reveal">Recursos e benefícios</h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @php
                        $cards = [
                            ['title'=>'Agendamento Online','desc'=>'Clientes escolhem horários disponíveis sem trocar mensagens.','icon'=>'🗓️'],
                            ['title'=>'Painel Administrativo','desc'=>'Gerencie agenda, serviços e clientes com facilidade.','icon'=>'🧭'],
                            ['title'=>'Link Personalizado','desc'=>'Compartilhe seu link no WhatsApp, Instagram ou site.','icon'=>'🔗'],
                            ['title'=>'Lembretes Automáticos','desc'=>'Reduza faltas com e-mail e WhatsApp.','icon'=>'🔔'],
                            ['title'=>'Personalização White Label','desc'=>'Sua logo, cores e subdomínio próprio.','icon'=>'🎨'],
                            ['title'=>'Multiusuário','desc'=>'Ideal para equipes, clínicas e salões.','icon'=>'👥'],
                        ];
                        @endphp
                        @foreach($cards as $c)
                        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-[0_6px_30px_-10px_rgba(15,23,42,0.2)] hover:-translate-y-1 hover:shadow-[0_18px_50px_-20px_rgba(108,99,255,0.35)] transition-all reveal" data-tilt>
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 grid place-content-center rounded-xl bg-gradient-to-br from-[var(--brand)]/15 to-emerald-400/20 text-2xl">{{ $c['icon'] }}</div>
                                <h3 class="font-semibold text-lg">{{ $c['title'] }}</h3>
                            </div>
                            <p class="text-sm text-slate-600">{{ $c['desc'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <section id="para-quem" class="py-24 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-bold text-center mb-14 reveal">Para quem é o Agende.Me</h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 text-slate-700">
                        @php
                        $targets = [
                            ['txt'=>'Salões de beleza e barbearias','icon'=>'💅'],
                            ['txt'=>'Clínicas estéticas','icon'=>'🧖‍♀️'],
                            ['txt'=>'Consultórios e clínicas médicas','icon'=>'🏥'],
                            ['txt'=>'Estúdios de tatuagem','icon'=>'🎨'],
                            ['txt'=>'Terapeutas, psicólogos, nutricionistas','icon'=>'🧘'],
                            ['txt'=>'Fotógrafos e autônomos','icon'=>'📸'],
                        ];
                        @endphp
                        @foreach($targets as $t)
                        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-[0_6px_30px_-12px_rgba(15,23,42,0.15)] hover:-translate-y-1 transition-all reveal">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 grid place-content-center rounded-xl bg-gradient-to-br from-indigo-50 to-emerald-50 text-xl">{{ $t['icon'] }}</div>
                                <p class="font-medium">{{ $t['txt'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>


            <section id="depoimentos" class="relative py-28 bg-gradient-to-br from-[var(--brand)]/5 via-white to-emerald-50">
                <div class="absolute inset-x-0 -top-16 h-32 bg-gradient-to-b from-white/0 to-white/60 pointer-events-none"></div>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-center mb-3 text-slate-900 reveal">O que nossos clientes dizem</h2>
                    <p class="text-center text-slate-600 mb-12 reveal">Histórias reais de quem já organiza a agenda com o Agende.Me</p>
                    <div class="max-w-4xl mx-auto reveal">
                        <div class="overflow-hidden rounded-3xl border border-white/60 bg-white/90 backdrop-blur shadow-[0_30px_80px_-28px_rgba(15,23,42,0.25)]">
                            <div class="t-track flex transition-transform duration-500" style="transform:translateX(0%)">
                                <div class="t-card shrink-0 w-full p-8">
                                    <div class="flex items-center gap-3 mb-2">
                                        <img alt="Ana" class="w-10 h-10 rounded-full" src="https://i.pravatar.cc/40?img=5"/>
                                        <div>
                                            <div class="font-medium">Ana Paula</div>
                                            <div class="text-xs text-slate-500">Studio de Beleza Ana</div>
                                        </div>
                                    </div>
                                    <div class="text-amber-400 mb-2">★★★★★</div>
                                    <p class="text-slate-700">“Desde que comecei a usar o Agende.Me, parei de perder horários e clientes!”</p>
                                </div>
                                <div class="t-card shrink-0 w-full p-8">
                                    <div class="flex items-center gap-3 mb-2">
                                        <img alt="Lucas" class="w-10 h-10 rounded-full" src="https://i.pravatar.cc/40?img=12"/>
                                        <div>
                                            <div class="font-medium">Lucas Tattoo</div>
                                            <div class="text-xs text-slate-500">São Paulo</div>
                                        </div>
                                    </div>
                                    <div class="text-amber-400 mb-2">★★★★★</div>
                                    <p class="text-slate-700">“O sistema é muito intuitivo, meus clientes amam o link direto no WhatsApp.”</p>
                                </div>
                                <div class="t-card shrink-0 w-full p-8">
                                    <div class="flex items-center gap-3 mb-2">
                                        <img alt="Vitta" class="w-10 h-10 rounded-full" src="https://i.pravatar.cc/40?img=30"/>
                                        <div>
                                            <div class="font-medium">Clínica Vitta</div>
                                            <div class="text-xs text-slate-500">Dermatologia</div>
                                        </div>
                                    </div>
                                    <div class="text-amber-400 mb-2">★★★★★</div>
                                    <p class="text-slate-700">“Ganhamos organização e tempo. Os lembretes reduziram faltas de forma visível.”</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center gap-2 mt-6">
                            <button class="dot w-2.5 h-2.5 rounded-full bg-[var(--brand)]"></button>
                            <button class="dot w-2.5 h-2.5 rounded-full bg-slate-300"></button>
                            <button class="dot w-2.5 h-2.5 rounded-full bg-slate-300"></button>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-20 bg-gradient-to-br from-[var(--brand)] to-indigo-500 text-white text-center">
                <div class="max-w-3xl mx-auto px-4">
                    <h2 class="text-3xl sm:text-4xl font-bold mb-4">Transforme sua agenda em um sistema inteligente.</h2>
                    <p class="text-white/90 mb-8">Experimente o Agende.Me gratuitamente e veja a diferença.</p>
                    <a href="{{ url('/register') }}" class="inline-flex items-center gap-2 rounded-md px-6 py-3 bg-white text-[var(--brand)] font-semibold shadow hover:shadow-md">Crie sua conta agora — é grátis!</a>
                </div>
            </section>
        </main>

        <footer id="contato" class="bg-white border-t border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid md:grid-cols-3 gap-6 text-sm">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-7 h-7 rounded-lg bg-[var(--brand)] text-white grid place-content-center font-bold">A</div>
                        <span class="font-semibold text-slate-900">Agende<span class="text-[var(--brand)]">.Me</span></span>
                    </div>
                    <p class="text-slate-600">© 2025 Agende.Me — Todos os direitos reservados.</p>
                    <p class="text-slate-600">Desenvolvido para facilitar a vida de quem vive de agendamentos.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-2">Links</h4>
                    <ul class="space-y-1 text-slate-600">
                        <li><a href="#planos" class="hover:text-[var(--brand)]">Planos</a></li>
                        <li><a href="#recursos" class="hover:text-[var(--brand)]">Recursos</a></li>
                        <li><a href="#demo" class="hover:text-[var(--brand)]">Demonstração</a></li>
                        <li><a href="#contato" class="hover:text-[var(--brand)]">Contato</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-2">Legal</h4>
                    <ul class="space-y-1 text-slate-600">
                        <li><a href="#" class="hover:text-[var(--brand)]">Termos de uso</a></li>
                        <li><a href="#" class="hover:text-[var(--brand)]">Política de privacidade</a></li>
                        <li><a href="mailto:suporte@agende.me" class="hover:text-[var(--brand)]">suporte@agende.me</a></li>
                    </ul>
                </div>
            </div>
        </footer>

        <script>
            (function(){
                const state = { day: null };
                const reservedDays = new Set([3,7,12,18,26]);
                const dayButtons = Array.from(document.querySelectorAll('#hero-cal .date-cell'));
                dayButtons.forEach(btn=>{
                    const day = Number(btn.getAttribute('data-day')) || Number(btn.textContent.trim());
                    if(reservedDays.has(day)){
                        btn.dataset.state = 'reserved';
                        btn.style.backgroundColor = '#e5e7eb'; // slate-200
                        btn.style.color = '#94a3b8'; // slate-400
                        btn.style.cursor = 'not-allowed';
                        btn.setAttribute('aria-disabled','true');
                    }
                    btn.addEventListener('click', ()=>{
                        if(reservedDays.has(day)) return;
                        // reset all
                        dayButtons.forEach(b=>{
                            if(b.dataset.state !== 'reserved'){
                                b.style.borderColor = '';
                                b.style.color = '';
                                b.style.backgroundColor = '';
                                b.removeAttribute('aria-pressed');
                            }
                        });
                        // highlight selected
                        btn.style.borderColor = 'var(--brand)';
                        btn.style.color = 'var(--brand)';
                        btn.style.backgroundColor = 'rgba(108,99,255,0.10)';
                        btn.setAttribute('aria-pressed','true');
                        state.day = day;
                    });
                });

                // Pré-seleciona o primeiro dia disponível (demonstração)
                if(!state.day){
                    const firstFree = dayButtons.find(b=>!reservedDays.has(Number(b.getAttribute('data-day'))));
                    if(firstFree){
                        firstFree.style.borderColor = 'var(--brand)';
                        firstFree.style.color = 'var(--brand)';
                        firstFree.style.backgroundColor = 'rgba(108,99,255,0.10)';
                        firstFree.setAttribute('aria-pressed','true');
                        state.day = Number(firstFree.getAttribute('data-day'));
                    }
                }
                const confirm = document.getElementById('confirm');
                const msg = document.getElementById('confirm-msg');
                const hourSelect = document.getElementById('hour');
                const nameInput = document.getElementById('name');
                const phoneInput = document.getElementById('phone');

                function hideMsg(){
                    if(!msg) return;
                    msg.classList.add('hidden');
                }
                // Clear message on interactions
                hourSelect?.addEventListener('change', hideMsg);
                nameInput?.addEventListener('input', hideMsg);
                phoneInput?.addEventListener('input', hideMsg);
                confirm?.addEventListener('click', ()=>{
                    const hour = document.getElementById('hour').value;
                    const name = document.getElementById('name').value.trim();
                    const phone = document.getElementById('phone').value.trim();
                    if(!state.day || !hour || !name){
                        msg.classList.remove('hidden');
                        msg.classList.remove('text-emerald-700','bg-emerald-50','border-emerald-200');
                        msg.classList.add('text-red-700','bg-red-50','border-red-200');
                        msg.textContent = 'Selecione um dia disponível, informe o horário e seu nome.';
                        return;
                    }
                    // Open modal confirmation
                    document.getElementById('bm-day').textContent = state.day + '/08';
                    document.getElementById('bm-hour').textContent = hour;
                    document.getElementById('bm-name').textContent = phone ? (name + ' · ' + phone) : name;
                    document.getElementById('booking-modal').classList.remove('hidden');
                });

                // Modal handlers
                const closeModal = ()=> document.getElementById('booking-modal').classList.add('hidden');
                document.getElementById('booking-close')?.addEventListener('click', closeModal);
                document.getElementById('booking-ok')?.addEventListener('click', closeModal);

                // Tilt effect (safe): disabled on touch devices and ignored when hovering inputs/buttons
                (function(){
                    const isTouch = 'ontouchstart' in window || navigator.maxTouchPoints>0;
                    if(isTouch) return;
                    const strength = 10;
                    document.querySelectorAll('[data-tilt]').forEach((el)=>{
                        let raf = null;
                        const update = (e)=>{
                            if(e.target.closest('button, input, select, textarea, a')) return;
                            const r = el.getBoundingClientRect();
                            const px = (e.clientX - r.left) / r.width - 0.5;
                            const py = (e.clientY - r.top) / r.height - 0.5;
                            el.style.transform = 'rotateX(' + (-(py*strength)) + 'deg) rotateY(' + (px*strength) + 'deg)';
                        };
                        el.addEventListener('mousemove',(e)=>{
                            if(raf) cancelAnimationFrame(raf);
                            raf = requestAnimationFrame(()=> update(e));
                        });
                        el.addEventListener('mouseleave',()=>{ el.style.transform = 'rotateX(0) rotateY(0)'; });
                    });
                })();

                // Scroll reveal
                const io = new IntersectionObserver((entries)=>{
                    entries.forEach((entry)=>{
                        if(entry.isIntersecting){ entry.target.classList.add('show'); io.unobserve(entry.target); }
                    });
                },{threshold:0.15});
                document.querySelectorAll('.reveal').forEach((n)=> io.observe(n));

                // Testimonials carousel
                // Simple testimonials track slider
                const track = document.querySelector('.t-track');
                const dots = Array.from(document.querySelectorAll('#depoimentos .dot'));
                let idx = 0;
                function slideTo(i){
                    idx = i;
                    if(track){ track.style.transform = 'translateX(-' + (i*100) + '%)'; }
                    dots.forEach((d,j)=>{ d.classList.toggle('bg-[var(--brand)]', j===i); d.classList.toggle('bg-slate-300', j!==i); });
                }
                dots.forEach((d,i)=> d.addEventListener('click', ()=> slideTo(i)));
                setInterval(()=>{ slideTo((idx+1)%dots.length); }, 4500);
                slideTo(0);

                // Mini calendar interactions (compact mockup)
                // Preview confirmation interactions
                // Demo tabs (reports / gallery / reminders)
                const tabs = Array.from(document.querySelectorAll('.demo-tab'));
                const panels = Array.from(document.querySelectorAll('.demo-panel'));
                function showPanel(key){
                    panels.forEach(p=>{
                        const on = p.getAttribute('data-panel')===key;
                        p.classList.toggle('hidden', !on);
                    });
                    tabs.forEach(t=>{
                        const on = t.getAttribute('data-panel')===key;
                        t.classList.toggle('bg-[var(--brand)]', on);
                        t.classList.toggle('text-white', on);
                        t.classList.toggle('bg-slate-100', !on);
                        t.classList.toggle('text-slate-700', !on);
                    });
                }
                tabs.forEach(t=> t.addEventListener('click',()=> showPanel(t.getAttribute('data-panel'))));
                showPanel('reports');

                // Robust reveal activation for non-hero
                const revealNodes = Array.from(document.querySelectorAll('#demo .reveal, #recursos .reveal, #para-quem .reveal, #planos .reveal, #depoimentos .reveal'));
                const observer = new IntersectionObserver((entries)=>{
                    entries.forEach((entry)=>{
                        if(entry.isIntersecting){ entry.target.classList.add('show'); observer.unobserve(entry.target); }
                    });
                },{threshold:0.15, rootMargin:'0px 0px -10% 0px'});
                revealNodes.forEach(n=>observer.observe(n));
            })();
        </script>
    </body>
    </html>


