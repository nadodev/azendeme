<!-- Sobre / Contato -->
<section id="contato" class="py-20 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="grid md:grid-cols-2">
                <div class="p-10">
                    <h3 class="text-3xl font-bold text-gray-900 mb-6">Sobre Nós</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        {{ $professional->bio ?? 'Somos profissionais dedicados em oferecer os melhores serviços para nossos clientes. Com anos de experiência no mercado, buscamos sempre a excelência e a satisfação de quem confia em nosso trabalho.' }}
                    </p>
                    <div class="space-y-3 mb-8">
                        @if($professional->phone)
                            <div class="flex items-center text-gray-700">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 text-white" style="background: var(--brand)">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <span>{{ $professional->phone }}</span>
                            </div>
                        @endif
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

