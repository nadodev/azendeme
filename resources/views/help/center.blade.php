@extends('landing.layout')

@section('content')
<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-black mb-4">Central de Ajuda</h1>
            <p class="text-lg text-gray-600">Encontre respostas rápidas ou fale com nosso suporte</p>
        </div>

        <div class="mb-10">
            <form method="GET" action="{{ route('help.center') }}" class="relative max-w-3xl mx-auto">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Busque por agendamentos, clientes, pagamentos..." class="w-full pl-12 pr-4 py-4 rounded-2xl border-2 border-gray-200 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">🔎</span>
            </form>
        </div>

        {{-- <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl border-2 border-gray-100 p-6">
                <h3 class="text-xl font-bold mb-4">Começando</h3>
                <ul class="space-y-3 text-gray-700">
                    <li><a class="hover:text-purple-600" href="#">Criar sua conta</a></li>
                    <li><a class="hover:text-purple-600" href="#">Configurar seu perfil profissional</a></li>
                    <li><a class="hover:text-purple-600" href="#">Publicar sua página</a></li>
                </ul>
            </div>

            <div class="bg-white rounded-2xl border-2 border-gray-100 p-6">
                <h3 class="text-xl font-bold mb-4">Agenda</h3>
                <ul class="space-y-3 text-gray-700">
                    <li><a class="hover:text-purple-600" href="#">Criar e editar agendamentos</a></li>
                    <li><a class="hover:text-purple-600" href="#">Confirmar e cancelar</a></li>
                    <li><a class="hover:text-purple-600" href="#">Lembretes e notificações</a></li>
                </ul>
            </div>

            <div class="bg-white rounded-2xl border-2 border-gray-100 p-6">
                <h3 class="text-xl font-bold mb-4">Financeiro</h3>
                <ul class="space-y-3 text-gray-700">
                    <li><a class="hover:text-purple-600" href="#">Relatórios e dashboards</a></li>
                    <li><a class="hover:text-purple-600" href="#">Métodos de pagamento</a></li>
                    <li><a class="hover:text-purple-600" href="#">Receitas por serviço</a></li>
                </ul>
            </div>
        </div> --}}

        <div class="mt-12 bg-white rounded-2xl border-2 border-gray-100 p-6">
            <h3 class="text-2xl font-bold mb-6">Perguntas Frequentes</h3>
            <div class="space-y-4">
                <details class="group border rounded-xl p-4">
                    <summary class="flex cursor-pointer list-none items-center justify-between">
                        <h4 class="text-lg font-semibold">Como personalizar as cores dos templates?</h4>
                        <span class="transition group-open:rotate-180">⌄</span>
                    </summary>
                    <p class="mt-3 text-gray-600">Acesse o painel em Aparência > Cores, defina por seção e salve. Você pode restaurar os padrões a qualquer momento.</p>
                </details>
                <details class="group border rounded-xl p-4">
                    <summary class="flex cursor-pointer list-none items-center justify-between">
                        <h4 class="text-lg font-semibold">Como ver relatórios financeiros?</h4>
                        <span class="transition group-open:rotate-180">⌄</span>
                    </summary>
                    <p class="mt-3 text-gray-600">No painel, acesse Relatórios > Financeiros para métricas por método, serviço e mês.</p>
                </details>
                <details class="group border rounded-xl p-4">
                    <summary class="flex cursor-pointer list-none items-center justify-between">
                        <h4 class="text-lg font-semibold">Como habilitar alertas?</h4>
                        <span class="transition group-open:rotate-180">⌄</span>
                    </summary>
                    <p class="mt-3 text-gray-600">Vá em Alertas > Configurações, escolha os tipos e canais, e salve.</p>
                </details>
            </div>
        </div>
    </div>
</section>
@endsection


