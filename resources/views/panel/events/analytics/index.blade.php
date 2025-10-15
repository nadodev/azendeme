@extends('panel.layout')

@section('title', 'Analytics de Eventos')

@section('content')
<div class="space-y-6">
    <!-- Filters -->
    <form method="GET" class="bg-white rounded-lg shadow p-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Data Inicial</label>
                <input type="date" name="start_date" value="{{ request('start_date', $start->toDateString()) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Data Final</label>
                <input type="date" name="end_date" value="{{ request('end_date', $end->toDateString()) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            <div class="flex space-x-2">
                <button class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">Filtrar</button>
                <a href="{{ route('panel.events.analytics.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">Limpar</a>
            </div>
        </div>
    </form>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-sm text-gray-600">Total de Eventos</p>
            <p class="text-3xl font-bold text-gray-900">{{ $totalEvents }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ $completedEvents }} concluídos</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-sm text-gray-600">Receita Total</p>
            <p class="text-3xl font-bold text-gray-900">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</p>
            <p class="text-xs text-gray-500 mt-1">Período selecionado</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-sm text-gray-600">Clientes Ativos</p>
            <p class="text-3xl font-bold text-gray-900">{{ $activeClients }}</p>
            <p class="text-xs text-gray-500 mt-1">no período</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-sm text-gray-600">Lucro Líquido</p>
            <p class="text-3xl font-bold text-gray-900">R$ {{ number_format($netProfit, 2, ',', '.') }}</p>
            <p class="text-xs text-gray-500 mt-1">Receitas - Despesas</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Top Event Types -->
        <div class="bg-white p-6 rounded-lg shadow lg:col-span-2">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tipos de Evento Mais Comuns</h3>
            <div class="space-y-3">
                @forelse($topEventTypes as $row)
                    <div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-700">{{ ucfirst($row->type) }}</span>
                            <span class="text-gray-900 font-medium">{{ $row->total }}</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2 mt-1">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: {{ max(8, ($row->total / max(1, ($topEventTypes->first()->total ?? 1))) * 100) }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Sem dados no período.</p>
                @endforelse
            </div>
        </div>

        <!-- Popular Hours -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Horários Mais Populares</h3>
            <div class="space-y-3">
                @forelse($popularHours as $row)
                    <div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-700">{{ sprintf('%02d:00', $row->hour) }}</span>
                            <span class="text-gray-900 font-medium">{{ $row->total }}</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2 mt-1">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ max(8, ($row->total / max(1, ($popularHours->first()->total ?? 1))) * 100) }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Sem dados no período.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Payment Methods -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Métodos de Pagamento</h3>
            <div class="space-y-3">
                @forelse($paymentMethods as $row)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-700">{{ ucfirst(str_replace('_',' ',$row->payment_method)) }}</span>
                        <span class="text-gray-900 font-medium">{{ $row->total }} • R$ {{ number_format($row->amount, 2, ',', '.') }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Sem dados no período.</p>
                @endforelse
            </div>
        </div>

        <!-- Financial Summary -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Resumo Financeiro</h3>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Receitas</span>
                    <span class="text-gray-900 font-medium">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Despesas</span>
                    <span class="text-gray-900 font-medium">R$ {{ number_format($totalCosts, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Lucro Líquido</span>
                    <span class="text-purple-700 font-semibold">R$ {{ number_format($netProfit, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


