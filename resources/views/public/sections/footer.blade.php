<!-- Footer -->
<footer class="py-12" style="background: var(--brand)">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-8 mb-8 text-white">
            <div>
                <h4 class="font-bold text-lg mb-3">{{ $professional->business_name ?? $professional->name }}</h4>
                <p class="text-white/80 text-sm">{{ Str::limit($professional->bio ?? 'Profissionais dedicados.', 100) }}</p>
            </div>
            <div>
                <h5 class="font-semibold mb-3">Links</h5>
                <ul class="space-y-2 text-sm text-white/80">
                    <li><a href="#servicos" class="hover:text-white transition">Serviços</a></li>
                    <li><a href="#galeria" class="hover:text-white transition">Galeria</a></li>
                    <li><a href="#contato" class="hover:text-white transition">Sobre</a></li>
                    <li><a href="#agendar" class="hover:text-white transition">Agendar</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-semibold mb-3">Contato</h5>
                <ul class="space-y-2 text-sm text-white/80">
                    @if($professional->phone)
                        <li>📞 {{ $professional->phone }}</li>
                    @endif
                    @if($professional->email)
                        <li>✉️ {{ $professional->email }}</li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="pt-8 border-t border-white/20 text-center text-white/80 text-sm">
            <p>&copy; {{ date('Y') }} {{ $professional->business_name ?? $professional->name }}. Todos os direitos reservados.</p>
            <p class="mt-2">Desenvolvido com ❤️ por <a href="https://AzendaMe" class="text-white hover:underline">AzendaMe</a></p>
        </div>
    </div>
</footer>

