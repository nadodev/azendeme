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
                <span>Termos de Uso</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white mb-3">Termos de Uso</h1>
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
                        <a href="#sec-1" class="block text-gray-600 hover:text-purple-600">1. Aceitação dos Termos</a>
                        <a href="#sec-2" class="block text-gray-600 hover:text-purple-600">2. Uso da Plataforma</a>
                        <a href="#sec-3" class="block text-gray-600 hover:text-purple-600">3. Assinaturas e Pagamentos</a>
                        <a href="#sec-4" class="block text-gray-600 hover:text-purple-600">4. Conteúdo e Propriedade</a>
                        <a href="#sec-5" class="block text-gray-600 hover:text-purple-600">5. Suporte</a>
                    </nav>
                </div>
            </aside>

            <!-- Main -->
            <div class="lg:col-span-9">
                <div class="bg-white rounded-2xl border-2 border-gray-100 p-6 md:p-10">
                    <div class="prose max-w-none prose-headings:font-bold prose-h2:text-gray-900 prose-p:text-gray-700">
                        <h2 id="sec-1">1. Aceitação dos Termos</h2>
                        <p>Ao utilizar aZendame, você concorda com estes termos e com nossa Política de Privacidade.</p>

                        <h2 id="sec-2">2. Uso da Plataforma</h2>
                        <p>Você é responsável por manter suas credenciais seguras e cumprir as leis aplicáveis.</p>

                        <h2 id="sec-3">3. Assinaturas e Pagamentos</h2>
                        <p>Planos são cobrados mensalmente. Cancelamentos podem ser feitos a qualquer momento.</p>

                        <div class="my-6 p-4 rounded-xl bg-blue-50 border border-blue-200">
                            <p class="text-sm text-blue-800"><strong>Dica:</strong> para dúvidas sobre cobrança, consulte nossa <a href="{{ route('help.center') }}" class="text-blue-700 underline">Central de Ajuda</a>.</p>
                        </div>

                        <h2 id="sec-4">4. Conteúdo e Propriedade</h2>
                        <p>Você mantém a propriedade do seu conteúdo. Concede-nos licença para hospedagem e exibição.</p>

                        <h2 id="sec-5">5. Suporte</h2>
                        <p>Oferecemos suporte conforme o plano contratado.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


