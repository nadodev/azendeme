@extends('panel.layout')

@section('title', 'Controle de Custos')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Controle de Custos</h1>
            <p class="text-gray-600">Gerencie os custos dos eventos</p>
        </div>
        <a href="{{ route('panel.events.costs.select-event') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
            Novo Custo
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-gray-100 rounded-lg">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $costs->total() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pendentes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $costs->where('payment_status', 'pendente')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pagos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $costs->where('payment_status', 'pago')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-lg">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Valor Total</p>
                    <p class="text-2xl font-bold text-gray-900">R$ {{ number_format($costs->sum('amount'), 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Costs List -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Custos</h3>
        </div>
        
        @if($costs->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($costs as $cost)
                    <div class="px-6 py-4 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-4">
                                    <div class="w-3 h-3 rounded-full" style="background-color: {{ optional($cost->costCategory)->color ?? '#E5E7EB' }}"></div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $cost->cost_number }}</h4>
                                        <p class="text-sm text-gray-500">{{ $cost->event->customer->name }} - {{ $cost->event->title }}</p>
                                    </div>
                                </div>
                                <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                                    <span>{{ optional($cost->costCategory)->name ?? 'Sem categoria' }}</span>
                                    <span>Data: {{ $cost->cost_date->format('d/m/Y') }}</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $cost->cost_type_color }}">
                                        {{ $cost->cost_type_label }}
                                    </span>
                                    @if($cost->supplier)
                                        <span>Fornecedor: {{ $cost->supplier }}</span>
                                    @endif
                                    <span>Valor: R$ {{ number_format($cost->amount, 2, ',', '.') }}</span>
                                </div>
                                <div class="mt-1 text-sm text-gray-600">
                                    {{ $cost->description }}
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $cost->payment_status_color }}">
                                    {{ $cost->payment_status_label }}
                                </span>
                                @if($cost->is_overdue)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Vencido
                                    </span>
                                @endif
                                <div class="flex space-x-1">
                                    <a href="{{ route('panel.events.costs.show', $cost) }}" class="text-purple-600 hover:text-purple-900 text-sm">
                                        Ver
                                    </a>
                                    <a href="{{ route('panel.events.costs.edit', $cost) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                        Editar
                                    </a>
                                    @if($cost->payment_status === 'pendente')
                                        <form method="POST" action="{{ route('panel.events.costs.mark-paid', $cost) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900 text-sm">
                                                Marcar Pago
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $costs->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum custo encontrado</h3>
                <p class="mt-1 text-sm text-gray-500">Comece registrando custos para os eventos.</p>
                <div class="mt-6">
                    <a href="{{ route('panel.events.costs.select-event') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        Novo Custo
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
