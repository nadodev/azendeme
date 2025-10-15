@extends('panel.layout')

@section('page-title', 'Criar Ordem de Serviço')
@section('page-subtitle', 'Selecione o evento para criar a ordem de serviço')

@section('header-actions')
    <a href="{{ route('panel.events.service-orders.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition inline-flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        <span>Voltar</span>
    </a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Selecione um Evento</h3>
        
        @if($events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($events as $event)
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-medium text-gray-900">{{ $event->title }}</h4>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                {{ ucfirst($event->type) }}
                            </span>
                        </div>
                        
                        <div class="text-sm text-gray-600 mb-3">
                            <p><strong>Cliente:</strong> {{ $event->customer->name }}</p>
                            <p><strong>Data:</strong> {{ $event->event_date->format('d/m/Y') }}</p>
                            <p><strong>Horário:</strong> {{ $event->start_time->format('H:i') }} - {{ $event->end_time->format('H:i') }}</p>
                        </div>
                        
                        <div class="flex space-x-2">
                            <a href="{{ route('panel.events.service-orders.create', $event) }}" 
                               class="flex-1 px-3 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition text-center">
                                Criar OS
                            </a>
                            <a href="{{ route('panel.events.show', $event) }}" 
                               class="px-3 py-2 bg-gray-200 text-gray-800 text-sm rounded-lg hover:bg-gray-300 transition">
                                Ver
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-6">
                {{ $events->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum evento encontrado</h3>
                <p class="mt-1 text-sm text-gray-500">Você precisa ter eventos cadastrados para criar ordens de serviço.</p>
                <div class="mt-6">
                    <a href="{{ route('panel.events.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Criar Evento
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
