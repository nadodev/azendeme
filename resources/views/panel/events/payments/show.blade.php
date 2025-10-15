@extends('panel.layout')

@section('page-title', 'Pagamento ' . $payment->payment_number)
@section('page-subtitle', 'Detalhes do pagamento')

@section('header-actions')
    <div class="flex space-x-3">
        <a href="{{ route('panel.events.payments.edit', $payment) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition inline-flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <span>Editar</span>
        </a>
        <a href="{{ route('panel.events.payments.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition inline-flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Voltar</span>
        </a>
    </div>
@endsection

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informações do Pagamento -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Cabeçalho do Pagamento -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Pagamento {{ $payment->payment_number }}</h1>
                        <p class="text-gray-600">Data: {{ $payment->payment_date->format('d/m/Y') }}</p>
                        <p class="text-gray-600">Valor: R$ {{ number_format($payment->amount, 2, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $payment->status_color }}">
                            {{ $payment->status_label }}
                        </span>
                    </div>
                </div>

                <!-- Informações do Cliente -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Cliente</h3>
                        <div class="text-sm text-gray-600">
                            <p class="font-medium">{{ $payment->event->customer->name }}</p>
                            <p>{{ $payment->event->customer->email }}</p>
                            @if($payment->event->customer->phone)
                                <p>{{ $payment->event->customer->phone }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Evento</h3>
                        <div class="text-sm text-gray-600">
                            <p class="font-medium">{{ $payment->event->title }}</p>
                            <p>{{ ucfirst($payment->event->type) }}</p>
                            <p>{{ $payment->event->event_date->format('d/m/Y') }}</p>
                            <p>{{ $payment->event->start_time->format('H:i') }} - {{ $payment->event->end_time->format('H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detalhes do Pagamento -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Detalhes do Pagamento</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Data do Pagamento</label>
                        <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                            {{ $payment->payment_date->format('d/m/Y') }}
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Valor</label>
                        <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                            R$ {{ number_format($payment->amount, 2, ',', '.') }}
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Método de Pagamento</label>
                        <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                            {{ $payment->payment_method_label }}
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                            {{ $payment->status_label }}
                        </div>
                    </div>
                </div>
                
                @if($payment->payment_reference)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Referência do Pagamento</label>
                        <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                            {{ $payment->payment_reference }}
                        </div>
                    </div>
                @endif
                
                @if($payment->notes)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                        <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                            {{ $payment->notes }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Ações -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Ações</h3>
                
                <div class="space-y-3">
                    @if($payment->status === 'pendente')
                        <form method="POST" action="{{ route('panel.events.payments.confirm', $payment) }}">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                Confirmar Pagamento
                            </button>
                        </form>
                    @endif
                    
                    @if($payment->status === 'confirmado')
                        <form method="POST" action="{{ route('panel.events.payments.cancel', $payment) }}">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                Cancelar Pagamento
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('panel.events.show', $payment->event) }}" class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition text-center block">
                        Ver Evento
                    </a>
                </div>
            </div>

            <!-- Fatura Relacionada -->
            @if($payment->invoice)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Fatura Relacionada</h3>
                    
                    <div class="border border-gray-200 rounded-lg p-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium">{{ $payment->invoice->invoice_number }}</p>
                                <p class="text-sm text-gray-600">{{ $payment->invoice->invoice_date->format('d/m/Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium">R$ {{ number_format($payment->invoice->total, 2, ',', '.') }}</p>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $payment->invoice->status === 'paga' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($payment->invoice->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('panel.events.invoices.show', $payment->invoice) }}" class="text-sm text-purple-600 hover:text-purple-900">Ver Fatura</a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Informações do Sistema -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informações do Sistema</h3>
                
                <div class="space-y-2 text-sm">
                    <div>
                        <span class="font-medium">Criado em:</span>
                        <span class="text-gray-600">{{ $payment->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="font-medium">Atualizado em:</span>
                        <span class="text-gray-600">{{ $payment->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
