@extends('panel.layout')

@section('title', 'Selecionar Evento - Novo Contrato')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Selecionar Evento</h1>
            <p class="text-gray-600">Escolha um evento para criar um novo contrato</p>
        </div>
        <a href="{{ route('panel.events.contracts.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
            Voltar
        </a>
    </div>

    <!-- Events List -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Eventos Disponíveis</h3>
        </div>
        
        @if($events->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($events as $event)
                    <div class="px-6 py-4 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $event->title }}</h4>
                                        <p class="text-sm text-gray-500">{{ $event->customer->name }}</p>
                                    </div>
                                </div>
                                <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                                    <span>Data: {{ $event->event_date->format('d/m/Y') }}</span>
                                    <span>Horário: {{ $event->start_time->format('H:i') }} - {{ $event->end_time->format('H:i') }}</span>
                                    <span>Tipo: {{ ucfirst($event->event_type) }}</span>
                                    @if($event->final_value)
                                        <span>Valor: R$ {{ number_format($event->final_value, 2, ',', '.') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $event->status === 'confirmado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                                <a href="{{ route('panel.events.contracts.create', $event) }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm">
                                    Criar Contrato
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $events->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum evento encontrado</h3>
                <p class="mt-1 text-sm text-gray-500">Crie um evento primeiro para poder gerar um contrato.</p>
                <div class="mt-6">
                    <a href="{{ route('panel.events.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                        Novo Evento
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
