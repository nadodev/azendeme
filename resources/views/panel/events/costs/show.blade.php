@extends('panel.layout')

@section('title', 'Custo - ' . $cost->description)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $cost->description }}</h1>
            <p class="text-gray-600 mt-2">{{ $cost->event->title }} - {{ $cost->event->customer->name }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('panel.events.costs.edit', $cost) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors">
                Editar
            </a>
            <a href="{{ route('panel.events.costs.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                Voltar
            </a>
        </div>
    </div>

    <!-- Status Badge -->
    <div class="mb-6">
        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
            @if($cost->status === 'pendente') bg-yellow-100 text-yellow-800
            @elseif($cost->status === 'pago') bg-green-100 text-green-800
            @elseif($cost->status === 'cancelado') bg-red-100 text-red-800
            @else bg-gray-100 text-gray-800 @endif">
            {{ ucfirst($cost->status) }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Cost Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Detalhes do Custo</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Descrição</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $cost->description }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Categoria</label>
                        <div class="mt-1 flex items-center">
                            <div class="w-4 h-4 rounded-full mr-2" style="background-color: {{ optional($cost->costCategory)->color ?? '#E5E7EB' }}"></div>
                            <span class="text-sm text-gray-900">{{ optional($cost->costCategory)->name ?? 'Sem categoria' }}</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Valor</label>
                        <p class="mt-1 text-sm text-gray-900 font-semibold">R$ {{ number_format($cost->amount, 2, ',', '.') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Data do Custo</label>
                        <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($cost->cost_date)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fornecedor</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $cost->supplier ?? 'Não informado' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Número da Nota</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $cost->invoice_number ?? 'Não informado' }}</p>
                    </div>
                </div>
            </div>

            <!-- Event Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Informações do Evento</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Título do Evento</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $cost->event->title }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tipo de Evento</label>
                        <p class="mt-1 text-sm text-gray-900">{{ ucfirst($cost->event->event_type) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Data do Evento</label>
                        <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($cost->event->event_date)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Local</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $cost->event->address }}, {{ $cost->event->city }}/{{ $cost->event->state }}</p>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Informações do Cliente</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nome</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $cost->event->customer->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $cost->event->customer->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Telefone</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $cost->event->customer->phone ?? 'Não informado' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">CPF/CNPJ</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $cost->event->customer->document ?? 'Não informado' }}</p>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            @if($cost->payment_date)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Informações do Pagamento</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Data do Pagamento</label>
                        <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($cost->payment_date)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Método de Pagamento</label>
                        <p class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $cost->payment_method)) }}</p>
                    </div>
                    @if($cost->payment_reference)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Referência do Pagamento</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $cost->payment_reference }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Notes -->
            @if($cost->notes)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Observações</h2>
                <p class="text-sm text-gray-700">{{ $cost->notes }}</p>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ações</h3>
                <div class="space-y-3">
                    <a href="{{ route('panel.events.costs.edit', $cost) }}" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors text-center block">
                        Editar Custo
                    </a>
                    @if($cost->status === 'pendente')
                        <form method="POST" action="{{ route('panel.events.costs.mark-paid', $cost) }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                                Marcar como Pago
                            </button>
                        </form>
                    @endif
                    <form method="POST" action="{{ route('panel.events.costs.destroy', $cost) }}" class="w-full" onsubmit="return confirm('Tem certeza que deseja excluir este custo?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                            Excluir Custo
                        </button>
                    </form>
                </div>
            </div>

            <!-- Cost Summary -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Resumo</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Valor Total:</span>
                        <span class="text-sm font-semibold text-gray-900">R$ {{ number_format($cost->amount, 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Status:</span>
                        <span class="text-sm font-semibold
                            @if($cost->status === 'pago') text-green-600
                            @elseif($cost->status === 'pendente') text-yellow-600
                            @elseif($cost->status === 'cancelado') text-red-600
                            @else text-gray-600 @endif">
                            {{ ucfirst($cost->status) }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Categoria:</span>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full mr-1" style="background-color: {{ optional($cost->costCategory)->color ?? '#E5E7EB' }}"></div>
                            <span class="text-sm text-gray-900">{{ optional($cost->costCategory)->name ?? 'Sem categoria' }}</span>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Criado em:</span>
                        <span class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($cost->created_at)->format('d/m/Y H:i') }}</span>
                    </div>
                    @if($cost->updated_at != $cost->created_at)
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Atualizado em:</span>
                        <span class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($cost->updated_at)->format('d/m/Y H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Category Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Categoria</h3>
                <div class="flex items-center mb-2">
                    <div class="w-6 h-6 rounded-full mr-3" style="background-color: {{ $cost->costCategory->color }}"></div>
                    <span class="text-sm font-medium text-gray-900">{{ $cost->costCategory->name }}</span>
                </div>
                @if($cost->costCategory->description)
                    <p class="text-sm text-gray-600">{{ $cost->costCategory->description }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection