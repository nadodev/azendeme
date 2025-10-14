@extends('panel.layout')

@section('title', 'Programa de Fidelidade')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">🎁 Programa de Fidelidade</h1>
            <p class="text-gray-600 mt-2">Configure pontos, recompensas e acompanhe seus clientes mais fiéis</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-2 border-green-200 text-green-800 px-6 py-4 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <!-- Configurações do Programa -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Configurações do Programa
            </h2>
        </div>
        <form action="{{ route('panel.loyalty.update-program') }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Status do Programa -->
                <div class="md:col-span-2">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" name="active" value="1" 
                            {{ $program && $program->active ? 'checked' : '' }}
                            class="w-6 h-6 text-purple-600 rounded focus:ring-2 focus:ring-purple-500">
                        <div>
                            <span class="text-lg font-semibold text-gray-900">Programa Ativo</span>
                            <p class="text-sm text-gray-600">Clientes acumularão pontos automaticamente em cada agendamento</p>
                        </div>
                    </label>
                </div>

                <!-- Pontos por Real Gasto -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        💰 Pontos por R$ Gasto
                    </label>
                    <input type="number" step="0.01" name="points_per_real" 
                        value="{{ old('points_per_real', $program->points_per_real ?? 1) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                        required>
                    <p class="text-xs text-gray-500 mt-1">Ex: 1 = 1 ponto a cada R$ 1,00 gasto</p>
                </div>

                <!-- Pontos por Visita -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        🎯 Pontos por Visita
                    </label>
                    <input type="number" name="points_per_visit" 
                        value="{{ old('points_per_visit', $program->points_per_visit ?? 10) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                        required>
                    <p class="text-xs text-gray-500 mt-1">Pontos extras por cada visita/agendamento</p>
                </div>

                <!-- Pontos de Boas-Vindas -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        🎉 Pontos de Boas-Vindas
                    </label>
                    <input type="number" name="welcome_points" 
                        value="{{ old('welcome_points', $program->welcome_points ?? 50) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                        required>
                    <p class="text-xs text-gray-500 mt-1">Pontos dados ao primeiro agendamento</p>
                </div>

                <!-- Validade dos Pontos -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        ⏰ Validade dos Pontos (dias)
                    </label>
                    <input type="number" name="points_expiration_days" 
                        value="{{ old('points_expiration_days', $program->points_expiration_days ?? '') }}"
                        placeholder="Deixe vazio para nunca expirar"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                    <p class="text-xs text-gray-500 mt-1">Deixe vazio se os pontos não devem expirar</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transform hover:scale-105 transition-all font-semibold">
                    💾 Salvar Configurações
                </button>
            </div>
        </form>
    </div>

    <!-- Recompensas -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-pink-600 to-orange-600 px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-bold text-white flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                </svg>
                Recompensas Disponíveis
            </h2>
            <a href="{{ route('panel.loyalty.create-reward') }}" class="px-4 py-2 bg-white text-pink-600 rounded-lg hover:bg-pink-50 transition font-semibold">
                + Nova Recompensa
            </a>
        </div>

        <div class="p-6">
            @if($rewards->isEmpty())
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                    </svg>
                    <p class="text-gray-500 text-lg">Nenhuma recompensa cadastrada ainda</p>
                    <a href="{{ route('panel.loyalty.create-reward') }}" class="inline-block mt-4 px-6 py-3 bg-gradient-to-r from-pink-600 to-orange-600 text-white rounded-lg hover:shadow-lg transition font-semibold">
                        Criar Primeira Recompensa
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($rewards as $reward)
                        <div class="border-2 {{ $reward->is_active ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-gray-50' }} rounded-xl p-4 hover:shadow-md transition">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg text-gray-900">{{ $reward->name }}</h3>
                                    @if($reward->description)
                                        <p class="text-sm text-gray-600 mt-1">{{ $reward->description }}</p>
                                    @endif
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $reward->is_active ? 'bg-green-200 text-green-800' : 'bg-gray-300 text-gray-700' }}">
                                    {{ $reward->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </div>

                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-purple-600 font-bold">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    {{ number_format($reward->points_required) }} pontos
                                </div>
                                <div class="text-sm text-gray-700">
                                    @if($reward->discount_type === 'percentage')
                                        <span class="font-semibold text-green-600">{{ $reward->discount_value }}% de desconto</span>
                                    @elseif($reward->discount_type === 'fixed')
                                        <span class="font-semibold text-green-600">R$ {{ number_format($reward->discount_value, 2, ',', '.') }} de desconto</span>
                                    @else
                                        <span class="font-semibold text-green-600">Serviço Grátis</span>
                                    @endif
                                </div>
                                @if($reward->valid_until)
                                    <div class="text-xs text-orange-600">
                                        ⏰ Válido até {{ \Carbon\Carbon::parse($reward->valid_until)->format('d/m/Y') }}
                                    </div>
                                @endif
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('panel.loyalty.edit-reward', $reward->id) }}" class="flex-1 px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center text-sm font-semibold">
                                    Editar
                                </a>
                                <form action="{{ route('panel.loyalty.destroy-reward', $reward->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Deseja realmente excluir esta recompensa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-semibold">
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Top Clientes -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-yellow-500 to-orange-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
                🏆 Top 10 Clientes Mais Fiéis
            </h2>
        </div>

        <div class="p-6">
            @if($topCustomers->isEmpty())
                <p class="text-center text-gray-500 py-8">Nenhum cliente com pontos ainda</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b-2 border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Posição</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Cliente</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Pontos</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($topCustomers as $index => $customer)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">
                                        @if($index === 0)
                                            <span class="text-2xl">🥇</span>
                                        @elseif($index === 1)
                                            <span class="text-2xl">🥈</span>
                                        @elseif($index === 2)
                                            <span class="text-2xl">🥉</span>
                                        @else
                                            <span class="font-semibold text-gray-600">{{ $index + 1 }}º</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $customer->name }}</div>
                                            <div class="text-sm text-gray-600">{{ $customer->phone }}</div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-purple-100 text-purple-800 font-bold">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            {{ number_format($customer->total_points) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('panel.loyalty.customer-points', $customer->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                            Ver Detalhes →
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

