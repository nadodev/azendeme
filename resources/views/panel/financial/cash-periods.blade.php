@extends('panel.layout')

@section('page-title', 'Períodos de Caixa')
@section('page-subtitle', 'Controle de fechamento diário, semanal e mensal')

@section('content')
<div class="space-y-6">
    <!-- Tabs de Tipo de Período -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6">
                <a href="?type=daily" class="border-transparent {{ $periodType === 'daily' ? 'border-purple-500 text-purple-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Diário
                </a>
                <a href="?type=weekly" class="border-transparent {{ $periodType === 'weekly' ? 'border-purple-500 text-purple-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Semanal
                </a>
                <a href="?type=monthly" class="border-transparent {{ $periodType === 'monthly' ? 'border-purple-500 text-purple-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Mensal
                </a>
            </nav>
        </div>

        <div class="p-6">
            <!-- Botão para Abrir Novo Período -->
            <div class="mb-6">
                <button onclick="openModal()" class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Abrir Novo Período {{ ucfirst($periodType === 'daily' ? 'Diário' : ($periodType === 'weekly' ? 'Semanal' : 'Mensal')) }}
                </button>
            </div>

            <!-- Lista de Períodos -->
            <div class="space-y-4">
                @forelse($periods as $period)
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ $period->period_start->format('d/m/Y') }} - {{ $period->period_end->format('d/m/Y') }}
                                    </h3>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $period->status === 'open' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $period->status === 'open' ? 'Aberto' : 'Fechado' }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-xs text-gray-600 mb-1">Saldo Inicial</p>
                                        <p class="text-lg font-bold text-gray-900">R$ {{ number_format($period->opening_balance, 2, ',', '.') }}</p>
                                    </div>
                                    <div class="bg-green-50 rounded-lg p-3">
                                        <p class="text-xs text-green-600 mb-1">Entradas</p>
                                        <p class="text-lg font-bold text-green-600">R$ {{ number_format($period->total_income, 2, ',', '.') }}</p>
                                    </div>
                                    <div class="bg-red-50 rounded-lg p-3">
                                        <p class="text-xs text-red-600 mb-1">Saídas</p>
                                        <p class="text-lg font-bold text-red-600">R$ {{ number_format($period->total_expense, 2, ',', '.') }}</p>
                                    </div>
                                    <div class="bg-purple-50 rounded-lg p-3">
                                        <p class="text-xs text-purple-600 mb-1">Saldo Final</p>
                                        <p class="text-lg font-bold text-purple-600">R$ {{ number_format($period->closing_balance, 2, ',', '.') }}</p>
                                    </div>
                                </div>

                                <div class="text-sm text-gray-600 space-y-1">
                                    <p>📊 Transações: {{ $period->total_transactions }} | 📅 Agendamentos: {{ $period->total_appointments }}</p>
                                    @if($period->status === 'closed' && $period->closedBy)
                                        <p>Fechado por {{ $period->closedBy->name }} em {{ $period->closed_at->format('d/m/Y H:i') }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="ml-4 flex flex-col gap-2">
                                @if($period->status === 'open')
                                    <form action="{{ route('panel.financeiro.periodos.close', $period->id) }}" method="POST" onsubmit="return confirm('Fechar este período? Esta ação não pode ser desfeita.')">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm font-semibold">
                                            Fechar Período
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('panel.financeiro.periodos.report', $period->id) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-semibold text-center">
                                        Ver Relatório PDF
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-gray-500 mb-4">Nenhum período encontrado</p>
                        <button onclick="openModal()" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                            Criar primeiro período
                        </button>
                    </div>
                @endforelse
            </div>

            @if($periods->hasPages())
                <div class="mt-6">
                    {{ $periods->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para Abrir Período -->
<div id="openPeriodModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Abrir Novo Período de Caixa</h3>
            
            <form method="POST" action="{{ route('panel.financeiro.periodos.open') }}" class="space-y-4">
                @csrf

                <input type="hidden" name="period_type" value="{{ $periodType }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Período</label>
                    <input type="text" value="{{ ucfirst($periodType === 'daily' ? 'Diário' : ($periodType === 'weekly' ? 'Semanal' : 'Mensal')) }}" readonly class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Data de Início *</label>
                    <input type="date" name="period_start" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Saldo Inicial (R$) *</label>
                    <input type="number" name="opening_balance" value="0.00" step="0.01" min="0" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                        Abrir Período
                    </button>
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('openPeriodModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('openPeriodModal').classList.add('hidden');
}
</script>
@endsection

