@extends('panel.layout')

@section('title', 'Contrato - ' . $contract->contract_number)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Contrato {{ $contract->contract_number }}</h1>
            <p class="text-gray-600">Evento: {{ $contract->event->title }}</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('panel.events.contracts.pdf', $contract) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                PDF
            </a>
            <a href="{{ route('panel.events.contracts.edit', $contract) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Editar
            </a>
            <a href="{{ route('panel.events.contracts.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                Voltar
            </a>
        </div>
    </div>

    <!-- Contract Status -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $contract->status === 'assinado' ? 'bg-green-100 text-green-800' : ($contract->status === 'pendente' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                    {{ ucfirst($contract->status) }}
                </span>
                <span class="text-sm text-gray-500">
                    Criado em {{ $contract->created_at->format('d/m/Y H:i') }}
                </span>
            </div>
            <div class="flex items-center space-x-2">
                @if($contract->status === 'pendente')
                    <form method="POST" action="{{ route('panel.events.contracts.sign', $contract) }}" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700 transition">
                            Assinar
                        </button>
                    </form>
                @endif
                <form method="POST" action="{{ route('panel.events.contracts.send', $contract) }}" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700 transition">
                        Enviar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Contract Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Event Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informações do Evento</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Cliente</label>
                        <p class="text-sm text-gray-900">{{ $contract->event->customer->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tipo de Evento</label>
                        <p class="text-sm text-gray-900">{{ ucfirst($contract->event->event_type) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Data do Evento</label>
                        <p class="text-sm text-gray-900">{{ $contract->event->event_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Horário</label>
                        <p class="text-sm text-gray-900">{{ $contract->event->start_time->format('H:i') }} - {{ $contract->event->end_time->format('H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Contract Terms -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Termos e Condições</h3>
                <div class="prose max-w-none">
                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $contract->terms_and_conditions }}</p>
                </div>
            </div>

            <!-- Payment Terms -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Termos de Pagamento</h3>
                <div class="prose max-w-none">
                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $contract->payment_terms }}</p>
                </div>
            </div>

            <!-- Cancellation Policy -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Política de Cancelamento</h3>
                <div class="prose max-w-none">
                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $contract->cancellation_policy }}</p>
                </div>
            </div>

            <!-- Liability Terms -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Termos de Responsabilidade</h3>
                <div class="prose max-w-none">
                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $contract->liability_terms }}</p>
                </div>
            </div>

            @if($contract->notes)
            <!-- Notes -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Observações</h3>
                <div class="prose max-w-none">
                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $contract->notes }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Contract Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Detalhes do Contrato</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Número do Contrato</label>
                        <p class="text-sm text-gray-900">{{ $contract->contract_number }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Data do Contrato</label>
                        <p class="text-sm text-gray-900">{{ $contract->contract_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Período</label>
                        <p class="text-sm text-gray-900">{{ $contract->start_date->format('d/m/Y') }} - {{ $contract->end_date->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Financial Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informações Financeiras</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Valor Total</label>
                        <p class="text-lg font-semibold text-gray-900">R$ {{ number_format($contract->total_value, 2, ',', '.') }}</p>
                    </div>
                    @if($contract->advance_payment)
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Pagamento Antecipado</label>
                        <p class="text-sm text-gray-900">R$ {{ number_format($contract->advance_payment, 2, ',', '.') }}</p>
                    </div>
                    @endif
                    @if($contract->final_payment)
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Pagamento Final</label>
                        <p class="text-sm text-gray-900">R$ {{ number_format($contract->final_payment, 2, ',', '.') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Related Budget -->
            @if($contract->budget)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Orçamento Relacionado</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Número do Orçamento</label>
                        <p class="text-sm text-gray-900">{{ $contract->budget->budget_number }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Status</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $contract->budget->status === 'aprovado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($contract->budget->status) }}
                        </span>
                    </div>
                    <div>
                        <a href="{{ route('panel.events.budgets.show', $contract->budget) }}" class="text-sm text-purple-600 hover:text-purple-800">
                            Ver Orçamento →
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Ações</h3>
                <div class="space-y-2">
                    <a href="{{ route('panel.events.contracts.pdf', $contract) }}" target="_blank" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Baixar PDF
                    </a>
                    <a href="{{ route('panel.events.contracts.edit', $contract) }}" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar Contrato
                    </a>
                    <form method="POST" action="{{ route('panel.events.contracts.destroy', $contract) }}" class="w-full" onsubmit="return confirm('Tem certeza que deseja excluir este contrato?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Excluir Contrato
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
