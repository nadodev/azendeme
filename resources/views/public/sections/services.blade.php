<!-- Serviços -->
<section id="servicos" class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Nossos Serviços</h3>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Conheça nossos serviços e escolha o que melhor atende suas necessidades</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($services as $service)
                <div class="service-card bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all overflow-hidden group">
                    <div class="p-8">
                        <div class="w-16 h-16 rounded-2xl mb-6 flex items-center justify-center text-3xl shadow-lg group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, var(--brand) 0%, var(--brand-light) 100%)">
                            💇
                        </div>
                        <h4 class="text-2xl font-bold text-gray-900 mb-3">{{ $service->name }}</h4>
                        <p class="text-gray-600 mb-6 leading-relaxed">{{ $service->description }}</p>
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-semibold">{{ $service->duration }} min</span>
                            </div>
                            <div class="text-2xl font-bold" style="color: var(--brand)">
                                R$ {{ number_format($service->price, 2, ',', '.') }}
                            </div>
                        </div>
                        <a href="#agendar" class="block w-full text-center px-6 py-3 rounded-xl font-bold text-white shadow-lg hover:shadow-xl transition-all hover:scale-105" style="background: var(--brand)" onclick="selectService({{ $service->id }})">
                            Agendar Este Serviço
                            <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
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
    </div>
</section>

