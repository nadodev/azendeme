@extends('panel.layout')

@section('title', 'Categorias de Custos')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Categorias de Custos</h1>
            <p class="text-gray-600">Gerencie as categorias para organizar os custos dos eventos</p>
        </div>
        <a href="{{ route('panel.events.cost-categories.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
            Nova Categoria
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total de Categorias</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $categories->total() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Categorias Ativas</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $categories->where('is_active', true)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total em Custos</p>
                    <p class="text-2xl font-bold text-gray-900">R$ {{ number_format($categories->sum(function($cat) { return $cat->getTotalAmount(); }), 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories List -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Categorias</h3>
        </div>
        
        @if($categories->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($categories as $category)
                    <div class="px-6 py-4 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-4 h-4 rounded-full" style="background-color: {{ $category->color }}"></div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $category->name }}</h4>
                                    @if($category->description)
                                        <p class="text-sm text-gray-500">{{ $category->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">R$ {{ number_format($category->getTotalAmount(), 2, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">{{ $category->costs()->count() }} custos</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if($category->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Ativa
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Inativa
                                        </span>
                                    @endif
                                    <div class="flex space-x-1">
                                        <a href="{{ route('panel.events.cost-categories.show', $category) }}" class="text-purple-600 hover:text-purple-900 text-sm">
                                            Ver
                                        </a>
                                        <a href="{{ route('panel.events.cost-categories.edit', $category) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                            Editar
                                        </a>
                                        <form method="POST" action="{{ route('panel.events.cost-categories.destroy', $category) }}" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm">
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $categories->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhuma categoria encontrada</h3>
                <p class="mt-1 text-sm text-gray-500">Comece criando uma nova categoria de custos.</p>
                <div class="mt-6">
                    <a href="{{ route('panel.events.cost-categories.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                        Nova Categoria
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
