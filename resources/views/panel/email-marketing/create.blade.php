@extends('panel.layout')

@section('page-title', 'Nova Campanha de E-mail')
@section('page-subtitle', 'Defina conteúdo, público e envio')

@section('content')
    <form method="POST" action="{{ route('panel.email-marketing.store') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf

        <div class="lg:col-span-2 space-y-6">
            <!-- Informações básicas -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações da Campanha</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nome da Campanha</label>
                        <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Assunto do E-mail</label>
                        <input type="text" name="subject" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                </div>
            </div>

            <!-- Conteúdo -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Conteúdo</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Template</label>
                        <select name="template" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            @foreach(($templates ?? []) as $tpl)
                                <option value="{{ $tpl['id'] ?? $tpl->id }}">{{ $tpl['name'] ?? $tpl->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prévia (opcional)</label>
                        <input type="text" name="preheader" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Texto de pré-visualização do e-mail">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Corpo (HTML simples)</label>
                    <textarea name="html" rows="10" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="<h1>Título</h1><p>Mensagem...</p>"></textarea>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Segmentação -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Segmentação</h3>
                <div class="space-y-3">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="segments[active_customers]" value="1" class="rounded border-gray-300 text-purple-600">
                        <span class="text-sm text-gray-700">Clientes ativos</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="segments[inactive_90d]" value="1" class="rounded border-gray-300 text-purple-600">
                        <span class="text-sm text-gray-700">Clientes inativos (90 dias)</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="segments[top_customers]" value="1" class="rounded border-gray-300 text-purple-600">
                        <span class="text-sm text-gray-700">Top clientes (maior gasto)</span>
                    </label>
                </div>
            </div>

            <!-- Agendamento -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Envio</h3>
                <div class="space-y-3">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="schedule[enabled]" value="1" class="rounded border-gray-300 text-purple-600" onchange="document.getElementById('schedule-fields').classList.toggle('hidden', !this.checked)">
                        <span class="text-sm text-gray-700">Agendar envio</span>
                    </label>
                    <div id="schedule-fields" class="hidden grid grid-cols-1 gap-3">
                        <input type="datetime-local" name="schedule[datetime]" class="px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div class="pt-3 border-t border-gray-100">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Enviar teste (opcional)</label>
                        <input type="email" name="test_email" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="seu-email@exemplo.com">
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('panel.email-marketing.index') }}" class="px-5 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold">Cancelar</a>
                <button type="submit" class="px-5 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-semibold">Salvar Campanha</button>
            </div>
        </div>
    </form>
@endsection


