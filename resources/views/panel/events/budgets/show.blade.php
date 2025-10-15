@extends('panel.layout')

@section('page-title', 'Orçamento ' . $budget->budget_number)
@section('page-subtitle', 'Detalhes do orçamento')

@section('header-actions')
    <div class="flex space-x-3">
        <a href="{{ route('panel.events.budgets.pdf', $budget) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition inline-flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>Baixar PDF</span>
        </a>
        @if($budget->status === 'rascunho')
            <a href="{{ route('panel.events.budgets.edit', $budget) }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition inline-flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span>Editar</span>
            </a>
        @endif
        <a href="{{ route('panel.events.budgets.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition inline-flex items-center space-x-2">
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
                    <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informações Principais -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Cabeçalho do Orçamento -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $budget->budget_number }}</h1>
                            <div class="flex items-center space-x-4 mt-1">
                                @switch($budget->status)
                                    @case('rascunho')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">Rascunho</span>
                                        @break
                                    @case('enviado')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">Enviado</span>
                                        @break
                                    @case('aprovado')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">Aprovado</span>
                                        @break
                                    @case('rejeitado')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">Rejeitado</span>
                                        @break
                                    @case('expirado')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">Expirado</span>
                                        @break
                                @endswitch
                                <span class="text-lg font-semibold text-green-600">R$ {{ number_format($budget->total, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Evento</h3>
                        <p class="text-sm font-medium text-gray-900">{{ $budget->event->title }}</p>
                        <p class="text-xs text-gray-500">{{ ucfirst($budget->event->type) }} • {{ $budget->event->event_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Cliente</h3>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-blue-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-xs">{{ substr($budget->event->customer->name, 0, 2) }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $budget->event->customer->name }}</p>
                                <p class="text-xs text-gray-500">{{ $budget->event->customer->phone ?? 'Sem telefone' }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Criado em</h3>
                        <p class="text-sm text-gray-900">{{ $budget->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Válido até</h3>
                        <p class="text-sm text-gray-900">{{ $budget->valid_until->format('d/m/Y') }}</p>
                        @if($budget->valid_until->isPast())
                            <p class="text-xs text-red-600">Expirado</p>
                        @elseif($budget->valid_until->diffInDays() <= 3)
                            <p class="text-xs text-yellow-600">Expira em {{ $budget->valid_until->diffInDays() }} dias</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Equipamentos -->
            @if($budget->event->services->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Equipamentos</h3>
                    
                    <div class="space-y-4">
                        @foreach($budget->event->services as $service)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-blue-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $service->equipment->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $service->hours }}h × R$ {{ number_format($service->hourly_rate, 2, ',', '.') }}/h</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-gray-900">R$ {{ number_format($service->total_value, 2, ',', '.') }}</p>
                                    </div>
                                </div>
                                @if($service->notes)
                                    <div class="mt-2">
                                        <p class="text-xs text-gray-500">{{ $service->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Funcionários -->
            @if($budget->event->employees->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Funcionários</h3>
                    
                    <div class="space-y-4">
                        @foreach($budget->event->employees as $employee)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-blue-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-semibold text-sm">{{ substr($employee->name, 0, 2) }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $employee->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $employee->role }} • {{ $employee->hours }}h × R$ {{ number_format($employee->hourly_rate, 2, ',', '.') }}/h</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-gray-900">R$ {{ number_format($employee->total_value, 2, ',', '.') }}</p>
                                    </div>
                                </div>
                                @if($employee->notes)
                                    <div class="mt-2">
                                        <p class="text-xs text-gray-500">{{ $employee->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Observações -->
            @if($budget->notes)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Observações</h3>
                    <p class="text-gray-900">{{ $budget->notes }}</p>
                </div>
            @endif

            <!-- Termos e Condições -->
            @if($budget->terms)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Termos e Condições</h3>
                    <div class="prose max-w-none">
                        <p class="text-gray-900 whitespace-pre-line">{{ $budget->terms }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Resumo Financeiro -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Resumo Financeiro</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Equipamentos:</span>
                        <span class="text-sm font-medium text-gray-900">R$ {{ number_format($budget->equipment_total, 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Funcionários:</span>
                        <span class="text-sm font-medium text-gray-900">R$ {{ number_format($budget->employees_total, 2, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-900">Subtotal:</span>
                            <span class="text-sm font-medium text-gray-900">R$ {{ number_format($budget->subtotal, 2, ',', '.') }}</span>
                        </div>
                        @if($budget->discount_value > 0)
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Desconto ({{ $budget->discount_percentage }}%):</span>
                                <span class="text-sm text-red-600">-R$ {{ number_format($budget->discount_value, 2, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between mt-2">
                            <span class="text-base font-semibold text-gray-900">Total:</span>
                            <span class="text-base font-semibold text-gray-900">R$ {{ number_format($budget->total, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ações -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ações</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('panel.events.budgets.pdf', $budget) }}" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-center block">
                        Baixar PDF
                    </a>
                    
                    @if($budget->status === 'rascunho')
                        <form action="{{ route('panel.events.budgets.send', $budget) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition" onclick="return confirm('Tem certeza que deseja enviar este orçamento para o cliente?')">
                                Enviar para Cliente
                            </button>
                        </form>
                        
                        <a href="{{ route('panel.events.budgets.edit', $budget) }}" class="w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-center block">
                            Editar Orçamento
                        </a>
                    @endif
                    
                    @if($budget->status === 'enviado')
                        <div class="grid grid-cols-2 gap-2">
                            <form action="{{ route('panel.events.budgets.approve', $budget) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm" onclick="return confirm('Marcar orçamento como aprovado?')">
                                    Aprovar
                                </button>
                            </form>
                            <form action="{{ route('panel.events.budgets.reject', $budget) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm" onclick="return confirm('Marcar orçamento como rejeitado?')">
                                    Rejeitar
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Informações Adicionais -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações</h3>
                
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-gray-500">Criado em:</span>
                        <span class="text-gray-900">{{ $budget->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Última atualização:</span>
                        <span class="text-gray-900">{{ $budget->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Evento:</span>
                        <a href="{{ route('panel.events.show', $budget->event) }}" class="text-purple-600 hover:text-purple-800">{{ $budget->event->title }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
