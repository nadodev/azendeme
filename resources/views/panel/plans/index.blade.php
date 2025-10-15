@extends('panel.layout')

@section('title', 'Planos')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
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

    <!-- Header -->
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Escolha seu Plano</h1>
        <p class="text-xl text-gray-600">Selecione o plano ideal para o seu negócio</p>
    </div>

    <!-- Plans Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($plans as $key => $plan)
            <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden {{ $current === $key ? 'ring-2 ring-blue-500 scale-105' : '' }}">
                @if($current === $key)
                    <div class="absolute top-0 right-0 bg-blue-500 text-white px-4 py-1 text-sm font-medium">
                        Plano Atual
                    </div>
                @endif

                @if($key === 'premium')
                    <div class="absolute top-0 left-0 right-0 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-center py-2 text-sm font-medium">
                        Mais Popular
                    </div>
                @endif

                <div class="p-8 {{ $key === 'premium' ? 'pt-12' : '' }}">
                    <!-- Plan Icon -->
                    <div class="w-16 h-16 mx-auto mb-6 rounded-full flex items-center justify-center
                        {{ $key === 'free' ? 'bg-gray-100' : 
                           ($key === 'premium' ? 'bg-blue-100' : 'bg-purple-100') }}">
                        @if($key === 'free')
                            <svg class="w-8 h-8 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        @elseif($key === 'premium')
                            <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @else
                            <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        @endif
                    </div>

                    <!-- Plan Name & Price -->
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan['name'] }}</h3>
                        <div class="text-4xl font-bold {{ $key==='master' ? 'text-purple-600' : ($key==='premium' ? 'text-blue-600' : 'text-gray-600') }}">
                            @if($plan['price'] > 0)
                                R$ {{ number_format($plan['price'],2,',','.') }}
                                <span class="text-lg font-normal text-gray-500">/mês</span>
                            @else
                                Grátis
                            @endif
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="space-y-4 mb-8">
                        @foreach($plan['features'] as $feature)
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Limits -->
                    <div class="mb-8">
                        <h4 class="text-sm font-semibold text-gray-900 mb-3">Limites:</h4>
                        <div class="space-y-2">
                            @foreach($plan['limits'] as $limit => $value)
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600">{{ config('plans.limit_labels.' . $limit, ucfirst(str_replace('_',' ', $limit))) }}</span>
                                    <span class="font-semibold text-gray-900">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Action Button -->
                    @if($key === 'free')
                        <form method="POST" action="{{ route('panel.plans.update') }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="plan" value="{{ $key }}" />
                            <button class="w-full py-3 px-6 rounded-lg font-semibold transition-all duration-200 {{ $current === $key ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-gray-600 text-white hover:bg-gray-700' }}" @if($current === $key) disabled @endif>
                                {{ $current === $key ? 'Plano Atual' : 'Escolher ' . $plan['name'] }}
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('panel.plans.checkout') }}">
                            @csrf
                            <input type="hidden" name="plan" value="{{ $key }}" />
                            <button class="w-full py-3 px-6 rounded-lg font-semibold transition-all duration-200 {{ $current === $key ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : ($key==='master' ? 'bg-purple-600 text-white hover:bg-purple-700' : 'bg-blue-600 text-white hover:bg-blue-700') }}" @if($current === $key) disabled @endif>
                                {{ $current === $key ? 'Plano Atual' : 'Assinar ' . $plan['name'] }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Current Subscription Management -->
    @if($current !== 'free' && auth()->user()->stripe_customer_id)
        <div class="bg-white rounded-xl shadow-lg p-8 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Gerenciar Assinatura</h2>
            <p class="text-gray-600 mb-6">Acesse o portal de cobrança para atualizar seu método de pagamento, ver faturas ou cancelar sua assinatura.</p>
            <form method="POST" action="{{ route('panel.plans.billing-portal') }}">
                @csrf
                <button type="submit" class="bg-gray-100 text-gray-700 py-3 px-8 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                    Gerenciar Assinatura
                </button>
            </form>
        </div>
    @endif
</div>
@endsection
