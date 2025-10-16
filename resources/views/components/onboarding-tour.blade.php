@if(auth()->check() && !auth()->user()->onboarding_completed)
<!-- Driver.js CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css"/>

<!-- Driver.js Script -->
<script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuração do Driver.js
    const driver = window.driver.js.driver;

    // Inicializa o tour
    const onboardingTour = driver({
        showProgress: true,
        showButtons: ['next', 'previous', 'close'],
        progressText: 'Passo @{{current}} de @{{total}}',
        nextBtnText: 'Próximo →',
        prevBtnText: '← Anterior',
        doneBtnText: 'Começar! ✓',
        closeBtnText: 'Pular Tour',
        onDestroyStarted: () => {
            // Quando o usuário fechar ou concluir o tour
            if (!onboardingTour.hasNextStep()) {
                // Tour completo - chegou no último passo
                markOnboardingComplete();
                onboardingTour.destroy();
            } else {
                // Tour pulado - fechou antes do último passo
                skipOnboarding();
                onboardingTour.destroy();
            }
        },
        steps: [
            {
                element: '#dashboard-link',
                popover: {
                    title: '👋 Bem-vindo ao aZendeMe!',
                    description: 'Este é o seu painel principal. Aqui você terá uma visão geral do seu negócio. Vamos fazer um tour rápido!',
                    side: "bottom",
                    align: 'start'
                }
            },
            {
                popover: {
                    title: '📋 Primeiros Passos',
                    description: `
                        <div class="space-y-3">
                            <p class="font-semibold">Para começar a receber agendamentos, você precisa:</p>
                            <ol class="list-decimal list-inside space-y-2 text-sm">
                                <li><strong>Serviços:</strong> Cadastre os serviços que você oferece (nome, duração, preço)</li>
                                <li><strong>Disponibilidade:</strong> Configure seus horários de atendimento</li>
                                <li><strong>Funcionários:</strong> (Opcional) Adicione funcionários se trabalhar em equipe</li>
                                <li><strong>Perfil Público:</strong> Personalize sua página de agendamento</li>
                            </ol>
                            <p class="mt-3 text-xs text-gray-500">Você encontra tudo isso no menu lateral esquerdo 👈</p>
                        </div>
                    `
                }
            },
            {
                element: '#public-page-link',
                popover: {
                    title: '🔗 Sua Página de Agendamento',
                    description: `
                        <div class="space-y-3">
                            <p>Este é o link da sua página pública de agendamento!</p>
                            <p class="text-sm">Compartilhe este link com seus clientes para que eles possam agendar online.</p>
                        </div>
                    `,
                    side: "left",
                    align: 'end'
                }
            },
            {
                popover: {
                    title: '🎉 Tudo Pronto!',
                    description: `
                        <div class="space-y-3">
                            <p class="font-semibold">Agora é só começar!</p>
                            <p class="text-sm">Cadastre seus serviços, configure seus horários e compartilhe o link da sua página.</p>
                            <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                <p class="text-xs text-blue-800">
                                    💡 <strong>Dica:</strong> Você pode acessar este tour novamente em <strong>Configurações</strong>
                                </p>
                            </div>
                        </div>
                    `
                }
            }
        ]
    });

    // Inicia o tour após um pequeno delay para garantir que os elementos estejam carregados
    setTimeout(() => {
        onboardingTour.drive();
    }, 500);

    // Função para marcar onboarding como completo
    function markOnboardingComplete() {
        fetch('{{ route("panel.onboarding.complete") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Onboarding concluído!');
            }
        })
        .catch(error => console.error('Erro ao completar onboarding:', error));
    }

    // Função para pular onboarding
    function skipOnboarding() {
        fetch('{{ route("panel.onboarding.skip") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Onboarding pulado');
            }
        })
        .catch(error => console.error('Erro ao pular onboarding:', error));
    }
});
</script>

<!-- Estilos customizados para o tour -->
<style>
    /* Customização do Driver.js */
    .driver-popover {
        max-width: 400px !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2) !important;
    }

    .driver-popover-title {
        font-size: 1.25rem !important;
        font-weight: 600 !important;
        color: #1a202c !important;
        margin-bottom: 0.5rem !important;
    }

    .driver-popover-description {
        font-size: 0.95rem !important;
        line-height: 1.6 !important;
        color: #4a5568 !important;
    }

    .driver-popover-footer {
        margin-top: 1rem !important;
    }

    .driver-popover-next-btn,
    .driver-popover-prev-btn {
        background: var(--brand, #3b82f6) !important;
        color: white !important;
        border: none !important;
        padding: 0.5rem 1rem !important;
        border-radius: 0.5rem !important;
        font-weight: 500 !important;
        transition: all 0.2s !important;
    }

    .driver-popover-next-btn:hover,
    .driver-popover-prev-btn:hover {
        opacity: 0.9 !important;
        transform: translateY(-1px) !important;
    }

    .driver-popover-close-btn {
        color: #9ca3af !important;
        font-size: 1.5rem !important;
    }

    .driver-popover-close-btn:hover {
        color: #4b5563 !important;
    }

    .driver-popover-progress-text {
        font-size: 0.875rem !important;
        color: #6b7280 !important;
    }
</style>
@endif

