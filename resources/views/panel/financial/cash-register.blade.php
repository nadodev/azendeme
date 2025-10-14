@extends('panel.layout')

@section('page-title', 'Controle de Caixa')
@section('page-subtitle', 'Gerencie a abertura e fechamento do caixa')

@section('content')
<div class="space-y-6">
    <!-- Caixa de Hoje -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            Caixa de Hoje - {{ date('d/m/Y') }}
        </h3>

        @if($todayRegister)
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Saldo Inicial</p>
                    <p class="text-2xl font-bold text-gray-900">R$ {{ number_format($todayRegister->opening_balance, 2, ',', '.') }}</p>
                </div>

                <div class="bg-green-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Total de Entradas</p>
                    <p class="text-2xl font-bold text-green-600">R$ {{ number_format($todayRegister->total_income, 2, ',', '.') }}</p>
                </div>

                <div class="bg-red-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Total de Saídas</p>
                    <p class="text-2xl font-bold text-red-600">R$ {{ number_format($todayRegister->total_expense, 2, ',', '.') }}</p>
                </div>

                <div class="bg-blue-50 rounded-lg p-4 border-2 border-blue-200">
                    <p class="text-sm text-gray-600 mb-1">Saldo Final</p>
                    <p class="text-2xl font-bold text-blue-600">R$ {{ number_format($todayRegister->net_balance, 2, ',', '.') }}</p>
                </div>
            </div>

            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $todayRegister->status === 'open' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $todayRegister->status === 'open' ? '✓ Caixa Aberto' : '✗ Caixa Fechado' }}
                    </span>
                    <span class="text-sm text-gray-600">
                        Aberto às {{ $todayRegister->opened_at->format('H:i') }}
                        @if($todayRegister->closed_at)
                            • Fechado às {{ $todayRegister->closed_at->format('H:i') }}
                        @endif
                    </span>
                </div>

                @if($todayRegister->status === 'open')
                    <form method="POST" action="{{ route('panel.financeiro.caixa.close', $todayRegister->id) }}" onsubmit="return confirm('Tem certeza que deseja fechar o caixa?')">
                        @csrf
                        <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            Fechar Caixa
                        </button>
                    </form>
                @endif
            </div>

            @if($todayRegister->notes)
                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-sm font-medium text-yellow-800 mb-1">Observações:</p>
                    <p class="text-sm text-yellow-700">{{ $todayRegister->notes }}</p>
                </div>
            @endif

        @else
            <!-- Formulário para Abrir Caixa -->
            <div class="max-w-md mx-auto text-center">
                <div class="mb-6">
                    <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Nenhum caixa aberto hoje</h4>
                    <p class="text-gray-600">Informe o saldo inicial para abrir o caixa</p>
                </div>

                <form method="POST" action="{{ route('panel.financeiro.caixa.open') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Saldo Inicial (R$)</label>
                        <input type="number" name="opening_balance" step="0.01" min="0" value="0.00" required class="w-full px-4 py-3 text-lg text-center border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('opening_balance')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors">
                        Abrir Caixa
                    </button>
                </form>
            </div>
        @endif
    </div>

    <!-- Histórico de Caixas -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Histórico de Caixas</h3>

        @if($recentRegisters->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Saldo Inicial</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Entradas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Saídas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Saldo Final</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentRegisters as $register)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $register->date->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    R$ {{ number_format($register->opening_balance, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-semibold">
                                    R$ {{ number_format($register->total_income, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-semibold">
                                    R$ {{ number_format($register->total_expense, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 font-bold">
                                    R$ {{ number_format($register->net_balance, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $register->status === 'open' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $register->status === 'open' ? 'Aberto' : 'Fechado' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-500">Nenhum histórico de caixa</p>
            </div>
        @endif
    </div>
</div>
@endsection

