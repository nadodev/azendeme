@extends('panel.layout')

@section('page-title', 'Serviços')
@section('page-subtitle', 'Gerencie seus serviços e preços')

@section('header-actions')
    @if($errors->has('plan'))
        <div class="mr-3 px-3 py-2 bg-yellow-100 text-yellow-800 rounded text-sm">{{ $errors->first('plan') }}</div>
    @endif
    <a href="{{ route('panel.servicos.create') }}" class="px-3 lg:px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition inline-flex items-center space-x-2 text-sm lg:text-base {{ ($reachedLimit ?? false) ? 'opacity-50 pointer-events-none' : '' }}">
        <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span class="hidden sm:inline">Novo Serviço</span>
        <span class="sm:hidden">Novo</span>
    </a>
    @if($reachedLimit ?? false)
        <a href="{{ route('panel.plans.index') }}" class="ml-2 px-3 lg:px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm lg:text-base">Upgrade</a>
    @endif
@endsection

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
    @forelse($services as $service)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 lg:p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $service->name }}</h3>
                    @if($service->description)
                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($service->description, 60) }}</p>
                    @endif
                </div>
                @if($service->active)
                    <span class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Ativo</span>
                @else
                    <span class="px-2 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">Inativo</span>
                @endif
            </div>
            
            <div class="space-y-2 mb-4">
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $service->duration }} minutos
                </div>
                @if($service->price)
                    <div class="flex items-center text-sm font-semibold text-gray-900">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        R$ {{ number_format($service->price, 2, ',', '.') }}
                    </div>
                @endif
                @if($service->assignedEmployer)
                    <div class="flex items-center text-sm text-purple-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        {{ $service->assignedEmployer->name }}
                    </div>
                @else
                    <div class="flex items-center text-sm text-gray-500 italic">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Qualquer funcionário
                    </div>
                @endif
            </div>

            <div class="flex space-x-2 pt-4 border-t border-gray-200">
                <a href="{{ route('panel.servicos.edit', $service) }}" class="flex-1 px-4 py-2 text-center text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    Editar
                </a>
                <form method="POST" action="{{ route('panel.servicos.destroy', $service) }}" onsubmit="return confirm('Tem certeza que deseja excluir este serviço?')" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition">
                        Excluir
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-full bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            <p class="text-gray-500 mb-4">Nenhum serviço cadastrado</p>
            <a href="{{ route('panel.servicos.create') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 font-medium">
                Criar primeiro serviço
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    @endforelse
</div>
@endsection

