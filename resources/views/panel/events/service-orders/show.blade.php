@extends('panel.layout')

@section('page-title', 'OS ' . $serviceOrder->order_number)
@section('page-subtitle', 'Detalhes da Ordem de Serviço')

@section('header-actions')
    <div class="flex space-x-3">
        <a href="{{ route('panel.events.service-orders.pdf', $serviceOrder) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition inline-flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>Gerar PDF</span>
        </a>
        <a href="{{ route('panel.events.service-orders.edit', $serviceOrder) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition inline-flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <span>Editar</span>
        </a>
        <a href="{{ route('panel.events.service-orders.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition inline-flex items-center space-x-2">
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
        <!-- Informações da OS -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Cabeçalho da OS -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">OS {{ $serviceOrder->order_number }}</h1>
                        <p class="text-gray-600">Data: {{ $serviceOrder->order_date->format('d/m/Y') }}</p>
                        <p class="text-gray-600">Agendada para: {{ $serviceOrder->scheduled_date->format('d/m/Y') }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $serviceOrder->status_color }}">
                            {{ $serviceOrder->status_label }}
                        </span>
                    </div>
                </div>

                <!-- Informações do Cliente -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Cliente</h3>
                        <div class="text-sm text-gray-600">
                            <p class="font-medium">{{ $serviceOrder->event->customer->name }}</p>
                            <p>{{ $serviceOrder->event->customer->email }}</p>
                            @if($serviceOrder->event->customer->phone)
                                <p>{{ $serviceOrder->event->customer->phone }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Evento</h3>
                        <div class="text-sm text-gray-600">
                            <p class="font-medium">{{ $serviceOrder->event->title }}</p>
                            <p>{{ ucfirst($serviceOrder->event->type) }}</p>
                            <p>{{ $serviceOrder->event->event_date->format('d/m/Y') }}</p>
                            <p>{{ $serviceOrder->event->start_time->format('H:i') }} - {{ $serviceOrder->event->end_time->format('H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agendamento -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Agendamento</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Data Agendada</label>
                        <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                            {{ $serviceOrder->scheduled_date->format('d/m/Y') }}
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Horário</label>
                        <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                            {{ $serviceOrder->scheduled_start_time->format('H:i') }} - {{ $serviceOrder->scheduled_end_time->format('H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detalhes da OS -->
            @if($serviceOrder->description)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Descrição dos Serviços</h3>
                    <p class="text-gray-600">{{ $serviceOrder->description }}</p>
                </div>
            @endif

            <!-- Equipamentos -->
            @if($serviceOrder->equipment_list)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Equipamentos</h3>
                    <p class="text-gray-600">{{ $serviceOrder->equipment_list }}</p>
                </div>
            @endif

            <!-- Funcionários -->
            @if($serviceOrder->employee_assignments)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Atribuições de Funcionários</h3>
                    <p class="text-gray-600">{{ $serviceOrder->employee_assignments }}</p>
                </div>
            @endif

            <!-- Instruções -->
            @if($serviceOrder->setup_instructions)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Instruções de Montagem</h3>
                    <p class="text-gray-600">{{ $serviceOrder->setup_instructions }}</p>
                </div>
            @endif

            <!-- Requisitos Especiais -->
            @if($serviceOrder->special_requirements)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Requisitos Especiais</h3>
                    <p class="text-gray-600">{{ $serviceOrder->special_requirements }}</p>
                </div>
            @endif

            <!-- Notas de Conclusão -->
            @if($serviceOrder->completion_notes)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Notas de Conclusão</h3>
                    <p class="text-gray-600">{{ $serviceOrder->completion_notes }}</p>
                </div>
            @endif

            <!-- Problemas Encontrados -->
            @if($serviceOrder->issues_encountered)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Problemas Encontrados</h3>
                    <p class="text-gray-600">{{ $serviceOrder->issues_encountered }}</p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Valor da OS -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Valor da OS</h3>
                
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">
                        R$ {{ number_format($serviceOrder->total_value, 2, ',', '.') }}
                    </div>
                </div>
            </div>

            <!-- Ações -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Ações</h3>
                
                <div class="space-y-3">
                    @if($serviceOrder->status === 'rascunho')
                        <form method="POST" action="{{ route('panel.events.service-orders.start', $serviceOrder) }}">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                                Agendar OS
                            </button>
                        </form>
                    @endif
                    
                    @if($serviceOrder->status === 'agendada')
                        <form method="POST" action="{{ route('panel.events.service-orders.start', $serviceOrder) }}">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Iniciar Execução
                            </button>
                        </form>
                    @endif
                    
                    @if($serviceOrder->status === 'em_execucao')
                        <form method="POST" action="{{ route('panel.events.service-orders.complete', $serviceOrder) }}">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                Concluir OS
                            </button>
                        </form>
                    @endif
                    
                    @if($serviceOrder->status === 'concluida')
                        <form method="POST" action="{{ route('panel.events.invoices.create-from-service-order', $serviceOrder) }}">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                                Criar Fatura
                            </button>
                        </form>
                    @endif
                    
                    @if($serviceOrder->status !== 'cancelada' && $serviceOrder->status !== 'concluida')
                        <form method="POST" action="{{ route('panel.events.service-orders.cancel', $serviceOrder) }}">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                Cancelar OS
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('panel.events.show', $serviceOrder->event) }}" class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition text-center block">
                        Ver Evento
                    </a>
                </div>
            </div>

            <!-- Faturas Relacionadas -->
            @if($serviceOrder->invoices->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Faturas Relacionadas</h3>
                    
                    <div class="space-y-3">
                        @foreach($serviceOrder->invoices as $invoice)
                            <div class="border border-gray-200 rounded-lg p-3">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium">{{ $invoice->invoice_number }}</p>
                                        <p class="text-sm text-gray-600">{{ $invoice->invoice_date->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium">R$ {{ number_format($invoice->total, 2, ',', '.') }}</p>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $invoice->status === 'paga' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <a href="{{ route('panel.events.invoices.show', $invoice) }}" class="text-sm text-purple-600 hover:text-purple-900">Ver Fatura</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
