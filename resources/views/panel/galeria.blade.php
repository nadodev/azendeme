@extends('panel.layout')

@section('page-title', 'Galeria de Fotos')
@section('page-subtitle', 'Gerencie as imagens da sua página pública')

@section('content')
<div class="mb-6">
    <a href="{{ route('panel.galeria.create') }}" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Adicionar Foto
    </a>
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

<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    @if($gallery->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($gallery as $photo)
                <div class="group relative">
                    <div class="aspect-square overflow-hidden rounded-lg bg-gray-100">
                        <img src="{{ $photo->image_path }}" alt="{{ $photo->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <div class="mt-3">
                        <h4 class="font-semibold text-gray-900 truncate">{{ $photo->title }}</h4>
                        @if($photo->description)
                            <p class="text-sm text-gray-500 truncate">{{ $photo->description }}</p>
                        @endif
                        <div class="flex items-center gap-2 mt-2">
                            <a href="{{ route('panel.galeria.edit', $photo->id) }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                Editar
                            </a>
                            <span class="text-gray-300">|</span>
                            <form action="{{ route('panel.galeria.destroy', $photo->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja remover esta foto?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:text-red-700 font-medium">
                                    Remover
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Nenhuma foto na galeria</h3>
            <p class="text-gray-500 mb-4">Adicione fotos para mostrar seu trabalho na página pública.</p>
            <a href="{{ route('panel.galeria.create') }}" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Adicionar Primeira Foto
            </a>
        </div>
    @endif
</div>
@endsection

