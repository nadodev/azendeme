@extends('panel.layout')

@section('page-title', 'Criar Orçamento')
@section('page-subtitle', 'Gere um orçamento para o evento')

@section('header-actions')
    <a href="{{ route('panel.events.show', $event) }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition inline-flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        <span>Voltar para Evento</span>
    </a>
@endsection

@section('content')
<div class="space-y-6">
    <form action="{{ route('panel.events.budgets.store', $event) }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Formulário Principal -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Resumo do Evento -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Resumo do Evento</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Evento</h4>
                            <p class="text-sm font-medium text-gray-900">{{ $event->title }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst($event->type) }} • {{ $event->event_date->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Cliente</h4>
                            <p class="text-sm font-medium text-gray-900">{{ $event->customer->name }}</p>
                            <p class="text-xs text-gray-500">{{ $event->customer->phone ?? 'Sem telefone' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Equipamentos Contratados -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Equipamentos Contratados</h3>
                    
                    @if($event->services->count() > 0)
                        <div class="space-y-4">
                            @foreach($event->services as $service)
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
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Nenhum equipamento contratado</h4>
                            <p class="text-sm text-gray-500 mb-4">Adicione equipamentos ao evento antes de criar o orçamento.</p>
                            <a href="{{ route('panel.events.show', $event) }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                                Adicionar Equipamentos
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Funcionários -->
                @if($event->employees->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Funcionários</h3>
                        
                        <div class="space-y-4">
                            @foreach($event->employees as $employee)
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
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Observações -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Observações do Orçamento</h3>
                    
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                        <textarea id="notes" name="notes" rows="4" placeholder="Adicione observações específicas para este orçamento..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Termos e Condições -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Termos e Condições</h3>
                    
                    <div>
                        <label for="terms" class="block text-sm font-medium text-gray-700 mb-2">Termos e Condições</label>
                        <textarea id="terms" name="terms" rows="6" placeholder="Ex: Pagamento à vista com 5% de desconto. Cancelamento até 48h antes do evento..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('terms') border-red-500 @enderror">{{ old('terms') }}</textarea>
                        @error('terms')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Validade -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Validade do Orçamento</h3>
                    
                    <div>
                        <label for="valid_until" class="block text-sm font-medium text-gray-700 mb-2">Válido até *</label>
                        <input type="date" id="valid_until" name="valid_until" value="{{ old('valid_until', now()->addDays(7)->format('Y-m-d')) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('valid_until') border-red-500 @enderror" required>
                        @error('valid_until')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Desconto -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Desconto</h3>
                    
                    <div>
                        <label for="discount_percentage" class="block text-sm font-medium text-gray-700 mb-2">Desconto (%)</label>
                        <input type="number" id="discount_percentage" name="discount_percentage" step="0.01" min="0" max="100" value="{{ old('discount_percentage', 0) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('discount_percentage') border-red-500 @enderror">
                        @error('discount_percentage')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Resumo Financeiro -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Resumo Financeiro</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Equipamentos:</span>
                            <span class="text-sm font-medium text-gray-900">R$ {{ number_format($event->total_equipment_value, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Funcionários:</span>
                            <span class="text-sm font-medium text-gray-900">R$ {{ number_format($event->total_employee_value, 2, ',', '.') }}</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-900">Subtotal:</span>
                                <span class="text-sm font-medium text-gray-900">R$ {{ number_format($event->total_value, 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Desconto:</span>
                                <span class="text-sm text-red-600" id="discount-display">R$ 0,00</span>
                            </div>
                            <div class="flex justify-between mt-2">
                                <span class="text-base font-semibold text-gray-900">Total:</span>
                                <span class="text-base font-semibold text-gray-900" id="total-display">R$ {{ number_format($event->total_value, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ações -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="space-y-3">
                        <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                            Criar Orçamento
                        </button>
                        <a href="{{ route('panel.events.show', $event) }}" class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition text-center block">
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const discountInput = document.getElementById('discount_percentage');
    const discountDisplay = document.getElementById('discount-display');
    const totalDisplay = document.getElementById('total-display');
    const subtotal = {{ $event->total_value }};

    function updateTotals() {
        const discountPercentage = parseFloat(discountInput.value) || 0;
        const discountValue = (subtotal * discountPercentage) / 100;
        const total = subtotal - discountValue;

        discountDisplay.textContent = 'R$ ' + discountValue.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        totalDisplay.textContent = 'R$ ' + total.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    discountInput.addEventListener('input', updateTotals);
    updateTotals(); // Initial calculation
});
</script>
@endsection
