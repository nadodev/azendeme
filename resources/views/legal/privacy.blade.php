@extends('landing.layout')

@section('content')
<section class="relative overflow-hidden">
    <!-- Hero -->
    <div class="relative bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600">
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_30%_20%,white,transparent_40%),radial-gradient(circle_at_70%_60%,white,transparent_40%)]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative">
            <div class="flex items-center gap-2 text-white/80 text-sm mb-4">
                <a href="/" class="hover:text-white">Início</a>
                <span>›</span>
                <span>Política de Privacidade</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white mb-3">Política de Privacidade</h1>
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 text-white rounded-full text-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-300"></span>
                Última atualização: {{ now()->format('d/m/Y') }}
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid lg:grid-cols-12 gap-8">
            <!-- Sidebar -->
            <aside class="lg:col-span-3 hidden lg:block">
                <div class="sticky top-24 bg-white border-2 border-gray-100 rounded-2xl p-5">
                    <h3 class="font-bold text-gray-900 mb-4">Nesta página</h3>
                    <nav class="space-y-3 text-sm">
                        <a href="#sec-1" class="block text-gray-600 hover:text-purple-600">1. Informações Coletadas</a>
                        <a href="#sec-2" class="block text-gray-600 hover:text-purple-600">2. Uso das Informações</a>
                        <a href="#sec-3" class="block text-gray-600 hover:text-purple-600">3. Compartilhamento</a>
                        <a href="#sec-4" class="block text-gray-600 hover:text-purple-600">4. Segurança</a>
                        <a href="#sec-5" class="block text-gray-600 hover:text-purple-600">5. Seus Direitos</a>
                    </nav>
                </div>
            </aside>

            <!-- Main -->
            <div class="lg:col-span-9">
                <div class="bg-white rounded-2xl border-2 border-gray-100 p-6 md:p-10">
                    <div class="prose max-w-none prose-headings:font-bold prose-h2:text-gray-900 prose-p:text-gray-700">
                        <h2 id="sec-1">1. Informações Coletadas</h2>
                        <p>Coletamos dados necessários para operar a plataforma, como nome, e-mail e dados de agendamento.</p>

                        <h2 id="sec-2">2. Uso das Informações</h2>
                        <p>Utilizamos seus dados para fornecer o serviço, melhorar a experiência e enviar comunicações.</p>

                        <h2 id="sec-3">3. Compartilhamento</h2>
                        <p>Não vendemos seus dados. Podemos compartilhar com operadores sob contratos de confidencialidade.</p>

                        <h2 id="sec-4">4. Segurança</h2>
                        <p>Adotamos medidas técnicas e organizacionais para proteger seus dados.</p>

                        <h2 id="sec-5">5. Seus Direitos</h2>
                        <p>Você pode solicitar acesso, correção e exclusão dos seus dados.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


