<!-- Preços -->
<section id="precos" class="py-24 bg-gradient-to-br from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-block px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold mb-4">
                💰 Planos e Preços
            </div>
            <h2 class="text-4xl md:text-5xl font-black mb-4">
                Escolha o plano
                <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">perfeito para você</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Comece gratuitamente e evolua conforme seu negócio cresce
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @php
                $plans = config('plans');
                $planOrder = ['free', 'premium', 'master'];
            @endphp
            
            @foreach($planOrder as $planKey)
                @php
                    $plan = $plans[$planKey];
                    $isPopular = $planKey === 'premium';
                    $isFree = $planKey === 'free';
                @endphp
                <!-- Plano {{ ucfirst($planKey) }} -->
                <div class="{{ $isPopular ? 'bg-gradient-to-br from-purple-600 to-pink-600 rounded-3xl p-8 border-2 border-purple-600 shadow-2xl transform scale-105 relative' : 'bg-white rounded-3xl p-8 border-2 border-gray-200 hover:border-purple-300 hover:shadow-xl transition-all' }}">
                    @if($isPopular)
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 px-4 py-1 bg-yellow-400 text-yellow-900 rounded-full text-sm font-black">
                    MAIS POPULAR
                </div>
                    @endif
                    
                    <div class="text-center mb-8 {{ $isPopular ? 'text-white' : '' }}">
                        <div class="inline-block p-4 {{ $isPopular ? 'bg-white/20' : 'bg-gray-100' }} rounded-2xl mb-4">
                            <span class="text-4xl">
                                @if($planKey === 'free') 🚀
                                @elseif($planKey === 'premium') ⭐
                                @else 🏢
                                @endif
                            </span>
                    </div>
                        <h3 class="text-2xl font-black mb-2">{{ $plan['name'] }}</h3>
                        <p class="{{ $isPopular ? 'text-purple-100' : 'text-gray-600' }} mb-6">
                            @if($planKey === 'free') Perfeito para começar
                            @elseif($planKey === 'premium') Para negócios em crescimento
                            @else Para grandes equipes
                            @endif
                        </p>
                    <div class="mb-6">
                            <span class="text-5xl font-black {{ $isPopular ? '' : 'text-gray-900' }}">
                                @if($isFree)
                                    Grátis
                                @else
                                    R$ {{ number_format($plan['price'], 0, ',', '.') }}
                                @endif
                            </span>
                            @if(!$isFree)
                                <span class="{{ $isPopular ? 'text-lg' : 'text-lg text-gray-600' }}">/mês</span>
                            @endif
                </div>
                
                        @if($isFree)
                            <a href="{{ url('/registrar') }}" class="block w-full px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl font-bold hover:shadow-lg transform hover:scale-105 transition">
                                🚀 Começar Grátis
                            </a>
                        @else
                            <a href="{{ url('/registrar') }}" class="block w-full px-6 py-4 {{ $isPopular ? 'bg-white text-purple-600 hover:bg-gray-100' : 'bg-gradient-to-r from-purple-600 to-pink-600 text-white hover:shadow-lg' }} rounded-xl font-bold transition">
                                💳 Começar Agora
                            </a>
                        @endif
                    </div>
                    
                    <!-- Limites do Plano -->
                    <div class="space-y-4 {{ $isPopular ? 'text-white' : '' }}">
                        @foreach($plan['limits'] as $limit => $value)
                    <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 {{ $isPopular ? 'text-yellow-300' : 'text-green-500' }} shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="{{ $isPopular ? '' : 'text-gray-700' }}">
                                    <strong>{{ config('plans.limit_labels.' . $limit, ucfirst(str_replace('_', ' ', $limit))) }}:</strong> {{ $value }}
                                </span>
                    </div>
                        @endforeach
                    </div>
                    
                    <!-- Features do Plano -->
                    @if(!empty($plan['features']))
                        <div class="mt-6 pt-6 border-t {{ $isPopular ? 'border-white/20' : 'border-gray-200' }}">
                            <h4 class="font-bold mb-3 {{ $isPopular ? 'text-white' : 'text-gray-900' }}">Recursos inclusos:</h4>
                            <div class="space-y-2">
                                @foreach($plan['features'] as $feature)
                                    <div class="flex items-start gap-2">
                                        <svg class="w-4 h-4 {{ $isPopular ? 'text-yellow-300' : 'text-green-500' }} shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-sm {{ $isPopular ? 'text-purple-100' : 'text-gray-600' }}">{{ $feature }}</span>
                    </div>
                                @endforeach
                    </div>
                </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- FAQ de Preços -->
        <div class="mt-20 max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h3 class="text-3xl md:text-4xl font-black mb-4">
                    Perguntas Frequentes sobre
                    <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Preços</span>
                </h3>
                <p class="text-lg text-gray-600">Tire suas dúvidas sobre nossos planos e funcionalidades</p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-purple-200 transition">
                    <h4 class="font-bold text-lg mb-3 flex items-center gap-2">
                        <span class="text-2xl">💳</span>
                        Quais formas de pagamento aceitam?
                    </h4>
                    <p class="text-gray-600">Aceitamos cartão de crédito (Visa, Mastercard, Amex) através do Stripe, com total segurança e criptografia.</p>
                </div>
                
                <div class="bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-purple-200 transition">
                    <h4 class="font-bold text-lg mb-3 flex items-center gap-2">
                        <span class="text-2xl">🔄</span>
                        Posso mudar de plano depois?
                    </h4>
                    <p class="text-gray-600">Sim! Você pode fazer upgrade ou downgrade a qualquer momento. As mudanças são aplicadas imediatamente.</p>
                </div>
                
                <div class="bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-purple-200 transition">
                    <h4 class="font-bold text-lg mb-3 flex items-center gap-2">
                        <span class="text-2xl">🚀</span>
                        O plano gratuito tem limitações?
                    </h4>
                    <p class="text-gray-600">O plano gratuito inclui 4 serviços, 1 funcionário, 10 agendamentos/mês, 20MB de armazenamento e 5 clientes.</p>
                </div>
                
                <div class="bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-purple-200 transition">
                    <h4 class="font-bold text-lg mb-3 flex items-center gap-2">
                        <span class="text-2xl">❌</span>
                        Posso cancelar a qualquer momento?
                    </h4>
                    <p class="text-gray-600">Sim, sem multas ou taxas. Você pode cancelar quando quiser e manter o acesso até o fim do período pago.</p>
                </div>
                
                <div class="bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-purple-200 transition">
                    <h4 class="font-bold text-lg mb-3 flex items-center gap-2">
                        <span class="text-2xl">📱</span>
                        Posso personalizar com minha marca?
                    </h4>
                    <p class="text-gray-600">Sim! Todos os planos incluem personalização completa com suas cores, logo e informações do negócio.</p>
                </div>
                
                <div class="bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-purple-200 transition">
                    <h4 class="font-bold text-lg mb-3 flex items-center gap-2">
                        <span class="text-2xl">🆘</span>
                        Tem suporte técnico?
                    </h4>
                    <p class="text-gray-600">Oferecemos suporte por e-mail para todos os planos. Planos pagos têm prioridade no atendimento.</p>
                </div>
            </div>
        </div>
    </div>
</section>

