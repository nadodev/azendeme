@extends('panel.layout')

@section('title', 'Pontos de ' . $customer->name)

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('panel.loyalty.index') }}" class="text-purple-600 hover:text-purple-800 font-semibold">
            ← Voltar para Fidelidade
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-2 border-green-200 text-green-800 px-6 py-4 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Cabeçalho do Cliente -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">{{ $customer->name }}</h1>
                <p class="text-purple-100">{{ $customer->phone }}</p>
                @if($customer->email)
                    <p class="text-purple-100">{{ $customer->email }}</p>
                @endif
            </div>
            <div class="text-center bg-white/20 rounded-xl px-8 py-4 backdrop-blur-sm">
                <div class="text-5xl font-bold">{{ number_format($totalPoints) }}</div>
                <div class="text-sm uppercase tracking-wide mt-1">Pontos Totais</div>
            </div>
        </div>
    </div>

    <!-- Adicionar/Remover Pontos Manualmente -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="bg-blue-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white">✏️ Ajustar Pontos Manualmente</h2>
        </div>
        <form action="{{ route('panel.loyalty.manual-points', $customer->id) }}" method="POST" class="p-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pontos</label>
                    <input type="number" name="points" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        placeholder="Ex: 50 ou -20"
                        required>
                    <p class="text-xs text-gray-500 mt-1">Use valores negativos para remover pontos</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Motivo</label>
                    <input type="text" name="description" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        placeholder="Ex: Ajuste manual, Bonificação especial"
                        required>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                        Adicionar
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Histórico de Transações -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-green-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white">📊 Histórico de Pontos</h2>
            </div>
            <div class="p-6">
                @if($transactions->isEmpty())
                    <p class="text-center text-gray-500 py-8">Nenhuma transação ainda</p>
                @else
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @foreach($transactions as $transaction)
                            <div class="flex items-center justify-between p-4 rounded-lg {{ $transaction->type === 'earned' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                                <div class="flex-1">
                                    <div class="font-semibold {{ $transaction->type === 'earned' ? 'text-green-800' : 'text-red-800' }}">
                                        {{ $transaction->description }}
                                    </div>
                                    <div class="text-xs text-gray-600 mt-1">
                                        {{ $transaction->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                                <div class="text-xl font-bold {{ $transaction->type === 'earned' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction->type === 'earned' ? '+' : '-' }}{{ $transaction->points }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Resgates -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-orange-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white">🎁 Recompensas Resgatadas</h2>
            </div>
            <div class="p-6">
                @if($redemptions->isEmpty())
                    <p class="text-center text-gray-500 py-8">Nenhum resgate ainda</p>
                @else
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @foreach($redemptions as $redemption)
                            <div class="p-4 rounded-lg bg-orange-50 border border-orange-200">
                                <div class="font-semibold text-orange-800">
                                    {{ $redemption->reward->name }}
                                </div>
                                <div class="text-sm text-gray-700 mt-1">
                                    {{ $redemption->points_used }} pontos
                                </div>
                                <div class="flex items-center justify-between mt-2">
                                    <div class="text-xs text-gray-600">
                                        {{ $redemption->created_at->format('d/m/Y H:i') }}
                                    </div>
                                    <span class="px-2 py-1 rounded text-xs font-semibold 
                                        {{ $redemption->status === 'used' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                        {{ $redemption->status === 'used' ? 'Utilizado' : 'Disponível' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

