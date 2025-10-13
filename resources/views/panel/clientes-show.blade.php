@extends('panel.layout')

@section('page-title', 'Detalhes do Cliente')
@section('page-subtitle', $cliente->name)

@section('content')
<div class="max-w-4xl">
    <!-- Informações do Cliente -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex justify-between items-start mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Informações do Cliente</h3>
            <a href="{{ route('panel.clientes.edit', ['cliente' => $cliente->id]) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-semibold">
                Editar Cliente
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Nome</label>
                <p class="text-gray-900 font-semibold">{{ $cliente->name }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Telefone</label>
                <p class="text-gray-900 font-semibold">{{ $cliente->phone }}</p>
            </div>

            @if($cliente->email)
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">E-mail</label>
                <p class="text-gray-900">{{ $cliente->email }}</p>
            </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Cliente desde</label>
                <p class="text-gray-900">{{ $cliente->created_at->format('d/m/Y') }}</p>
            </div>

            @if($cliente->notes)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 mb-1">Observações</label>
                <p class="text-gray-900">{{ $cliente->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Estatísticas Rápidas -->
    @php
        $totalAgendamentos = $cliente->appointments->count();
        $agendamentosFuturos = $cliente->appointments->filter(fn($a) => \Carbon\Carbon::parse($a->start_time)->isFuture())->count();
        $agendamentosPassados = $totalAgendamentos - $agendamentosFuturos;
        $concluidos = $cliente->appointments->where('status', 'completed')->count();
        $cancelados = $cliente->appointments->where('status', 'cancelled')->count();
    @endphp
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalAgendamentos }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Futuros</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $agendamentosFuturos }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Concluídos</p>
                    <p class="text-2xl font-bold text-green-600">{{ $concluidos }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Cancelados</p>
                    <p class="text-2xl font-bold text-red-600">{{ $cancelados }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Agendamentos Futuros -->
    @if($agendamentosFuturos > 0)
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg mb-6">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div>
                <h4 class="font-semibold text-blue-900 mb-1">{{ $agendamentosFuturos }} Agendamento(s) Futuro(s)</h4>
                <p class="text-sm text-blue-800">Este cliente tem agendamentos marcados para as próximas datas.</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Histórico de Agendamentos -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Histórico Completo de Agendamentos</h3>

        @if($cliente->appointments && $cliente->appointments->count() > 0)
            <div class="space-y-4">
                @foreach($cliente->appointments as $appointment)
                    @php
                        $isFuturo = \Carbon\Carbon::parse($appointment->start_time)->isFuture();
                        $borderClass = $isFuturo ? 'border-blue-300 bg-blue-50' : 'border-gray-200';
                    @endphp
                    <div class="border {{ $borderClass }} rounded-lg p-4 hover:bg-gray-50 transition {{ $isFuturo ? 'shadow-md' : '' }}">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    @if($isFuturo)
                                        <span class="px-2 py-1 text-xs font-bold rounded bg-blue-600 text-white">
                                            🗓️ PRÓXIMO
                                        </span>
                                    @endif
                                    <h4 class="font-semibold text-gray-900">{{ $appointment->service->name }}</h4>
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'confirmed' => 'bg-blue-100 text-blue-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                            'completed' => 'bg-green-100 text-green-800',
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Pendente',
                                            'confirmed' => 'Confirmado',
                                            'cancelled' => 'Cancelado',
                                            'completed' => 'Concluído',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$appointment->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $statusLabels[$appointment->status] ?? $appointment->status }}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-600">
                                    <p>📅 {{ \Carbon\Carbon::parse($appointment->start_time)->format('d/m/Y H:i') }}</p>
                                    <p>⏱️ {{ $appointment->service->duration }} minutos</p>
                                    @if($appointment->service->price)
                                        <p>💰 R$ {{ number_format($appointment->service->price, 2, ',', '.') }}</p>
                                    @endif
                                </div>
                                @if($appointment->notes)
                                    <p class="text-sm text-gray-500 mt-2">📝 {{ $appointment->notes }}</p>
                                @endif
                            </div>
                            <a href="{{ route('panel.agenda.edit', ['agenda' => $appointment->id]) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                Ver Agendamento
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Estatísticas -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-900">{{ $cliente->appointments->count() }}</p>
                        <p class="text-sm text-gray-500">Total de Agendamentos</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-green-600">{{ $cliente->appointments->where('status', 'completed')->count() }}</p>
                        <p class="text-sm text-gray-500">Concluídos</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-red-600">{{ $cliente->appointments->where('status', 'cancelled')->count() }}</p>
                        <p class="text-sm text-gray-500">Cancelados</p>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Nenhum agendamento ainda</h3>
                <p class="text-gray-500">Este cliente ainda não fez nenhum agendamento.</p>
            </div>
        @endif
    </div>

    <!-- Botões de Ação -->
    <div class="mt-6 flex justify-between">
        <a href="{{ route('panel.clientes.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
            ← Voltar para Clientes
        </a>
        <form action="{{ route('panel.clientes.destroy', ['cliente' => $cliente->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este cliente? Todos os agendamentos associados também serão excluídos.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">
                Excluir Cliente
            </button>
        </form>
    </div>
</div>
@endsection

