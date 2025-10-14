@extends('panel.layout')

@section('page-title', 'E-mail Marketing')
@section('page-subtitle', 'Campanhas, métricas e segmentações')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Total de Campanhas</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_campaigns'] ?? ($campaigns->count() ?? 0) }}</p>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-5">
            <p class="text-sm text-gray-500">E-mails Enviados</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_sent'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Taxa de Abertura</p>
            <p class="text-2xl font-bold {{ isset($stats['avg_open_rate']) && $stats['avg_open_rate'] > 0 ? 'text-green-600' : 'text-gray-900' }}">{{ isset($stats['avg_open_rate']) ? number_format($stats['avg_open_rate'], 2, ',', '.') : '0,00' }}%</p>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Taxa de Clique</p>
            <p class="text-2xl font-bold {{ isset($stats['avg_click_rate']) && $stats['avg_click_rate'] > 0 ? 'text-blue-600' : 'text-gray-900' }}">{{ isset($stats['avg_click_rate']) ? number_format($stats['avg_click_rate'], 2, ',', '.') : '0,00' }}%</p>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Campanhas Recentes</h3>
            <a href="{{ route('panel.email-marketing.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nova Campanha
            </a>
        </div>

        @php $items = isset($campaigns) ? $campaigns : collect(); @endphp
        @if($items->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Campanha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enviados</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Abertura</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliques</th>
                            <th class="px-6 py-3" />
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($items as $campaign)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ $campaign->name ?? 'Campanha' }}</div>
                                    <div class="text-sm text-gray-500">{{ $campaign->subject ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ ($campaign->status ?? 'draft') === 'sent' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($campaign->status ?? 'rascunho') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $campaign->sent_count ?? 0 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ isset($campaign->open_rate) ? number_format($campaign->open_rate, 2, ',', '.') : '0,00' }}%</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ isset($campaign->click_rate) ? number_format($campaign->click_rate, 2, ',', '.') : '0,00' }}%</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a href="{{ route('panel.email-marketing.show', $campaign->id ?? 0) }}" class="text-purple-600 hover:text-purple-800 font-medium">Detalhes</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12 text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <p>Nenhuma campanha encontrada.</p>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Segmentações</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-4 rounded-lg border border-gray-200">
                <div class="text-sm text-gray-500">Clientes Ativos</div>
                <div class="text-2xl font-bold text-gray-900">{{ $segments['active_customers'] ?? 0 }}</div>
            </div>
            <div class="p-4 rounded-lg border border-gray-200">
                <div class="text-sm text-gray-500">Clientes Inativos (90d)</div>
                <div class="text-2xl font-bold text-gray-900">{{ $segments['inactive_90d'] ?? 0 }}</div>
            </div>
            <div class="p-4 rounded-lg border border-gray-200">
                <div class="text-sm text-gray-500">Top Clientes</div>
                <div class="text-2xl font-bold text-gray-900">{{ $segments['top_customers'] ?? 0 }}</div>
            </div>
        </div>
    </div>

@endsection


