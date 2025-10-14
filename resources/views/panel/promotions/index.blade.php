@extends('panel.layout')

@section('title', 'Promoções e Pacotes')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">🎉 Promoções e Pacotes</h1>
            <p class="text-gray-600 mt-2">Crie ofertas especiais e envie para seus clientes segmentados</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('panel.promotions.segments') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                👥 Segmentos
            </a>
            <a href="{{ route('panel.promotions.create') }}" class="px-4 py-2 bg-gradient-to-r from-pink-600 to-orange-600 text-white rounded-lg hover:shadow-lg transition font-semibold">
                + Nova Promoção
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-2 border-green-200 text-green-800 px-6 py-4 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <!-- Promoções -->
    @if($promotions->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
            </svg>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Nenhuma promoção criada ainda</h3>
            <p class="text-gray-600 mb-6">Comece criando sua primeira promoção para atrair mais clientes!</p>
            <a href="{{ route('panel.promotions.create') }}" class="inline-block px-8 py-4 bg-gradient-to-r from-pink-600 to-orange-600 text-white rounded-lg hover:shadow-lg transform hover:scale-105 transition font-semibold">
                Criar Primeira Promoção
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($promotions as $promotion)
                <div class="bg-white rounded-2xl shadow-sm border-2 {{ $promotion->active ? 'border-green-300' : 'border-gray-200' }} overflow-hidden hover:shadow-lg transition">
                    <!-- Header com código -->
                    <div class="bg-gradient-to-r {{ $promotion->active ? 'from-green-500 to-emerald-600' : 'from-gray-400 to-gray-500' }} px-6 py-4">
                        <div class="flex justify-between items-center">
                            <span class="px-3 py-1 bg-white/20 rounded-lg text-white font-mono font-bold text-lg backdrop-blur-sm">
                                {{ $promotion->promo_code }}
                            </span>
                            <span class="px-3 py-1 bg-white/20 rounded-lg text-white text-xs font-semibold backdrop-blur-sm uppercase">
                                {{ $promotion->type === 'discount' ? 'Desconto' : ($promotion->type === 'package' ? 'Pacote' : ($promotion->type === 'bonus_points' ? 'Pontos' : 'Grátis')) }}
                            </span>
                        </div>
                    </div>

                    <!-- Conteúdo -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $promotion->name }}</h3>
                        @if($promotion->description)
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($promotion->description, 80) }}</p>
                        @endif

                        <!-- Valor do desconto -->
                        <div class="mb-4">
                            <div class="inline-flex items-center px-4 py-2 bg-orange-100 text-orange-800 rounded-lg font-bold text-lg">
                                @if($promotion->discount_percentage)
                                    {{ $promotion->discount_percentage }}% OFF
                                @elseif($promotion->discount_fixed)
                                    R$ {{ number_format($promotion->discount_fixed, 2, ',', '.') }} OFF
                                @elseif($promotion->bonus_points)
                                    +{{ $promotion->bonus_points }} pontos
                                @else
                                    Serviço Grátis
                                @endif
                            </div>
                        </div>

                        <!-- Informações -->
                        <div class="space-y-2 text-sm mb-4">
                            <div class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ \Carbon\Carbon::parse($promotion->valid_from)->format('d/m/Y') }} - 
                                {{ \Carbon\Carbon::parse($promotion->valid_until)->format('d/m/Y') }}
                            </div>
                            
                            @if($promotion->max_uses)
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    {{ $promotion->current_uses ?? 0 }}/{{ $promotion->max_uses }} usos
                                </div>
                            @endif

                            @if($promotion->service_ids && count($promotion->service_ids) > 0)
                                <div class="flex items-start text-gray-600">
                                    <svg class="w-4 h-4 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                    <span>{{ count($promotion->service_ids) }} serviço(s)</span>
                                </div>
                            @endif
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            @php
                                $now = now();
                                $validFrom = \Carbon\Carbon::parse($promotion->valid_from);
                                $validUntil = \Carbon\Carbon::parse($promotion->valid_until);
                            @endphp
                            
                            @if(!$promotion->active)
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-200 text-gray-700 text-xs font-semibold">
                                    ⏸️ Pausada
                                </span>
                            @elseif($now < $validFrom)
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-200 text-blue-800 text-xs font-semibold">
                                    ⏰ Agendada
                                </span>
                            @elseif($now > $validUntil)
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-200 text-red-800 text-xs font-semibold">
                                    ⚠️ Expirada
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-200 text-green-800 text-xs font-semibold">
                                    ✅ Ativa
                                </span>
                            @endif
                        </div>

                        <!-- Ações -->
                        <div class="flex gap-2">
                            <a href="{{ route('panel.promotions.edit', $promotion->id) }}" class="flex-1 px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center text-sm font-semibold">
                                Editar
                            </a>
                            <form action="{{ route('panel.promotions.destroy', $promotion->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Deseja realmente excluir esta promoção?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-semibold">
                                    Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

