@extends('panel.layout')

@section('title', 'Recibo - ' . $receipt->receipt_number)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Recibo #{{ $receipt->receipt_number }}</h1>
            <p class="text-gray-600 mt-2">{{ $receipt->event->title }} - {{ $receipt->event->customer->name }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('panel.events.receipts.pdf', $receipt) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                PDF
            </a>
            <a href="{{ route('panel.events.receipts.edit', $receipt) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors">
                Editar
            </a>
            <a href="{{ route('panel.events.receipts.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                Voltar
            </a>
        </div>
    </div>

    <!-- Status Badge -->
    <div class="mb-6">
        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
            @if($receipt->status === 'rascunho') bg-gray-100 text-gray-800
            @elseif($receipt->status === 'emitido') bg-blue-100 text-blue-800
            @elseif($receipt->status === 'pago') bg-green-100 text-green-800
            @elseif($receipt->status === 'cancelado') bg-red-100 text-red-800
            @else bg-gray-100 text-gray-800 @endif">
            {{ ucfirst($receipt->status) }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Receipt Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Detalhes do Recibo</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Número do Recibo</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $receipt->receipt_number }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Data de Emissão</label>
                        <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($receipt->receipt_date)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Valor</label>
                        <p class="mt-1 text-sm text-gray-900 font-semibold">R$ {{ number_format($receipt->amount, 2, ',', '.') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Forma de Pagamento</label>
                        <p class="mt-1 text-sm text-gray-900">{{ ucfirst($receipt->payment_method) }}</p>
                    </div>
                </div>
            </div>

            <!-- Event Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Informações do Evento</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Título do Evento</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $receipt->event->title }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tipo de Evento</label>
                        <p class="mt-1 text-sm text-gray-900">{{ ucfirst($receipt->event->event_type) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Data do Evento</label>
                        <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($receipt->event->event_date)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Local</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $receipt->event->address }}, {{ $receipt->event->city }}/{{ $receipt->event->state }}</p>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Informações do Cliente</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nome</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $receipt->event->customer->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $receipt->event->customer->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Telefone</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $receipt->event->customer->phone ?? 'Não informado' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">CPF/CNPJ</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $receipt->event->customer->document ?? 'Não informado' }}</p>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            @if($receipt->payment)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Informações do Pagamento</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Data do Pagamento</label>
                        <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($receipt->payment->payment_date)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Valor Pago</label>
                        <p class="mt-1 text-sm text-gray-900 font-semibold">R$ {{ number_format($receipt->payment->amount, 2, ',', '.') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Método de Pagamento</label>
                        <p class="mt-1 text-sm text-gray-900">{{ ucfirst($receipt->payment->payment_method) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            @if($receipt->payment->status === 'pendente') bg-yellow-100 text-yellow-800
                            @elseif($receipt->payment->status === 'confirmado') bg-green-100 text-green-800
                            @elseif($receipt->payment->status === 'cancelado') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($receipt->payment->status) }}
                        </span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Notes -->
            @if($receipt->notes)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Observações</h2>
                <p class="text-sm text-gray-700">{{ $receipt->notes }}</p>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ações</h3>
                <div class="space-y-3">
                    <a href="{{ route('panel.events.receipts.pdf', $receipt) }}" target="_blank" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors text-center block">
                        Gerar PDF
                    </a>
                    <a href="{{ route('panel.events.receipts.edit', $receipt) }}" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors text-center block">
                        Editar Recibo
                    </a>
                    @if($receipt->status === 'rascunho')
                        <form method="POST" action="{{ route('panel.events.receipts.issue', $receipt) }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                                Emitir Recibo
                            </button>
                        </form>
                    @endif
                    @if($receipt->status === 'emitido')
                        <form method="POST" action="{{ route('panel.events.receipts.mark-as-paid', $receipt) }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                                Marcar como Pago
                            </button>
                        </form>
                    @endif
                    <form method="POST" action="{{ route('panel.events.receipts.destroy', $receipt) }}" class="w-full" onsubmit="return confirm('Tem certeza que deseja excluir este recibo?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                            Excluir Recibo
                        </button>
                    </form>
                </div>
            </div>

            <!-- Receipt Summary -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Resumo</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Valor Total:</span>
                        <span class="text-sm font-semibold text-gray-900">R$ {{ number_format($receipt->amount, 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Status:</span>
                        <span class="text-sm font-semibold
                            @if($receipt->status === 'pago') text-green-600
                            @elseif($receipt->status === 'emitido') text-blue-600
                            @elseif($receipt->status === 'cancelado') text-red-600
                            @else text-gray-600 @endif">
                            {{ ucfirst($receipt->status) }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Criado em:</span>
                        <span class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($receipt->created_at)->format('d/m/Y H:i') }}</span>
                    </div>
                    @if($receipt->updated_at != $receipt->created_at)
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Atualizado em:</span>
                        <span class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($receipt->updated_at)->format('d/m/Y H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
