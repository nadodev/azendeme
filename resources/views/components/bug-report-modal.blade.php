<!-- Modal de Relatório de Bugs -->
<div id="bugReportModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <!-- Header -->
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white p-6 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            🐛
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Reportar Bug</h3>
                            <p class="text-purple-100 text-sm">Ajude-nos a melhorar o sistema</p>
                        </div>
                    </div>
                    <button onclick="closeBugReportModal()" class="text-white/80 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Form -->
            <form id="bugReportForm" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="source" value="landing">
                <input type="hidden" name="page_url" id="currentPageUrl">
                <input type="hidden" name="user_agent" id="userAgent">

                <div>
                    <label for="bugName" class="block text-sm font-semibold text-gray-700 mb-2">Nome *</label>
                    <input type="text" id="bugName" name="name" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                           placeholder="Seu nome completo">
                </div>

                <div>
                    <label for="bugEmail" class="block text-sm font-semibold text-gray-700 mb-2">E-mail *</label>
                    <input type="email" id="bugEmail" name="email" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                           placeholder="seu@email.com">
                </div>

                <div>
                    <label for="bugSubject" class="block text-sm font-semibold text-gray-700 mb-2">Assunto *</label>
                    <input type="text" id="bugSubject" name="subject" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                           placeholder="Resumo do problema">
                </div>

                <div>
                    <label for="bugDescription" class="block text-sm font-semibold text-gray-700 mb-2">Descrição do Problema *</label>
                    <textarea id="bugDescription" name="description" required rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition resize-none"
                              placeholder="Descreva detalhadamente o problema encontrado, incluindo passos para reproduzir..."></textarea>
                </div>

                <!-- Loading/Status -->
                <div id="bugReportStatus" class="hidden">
                    <div class="flex items-center gap-2 text-sm">
                        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-purple-600"></div>
                        <span>Enviando relatório...</span>
                    </div>
                </div>

                <!-- Error Message -->
                <div id="bugReportError" class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm"></div>

                <!-- Success Message -->
                <div id="bugReportSuccess" class="hidden bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm"></div>

                <!-- Actions -->
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeBugReportModal()" 
                            class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold">
                        Cancelar
                    </button>
                    <button type="submit" id="bugReportSubmit"
                            class="flex-1 px-4 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transition font-semibold">
                        Enviar Relatório
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openBugReportModal() {
    // Preencher dados automáticos
    document.getElementById('currentPageUrl').value = window.location.href;
    document.getElementById('userAgent').value = navigator.userAgent;
    
    // Mostrar modal
    document.getElementById('bugReportModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Focar no primeiro campo
    document.getElementById('bugName').focus();
}

function closeBugReportModal() {
    document.getElementById('bugReportModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    
    // Limpar formulário
    document.getElementById('bugReportForm').reset();
    document.getElementById('bugReportStatus').classList.add('hidden');
    document.getElementById('bugReportError').classList.add('hidden');
    document.getElementById('bugReportSuccess').classList.add('hidden');
}

// Submit do formulário
document.getElementById('bugReportForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = this;
    const submitBtn = document.getElementById('bugReportSubmit');
    const statusDiv = document.getElementById('bugReportStatus');
    const errorDiv = document.getElementById('bugReportError');
    const successDiv = document.getElementById('bugReportSuccess');
    
    // Esconder mensagens anteriores
    errorDiv.classList.add('hidden');
    successDiv.classList.add('hidden');
    
    // Mostrar loading
    statusDiv.classList.remove('hidden');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Enviando...';
    
    try {
        const formData = new FormData(form);
        
        const response = await fetch('/bug-report', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            successDiv.textContent = data.message;
            successDiv.classList.remove('hidden');
            
            // Limpar formulário após sucesso
            setTimeout(() => {
                closeBugReportModal();
            }, 2000);
        } else {
            if (data.errors) {
                const errorMessages = Object.values(data.errors).flat().join('\n');
                errorDiv.textContent = errorMessages;
            } else {
                errorDiv.textContent = data.message || 'Erro ao enviar relatório. Tente novamente.';
            }
            errorDiv.classList.remove('hidden');
        }
    } catch (error) {
        errorDiv.textContent = 'Erro de conexão. Verifique sua internet e tente novamente.';
        errorDiv.classList.remove('hidden');
    } finally {
        statusDiv.classList.add('hidden');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Enviar Relatório';
    }
});

// Fechar modal com ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeBugReportModal();
    }
});
</script>
