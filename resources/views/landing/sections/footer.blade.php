<!-- Footer -->
<footer class="bg-gray-900 text-gray-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
            <!-- Logo e Descrição -->
            <div class="lg:col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('logo.png') }}" alt="aZendeMe" class="w-8 h-8">
                    <span class="text-2xl font-black">
                        <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">aZendeMe</span>
                    </span>
                </div>
                <p class="text-gray-400 mb-6">
                    Sistema completo de agendamentos profissionais. Transforme seu negócio com tecnologia.
                </p>
            </div>

            <!-- Produto -->
            <div>
                <h4 class="text-white font-bold text-lg mb-4">Produto</h4>
                <ul class="space-y-3">
                    <li><a href="/#funcionalidades" class="hover:text-purple-400 transition">Funcionalidades</a></li>
                    <li><a href="{{ url('/funcionalidades') }}" class="hover:text-purple-400 transition">Lista Completa</a></li>
                    <li><a href="/#templates" class="hover:text-purple-400 transition">Templates</a></li>
                    <li><a href="/#precos" class="hover:text-purple-400 transition">Preços</a></li>
                    <li><a href="{{ url('/registrar') }}" class="hover:text-purple-400 transition">Começar Grátis</a></li>
                </ul>
            </div>

            <!-- Suporte -->
            <div>
                <h4 class="text-white font-bold text-lg mb-4">Suporte</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('help.center') }}" class="hover:text-purple-400 transition">Central de Ajuda</a></li>
                    <li><a href="mailto:suporte@azendeme.com.br" class="hover:text-purple-400 transition">Contato</a></li>
                    <li><a href="https://wa.me/5549999195407" target="_blank" class="hover:text-purple-400 transition">WhatsApp</a></li>
                </ul>
            </div>
        </div>

        <!-- CTA Final -->
        <div class="border-t border-gray-800 pt-12 mb-12">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-3xl p-12 text-center">
                <h3 class="text-3xl md:text-4xl font-black text-white mb-4">
                    Pronto para começar?
                </h3>
                <p class="text-xl text-purple-100 mb-8 max-w-2xl mx-auto">
                    Junte-se a centenas de profissionais que já transformaram seus negócios
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ url('/registrar') }}" class="px-10 py-4 bg-white text-purple-600 rounded-xl font-bold text-lg hover:shadow-2xl transform hover:scale-105 transition">
                        🚀 Começar Grátis
                    </a>
                    <a href="https://wa.me/5549999195407?text=Olá!%20Gostaria%20de%20conhecer%20o%20AzendaMe" target="_blank" class="px-10 py-4 bg-green-600 text-white rounded-xl font-bold text-lg border-2 border-white/30 hover:bg-green-700 transition">
                        💬 Falar no WhatsApp
                    </a>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-400 text-sm">
                © 2025 AzendeMe. Todos os direitos reservados.
            </p>
            <div class="flex gap-6 text-sm">
                <a href="{{ route('legal.terms') }}" class="hover:text-purple-400 transition">Termos de Uso</a>
                <a href="{{ route('legal.privacy') }}" class="hover:text-purple-400 transition">Política de Privacidade</a>
                <a href="{{ route('legal.cookies') }}" class="hover:text-purple-400 transition">Cookies</a>
            </div>
        </div>
    </div>
</footer>

