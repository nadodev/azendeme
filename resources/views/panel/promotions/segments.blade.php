@extends('panel.layout')

@section('title', 'Segmentos de Clientes')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">👥 Segmentos de Clientes</h1>
            <p class="text-gray-600 mt-2">Análise automática dos seus clientes para campanhas direcionadas</p>
        </div>
        <a href="{{ route('panel.promotions.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
            ← Voltar para Promoções
        </a>
    </div>

    <!-- Segmentos Automáticos -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($segments as $segment)
            <div class="bg-white rounded-2xl shadow-sm border-2 border-gray-200 overflow-hidden hover:shadow-lg transition">
                <div class="bg-gradient-to-r 
                    @if($segment['key'] === 'new') from-blue-600 to-cyan-600
                    @elseif($segment['key'] === 'active') from-green-600 to-emerald-600
                    @elseif($segment['key'] === 'loyal') from-purple-600 to-pink-600
                    @else from-orange-600 to-red-600
                    @endif
                    px-6 py-4">
                    <h3 class="text-xl font-bold text-white">{{ $segment['name'] }}</h3>
                </div>

                <div class="p-6">
                    <div class="mb-4">
                        <div class="text-5xl font-bold 
                            @if($segment['key'] === 'new') text-blue-600
                            @elseif($segment['key'] === 'active') text-green-600
                            @elseif($segment['key'] === 'loyal') text-purple-600
                            @else text-orange-600
                            @endif
                        ">
                            {{ $segment['count'] }}
                        </div>
                        <div class="text-sm text-gray-600 mt-1">
                            {{ $segment['count'] === 1 ? 'cliente' : 'clientes' }}
                        </div>
                    </div>

                    <p class="text-gray-700 mb-4">{{ $segment['description'] }}</p>

                    <div class="flex gap-2">
                        <a href="{{ route('panel.promotions.create') }}?segment={{ $segment['key'] }}" 
                            class="flex-1 px-4 py-2 bg-gradient-to-r 
                                @if($segment['key'] === 'new') from-blue-600 to-cyan-600
                                @elseif($segment['key'] === 'active') from-green-600 to-emerald-600
                                @elseif($segment['key'] === 'loyal') from-purple-600 to-pink-600
                                @else from-orange-600 to-red-600
                                @endif
                                text-white rounded-lg hover:shadow-lg transition text-center font-semibold">
                            Criar Promoção para Este Segmento
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Informações Adicionais -->
    <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-6">
        <h3 class="text-lg font-bold text-blue-900 mb-3">💡 Como Usar os Segmentos</h3>
        <div class="space-y-2 text-blue-800">
            <p><strong>Novos Clientes:</strong> Ofereça descontos de boas-vindas para converter cadastros em agendamentos.</p>
            <p><strong>Clientes Ativos:</strong> Recompense com benefícios exclusivos para manter o engajamento.</p>
            <p><strong>Clientes Fiéis:</strong> Programas VIP, acesso antecipado a serviços ou descontos especiais.</p>
            <p><strong>Clientes Inativos:</strong> Campanhas de reativação com ofertas especiais para reconquistar.</p>
        </div>
    </div>
</div>
@endsection

