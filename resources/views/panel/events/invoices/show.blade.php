@extends('panel.layout')

@section('page-title', 'Fatura ' . $invoice->invoice_number)
@section('page-subtitle', 'Detalhes da fatura')

@section('header-actions')
    <div class="flex space-x-3">
        <a href="{{ route('panel.events.invoices.pdf', $invoice) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition inline-flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>Gerar PDF</span>
        </a>
        <a href="{{ route('panel.events.invoices.edit', $invoice) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition inline-flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <span>Editar</span>
        </a>
        <a href="{{ route('panel.events.invoices.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition inline-flex items-center space-x-2">
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
        <!-- Informações da Fatura -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Cabeçalho da Fatura -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Fatura {{ $invoice->invoice_number }}</h1>
                        <p class="text-gray-600">Data: {{ $invoice->invoice_date->format('d/m/Y') }}</p>
                        <p class="text-gray-600">Vencimento: {{ $invoice->due_date->format('d/m/Y') }}</p>
                    </div>
                    <div class="text-right">
                        @php
                            $statusColors = [
                                'rascunho' => 'bg-gray-100 text-gray-800',
                                'enviada' => 'bg-blue-100 text-blue-800',
                                'paga' => 'bg-green-100 text-green-800',
                                'vencida' => 'bg-red-100 text-red-800',
                                'cancelada' => 'bg-red-100 text-red-800',
                            ];
                        @endphp
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $statusColors[$invoice->status] }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </div>
                </div>

                <!-- Informações do Cliente -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Cliente</h3>
                        <div class="text-sm text-gray-600">
                            <p class="font-medium">{{ $invoice->event->customer->name }}</p>
                            <p>{{ $invoice->event->customer->email }}</p>
                            @if($invoice->event->customer->phone)
                                <p>{{ $invoice->event->customer->phone }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Evento</h3>
                        <div class="text-sm text-gray-600">
                            <p class="font-medium">{{ $invoice->event->title }}</p>
                            <p>{{ ucfirst($invoice->event->type) }}</p>
                            <p>{{ $invoice->event->event_date->format('d/m/Y') }}</p>
                            <p>{{ $invoice->event->start_time->format('H:i') }} - {{ $invoice->event->end_time->format('H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detalhes Financeiros -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Detalhes Financeiros</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between py-2 border-b border-gray-200">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-medium">R$ {{ number_format($invoice->subtotal, 2, ',', '.') }}</span>
                    </div>
                    
                    @if($invoice->discount_percentage > 0)
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">Desconto ({{ $invoice->discount_percentage }}%):</span>
                            <span class="font-medium text-red-600">- R$ {{ number_format($invoice->discount_value, 2, ',', '.') }}</span>
                        </div>
                    @endif
                    
                    @if($invoice->tax_percentage > 0)
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">Imposto ({{ $invoice->tax_percentage }}%):</span>
                            <span class="font-medium">R$ {{ number_format($invoice->tax_value, 2, ',', '.') }}</span>
                        </div>
                    @endif
                    
                    <div class="flex justify-between py-2 text-lg font-bold">
                        <span>Total:</span>
                        <span class="text-purple-600">R$ {{ number_format($invoice->total, 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Observações -->
            @if($invoice->notes || $invoice->payment_terms)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informações Adicionais</h3>
                    
                    @if($invoice->notes)
                        <div class="mb-4">
                            <h4 class="font-medium text-gray-900 mb-2">Observações:</h4>
                            <p class="text-gray-600">{{ $invoice->notes }}</p>
                        </div>
                    @endif
                    
                    @if($invoice->payment_terms)
                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">Termos de Pagamento:</h4>
                            <p class="text-gray-600">{{ $invoice->payment_terms }}</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">

            <!-- Status de Pagamento -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Status de Pagamento</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total da Fatura:</span>
                        <span class="font-medium">R$ {{ number_format($invoice->total, 2, ',', '.') }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Valor Pago:</span>
                        <span class="font-medium text-green-600">R$ {{ number_format($invoice->total_paid, 2, ',', '.') }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Valor Restante:</span>
                        <span class="font-medium {{ $invoice->remaining_amount > 0 ? 'text-red-600' : 'text-green-600' }}">
                            R$ {{ number_format($invoice->remaining_amount, 2, ',', '.') }}
                        </span>
                    </div>
                    
                    @if($invoice->is_overdue)
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                            <p class="text-sm text-red-800 font-medium">⚠️ Fatura Vencida</p>
                        </div>
                    @elseif($invoice->is_fully_paid)
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                            <p class="text-sm text-green-800 font-medium">✅ Fatura Paga</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Ações -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Ações</h3>
                
                <div class="space-y-3">
                    @if($invoice->status === 'rascunho')
                        <form method="POST" action="{{ route('panel.events.invoices.send', $invoice) }}">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Enviar para Cliente
                            </button>
                        </form>
                    @endif
                    
                    @if($invoice->status === 'enviada' && !$invoice->is_fully_paid)
                        <form method="POST" action="{{ route('panel.events.invoices.mark-paid', $invoice) }}">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                Marcar como Paga
                            </button>
                        </form>
                    @endif
                    
                    @if(!$invoice->is_fully_paid)
                        <a href="{{ route('panel.events.payments.create', $invoice->event) }}" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-center block">
                            Registrar Pagamento
                        </a>
                    @else
                        <div class="w-full px-4 py-2 bg-gray-100 text-gray-500 rounded-lg text-center text-sm">
                            Fatura totalmente paga
                        </div>
                    @endif
                    
                    <a href="{{ route('panel.events.show', $invoice->event) }}" class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition text-center block">
                        Ver Evento
                    </a>
                </div>
            </div>

            <!-- Histórico de Pagamentos -->
            @if($invoice->payments->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Histórico de Pagamentos</h3>
                    
                    <div class="space-y-3">
                        @foreach($invoice->payments as $payment)
                            <div class="border border-gray-200 rounded-lg p-3">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium">{{ $payment->payment_number }}</p>
                                        <p class="text-sm text-gray-600">{{ $payment->payment_date->format('d/m/Y') }}</p>
                                        <p class="text-sm text-gray-600">{{ $payment->payment_method_label }}</p>
                                        @if($payment->payment_reference)
                                            <p class="text-sm text-gray-500">Ref: {{ $payment->payment_reference }}</p>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium">R$ {{ number_format($payment->amount, 2, ',', '.') }}</p>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $payment->status === 'confirmado' ? 'bg-green-100 text-green-800' : ($payment->status === 'cancelado' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ $payment->status_label }}
                                        </span>
                                    </div>
                                </div>
                                
                                @if($payment->status === 'pendente')
                                    <div class="mt-3 flex space-x-2">
                                        <form method="POST" action="{{ route('panel.events.payments.confirm', $payment) }}" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full px-3 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700 transition">
                                                Confirmar
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('panel.events.payments.cancel', $payment) }}" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full px-3 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition">
                                                Cancelar
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
