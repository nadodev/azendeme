<!-- Formulário de Demonstração -->
<section id="demo" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Texto -->
            <div>
                <div class="inline-block px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold mb-4">
                    🚀 Teste Grátis
                </div>
                <h2 class="text-4xl md:text-5xl font-black mb-6">
                    Solicite uma
                    <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">demonstração gratuita</span>
                </h2>
                <p class="text-xl text-gray-600 mb-8">
                    Preencha o formulário ou fale diretamente conosco pelo WhatsApp. Nossa equipe vai configurar tudo para você!
                </p>

                <div class="space-y-6 mb-8">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center shrink-0">
                            <span class="text-2xl">⚡</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg mb-1">Configuração Rápida</h3>
                            <p class="text-gray-600">Em até 24 horas seu sistema estará pronto para usar</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center shrink-0">
                            <span class="text-2xl">🎓</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg mb-1">Treinamento Incluso</h3>
                            <p class="text-gray-600">Vídeo-aulas e suporte para você dominar o sistema</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center shrink-0">
                            <span class="text-2xl">💬</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg mb-1">Suporte Dedicado</h3>
                            <p class="text-gray-600">Equipe em português pronta para ajudar</p>
                        </div>
                    </div>
                </div>

                <!-- WhatsApp Direto -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8 border-2 border-green-200">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center text-white text-2xl">
                            📱
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Prefere falar pelo WhatsApp?</h3>
                            <p class="text-sm text-gray-600">Atendimento imediato</p>
                        </div>
                    </div>
                    <a href="https://wa.me/5511999999999?text=Olá!%20Gostaria%20de%20solicitar%20uma%20demonstração%20do%20AzendaMe" target="_blank" class="block text-center px-8 py-4 bg-green-500 hover:bg-green-600 text-white rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition">
                        💬 Falar no WhatsApp Agora
                    </a>
                    <p class="text-center text-sm text-gray-600 mt-3">Respondemos em poucos minutos!</p>
                </div>
            </div>

            <!-- Formulário -->
            <div class="bg-gradient-to-br from-purple-600 to-pink-600 rounded-3xl p-8 shadow-2xl">
                <h3 class="text-3xl font-bold text-white mb-2">Solicite uma Demo</h3>
                <p class="text-purple-100 mb-6">Preencha os dados abaixo que entraremos em contato</p>

                <form id="demoForm" class="space-y-4">
                    <div>
                        <label class="block text-white font-semibold mb-2">Nome Completo *</label>
                        <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border-2 border-white/20 bg-white/10 text-white placeholder-white/60 focus:bg-white/20 focus:border-white transition" placeholder="Digite seu nome">
                    </div>

                    <div>
                        <label class="block text-white font-semibold mb-2">WhatsApp *</label>
                        <input type="tel" name="phone" required class="w-full px-4 py-3 rounded-xl border-2 border-white/20 bg-white/10 text-white placeholder-white/60 focus:bg-white/20 focus:border-white transition" placeholder="(11) 99999-9999">
                    </div>

                    <div>
                        <label class="block text-white font-semibold mb-2">E-mail *</label>
                        <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl border-2 border-white/20 bg-white/10 text-white placeholder-white/60 focus:bg-white/20 focus:border-white transition" placeholder="seu@email.com">
                    </div>

                    <div>
                        <label class="block text-white font-semibold mb-2">Tipo de Negócio *</label>
                        <select name="business_type" required class="w-full px-4 py-3 rounded-xl border-2 border-white/20 bg-white/10 text-white focus:bg-white/20 focus:border-white transition">
                            <option value="" class="text-gray-900">Selecione...</option>
                            <option value="clinica" class="text-gray-900">Clínica Médica/Estética</option>
                            <option value="salao" class="text-gray-900">Salão de Beleza/Spa</option>
                            <option value="barbearia" class="text-gray-900">Barbearia</option>
                            <option value="tatuagem" class="text-gray-900">Estúdio de Tatuagem</option>
                            <option value="consultorio" class="text-gray-900">Consultório</option>
                            <option value="outros" class="text-gray-900">Outros</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-white font-semibold mb-2">Nome do Negócio</label>
                        <input type="text" name="business_name" class="w-full px-4 py-3 rounded-xl border-2 border-white/20 bg-white/10 text-white placeholder-white/60 focus:bg-white/20 focus:border-white transition" placeholder="Nome do seu estabelecimento">
                    </div>

                    <div>
                        <label class="block text-white font-semibold mb-2">Como conheceu o AzendaMe?</label>
                        <select name="source" class="w-full px-4 py-3 rounded-xl border-2 border-white/20 bg-white/10 text-white focus:bg-white/20 focus:border-white transition">
                            <option value="" class="text-gray-900">Selecione...</option>
                            <option value="google" class="text-gray-900">Google</option>
                            <option value="instagram" class="text-gray-900">Instagram</option>
                            <option value="facebook" class="text-gray-900">Facebook</option>
                            <option value="indicacao" class="text-gray-900">Indicação</option>
                            <option value="outros" class="text-gray-900">Outros</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-white font-semibold mb-2">Mensagem (Opcional)</label>
                        <textarea name="message" rows="3" class="w-full px-4 py-3 rounded-xl border-2 border-white/20 bg-white/10 text-white placeholder-white/60 focus:bg-white/20 focus:border-white transition resize-none" placeholder="Conte-nos mais sobre suas necessidades..."></textarea>
                    </div>

                    <button type="submit" class="w-full px-8 py-4 bg-white text-purple-600 rounded-xl font-bold text-lg hover:shadow-2xl transform hover:scale-105 transition">
                        🚀 Solicitar Demonstração Grátis
                    </button>

                    <p class="text-center text-sm text-purple-100">
                        Ao enviar, você concorda com nossos <a href="#" class="underline">termos de uso</a>
                    </p>
                </form>

                <div id="successMessage" class="hidden mt-6 p-4 bg-green-500 rounded-xl text-white text-center font-semibold">
                    ✓ Solicitação enviada! Em breve entraremos em contato.
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('demoForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);
    
    // Aqui você pode integrar com sua API/Backend
    console.log('Demo request:', data);
    
    // Mostrar mensagem de sucesso
    e.target.classList.add('hidden');
    document.getElementById('successMessage').classList.remove('hidden');
    
    // Opcional: Enviar para o WhatsApp também
    const message = `🚀 Nova solicitação de demo!\n\nNome: ${data.name}\nWhatsApp: ${data.phone}\nEmail: ${data.email}\nNegócio: ${data.business_type}\n${data.business_name ? 'Nome: ' + data.business_name : ''}\n${data.message ? 'Mensagem: ' + data.message : ''}`;
    
    // Redirecionar após 2 segundos (opcional)
    setTimeout(() => {
        window.location.href = `https://wa.me/5511999999999?text=${encodeURIComponent(message)}`;
    }, 2000);
});
</script>

