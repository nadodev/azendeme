@extends('panel.layout')

@section('title', 'Meu Perfil')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    @if(session('success'))
        <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl shadow-xl overflow-hidden">
        <div class="px-8 py-12">
            <div class="flex items-center space-x-6">
                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center overflow-hidden">
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                </div>
                <div class="text-white">
                    <h1 class="text-3xl font-bold">{{ auth()->user()->name }}</h1>
                    <p class="text-blue-100 text-lg">{{ auth()->user()->email }}</p>
                    <div class="mt-2">
                        @php
                            $currentPlan = auth()->user()->plan ?? 'free';
                            $planConfig = config('plans.' . $currentPlan);
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $currentPlan === 'free' ? 'bg-white/20 text-white' : 
                               ($currentPlan === 'premium' ? 'bg-blue-500 text-white' : 'bg-purple-500 text-white') }}">
                            {{ $planConfig['name'] ?? 'Free' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Info Card -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Informações Pessoais</h2>
                    <a href="{{ route('panel.profile.edit') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Editar</span>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nome Completo</label>
                            <p class="text-gray-900 font-medium">{{ auth()->user()->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <p class="text-gray-900 font-medium">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Membro desde</label>
                            <p class="text-gray-900 font-medium">{{ auth()->user()->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ID do Usuário</label>
                            <p class="text-gray-500 text-sm font-mono">{{ auth()->user()->id }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usage Statistics -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Estatísticas de Uso</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ auth()->user()->professional->services()->count() ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Serviços</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ auth()->user()->professional->customers()->count() ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Clientes</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">{{ auth()->user()->professional->appointments()->count() ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Agendamentos</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscription Sidebar -->
        <div class="space-y-6">
            <!-- Current Plan Card -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Plano Atual</h2>
                
                <div class="text-center mb-6">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center
                        {{ $currentPlan === 'free' ? 'bg-gray-100' : 
                           ($currentPlan === 'premium' ? 'bg-blue-100' : 'bg-purple-100') }}">
                        @if($currentPlan === 'free')
                            <svg class="w-8 h-8 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        @elseif($currentPlan === 'premium')
                            <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @else
                            <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        @endif
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $planConfig['name'] ?? 'Free' }}</h3>
                    <p class="text-gray-600 mt-2">
                        @if($currentPlan === 'free')
                            Gratuito para sempre
                        @else
                            R$ {{ number_format($planConfig['price'] ?? 0, 2, ',', '.') }}/mês
                        @endif
                    </p>
                </div>

                <!-- Plan Features -->
                <div class="space-y-3 mb-6">
                    @foreach($planConfig['features'] ?? [] as $feature)
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">{{ $feature }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <a href="{{ route('panel.plans.index') }}" class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium text-center block">
                        Ver Todos os Planos
                    </a>
                    
                    @if($currentPlan !== 'free' && auth()->user()->stripe_customer_id)
                        <form method="POST" action="{{ route('panel.plans.billing-portal') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full bg-gray-100 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                                Gerenciar Assinatura
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Plan Limits -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Limites do Plano</h2>
                <div class="space-y-4">
                    @foreach($planConfig['limits'] ?? [] as $limit => $value)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                            <span class="text-gray-700">{{ config('plans.limit_labels.' . $limit, ucfirst(str_replace('_', ' ', $limit))) }}</span>
                            <span class="font-semibold text-gray-900">{{ $value }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection