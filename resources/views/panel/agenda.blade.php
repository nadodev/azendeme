@extends('panel.layout')

@section('page-title', 'Agenda')
@section('page-subtitle', 'Gerencie seus agendamentos')

@php
    // Breadcrumb customizado para a página de agenda
    $customBreadcrumb = [
        'Dashboard' => route('panel.dashboard'),
        'Agenda' => null
    ];
@endphp

@section('content')

<!-- Cards de Resumo -->
@if($appointments->count() > 0)
    <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $appointments->count() }}</p>
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
                    <p class="text-sm text-gray-500 mb-1">Confirmados</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $appointments->where('status', 'confirmed')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Pendentes</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $appointments->where('status', 'pending')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Concluídos</p>
                    <p class="text-2xl font-bold text-green-600">{{ $appointments->where('status', 'completed')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Abas de visualização -->
<div class="mb-6 border-b border-gray-200">
    <nav class="-mb-px flex space-x-8">
        <button onclick="switchView('calendar')" id="calendar-tab" class="view-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Calendário
        </button>
        <button onclick="switchView('list')" id="list-tab" class="view-tab border-purple-500 text-purple-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
            </svg>
            Lista
        </button>
    </nav>
</div>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <a href="{{ route('panel.agenda.create') }}" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Novo Agendamento
    </a>

    <!-- Filtros -->
    <form method="GET" class="flex flex-wrap gap-3">
        <input type="date" name="date" value="{{ $date }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        
        <select name="service_id" class="px-8 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            <option value="">Todos os serviços</option>
            @foreach($services as $service)
                <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                    {{ $service->name }}
                </option>
            @endforeach
        </select>

        <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            <option value="">Todos os status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendente</option>
            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmado</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Concluído</option>
            <option value="no-show" {{ request('status') == 'no-show' ? 'selected' : '' }}>Não Compareceu</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
        </select>

        <button type="submit" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
            Filtrar
        </button>
        <a href="{{ route('panel.agenda.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
            Limpar
        </a>
    </form>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    </div>
@endif

@if(session('feedback_link'))
    <div class="mb-6 p-6 bg-blue-50 border-2 border-blue-200 rounded-xl">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-blue-900">🎉 Link de Feedback Gerado!</h3>
                    <p class="text-sm text-blue-700">Envie este link para o cliente avaliar o serviço</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg p-4 mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Link do Formulário de Feedback:</label>
            <div class="flex gap-2">
                <input type="text" value="{{ session('feedback_link') }}" id="feedback-url" readonly 
                    class="flex-1 px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg font-mono text-sm">
                <button onclick="copyFeedbackUrl()" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold whitespace-nowrap">
                    📋 Copiar
                </button>
            </div>
        </div>

        <div class="flex gap-3">
            <a href="https://wa.me/?text={{ urlencode('Olá! Por favor, avalie nosso serviço: ' . session('feedback_link')) }}" target="_blank" 
                class="flex-1 px-4 py-3 bg-green-500 hover:bg-green-600 text-white rounded-lg transition font-semibold text-center">
                💬 Enviar via WhatsApp
            </a>
            <a href="mailto:?subject=Avalie nosso serviço&body={{ urlencode('Olá! Por favor, avalie nosso serviço clicando no link: ' . session('feedback_link')) }}" 
                class="flex-1 px-4 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition font-semibold text-center">
                📧 Enviar via E-mail
            </a>
        </div>
    </div>

    <script>
        function copyFeedbackUrl() {
            const input = document.getElementById('feedback-url');
            input.select();
            document.execCommand('copy');
            
            const button = event.target;
            const originalText = button.textContent;
            button.textContent = '✅ Copiado!';
            button.classList.add('bg-green-600');
            button.classList.remove('bg-blue-600');
            
            setTimeout(() => {
                button.textContent = originalText;
                button.classList.remove('bg-green-600');
                button.classList.add('bg-blue-600');
            }, 2000);
        }
    </script>
@endif

<!-- Visualização Calendário -->
<div id="calendar-view" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hidden">
    <!-- Controles do Calendário -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-4">
            <button id="prev-month" class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button id="today-btn" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                Hoje
            </button>
            <button id="next-month" class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
        
        <h2 id="current-month" class="text-xl font-bold text-gray-900">Outubro 2025</h2>
        
        <div class="flex items-center gap-2">
            <button id="view-month" class="px-4 py-2 bg-purple-600 text-white rounded-lg font-semibold">Mês</button>
            <button id="view-week" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold">Semana</button>
            <button id="view-day" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold">Dia</button>
        </div>
    </div>

    <!-- Calendário Customizado -->
    <div id="custom-calendar" class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <!-- Cabeçalho dos dias da semana -->
        <div class="sticky top-0 z-10">
            <div class="grid grid-cols-7 bg-gradient-to-r from-purple-50 via-gray-50 to-blue-50 border-b border-gray-200">
                <div class="p-3 text-center text-xs sm:text-sm font-semibold text-gray-700 border-r border-gray-200">Dom</div>
                <div class="p-3 text-center text-xs sm:text-sm font-semibold text-gray-700 border-r border-gray-200">Seg</div>
                <div class="p-3 text-center text-xs sm:text-sm font-semibold text-gray-700 border-r border-gray-200">Ter</div>
                <div class="p-3 text-center text-xs sm:text-sm font-semibold text-gray-700 border-r border-gray-200">Qua</div>
                <div class="p-3 text-center text-xs sm:text-sm font-semibold text-gray-700 border-r border-gray-200">Qui</div>
                <div class="p-3 text-center text-xs sm:text-sm font-semibold text-gray-700 border-r border-gray-200">Sex</div>
                <div class="p-3 text-center text-xs sm:text-sm font-semibold text-gray-700">Sáb</div>
            </div>
        </div>
        
        <!-- Grid do calendário (com rolagem horizontal no mobile) -->
        <div class="overflow-x-auto">
            <div class="min-w-[980px]">
                <div id="calendar-grid" class="grid grid-cols-7">
                    <!-- Dias serão inseridos aqui via JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Legenda de Status -->
    <div class="mt-6 flex flex-wrap gap-4 justify-center">
        <div class="flex items-center gap-2">
            <div class="w-4 h-4 bg-yellow-400 rounded-full"></div>
            <span class="text-sm text-gray-600">Pendente</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
            <span class="text-sm text-gray-600">Confirmado</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-4 h-4 bg-green-500 rounded-full"></div>
            <span class="text-sm text-gray-600">Concluído</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-4 h-4 bg-red-500 rounded-full"></div>
            <span class="text-sm text-gray-600">Cancelado</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-4 h-4 bg-orange-500 rounded-full"></div>
            <span class="text-sm text-gray-600">Não Compareceu</span>
        </div>
    </div>
</div>

<!-- Visualização Lista -->
<div id="list-view" class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    @if($appointments->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data/Hora</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profissional</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serviço</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($appointments as $appointment)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($appointment->start_time)->format('d/m/Y') }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $appointment->customer->name }}</div>
                                <div class="text-sm text-gray-500">{{ $appointment->customer->phone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($appointment->professional_id)
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full flex items-center justify-center text-white font-bold text-xs">
                                            {{ substr($appointment->professional->name ?? 'P', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $appointment->professional->name ?? 'Profissional' }}</div>
                                            @if($appointment->professional && $appointment->professional->specialty)
                                                <div class="text-xs text-gray-500">{{ $appointment->professional->specialty }}</div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 text-xs">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                        </div>
                                        <div class="text-sm text-gray-500 italic">Qualquer profissional</div>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($appointment->has_multiple_services)
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                            </svg>
                                            {{ $appointment->appointmentServices->count() }} Serviços
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-600 space-y-1">
                                        @foreach($appointment->appointmentServices as $appService)
                                            <div>• {{ $appService->service->name }} ({{ $appService->duration }}min)</div>
                                        @endforeach
                                    </div>
                                    <div class="text-xs font-semibold text-gray-700 mt-1">
                                        Total: {{ $appointment->total_duration }} min
                                    </div>
                                @else
                                    <div class="text-sm text-gray-900">{{ $appointment->service->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $appointment->service->duration }} min</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses[$appointment->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusLabels[$appointment->status] ?? $appointment->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    @if($appointment->status === 'pending')
                                        <form action="{{ route('panel.agenda.update-status', $appointment->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs font-semibold" title="Confirmar">
                                                ✓ Confirmar
                                            </button>
                                        </form>
                                        <form action="{{ route('panel.agenda.update-status', $appointment->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-semibold" title="Cancelar" onclick="return confirm('Tem certeza que deseja cancelar este agendamento?')">
                                                ✗ Recusar
                                            </button>
                                        </form>
                                    @elseif($appointment->status === 'confirmed')
                                        <button onclick="openPaymentModal({{ $appointment->id }}, '{{ addslashes($appointment->customer->name) }}', '{{ addslashes($appointment->service->name) }}', {{ $appointment->service->price }})" class="px-3 py-1 bg-purple-600 text-white rounded hover:bg-purple-700 text-xs font-semibold" title="Marcar como Atendido">
                                            💰 Atendido
                                        </button>
                                        <form action="{{ route('panel.agenda.update-status', $appointment->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="no-show">
                                            <button type="submit" class="px-3 py-1 bg-orange-600 text-white rounded hover:bg-orange-700 text-xs font-semibold" title="Não Compareceu" onclick="return confirm('Marcar como não compareceu?')">
                                                ⊘ Faltou
                                            </button>
                                        </form>
                                    @elseif($appointment->status === 'completed')
                                        <form action="{{ route('panel.agenda.generate-feedback', $appointment->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs font-semibold" title="Gerar Link de Feedback">
                                                ⭐ Feedback
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('panel.agenda.edit', $appointment->id) }}" class="text-blue-600 hover:text-blue-700">
                                        Editar
                                    </a>
                                    <form action="{{ route('panel.agenda.destroy', $appointment->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este agendamento?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Nenhum agendamento encontrado</h3>
            <p class="text-gray-500 mb-4">Não há agendamentos para os filtros selecionados.</p>
            <a href="{{ route('panel.agenda.create') }}" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Criar Primeiro Agendamento
            </a>
        </div>
    @endif
</div>
</div>

<style>
    /* Estilos do Calendário Customizado */
    .calendar-day {
        min-height: 120px;
        border-right: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
        padding: 10px;
        position: relative;
        background: white;
        transition: background-color 0.2s, box-shadow 0.2s, transform 0.08s ease-in-out;
        outline: none;
    }
    
    .calendar-day:hover {
        background-color: #f9fafb;
        box-shadow: inset 0 0 0 1px #e5e7eb;
    }
    
    .calendar-day.today {
        background: linear-gradient(180deg, #fff7ed 0%, #fffbeb 100%);
        box-shadow: inset 0 0 0 2px #f59e0b;
    }

    .calendar-day.selected {
        background: linear-gradient(180deg, #eef2ff 0%, #f5f3ff 100%);
        box-shadow: inset 0 0 0 2px #6366f1, 0 2px 6px rgba(99,102,241,0.2);
        transform: translateY(-1px);
    }
    
    .calendar-day.other-month {
        background-color: #f9fafb;
        color: #9ca3af;
    }
    
    .calendar-day-number {
        font-weight: 700;
        margin-bottom: 6px;
        font-size: 13px;
        color: #111827;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .calendar-day-number .dot {
        width: 6px;
        height: 6px;
        border-radius: 9999px;
        background: #d1d5db;
        display: inline-block;
    }
    
    .appointment-item {
        background: white;
        border-radius: 4px;
        padding: 2px 6px;
        margin-bottom: 2px;
        font-size: 11px;
        cursor: pointer;
        border-left: 3px solid;
        box-shadow: 0 1px 2px rgba(0,0,0,0.08);
        transition: all 0.15s ease;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .appointment-item:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.15);
    }
    
    .appointment-item.pending {
        border-left-color: #f59e0b;
        background: #fef3c7;
        color: #92400e;
    }
    
    .appointment-item.confirmed {
        border-left-color: #3b82f6;
        background: #dbeafe;
        color: #1e40af;
    }
    
    .appointment-item.completed {
        border-left-color: #10b981;
        background: #d1fae5;
        color: #065f46;
    }
    
    .appointment-item.cancelled {
        border-left-color: #ef4444;
        background: #fee2e2;
        color: #991b1b;
    }
    
    .appointment-item.no-show {
        border-left-color: #f97316;
        background: #fed7aa;
        color: #9a3412;
    }
    
    .appointment-time {
        font-weight: 600;
        font-size: 10px;
    }
    
    .appointment-customer {
        font-weight: 500;
    }
    
    .appointment-service {
        font-size: 10px;
        opacity: 0.8;
    }
    
    .more-appointments {
        background: #6b7280;
        color: white;
        border-radius: 4px;
        padding: 2px 6px;
        font-size: 10px;
        font-weight: 600;
        cursor: pointer;
        text-align: center;
        margin-top: 2px;
    }
    
    .more-appointments:hover {
        background: #4b5563;
    }
    
    /* Modal de Agendamentos */
    .appointment-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        padding: 20px;
    }
    
    .appointment-modal-content {
        background: white;
        border-radius: 12px;
        max-width: 500px;
        width: 100%;
        max-height: 80vh;
        overflow-y: auto;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
    }
    
    /* Responsividade */
    @media (max-width: 768px) {
        .calendar-day {
            min-height: 74px;
            padding: 6px;
        }
        
        .appointment-item {
            font-size: 10px;
            padding: 1px 4px;
        }
        
        .appointment-time {
            font-size: 9px;
        }
        
        .appointment-customer {
            font-size: 10px;
        }
        
        .appointment-service {
            font-size: 9px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dados dos agendamentos
    const appointments = @json($calendarEvents);
    const currentDate = new Date();
    let selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate());
    let currentMonth = selectedDate.getMonth();
    let currentYear = selectedDate.getFullYear();
    let currentView = 'month';
    
    // Mapeamento de status para cores
    const statusColors = {
        'pending': { bg: '#fef3c7', border: '#f59e0b', text: '#92400e' },
        'confirmed': { bg: '#dbeafe', border: '#3b82f6', text: '#1e40af' },
        'completed': { bg: '#d1fae5', border: '#10b981', text: '#065f46' },
        'cancelled': { bg: '#fee2e2', border: '#ef4444', text: '#991b1b' },
        'no-show': { bg: '#fed7aa', border: '#f97316', text: '#9a3412' }
    };
    
    const statusLabels = {
        'pending': 'Pendente',
        'confirmed': 'Confirmado',
        'completed': 'Concluído',
        'cancelled': 'Cancelado',
        'no-show': 'Não Compareceu'
    };
    
    // Função para formatar data
    function formatDate(date) {
        return date.toISOString().split('T')[0];
    }
    
    // Função para obter agendamentos de um dia
    function getAppointmentsForDate(date) {
        const dateStr = formatDate(date);
        return appointments.filter(apt => {
            const aptDate = new Date(apt.start);
            return formatDate(aptDate) === dateStr;
        });
    }
    
    // Função para renderizar um dia (célula)
    function renderDay(date, isCurrentMonth = true) {
        const dayNumber = date.getDate();
        const isToday = date.toDateString() === new Date().toDateString();
        const dayAppointments = getAppointmentsForDate(date);
        
        const dayClass = `calendar-day ${!isCurrentMonth ? 'other-month' : ''} ${isToday ? 'today' : ''}`;
        
        let appointmentsHtml = '';
        const maxVisible = 3;
        
        if (dayAppointments.length > 0) {
            const visibleAppointments = dayAppointments.slice(0, maxVisible);
            const hiddenCount = dayAppointments.length - maxVisible;
            
            visibleAppointments.forEach(apt => {
                const startTime = new Date(apt.start);
                const timeStr = startTime.toLocaleTimeString('pt-BR', { 
                    hour: '2-digit', 
                    minute: '2-digit' 
                });
                
                appointmentsHtml += `
                    <div class="appointment-item ${apt.extendedProps.status}" 
                         onclick="showAppointmentModal(${apt.extendedProps.appointmentId})"
                         title="${apt.extendedProps.customer} - ${apt.extendedProps.service}">
                        <div class="appointment-time">${timeStr}</div>
                        <div class="appointment-customer">${apt.extendedProps.customer}</div>
                        <div class="appointment-service">${apt.extendedProps.service}</div>
                    </div>
                `;
            });
            
            if (hiddenCount > 0) {
                appointmentsHtml += `
                    <div class="more-appointments" onclick="showDayModal('${formatDate(date)}', ${dayAppointments.length})">
                        +${hiddenCount} mais
                    </div>
                `;
            }
        }
        
        const countBadge = dayAppointments.length > 0
            ? `<span class="ml-2 inline-flex items-center justify-center px-1.5 min-w-[1.25rem] h-5 rounded-full text-[10px] font-bold text-white"
                 style="background: linear-gradient(90deg,#6366f1,#8b5cf6);">${dayAppointments.length}</span>`
            : '';

        return `
            <div class="${dayClass}" tabindex="0" role="button" aria-label="Dia ${dayNumber}" onclick="selectCalendarDay(this)">
                <div class="calendar-day-number">
                    <span>${dayNumber}</span>
                    ${countBadge}
                </div>
                <div class="appointments-container">
                    ${appointmentsHtml}
                </div>
            </div>
        `;
    }
    
    // Renderizações por visão
    function renderMonth() {
        const calendarGrid = document.getElementById('calendar-grid');
        const currentMonthEl = document.getElementById('current-month');
        const monthNames = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
            'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];
        currentMonthEl.textContent = `${monthNames[currentMonth]} ${currentYear}`;
        calendarGrid.style.gridTemplateColumns = 'repeat(7, minmax(0, 1fr))';
        calendarGrid.innerHTML = '';
        const firstDay = new Date(currentYear, currentMonth, 1);
        const lastDay = new Date(currentYear, currentMonth + 1, 0);
        const firstDayWeekday = firstDay.getDay();
        const prevMonth = new Date(currentYear, currentMonth, 0);
        for (let i = firstDayWeekday - 1; i >= 0; i--) {
            const day = new Date(prevMonth.getFullYear(), prevMonth.getMonth(), prevMonth.getDate() - i);
            calendarGrid.innerHTML += renderDay(day, false);
        }
        for (let day = 1; day <= lastDay.getDate(); day++) {
            const date = new Date(currentYear, currentMonth, day);
            calendarGrid.innerHTML += renderDay(date, true);
        }
        const totalCells = calendarGrid.children.length;
        const remainingCells = 42 - totalCells;
        const nextMonth = new Date(currentYear, currentMonth + 1, 1);
        for (let day = 1; day <= remainingCells; day++) {
            const date = new Date(nextMonth.getFullYear(), nextMonth.getMonth(), day);
            calendarGrid.innerHTML += renderDay(date, false);
        }
    }

    function startOfWeek(date) {
        const d = new Date(date);
        const day = d.getDay(); // 0-6
        const diff = d.getDate() - day; // domingo como início
        return new Date(d.getFullYear(), d.getMonth(), diff);
    }

    function renderWeek() {
        const calendarGrid = document.getElementById('calendar-grid');
        const currentMonthEl = document.getElementById('current-month');
        const start = startOfWeek(selectedDate);
        const end = new Date(start);
        end.setDate(start.getDate() + 6);
        calendarGrid.style.gridTemplateColumns = 'repeat(7, minmax(0, 1fr))';
        calendarGrid.innerHTML = '';
        for (let i = 0; i < 7; i++) {
            const date = new Date(start);
            date.setDate(start.getDate() + i);
            const inCurrentMonth = date.getMonth() === currentMonth && date.getFullYear() === currentYear;
            calendarGrid.innerHTML += renderDay(date, inCurrentMonth);
        }
        const options = { day: '2-digit', month: 'short' };
        currentMonthEl.textContent = `${start.toLocaleDateString('pt-BR', options)} — ${end.toLocaleDateString('pt-BR', options)} ${end.getFullYear()}`;
    }

    function renderDayView() {
        const calendarGrid = document.getElementById('calendar-grid');
        const currentMonthEl = document.getElementById('current-month');
        calendarGrid.style.gridTemplateColumns = 'repeat(1, minmax(0, 1fr))';
        calendarGrid.innerHTML = renderDay(selectedDate, true);
        const options = { weekday: 'long', day: '2-digit', month: 'long', year: 'numeric' };
        currentMonthEl.textContent = selectedDate.toLocaleDateString('pt-BR', options);
    }

    function renderCalendar() {
        if (currentView === 'month') return renderMonth();
        if (currentView === 'week') return renderWeek();
        return renderDayView();
    }
    
    // Event listeners
    document.getElementById('prev-month').addEventListener('click', () => {
        if (currentView === 'month') {
            currentMonth--;
            if (currentMonth < 0) { currentMonth = 11; currentYear--; }
            selectedDate = new Date(currentYear, currentMonth, 1);
        } else if (currentView === 'week') {
            selectedDate.setDate(selectedDate.getDate() - 7);
            currentMonth = selectedDate.getMonth();
            currentYear = selectedDate.getFullYear();
        } else {
            selectedDate.setDate(selectedDate.getDate() - 1);
            currentMonth = selectedDate.getMonth();
            currentYear = selectedDate.getFullYear();
        }
        renderCalendar();
    });
    
    document.getElementById('next-month').addEventListener('click', () => {
        if (currentView === 'month') {
            currentMonth++;
            if (currentMonth > 11) { currentMonth = 0; currentYear++; }
            selectedDate = new Date(currentYear, currentMonth, 1);
        } else if (currentView === 'week') {
            selectedDate.setDate(selectedDate.getDate() + 7);
            currentMonth = selectedDate.getMonth();
            currentYear = selectedDate.getFullYear();
        } else {
            selectedDate.setDate(selectedDate.getDate() + 1);
            currentMonth = selectedDate.getMonth();
            currentYear = selectedDate.getFullYear();
        }
        renderCalendar();
    });
    
    document.getElementById('today-btn').addEventListener('click', () => {
        const today = new Date();
        selectedDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
        currentMonth = selectedDate.getMonth();
        currentYear = selectedDate.getFullYear();
        renderCalendar();
    });
    
    // Botões de visualização
    document.getElementById('view-month').addEventListener('click', () => {
        currentView = 'month';
        // alinhar selectedDate ao primeiro dia do mês
        selectedDate = new Date(currentYear, currentMonth, 1);
        updateViewButtons();
        renderCalendar();
    });
    
    document.getElementById('view-week').addEventListener('click', () => {
        currentView = 'week';
        // manter selectedDate, central para a semana
        updateViewButtons();
        renderCalendar();
    });
    
    document.getElementById('view-day').addEventListener('click', () => {
        currentView = 'day';
        // manter selectedDate no dia atual
        updateViewButtons();
        renderCalendar();
    });
    
    function updateViewButtons() {
        const buttons = ['view-month', 'view-week', 'view-day'];
        buttons.forEach(btnId => {
            const btn = document.getElementById(btnId);
            const view = btnId.replace('view-', '');
            if (view === currentView) {
                btn.className = 'px-4 py-2 bg-purple-600 text-white rounded-lg font-semibold';
            } else {
                btn.className = 'px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold';
            }
        });
    }
    
    // Função para mostrar modal de agendamento individual
    window.showAppointmentModal = function(appointmentId) {
        const appointment = appointments.find(apt => apt.extendedProps.appointmentId === appointmentId);
        if (!appointment) return;
        
        const startTime = new Date(appointment.start);
        const endTime = new Date(appointment.end);
        
        const modal = `
            <div class="appointment-modal" onclick="if(event.target === this) this.remove()">
                <div class="appointment-modal-content">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold text-gray-900">Detalhes do Agendamento</h3>
                            <button onclick="this.closest('.appointment-modal').remove()" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Cliente</p>
                                    <p class="font-semibold text-gray-900">${appointment.extendedProps.customer}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Telefone</p>
                                    <p class="font-semibold text-gray-900">${appointment.extendedProps.phone}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Serviço</p>
                                    <p class="font-semibold text-gray-900">${appointment.extendedProps.service}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Data/Hora</p>
                                    <p class="font-semibold text-gray-900">
                                        ${startTime.toLocaleDateString('pt-BR')} 
                                        ${startTime.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' })} - 
                                        ${endTime.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' })}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Status</p>
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full" 
                                          style="background-color: ${statusColors[appointment.extendedProps.status].bg}; color: ${statusColors[appointment.extendedProps.status].text};">
                                        ${statusLabels[appointment.extendedProps.status]}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex gap-3">
                            <a href="/panel/agenda/${appointmentId}/edit" 
                               class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-center font-semibold transition">
                                ✏️ Editar
                            </a>
                            <button onclick="this.closest('.appointment-modal').remove()" 
                                    class="flex-1 px-4 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-semibold transition">
                                Fechar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', modal);
    };
    
    // Função para mostrar modal de dia com todos os agendamentos
    window.showDayModal = function(dateStr, totalCount) {
        const date = new Date(dateStr);
        const dayAppointments = getAppointmentsForDate(date);
        
        const modal = `
            <div class="appointment-modal" onclick="if(event.target === this) this.remove()">
                <div class="appointment-modal-content">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold text-gray-900">
                                ${date.toLocaleDateString('pt-BR', { 
                                    weekday: 'long', 
                                    year: 'numeric', 
                                    month: 'long', 
                                    day: 'numeric' 
                                })}
                            </h3>
                            <button onclick="this.closest('.appointment-modal').remove()" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="space-y-3">
                            ${dayAppointments.map(apt => {
                                const startTime = new Date(apt.start);
                                const timeStr = startTime.toLocaleTimeString('pt-BR', { 
                                    hour: '2-digit', 
                                    minute: '2-digit' 
                                });
                                
                                return `
                                    <div class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer"
                                         onclick="showAppointmentModal(${apt.extendedProps.appointmentId})">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-semibold"
                                                     style="background-color: ${statusColors[apt.extendedProps.status].border}">
                                                    ${timeStr}
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-900">${apt.extendedProps.customer}</p>
                                                    <p class="text-sm text-gray-600">${apt.extendedProps.service}</p>
                                                </div>
                                            </div>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                                  style="background-color: ${statusColors[apt.extendedProps.status].bg}; color: ${statusColors[apt.extendedProps.status].text};">
                                                ${statusLabels[apt.extendedProps.status]}
                                            </span>
                                        </div>
                                    </div>
                                `;
                            }).join('')}
                        </div>
                        
                        <div class="mt-6 text-center">
                            <button onclick="this.closest('.appointment-modal').remove()" 
                                    class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-semibold transition">
                                Fechar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', modal);
    };
    

    // Inicializar calendário
    renderCalendar();

    // Seleção visual de dia no calendário
    window.selectCalendarDay = function(el) {
        document.querySelectorAll('#calendar-grid .calendar-day.selected').forEach(d => d.classList.remove('selected'));
        el.classList.add('selected');
    };

    // Gestos de swipe para trocar mês no mobile
    (function enableSwipeNavigation() {
        const container = document.getElementById('custom-calendar');
        if (!container) return;
        let touchStartX = 0;
        let touchEndX = 0;
        let touchStartY = 0;

        container.addEventListener('touchstart', (e) => {
            const t = e.changedTouches[0];
            touchStartX = t.clientX;
            touchStartY = t.clientY;
        }, { passive: true });

        container.addEventListener('touchend', (e) => {
            const t = e.changedTouches[0];
            touchEndX = t.clientX;
            const dx = touchEndX - touchStartX;
            const dy = Math.abs(t.clientY - touchStartY);
            // Ignorar rolagem vertical predominante
            if (dy > Math.abs(dx)) return;
            // Threshold para swipe
            if (dx > 60) {
                // swipe right -> mês anterior
                document.getElementById('prev-month').click();
            } else if (dx < -60) {
                // swipe left -> próximo mês
                document.getElementById('next-month').click();
            }
        }, { passive: true });
    })();
});

// Modal de Pagamento - Funções globais
window.openPaymentModal = async function(appointmentId, customerName, serviceName, price) {
    console.log('Opening modal for appointment:', appointmentId);
    
    const modal = document.getElementById('payment-modal');
    const form = document.getElementById('payment-form');
    
    if (!modal || !form) {
        console.error('Modal ou form não encontrado!');
        return;
    }
    
    modal.classList.remove('hidden');
    document.getElementById('modal-appointment-id').value = appointmentId;
    document.getElementById('modal-customer-name').textContent = customerName;
    document.getElementById('modal-service-name').textContent = serviceName;
    document.getElementById('modal-original-price').textContent = 'R$ ' + parseFloat(price).toFixed(2).replace('.', ',');
    document.getElementById('modal-final-price').textContent = 'R$ ' + parseFloat(price).toFixed(2).replace('.', ',');
    
    // Armazena preço original para cálculos
    window.originalPrice = parseFloat(price);
    window.currentPrice = parseFloat(price);
    
    // Atualizar action do formulário
    form.action = '/panel/agenda/' + appointmentId + '/mark-completed';
    console.log('Form action set to:', form.action);
    
    // Buscar pontos de fidelidade do cliente
    await loadCustomerLoyalty(appointmentId);
};

window.loadCustomerLoyalty = async function(appointmentId) {
    console.log('Loading loyalty for appointment:', appointmentId);
    
    const loyaltySection = document.getElementById('loyalty-section');
    const loyaltyLoading = document.getElementById('loyalty-loading');
    const loyaltyContent = document.getElementById('loyalty-content');
    
    if (!loyaltySection || !loyaltyLoading || !loyaltyContent) {
        console.error('Elementos de fidelidade não encontrados!');
        return;
    }
    
    loyaltySection.classList.remove('hidden');
    loyaltyLoading.classList.remove('hidden');
    loyaltyContent.classList.add('hidden');
    
    try {
        const response = await fetch(`/panel/agenda/${appointmentId}/customer-loyalty`);
        const data = await response.json();
        
        loyaltyLoading.classList.add('hidden');
        
        // Sempre mostrar a seção de fidelidade
        document.getElementById('customer-points').textContent = data.points || 0;
        
        const rewardsContainer = document.getElementById('rewards-container');
        rewardsContainer.innerHTML = '';
        
        if (data.rewards && data.rewards.length > 0) {
            data.rewards.forEach(reward => {
                const canRedeem = data.points >= reward.points_required;
                const rewardDiv = document.createElement('div');
                rewardDiv.className = `p-3 border rounded-lg cursor-pointer transition ${canRedeem ? 'border-green-300 bg-green-50 hover:bg-green-100' : 'border-gray-200 bg-gray-50'}`;
                rewardDiv.onclick = canRedeem ? () => applyRewardDiscount(reward) : null;
                
                rewardDiv.innerHTML = `
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">${reward.name}</p>
                            <p class="text-xs text-gray-600">${reward.description}</p>
                            <p class="text-xs text-orange-600 font-semibold">${reward.points_required} pts</p>
                        </div>
                    </div>
                    ${canRedeem ? '<span class="text-xs text-green-600 font-semibold">✓ Disponível</span>' : '<span class="text-xs text-gray-400">Pontos insuficientes</span>'}
                `;
                
                rewardsContainer.appendChild(rewardDiv);
            });
            
            loyaltyContent.classList.remove('hidden');
        } else {
            loyaltyContent.innerHTML = '<p class="text-sm text-gray-500 text-center py-2">Nenhuma recompensa disponível</p>';
            loyaltyContent.classList.remove('hidden');
        }
    } catch (error) {
        console.error('Erro ao carregar fidelidade:', error);
        loyaltyLoading.classList.add('hidden');
        loyaltyContent.innerHTML = '<p class="text-sm text-red-500 text-center py-2">Erro ao carregar recompensas</p>';
        loyaltyContent.classList.remove('hidden');
    }
};

window.applyRewardDiscount = function(reward) {
    const discountAmount = parseFloat(reward.discount_value);
    const discountType = reward.reward_type;
    
    let newPrice = window.originalPrice;
    
    if (discountType === 'percentage') {
        newPrice = window.originalPrice * (1 - discountAmount / 100);
    } else if (discountType === 'fixed') {
        newPrice = Math.max(0, window.originalPrice - discountAmount);
    } else if (discountType === 'free_service') {
        newPrice = 0;
    }
    
    window.currentPrice = newPrice;
    document.getElementById('modal-final-price').textContent = 'R$ ' + newPrice.toFixed(2).replace('.', ',');
    
    // Adicionar indicador visual
    const loyaltySection = document.getElementById('loyalty-section');
    loyaltySection.classList.add('ring-2', 'ring-green-400');
    
    // Armazenar recompensa selecionada
    window.selectedReward = reward;
};

window.clearRewardDiscount = function() {
    window.currentPrice = window.originalPrice;
    document.getElementById('modal-final-price').textContent = 'R$ ' + window.originalPrice.toFixed(2).replace('.', ',');
    
    const loyaltySection = document.getElementById('loyalty-section');
    loyaltySection.classList.remove('ring-2', 'ring-green-400');
    
    window.selectedReward = null;
};

window.closePaymentModal = function() {
    document.getElementById('payment-modal').classList.add('hidden');
};

// Gerenciar troca de visualização
window.switchView = function(view) {
    const calendarView = document.getElementById('calendar-view');
    const listView = document.getElementById('list-view');
    const listSummary = document.getElementById('list-summary');
    const calendarTab = document.getElementById('calendar-tab');
    const listTab = document.getElementById('list-tab');

    if (view === 'calendar') {
        if (calendarView) calendarView.classList.remove('hidden');
        if (listView) listView.classList.add('hidden');
        if (listSummary) listSummary.classList.add('hidden');
        if (calendarTab) {
            calendarTab.classList.remove('border-transparent', 'text-gray-500');
            calendarTab.classList.add('border-purple-500', 'text-purple-600');
        }
        if (listTab) {
            listTab.classList.remove('border-purple-500', 'text-purple-600');
            listTab.classList.add('border-transparent', 'text-gray-500');
        }
        // Não precisamos mais do calendar.updateSize() pois não usamos FullCalendar
    } else {
        if (calendarView) calendarView.classList.add('hidden');
        if (listView) listView.classList.remove('hidden');
        if (listSummary) listSummary.classList.remove('hidden');
        if (listTab) {
            listTab.classList.remove('border-transparent', 'text-gray-500');
            listTab.classList.add('border-purple-500', 'text-purple-600');
        }
        if (calendarTab) {
            calendarTab.classList.remove('border-purple-500', 'text-purple-600');
            calendarTab.classList.add('border-transparent', 'text-gray-500');
        }
    }
};
</script>

<!-- Modal de Pagamento -->
<div id="payment-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white my-10">
        <div class="mt-3">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                💰 Finalizar Atendimento
            </h3>
            
            <div class="mb-4 p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg border-2 border-purple-200">
                <div class="flex justify-between mb-2">
                    <span class="text-sm text-gray-600">Cliente:</span>
                    <span class="text-sm font-semibold" id="modal-customer-name"></span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-sm text-gray-600">Serviço:</span>
                    <span class="text-sm font-semibold" id="modal-service-name"></span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-sm text-gray-600">Valor Original:</span>
                    <span class="text-sm font-semibold line-through text-gray-500" id="modal-original-price"></span>
                </div>
                <div id="discount-info" class="hidden mb-2 p-2 bg-green-100 rounded border border-green-300">
                    <div class="flex justify-between text-sm">
                        <span class="text-green-700 font-semibold">⭐ Desconto Fidelidade:</span>
                        <span class="text-green-700 font-semibold" id="discount-amount"></span>
                    </div>
                    <div class="text-xs text-green-600 text-right" id="discount-points"></div>
                </div>
                <div class="flex justify-between pt-2 border-t-2 border-purple-300">
                    <span class="text-base font-bold text-gray-800">Valor Final:</span>
                    <span class="text-xl font-bold text-purple-600" id="modal-final-price"></span>
                </div>
            </div>

            <form id="payment-form" method="POST" action="">
                @csrf
                <input type="hidden" id="modal-appointment-id" name="appointment_id">
                
                <!-- Seção de Fidelidade -->
                <div id="loyalty-section" class="hidden mb-4 p-4 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg border-2 border-yellow-200">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-sm font-bold text-gray-800">⭐ Pontos de Fidelidade</h4>
                        <div class="text-lg font-bold text-orange-600">
                            <span id="customer-points">0</span> pts
                        </div>
                    </div>

                    <div id="loyalty-loading" class="text-center py-4">
                        <div class="animate-spin inline-block w-6 h-6 border-2 border-current border-t-transparent text-orange-600 rounded-full"></div>
                        <p class="text-xs text-gray-600 mt-2">Carregando recompensas...</p>
                    </div>

                    <div id="loyalty-content" class="hidden space-y-2">
                        <p class="text-xs text-gray-600 mb-2">Cliente quer resgatar alguma recompensa?</p>
                        <div id="rewards-container" class="space-y-2 max-h-48 overflow-y-auto"></div>
                        <button type="button" onclick="clearRewardDiscount()" class="text-xs text-purple-600 hover:text-purple-700 font-semibold mt-2">
                            Limpar seleção
                        </button>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Método de Pagamento *</label>
                        <select name="payment_method_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Selecione...</option>
                            @php
                                $paymentMethods = \App\Models\PaymentMethod::where('professional_id', 1)->where('active', true)->orderBy('order')->get();
                            @endphp
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method->id }}">{{ $method->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Valor Recebido</label>
                        <input type="text" name="amount_paid" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="R$ 0,00">
                        <p class="text-xs text-gray-500 mt-1">Deixe vazio para usar o valor final</p>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Observações (opcional)</label>
                    <textarea name="notes" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Informações adicionais sobre o pagamento..."></textarea>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="flex-1 px-4 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transition font-semibold">
                        ✓ Confirmar Pagamento e Concluir
                    </button>
                    <button type="button" onclick="closePaymentModal()" class="px-4 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
