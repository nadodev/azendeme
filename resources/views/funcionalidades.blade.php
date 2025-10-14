<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Funcionalidades Completas — AzendeMe</title>
    <meta name="description" content="Veja todas as funcionalidades do AzendeMe em detalhes. Sistema completo de agendamentos com mais de 20 recursos profissionais.">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900" rel="stylesheet" />
    <style>
        .feature-detail {
            transition: all 0.3s ease;
        }
        .feature-detail:hover {
            transform: translateX(8px);
        }
    </style>
</head>
<body class="bg-gray-50 antialiased">
    
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-gray-200">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-xl">A</span>
                    </div>
                    <span class="text-2xl font-bold">
                        Azende<span class="text-purple-600">Me</span>
                    </span>
                </a>
                
                <div class="flex items-center gap-4">
                    <a href="{{ url('/') }}" class="text-gray-700 hover:text-purple-600 font-medium transition">
                        ← Voltar
                    </a>
                    <a href="{{ url('/#demo') }}" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg transition">
                        Solicitar Demo
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero -->
    <section class="py-20 bg-gradient-to-br from-purple-600 to-pink-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-6xl font-black mb-6">
                Todas as Funcionalidades
            </h1>
            <p class="text-2xl text-purple-100 max-w-3xl mx-auto mb-8">
                Conheça em detalhes cada recurso do sistema mais completo de agendamentos do Brasil
            </p>
            <div class="inline-flex items-center gap-2 px-6 py-3 bg-white/20 rounded-full text-lg font-semibold">
                ⚡ Mais de 20 funcionalidades profissionais
            </div>
        </div>
    </section>

    <!-- Índice Rápido -->
    <section class="py-12 bg-white border-b border-gray-200 sticky top-20 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-center gap-3">
                <a href="#agenda" class="px-4 py-2 bg-purple-100 text-purple-700 rounded-lg font-semibold hover:bg-purple-200 transition text-sm">Agenda</a>
                <a href="#clientes" class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg font-semibold hover:bg-blue-200 transition text-sm">Clientes</a>
                <a href="#servicos" class="px-4 py-2 bg-pink-100 text-pink-700 rounded-lg font-semibold hover:bg-pink-200 transition text-sm">Serviços</a>
                <a href="#fidelidade" class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg font-semibold hover:bg-yellow-200 transition text-sm">Fidelidade</a>
                <a href="#promocoes" class="px-4 py-2 bg-red-100 text-red-700 rounded-lg font-semibold hover:bg-red-200 transition text-sm">Promoções</a>
                <a href="#feedback" class="px-4 py-2 bg-amber-100 text-amber-700 rounded-lg font-semibold hover:bg-amber-200 transition text-sm">Feedbacks</a>
                <a href="#financeiro" class="px-4 py-2 bg-green-100 text-green-700 rounded-lg font-semibold hover:bg-green-200 transition text-sm">Financeiro</a>
                {{-- <a href="#social" class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg font-semibold hover:bg-indigo-200 transition text-sm">Social</a> --}}
                <a href="#relatorios" class="px-4 py-2 bg-cyan-100 text-cyan-700 rounded-lg font-semibold hover:bg-cyan-200 transition text-sm">Relatórios</a>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <!-- 1. AGENDA E AGENDAMENTOS -->
        <section id="agenda" class="mb-20 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center text-4xl shadow-lg">
                    📅
                </div>
                <div>
                    <h2 class="text-4xl font-black">Agenda e Agendamentos</h2>
                    <p class="text-gray-600 text-lg">Gestão completa da sua agenda profissional</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-purple-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-purple-600">✓</span> Calendário Visual Interativo
                    </h3>
                    <p class="text-gray-600 mb-3">Visualize todos os agendamentos em um calendário completo com cores por status (confirmado, pendente, cancelado, atendido).</p>
                    <div class="text-sm text-purple-600 font-semibold">• Integração com FullCalendar.js</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-purple-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-purple-600">✓</span> Agendamentos Recorrentes
                    </h3>
                    <p class="text-gray-600 mb-3">Crie agendamentos que se repetem semanalmente ou mensalmente automaticamente.</p>
                    <div class="text-sm text-purple-600 font-semibold">• Exemplo: Cliente que vem toda terça às 14h</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-purple-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-purple-600">✓</span> Links Rápidos de Agendamento
                    </h3>
                    <p class="text-gray-600 mb-3">Gere links diretos para compartilhar em stories, campanhas e posts. Cliente clica e agenda direto.</p>
                    <div class="text-sm text-purple-600 font-semibold">• Controle de expiração e limite de usos</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-purple-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-purple-600">✓</span> Fila de Espera
                    </h3>
                    <p class="text-gray-600 mb-3">Gerencie lista de espera. Quando houver cancelamento, sistema notifica clientes na fila.</p>
                    <div class="text-sm text-purple-600 font-semibold">• Notificações automáticas por e-mail</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-purple-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-purple-600">✓</span> Gestão de Status
                    </h3>
                    <p class="text-gray-600 mb-3">Confirme, cancele, marque como atendido ou não-compareceu. Controle total sobre cada agendamento.</p>
                    <div class="text-sm text-purple-600 font-semibold">• Notificações automáticas ao cliente</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-purple-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-purple-600">✓</span> Disponibilidade por Profissional
                    </h3>
                    <p class="text-gray-600 mb-3">Cada profissional da equipe tem sua própria agenda e horários disponíveis.</p>
                    <div class="text-sm text-purple-600 font-semibold">• Perfeito para clínicas e salões multi-profissionais</div>
                </div>
            </div>
        </section>

        <!-- 2. GESTÃO DE CLIENTES -->
        <section id="clientes" class="mb-20 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center text-4xl shadow-lg">
                    👥
                </div>
                <div>
                    <h2 class="text-4xl font-black">Gestão de Clientes</h2>
                    <p class="text-gray-600 text-lg">Cadastro completo e histórico detalhado</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-blue-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-blue-600">✓</span> Cadastro Completo
                    </h3>
                    <p class="text-gray-600 mb-3">Nome, telefone, e-mail, data de nascimento, preferências e observações personalizadas.</p>
                    <div class="text-sm text-blue-600 font-semibold">• Campos personalizáveis conforme sua necessidade</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-blue-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-blue-600">✓</span> Histórico de Agendamentos
                    </h3>
                    <p class="text-gray-600 mb-3">Veja todo o histórico: serviços realizados, valores gastos, frequência de visitas.</p>
                    <div class="text-sm text-blue-600 font-semibold">• Identifique seus clientes mais fiéis</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-blue-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-blue-600">✓</span> Segmentação Automática
                    </h3>
                    <p class="text-gray-600 mb-3">Clientes novos, ativos, fiéis e inativos são automaticamente categorizados.</p>
                    <div class="text-sm text-blue-600 font-semibold">• Use para campanhas direcionadas</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-blue-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-blue-600">✓</span> Pontos de Fidelidade
                    </h3>
                    <p class="text-gray-600 mb-3">Veja quantos pontos cada cliente acumulou e o histórico de resgates.</p>
                    <div class="text-sm text-blue-600 font-semibold">• Adicione ou remova pontos manualmente</div>
                </div>
            </div>
        </section>

        <!-- 3. SERVIÇOS E PROFISSIONAIS -->
        <section id="servicos" class="mb-20 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl flex items-center justify-center text-4xl shadow-lg">
                    ✂️
                </div>
                <div>
                    <h2 class="text-4xl font-black">Serviços e Profissionais</h2>
                    <p class="text-gray-600 text-lg">Configure seus serviços e equipe</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-pink-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-pink-600">✓</span> Cadastro de Serviços
                    </h3>
                    <p class="text-gray-600 mb-3">Nome, descrição, valor, duração e profissional responsável por cada serviço.</p>
                    <div class="text-sm text-pink-600 font-semibold">• Ilimitados serviços cadastrados</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-pink-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-pink-600">✓</span> Múltiplos Serviços por Agendamento
                    </h3>
                    <p class="text-gray-600 mb-3">Cliente pode agendar mais de um serviço na mesma visita (ex: corte + barba).</p>
                    <div class="text-sm text-pink-600 font-semibold">• Sistema calcula duração e valor total automaticamente</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-pink-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-pink-600">✓</span> Perfis de Profissionais
                    </h3>
                    <p class="text-gray-600 mb-3">Foto, especialidade, biografia e link de agendamento exclusivo para cada profissional.</p>
                    <div class="text-sm text-pink-600 font-semibold">• Cliente escolhe o profissional preferido</div>
                </div>

                {{-- <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-pink-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-pink-600">✓</span> Sistema de Comissões
                    </h3>
                    <p class="text-gray-600 mb-3">Configure porcentagem de comissão para cada profissional. Cálculo automático.</p>
                    <div class="text-sm text-pink-600 font-semibold">• Relatórios de comissões por período</div>
                </div> --}}
            </div>
        </section>

        <!-- 4. PROGRAMA DE FIDELIDADE -->
        <section id="fidelidade" class="mb-20 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center text-4xl shadow-lg">
                    🎁
                </div>
                <div>
                    <h2 class="text-4xl font-black">Programa de Fidelidade</h2>
                    <p class="text-gray-600 text-lg">Fidelize clientes com pontos e recompensas</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-yellow-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-yellow-600">✓</span> Acúmulo Automático de Pontos
                    </h3>
                    <p class="text-gray-600 mb-3">Configure pontos por visita e/ou por valor gasto. Cliente acumula automaticamente.</p>
                    <div class="text-sm text-yellow-600 font-semibold">• Ex: 10 pontos por visita + 1 ponto a cada R$10</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-yellow-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-yellow-600">✓</span> Recompensas Personalizadas
                    </h3>
                    <p class="text-gray-600 mb-3">Crie recompensas: descontos percentuais, valores fixos ou serviços gratuitos.</p>
                    <div class="text-sm text-yellow-600 font-semibold">• Ex: 100 pontos = 20% de desconto</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-yellow-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-yellow-600">✓</span> Validade de Pontos
                    </h3>
                    <p class="text-gray-600 mb-3">Defina se os pontos expiram após X dias. Incentiva retorno frequente.</p>
                    <div class="text-sm text-yellow-600 font-semibold">• Configurável ou pontos sem expiração</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-yellow-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-yellow-600">✓</span> Ranking de Clientes Fiéis
                    </h3>
                    <p class="text-gray-600 mb-3">Veja quem são seus clientes mais engajados e fiéis baseado em pontos acumulados.</p>
                    <div class="text-sm text-yellow-600 font-semibold">• Ideal para ações VIP</div>
                </div>
            </div>
        </section>

        <!-- 5. PROMOÇÕES E CUPONS -->
        <section id="promocoes" class="mb-20 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-red-500 to-pink-500 rounded-2xl flex items-center justify-center text-4xl shadow-lg">
                    🎉
                </div>
                <div>
                    <h2 class="text-4xl font-black">Promoções e Cupons</h2>
                    <p class="text-gray-600 text-lg">Campanhas inteligentes e segmentadas</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-red-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-red-600">✓</span> Cupons de Desconto
                    </h3>
                    <p class="text-gray-600 mb-3">Crie cupons com código personalizado, desconto fixo ou percentual, validade e limite de usos.</p>
                    <div class="text-sm text-red-600 font-semibold">• Ex: VOLTA20 = 20% off até 31/12</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-red-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-red-600">✓</span> Campanhas Segmentadas
                    </h3>
                    <p class="text-gray-600 mb-3">Envie promoções apenas para clientes novos, ativos, inativos ou fiéis.</p>
                    <div class="text-sm text-red-600 font-semibold">• Aumente a taxa de retorno</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-red-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-red-600">✓</span> Segmentos Automáticos
                    </h3>
                    <p class="text-gray-600 mb-3">Sistema calcula automaticamente: clientes novos (sem agendamentos), ativos (últimos 30 dias), fiéis (5+ agendamentos), inativos (60+ dias).</p>
                    <div class="text-sm text-red-600 font-semibold">• Segmentação inteligente</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-red-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-red-600">✓</span> Controle de Uso
                    </h3>
                    <p class="text-gray-600 mb-3">Acompanhe quantas vezes cada cupom foi usado e por quem.</p>
                    <div class="text-sm text-red-600 font-semibold">• Relatório de efetividade de campanhas</div>
                </div>
            </div>
        </section>

        <!-- 6. SISTEMA DE FEEDBACKS -->
        <section id="feedback" class="mb-20 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-amber-500 to-yellow-500 rounded-2xl flex items-center justify-center text-4xl shadow-lg">
                    ⭐
                </div>
                <div>
                    <h2 class="text-4xl font-black">Sistema de Feedbacks</h2>
                    <p class="text-gray-600 text-lg">Colete e exiba avaliações profissionalmente</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-amber-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-amber-600">✓</span> Geração de Link de Feedback
                    </h3>
                    <p class="text-gray-600 mb-3">Após atendimento, gere um link único e envie para o cliente avaliar.</p>
                    <div class="text-sm text-amber-600 font-semibold">• Formulário personalizado com seu logo</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-amber-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-amber-600">✓</span> Avaliação de 1 a 5 Estrelas
                    </h3>
                    <p class="text-gray-600 mb-3">Cliente avalia o serviço e profissional com estrelas e comentário opcional.</p>
                    <div class="text-sm text-amber-600 font-semibold">• Interface amigável e rápida</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-amber-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-amber-600">✓</span> Aprovação Manual
                    </h3>
                    <p class="text-gray-600 mb-3">Feedbacks ficam pendentes até você aprovar. Evita avaliações inadequadas.</p>
                    <div class="text-sm text-amber-600 font-semibold">• Controle total sobre o que aparece</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-amber-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-amber-600">✓</span> Exibição na Página Pública
                    </h3>
                    <p class="text-gray-600 mb-3">Feedbacks aprovados aparecem automaticamente em todos os templates públicos.</p>
                    <div class="text-sm text-amber-600 font-semibold">• Aumenta credibilidade e conversões</div>
                </div>
            </div>
        </section>

        <!-- 7. CENTRO FINANCEIRO -->
        <section id="financeiro" class="mb-20 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center text-4xl shadow-lg">
                    💰
                </div>
                <div>
                    <h2 class="text-4xl font-black">Centro Financeiro</h2>
                    <p class="text-gray-600 text-lg">Gestão completa de receitas e despesas</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-green-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-green-600">✓</span> Integração com Agendamentos
                    </h3>
                    <p class="text-gray-600 mb-3">Ao marcar agendamento como "Atendido", gera transação financeira automaticamente.</p>
                    <div class="text-sm text-green-600 font-semibold">• Confirme pagamento (Dinheiro, Pix, Cartão)</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-green-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-green-600">✓</span> Lançamentos Manuais
                    </h3>
                    <p class="text-gray-600 mb-3">Registre receitas (venda de produtos) e despesas (aluguel, energia, materiais) manualmente.</p>
                    <div class="text-sm text-green-600 font-semibold">• Categorias personalizáveis</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-green-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-green-600">✓</span> Controle de Caixa Diário
                    </h3>
                    <p class="text-gray-600 mb-3">Abertura e fechamento de caixa com saldo inicial/final. Relatório automático em PDF.</p>
                    <div class="text-sm text-green-600 font-semibold">• Fechamento diário, semanal ou mensal</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-green-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-green-600">✓</span> Emissão de Recibos
                    </h3>
                    <p class="text-gray-600 mb-3">Gere recibos/cupons digitais em PDF com logo, dados do cliente e serviço.</p>
                    <div class="text-sm text-green-600 font-semibold">• Envie por e-mail ou WhatsApp</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-green-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-green-600">✓</span> Indicadores Financeiros
                    </h3>
                    <p class="text-gray-600 mb-3">Receita total, lucro líquido, serviços mais rentáveis, profissional que mais fatura.</p>
                    <div class="text-sm text-green-600 font-semibold">• Gráficos semanais e mensais</div>
                </div>

                {{-- <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-green-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-green-600">✓</span> Comissões por Profissional
                    </h3>
                    <p class="text-gray-600 mb-3">Sistema calcula comissões automaticamente baseado na porcentagem configurada.</p>
                    <div class="text-sm text-green-600 font-semibold">• Relatório de comissões a pagar</div>
                </div> --}}
            </div>
        </section>

        <!-- 8. REDES SOCIAIS -->
        {{-- <section id="social" class="mb-20 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-2xl flex items-center justify-center text-4xl shadow-lg">
                    📱
                </div>
                <div>
                    <h2 class="text-4xl font-black">Integração com Redes Sociais</h2>
                    <p class="text-gray-600 text-lg">Conecte suas redes sociais e facilite agendamentos</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-indigo-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-indigo-600">✓</span> Link de Agendamento na Bio
                    </h3>
                    <p class="text-gray-600 mb-3">Adicione seu link personalizado (AzendaMe/seu-negocio) na bio do Instagram, Facebook, TikTok.</p>
                    <div class="text-sm text-indigo-600 font-semibold">• Cliente clica e agenda diretamente</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-indigo-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-indigo-600">✓</span> QR Code Personalizado
                    </h3>
                    <p class="text-gray-600 mb-3">Gere QR Code para imprimir em cartões de visita, banners e materiais impressos.</p>
                    <div class="text-sm text-indigo-600 font-semibold">• Cliente escaneia e agenda</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-indigo-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-indigo-600">✓</span> Botão de Agendamento em Stories
                    </h3>
                    <p class="text-gray-600 mb-3">Use links rápidos temporários em stories para campanhas específicas.</p>
                    <div class="text-sm text-indigo-600 font-semibold">• Controle de expiração e contagem de cliques</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-indigo-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-indigo-600">✓</span> Gerenciamento de Links
                    </h3>
                    <p class="text-gray-600 mb-3">Adicione e gerencie links do Instagram, Facebook, WhatsApp, TikTok e outros.</p>
                    <div class="text-sm text-indigo-600 font-semibold">• Todos aparecem na página pública</div>
                </div>
            </div>
        </section> --}}

        <!-- 9. RELATÓRIOS E ANALYTICS -->
        <section id="relatorios" class="mb-20 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-2xl flex items-center justify-center text-4xl shadow-lg">
                    📊
                </div>
                <div>
                    <h2 class="text-4xl font-black">Relatórios e Analytics</h2>
                    <p class="text-gray-600 text-lg">Dashboards e métricas do seu negócio</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-cyan-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-cyan-600">✓</span> Dashboard Completo
                    </h3>
                    <p class="text-gray-600 mb-3">Visão geral: agendamentos do dia, receita do mês, taxa de ocupação, clientes novos.</p>
                    <div class="text-sm text-cyan-600 font-semibold">• Atualizações em tempo real</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-cyan-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-cyan-600">✓</span> Serviços Mais Vendidos
                    </h3>
                    <p class="text-gray-600 mb-3">Ranking dos serviços que mais geram agendamentos e receita.</p>
                    <div class="text-sm text-cyan-600 font-semibold">• Identifique os serviços estrela</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-cyan-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-cyan-600">✓</span> Horários Mais Populares
                    </h3>
                    <p class="text-gray-600 mb-3">Veja quais horários têm mais demanda para otimizar sua agenda.</p>
                    <div class="text-sm text-cyan-600 font-semibold">• Gráfico de calor por dia/hora</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-cyan-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-cyan-600">✓</span> Relatórios Exportáveis
                    </h3>
                    <p class="text-gray-600 mb-3">Exporte relatórios financeiros e de agendamentos em PDF e Excel.</p>
                    <div class="text-sm text-cyan-600 font-semibold">• Perfeito para contabilidade</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-cyan-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-cyan-600">✓</span> Taxa de Conversão
                    </h3>
                    <p class="text-gray-600 mb-3">Percentual de agendamentos que foram efetivamente atendidos vs cancelados/faltas.</p>
                    <div class="text-sm text-cyan-600 font-semibold">• Melhore seus processos</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-cyan-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-cyan-600">✓</span> Performance por Profissional
                    </h3>
                    <p class="text-gray-600 mb-3">Compare receita, quantidade de atendimentos e avaliações de cada profissional.</p>
                    <div class="text-sm text-cyan-600 font-semibold">• Incentive a equipe</div>
                </div>
            </div>
        </section>

        <!-- 10. PÁGINA PÚBLICA E TEMPLATES -->
        <section id="templates-details" class="mb-20 scroll-mt-32">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center text-4xl shadow-lg">
                    🎨
                </div>
                <div>
                    <h2 class="text-4xl font-black">Página Pública e Templates</h2>
                    <p class="text-gray-600 text-lg">Sua presença online profissional</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-purple-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-purple-600">✓</span> 4 Templates Profissionais
                    </h3>
                    <p class="text-gray-600 mb-3">Clínica, Salão/Spa, Tatuagem e Barbearia. Designs modernos e responsivos.</p>
                    <div class="text-sm text-purple-600 font-semibold">• Troque de template a qualquer momento</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-purple-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-purple-600">✓</span> Personalização Total
                    </h3>
                    <p class="text-gray-600 mb-3">Defina cores, textos, logo, sobre você, e todas as informações exibidas.</p>
                    <div class="text-sm text-purple-600 font-semibold">• 100% sua marca</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-purple-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-purple-600">✓</span> Galeria de Fotos
                    </h3>
                    <p class="text-gray-600 mb-3">Adicione fotos do seu trabalho, ambiente e equipe. Modal para visualização ampliada.</p>
                    <div class="text-sm text-purple-600 font-semibold">• Ilimitadas imagens</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-purple-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-purple-600">✓</span> Calendário Interativo
                    </h3>
                    <p class="text-gray-600 mb-3">Cliente vê horários disponíveis em tempo real. Datas bloqueadas são desabilitadas automaticamente.</p>
                    <div class="text-sm text-purple-600 font-semibold">• Sincronizado com sua agenda</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-purple-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-purple-600">✓</span> SEO Otimizado
                    </h3>
                    <p class="text-gray-600 mb-3">Meta tags, descrições e estrutura otimizada para aparecer no Google.</p>
                    <div class="text-sm text-purple-600 font-semibold">• Aumente visibilidade orgânica</div>
                </div>

                <div class="feature-detail bg-white rounded-2xl p-6 border-2 border-gray-100 hover:border-purple-200 hover:shadow-lg">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="text-purple-600">✓</span> Totalmente Responsivo
                    </h3>
                    <p class="text-gray-600 mb-3">Funciona perfeitamente em celular, tablet e desktop.</p>
                    <div class="text-sm text-purple-600 font-semibold">• +70% dos agendamentos são mobile</div>
                </div>
            </div>
        </section>

        <!-- CTA Final -->
        <section class="bg-gradient-to-br from-purple-600 to-pink-600 rounded-3xl p-16 text-center text-white">
            <h2 class="text-4xl md:text-5xl font-black mb-6">
                Pronto para ter tudo isso no seu negócio?
            </h2>
            <p class="text-2xl text-purple-100 mb-10 max-w-3xl mx-auto">
                Solicite uma demonstração gratuita e veja o sistema funcionando com seus dados
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url('/#demo') }}" class="px-12 py-5 bg-white text-purple-600 rounded-xl font-bold text-xl hover:shadow-2xl transform hover:scale-105 transition">
                    🚀 Solicitar Demonstração Grátis
                </a>
                <a href="https://wa.me/5511999999999?text=Olá!%20Vi%20todas%20as%20funcionalidades%20e%20quero%20uma%20demonstração!" target="_blank" class="px-12 py-5 bg-green-500 text-white rounded-xl font-bold text-xl hover:shadow-2xl transform hover:scale-105 transition">
                    💬 Falar no WhatsApp
                </a>
            </div>
        </section>

    </div>

    @include('landing.sections.footer')

</body>
</html>

