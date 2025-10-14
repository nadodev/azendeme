<!-- Sobre / Contato -->
<section id="contato" class="py-20" style="background: var(--gallery-bg, #F9FAFB)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-6 py-3 rounded-full text-sm font-semibold mb-6 shadow-lg" style="background: var(--gallery-primary, #EC4899)20; color: var(--gallery-primary, #EC4899); border: 1px solid var(--gallery-primary, #EC4899)30">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
                </svg>
                Conheça Nossa História
            </div>
            <h3 class="text-4xl lg:text-6xl font-extrabold mb-6" style="color: var(--text, #1F2937)">Sobre Nós</h3>
            <p class="text-xl lg:text-2xl max-w-3xl mx-auto leading-relaxed" style="color: var(--text, #1F2937); opacity: 0.8">
                Profissionais dedicados em transformar sua beleza natural com excelência e cuidado
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Conteúdo -->
            <div class="space-y-8">
                <div class="rounded-2xl p-8 shadow-lg border" style="background: var(--background, #FFFFFF); border-color: var(--gallery-primary, #EC4899)20;">
                    <div class="flex items-start space-x-4">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-lg" style="background: linear-gradient(135deg, var(--gallery-primary, #EC4899) 0%, var(--accent, #7C3AED) 100%)">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-2xl font-bold mb-3" style="color: var(--text, #1F2937)">Nossa Missão</h4>
                            <p class="leading-relaxed text-lg" style="color: var(--text, #1F2937); opacity: 0.9">
                                {{ $professional->bio ?? 'Especializada em design de sobrancelhas, micropigmentação e cílios. Mais de 10 anos de experiência transformando a beleza natural das minhas clientes.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Informações de Contato -->
                <div class="grid md:grid-cols-2 gap-6">
                    @if($professional->phone)
                        <div class="rounded-xl p-6 shadow-lg border hover:shadow-xl transition-all duration-300 group" style="background: var(--background, #FFFFFF); border-color: var(--gallery-primary, #EC4899)20;">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform" style="background: var(--gallery-primary, #EC4899)">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium" style="color: var(--text, #1F2937); opacity: 0.8">Telefone</p>
                                    <p class="text-lg font-bold" style="color: var(--text, #1F2937)">{{ $professional->phone }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($professional->email)
                        <div class="rounded-xl p-6 shadow-lg border hover:shadow-xl transition-all duration-300 group" style="background: var(--background, #FFFFFF); border-color: var(--gallery-primary, #EC4899)20;">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform" style="background: var(--gallery-primary, #EC4899)">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium" style="color: var(--text, #1F2937); opacity: 0.8">E-mail</p>
                                    <p class="text-lg font-bold" style="color: var(--text, #1F2937)">{{ $professional->email }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Botão de Agendamento -->
                <div class="text-center">
                    <a href="#agendar" class="inline-flex items-center px-8 py-4 rounded-2xl text-white font-bold text-lg shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105" style="background: linear-gradient(135deg, var(--gallery-primary, #EC4899) 0%, var(--accent, #7C3AED) 100%)">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Agendar Agora
                        <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Imagem da Seção Sobre Nós -->
            <div class="relative">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                    @if($professional->templateSetting && $professional->templateSetting->about_image)
                        <img src="{{ asset('storage/' . $professional->templateSetting->about_image) }}" alt="{{ $professional->name }}" class="w-full h-96 object-cover">
                    @elseif($professional->logo)
                        <img src="{{ asset('storage/' . $professional->logo) }}" alt="{{ $professional->name }}" class="w-full h-96 object-cover">
                    @else
                        <div class="w-full h-96 flex items-center justify-center text-white text-9xl font-bold" style="background: linear-gradient(135deg, var(--gallery-primary, #EC4899) 0%, var(--accent, #7C3AED) 100%)">
                            {{ substr($professional->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
                
                <!-- Decoração -->
                <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full opacity-20" style="background: var(--gallery-primary, #EC4899)"></div>
                <div class="absolute -bottom-6 -left-6 w-32 h-32 rounded-full opacity-10" style="background: var(--accent, #7C3AED)"></div>
            </div>
        </div>
    </div>
</section>

