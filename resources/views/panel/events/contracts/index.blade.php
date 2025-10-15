@extends('panel.layout')

@section('title', 'Contratos')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Contratos</h1>
            <p class="text-gray-600">Gerencie os contratos dos eventos</p>
        </div>
        <a href="{{ route('panel.events.contracts.select-event') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
            Novo Contrato
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
                    <p class="text-2xl font-bold text-gray-900">{{ $contracts->total() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Enviados</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $contracts->where('status', 'enviado')->count() }}</p>
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
                    <p class="text-sm font-medium text-gray-600">Assinados</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $contracts->where('status', 'assinado')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Valor Total</p>
                    <p class="text-2xl font-bold text-gray-900">R$ {{ number_format($contracts->sum('total_value'), 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contracts List -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Contratos</h3>
        </div>
        
        @if($contracts->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($contracts as $contract)
                    <div class="px-6 py-4 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $contract->contract_number }}</h4>
                                        <p class="text-sm text-gray-500">{{ $contract->event->customer->name }} - {{ $contract->event->title }}</p>
                                    </div>
                                </div>
                                <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                                    <span>Data: {{ $contract->contract_date->format('d/m/Y') }}</span>
                                    <span>Valor: R$ {{ number_format($contract->total_value, 2, ',', '.') }}</span>
                                    @if($contract->signed_date)
                                        <span>Assinado em: {{ $contract->signed_date->format('d/m/Y') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $contract->status_color }}">
                                    {{ $contract->status_label }}
                                </span>
                                <div class="flex space-x-1">
                                    <a href="{{ route('panel.events.contracts.show', $contract) }}" class="text-purple-600 hover:text-purple-900 text-sm">
                                        Ver
                                    </a>
                                    <a href="{{ route('panel.events.contracts.edit', $contract) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                        Editar
                                    </a>
                                    <a href="{{ route('panel.events.contracts.pdf', $contract) }}" class="text-green-600 hover:text-green-900 text-sm">
                                        PDF
                                    </a>
                                    @if($contract->status === 'rascunho')
                                        <form method="POST" action="{{ route('panel.events.contracts.send', $contract) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-orange-600 hover:text-orange-900 text-sm">
                                                Enviar
                                            </button>
                                        </form>
                                    @endif
                                    @if($contract->status === 'enviado')
                                        <form method="POST" action="{{ route('panel.events.contracts.sign', $contract) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900 text-sm">
                                                Assinar
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
                {{ $contracts->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum contrato encontrado</h3>
                <p class="mt-1 text-sm text-gray-500">Comece criando um contrato para um evento.</p>
                <div class="mt-6">
                    <a href="{{ route('panel.events.contracts.select-event') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                        Novo Contrato
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
