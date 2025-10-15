@extends('panel.layout')

@section('title', 'Profissionais')

@section('content')
<div class="p-8">
    <!-- Cabeçalho -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Profissionais da Equipe</h1>
            <p class="text-gray-600 mt-1">Gerencie os profissionais que prestam serviços</p>
        </div>
        <a href="{{ route('panel.professionals.create') }}" class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            <span>Novo Profissional</span>
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Grid de Profissionais -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($professionals as $professional)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
            <div class="p-6">
                <!-- Foto e Badge Principal -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        @if($professional->photo)
                            <img src="{{ asset('storage/' . $professional->photo) }}" alt="{{ $professional->name }}" class="w-16 h-16 rounded-full object-cover">
                        @else
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-white text-2xl font-bold">
                                {{ substr($professional->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $professional->name }}</h3>
                            @if($professional->specialty)
                                <p class="text-sm text-gray-600">{{ $professional->specialty }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Informações -->
                <div class="space-y-2 mb-4">
                    @if($professional->email)
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $professional->email }}
                        </div>
                    @endif
                    @if($professional->phone)
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $professional->phone }}
                        </div>
                    @endif
                    @if($professional->commission_percentage > 0)
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Comissão: {{ $professional->commission_percentage }}%
                        </div>
                    @endif
                </div>

                @if($professional->bio)
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $professional->bio }}</p>
                @endif

                <!-- Ações -->
                <div class="flex space-x-2">
                    <a href="{{ route('panel.professionals.edit', $professional->id) }}" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-center text-sm font-medium">
                        Editar
                    </a>
                    @if(!$professional->is_main)
                        <form action="{{ route('panel.professionals.destroy', $professional->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Deseja realmente excluir este profissional?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition text-sm font-medium">
                                Excluir
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($professionals->count() === 0)
        <div class="bg-gray-50 rounded-xl p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Nenhum profissional cadastrado</h3>
            <p class="text-gray-600 mb-4">Adicione profissionais à sua equipe para começar</p>
            <a href="{{ route('panel.professionals.create') }}" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Cadastrar Primeiro Profissional
            </a>
        </div>
    @endif
</div>
@endsection

