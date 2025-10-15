@extends('panel.layout')

@section('page-title', 'Relatório de Métodos de Pagamento')
@section('page-subtitle', 'Análise das formas de pagamento utilizadas')

@section('header-actions')
    <div class="flex space-x-3">
        <a href="{{ route('panel.events.reports.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition inline-flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Voltar</span>
        </a>
    </div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Filtros</h3>
        
        <form method="GET" action="{{ route('panel.events.reports.payment-methods') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Data Inicial</label>
                <input type="date" id="start_date" name="start_date" value="{{ $startDate }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Data Final</label>
                <input type="date" id="end_date" name="end_date" value="{{ $endDate }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    Aplicar Filtros
                </button>
            </div>
        </form>
    </div>

    <!-- Resumo dos Métodos de Pagamento -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total de Pagamentos</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $paymentsByMethod->sum('count') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Valor Total Recebido</p>
                    <p class="text-2xl font-semibold text-gray-900">R$ {{ number_format($paymentsByMethod->sum('total'), 2, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Valor Médio</p>
                    @php
                        $totalPayments = $paymentsByMethod->sum('count');
                        $totalValue = $paymentsByMethod->sum('total');
                        $averageValue = $totalPayments > 0 ? $totalValue / $totalPayments : 0;
                    @endphp
                    <p class="text-2xl font-semibold text-gray-900">R$ {{ number_format($averageValue, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pagamentos por Método -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Pagamentos por Método</h3>
            
            @if($paymentsByMethod->count() > 0)
                <div class="space-y-3">
                    @foreach($paymentsByMethod as $payment)
                        @php
                            $percentage = $paymentsByMethod->sum('total') > 0 ? ($payment->total / $paymentsByMethod->sum('total')) * 100 : 0;
                        @endphp
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @switch($payment->payment_method)
                                            @case('dinheiro') bg-green-100 text-green-800 @break
                                            @case('cartao_credito') bg-blue-100 text-blue-800 @break
                                            @case('cartao_debito') bg-indigo-100 text-indigo-800 @break
                                            @case('pix') bg-purple-100 text-purple-800 @break
                                            @case('transferencia') bg-gray-100 text-gray-800 @break
                                            @case('cheque') bg-yellow-100 text-yellow-800 @break
                                            @default bg-red-100 text-red-800 @break
                                        @endswitch">
                                        @switch($payment->payment_method)
                                            @case('dinheiro') 💵 @break
                                            @case('cartao_credito') 💳 @break
                                            @case('cartao_debito') 💳 @break
                                            @case('pix') 📱 @break
                                            @case('transferencia') 🏦 @break
                                            @case('cheque') 📄 @break
                                            @default 🔧 @break
                                        @endswitch
                                        {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                    </span>
                                    <span class="ml-3 text-sm text-gray-600">{{ $payment->count }} pagamentos</span>
                                </div>
                                <span class="text-sm font-medium text-gray-900">R$ {{ number_format($payment->total, 2, ',', '.') }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Nenhum pagamento encontrado no período.</p>
            @endif
        </div>

        <!-- Valor Médio por Método -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Valor Médio por Método</h3>
            
            @if($averageByMethod->count() > 0)
                <div class="space-y-3">
                    @foreach($averageByMethod as $method)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @switch($method->payment_method)
                                        @case('dinheiro') bg-green-100 text-green-800 @break
                                        @case('cartao_credito') bg-blue-100 text-blue-800 @break
                                        @case('cartao_debito') bg-indigo-100 text-indigo-800 @break
                                        @case('pix') bg-purple-100 text-purple-800 @break
                                        @case('transferencia') bg-gray-100 text-gray-800 @break
                                        @case('cheque') bg-yellow-100 text-yellow-800 @break
                                        @default bg-red-100 text-red-800 @break
                                    @endswitch">
                                    @switch($method->payment_method)
                                        @case('dinheiro') 💵 @break
                                        @case('cartao_credito') 💳 @break
                                        @case('cartao_debito') 💳 @break
                                        @case('pix') 📱 @break
                                        @case('transferencia') 🏦 @break
                                        @case('cheque') 📄 @break
                                        @default 🔧 @break
                                    @endswitch
                                    {{ ucfirst(str_replace('_', ' ', $method->payment_method)) }}
                                </span>
                            </div>
                            <span class="font-medium">R$ {{ number_format($method->average_amount, 2, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Nenhum dado encontrado no período.</p>
            @endif
        </div>
    </div>

    <!-- Evolução dos Métodos de Pagamento -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Evolução dos Métodos de Pagamento</h3>
        
        @if($methodEvolution->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mês</th>
                            @foreach($paymentsByMethod as $method)
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ ucfirst(str_replace('_', ' ', $method->payment_method)) }}
                                </th>
                            @endforeach
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $months = $methodEvolution->groupBy('month');
                        @endphp
                        @foreach($months as $month => $methods)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('m/Y') }}
                                </td>
                                @foreach($paymentsByMethod as $method)
                                    @php
                                        $monthMethod = $methods->where('payment_method', $method->payment_method)->first();
                                        $count = $monthMethod ? $monthMethod->count : 0;
                                        $total = $monthMethod ? $monthMethod->total : 0;
                                    @endphp
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div>{{ $count }} pagamentos</div>
                                        <div class="text-xs text-gray-500">R$ {{ number_format($total, 2, ',', '.') }}</div>
                                    </td>
                                @endforeach
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <div>{{ $methods->sum('count') }} pagamentos</div>
                                    <div class="text-xs text-gray-500">R$ {{ number_format($methods->sum('total'), 2, ',', '.') }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">Nenhum pagamento encontrado no período.</p>
        @endif
    </div>

    <!-- Análise de Performance -->
    @if($paymentsByMethod->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Análise de Performance</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Método Mais Usado</h4>
                    @php
                        $mostUsed = $paymentsByMethod->sortByDesc('count')->first();
                    @endphp
                    @if($mostUsed)
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <p class="font-medium text-blue-900">{{ ucfirst(str_replace('_', ' ', $mostUsed->payment_method)) }}</p>
                            <p class="text-sm text-blue-700">{{ $mostUsed->count }} pagamentos ({{ number_format(($mostUsed->count / $paymentsByMethod->sum('count')) * 100, 1) }}%)</p>
                        </div>
                    @endif
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Método Mais Rentável</h4>
                    @php
                        $mostProfitable = $paymentsByMethod->sortByDesc('total')->first();
                    @endphp
                    @if($mostProfitable)
                        <div class="p-3 bg-green-50 rounded-lg">
                            <p class="font-medium text-green-900">{{ ucfirst(str_replace('_', ' ', $mostProfitable->payment_method)) }}</p>
                            <p class="text-sm text-green-700">R$ {{ number_format($mostProfitable->total, 2, ',', '.') }}</p>
                        </div>
                    @endif
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Maior Ticket Médio</h4>
                    @php
                        $highestAverage = $averageByMethod->sortByDesc('average_amount')->first();
                    @endphp
                    @if($highestAverage)
                        <div class="p-3 bg-purple-50 rounded-lg">
                            <p class="font-medium text-purple-900">{{ ucfirst(str_replace('_', ' ', $highestAverage->payment_method)) }}</p>
                            <p class="text-sm text-purple-700">R$ {{ number_format($highestAverage->average_amount, 2, ',', '.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
