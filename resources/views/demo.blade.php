<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Página do Profissional — Demonstração • AzendaMe</title>
        @vite(['resources/css/app.css','resources/js/app.js'])
    </head>
    <body class="antialiased text-slate-900">
        <header class="sticky top-0 z-40 bg-white/70 backdrop-blur border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-[var(--brand,#6C63FF)] text-white grid place-content-center font-bold">A</div>
                    <span class="font-semibold">Azenda<span class="text-[var(--brand,#6C63FF)]">Me</span></span>
                </a>
                <nav class="hidden md:flex items-center gap-6 text-sm">
                    <a href="#inicio" class="hover:text-[var(--brand,#6C63FF)]">Início</a>
                    <a href="#servicos" class="hover:text-[var(--brand,#6C63FF)]">Serviços</a>
                    <a href="#galeria" class="hover:text-[var(--brand,#6C63FF)]">Galeria</a>
                    <a href="#sobre" class="hover:text-[var(--brand,#6C63FF)]">Sobre</a>
                    <a href="#agendar" class="text-[var(--brand,#6C63FF)]">Agendar</a>
                </nav>
            </div>
        </header>

        <main>
            <section id="inicio" class="bg-gradient-to-b from-indigo-50 to-emerald-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight text-transparent bg-clip-text bg-gradient-to-r from-[var(--brand,#6C63FF)] via-indigo-500 to-emerald-500">Studio Ana — Estética e Bem‑estar</h1>
                        <p class="text-slate-600 mt-4">Especialista em estética facial e corporal com mais de 5 anos de experiência. Nosso foco é o seu bem‑estar.</p>
                        <div class="mt-6 flex gap-3">
                            <a href="#agendar" class="rounded-md px-5 py-3 bg-[var(--brand,#6C63FF)] text-white font-semibold">Agendar agora</a>
                            <a href="/panel" class="rounded-md px-5 py-3 bg-white border border-slate-200 shadow-sm">Ver painel (demo)</a>
                        </div>
                    </div>
                    <div class="rounded-3xl border border-white/60 bg-white/80 backdrop-blur p-6 shadow-[0_30px_80px_-28px_rgba(15,23,42,0.25)]">
                        <div class="aspect-[16/9] w-full rounded-xl bg-slate-100"></div>
                    </div>
                </div>
            </section>
            <section id="servicos" class="py-20 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-bold text-center mb-12">Serviços</h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @php($services = [
                            ['name'=>'Limpeza de Pele','dur'=>'1h','price'=>'R$ 120'],
                            ['name'=>'Massagem Relaxante','dur'=>'45min','price'=>'R$ 90'],
                            ['name'=>'Design de Sobrancelhas','dur'=>'30min','price'=>'R$ 50']
                        ])
                        @endphp
                        @foreach($services as $s)
                        <div class="rounded-xl border border-slate-200 p-4 bg-white">
                            <div class="font-semibold">{{ $s['name'] }}</div>
                            <div class="text-sm text-slate-500 mb-3">{{ $s['dur'] }} • {{ $s['price'] }}</div>
                            <a href="#agendar" class="inline-flex items-center rounded-md px-3 py-2 text-sm bg-[var(--brand,#6C63FF)] text-white">Agendar agora</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <section id="agendar" class="py-20 bg-slate-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-bold text-center mb-12">Agende seu horário</h2>
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <p class="text-sm text-slate-600 mb-4">Demonstração – selecione dia e horário livres e confirme.</p>
                        <div class="grid lg:grid-cols-2 gap-6">
                            <div>
                                <div class="grid grid-cols-7 gap-1 text-center text-xs text-slate-500 mb-2">
                                    <span>Dom</span><span>Seg</span><span>Ter</span><span>Qua</span><span>Qui</span><span>Sex</span><span>Sáb</span>
                                </div>
                                <div class="grid grid-cols-7 gap-1 mb-4">
                                    @for($i=1;$i<=28;$i++)
                                        <button type="button" data-day="{{ $i }}" class="pub-day aspect-square text-sm rounded-md border border-slate-200 hover:border-[var(--brand,#6C63FF)] hover:text-[var(--brand,#6C63FF)] bg-white">{{ $i }}</button>
                                    @endfor
                                </div>
                                <div id="pub-times" class="flex flex-wrap gap-2"></div>
                            </div>
                            <div>
                                <div class="grid gap-3">
                                    <input id="pub-name" class="rounded-md border border-slate-300 px-3 py-2 text-sm" placeholder="Seu nome" />
                                    <input id="pub-phone" class="rounded-md border border-slate-300 px-3 py-2 text-sm" placeholder="Telefone/WhatsApp" />
                                    <textarea id="pub-notes" class="rounded-md border border-slate-300 px-3 py-2 text-sm" rows="3" placeholder="Observações (opcional)"></textarea>
                                    <button id="pub-confirm" class="rounded-md px-4 py-2 bg-[var(--brand,#6C63FF)] text-white text-sm">Confirmar</button>
                                    <p id="pub-msg" class="hidden text-sm text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-md px-3 py-2"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <script>
            (function(){
                const reserved = new Set([2,6,12,20,27]);
                let selDay = null, selTime = null;
                const times = ['09:00','10:00','11:00','14:00','16:00'];
                const dayBtns = Array.from(document.querySelectorAll('.pub-day'));
                const timesWrap = document.getElementById('pub-times');
                const msg = document.getElementById('pub-msg');
                function renderTimes(){
                    timesWrap.innerHTML='';
                    times.forEach(t=>{
                        const b = document.createElement('button');
                        b.textContent = t; b.className='px-3 py-1 rounded-md border border-slate-300 text-sm';
                        b.addEventListener('click',()=>{ selTime=t; Array.from(timesWrap.children).forEach(c=>c.classList.remove('bg-[var(--brand)]','text-white')); b.classList.add('bg-[var(--brand,#6C63FF)]','text-white'); msg.classList.add('hidden'); });
                        timesWrap.appendChild(b);
                    })
                }
                renderTimes();
                dayBtns.forEach(b=>{
                    const d = Number(b.dataset.day);
                    if(reserved.has(d)){ b.style.background='#e5e7eb'; b.style.color='#94a3b8'; b.style.cursor='not-allowed'; b.setAttribute('aria-disabled','true'); }
                    b.addEventListener('click',()=>{ if(reserved.has(d)) return; selDay=d; dayBtns.forEach(x=>{x.style.background=''; x.style.color='';}); b.style.background='rgba(108,99,255,.1)'; b.style.color='var(--brand,#6C63FF)'; msg.classList.add('hidden');});
                })
                document.getElementById('pub-confirm').addEventListener('click',()=>{
                    const name=document.getElementById('pub-name').value.trim();
                    if(!selDay||!selTime||!name){ msg.textContent='Selecione dia, horário e informe seu nome.'; msg.classList.remove('hidden'); return; }
                    msg.textContent='Agendamento de demonstração confirmado para '+selDay+'/08 às '+selTime+' para '+name+'.'; msg.classList.remove('hidden');
                })
            })();
        </script>
    </body>
    </html>


