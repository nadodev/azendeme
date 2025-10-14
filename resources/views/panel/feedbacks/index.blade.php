@extends('panel.layout')

@section('title', 'Gerenciar Feedbacks')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">⭐ Feedbacks dos Clientes</h1>
            <p class="text-gray-600 mt-2">Gerencie as avaliações e aprove para exibição pública</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-2 border-green-200 text-green-800 px-6 py-4 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <!-- Cards de Resumo -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border-2 border-yellow-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-yellow-600 font-semibold mb-1">Pendentes</p>
                    <p class="text-3xl font-bold text-yellow-700">{{ $pendingCount }}</p>
                </div>
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-yellow-600 mt-2">Aguardando sua aprovação</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border-2 border-green-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-600 font-semibold mb-1">Aprovados</p>
                    <p class="text-3xl font-bold text-green-700">{{ $approvedCount }}</p>
                </div>
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-green-600 mt-2">Feedbacks aprovados</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border-2 border-blue-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-600 font-semibold mb-1">Públicos</p>
                    <p class="text-3xl font-bold text-blue-700">{{ $publicCount }}</p>
                </div>
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-blue-600 mt-2">Visíveis na página pública</p>
        </div>
    </div>

    <!-- Lista de Feedbacks -->
    @if($feedbacks->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
            </svg>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Nenhum feedback ainda</h3>
            <p class="text-gray-600">Quando os clientes responderem, os feedbacks aparecerão aqui.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($feedbacks as $feedback)
                <div class="bg-white rounded-xl shadow-sm border-2 
                    {{ !$feedback->approved ? 'border-yellow-200 bg-yellow-50' : ($feedback->visible_public ? 'border-green-200' : 'border-gray-200') }} 
                    overflow-hidden hover:shadow-lg transition">
                    
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">{{ $feedback->customer->name }}</h3>
                                    
                                    <!-- Estrelas -->
                                    <div class="flex items-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $feedback->rating)
                                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endif
                                        @endfor
                                        <span class="ml-2 text-sm font-semibold text-gray-700">{{ $feedback->rating }}/5</span>
                                    </div>
                                </div>

                                <div class="text-sm text-gray-600 mb-3">
                                    <span class="font-semibold">Serviço:</span> {{ $feedback->service->name }} • 
                                    <span class="font-semibold">Data:</span> {{ $feedback->created_at->format('d/m/Y H:i') }}
                                </div>

                                @if($feedback->comment)
                                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                        <p class="text-gray-800 italic">"{{ $feedback->comment }}"</p>
                                    </div>
                                @endif

                                <!-- Status Badges -->
                                <div class="flex gap-2">
                                    @if(!$feedback->approved)
                                        <span class="px-3 py-1 bg-yellow-200 text-yellow-800 rounded-full text-xs font-semibold">
                                            ⏳ Aguardando Aprovação
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-green-200 text-green-800 rounded-full text-xs font-semibold">
                                            ✅ Aprovado
                                        </span>
                                    @endif

                                    @if($feedback->visible_public)
                                        <span class="px-3 py-1 bg-blue-200 text-blue-800 rounded-full text-xs font-semibold">
                                            👁️ Visível Publicamente
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-200 text-gray-700 rounded-full text-xs font-semibold">
                                            🔒 Oculto
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Ações -->
                        <div class="flex gap-2 pt-4 border-t border-gray-200">
                            @if(!$feedback->approved)
                                <form action="{{ route('panel.feedbacks.approve', $feedback->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold text-sm">
                                        ✅ Aprovar
                                    </button>
                                </form>
                            @endif

                            @if($feedback->approved)
                                <form action="{{ route('panel.feedbacks.toggle-visibility', $feedback->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 {{ $feedback->visible_public ? 'bg-gray-600' : 'bg-blue-600' }} text-white rounded-lg hover:opacity-90 transition font-semibold text-sm">
                                        {{ $feedback->visible_public ? '🔒 Ocultar da Página Pública' : '👁️ Mostrar na Página Pública' }}
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('panel.feedbacks.destroy', $feedback->id) }}" method="POST" class="inline" onsubmit="return confirm('Deseja realmente excluir este feedback?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold text-sm">
                                    🗑️ Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

