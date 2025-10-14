@props(['items' => []])

@php
    // Se não foram passados itens, tentar gerar automaticamente baseado na rota atual
    if (empty($items)) {
        $currentRoute = request()->route()->getName();
        $currentUrl = request()->url();
        $segments = request()->segments();
        
        // Mapeamento de rotas para breadcrumbs
        $routeMap = [
            'panel.dashboard' => ['Dashboard' => route('panel.dashboard')],
            'panel.agenda.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Agenda' => route('panel.agenda.index')
            ],
            'panel.agenda.create' => [
                'Dashboard' => route('panel.dashboard'),
                'Agenda' => route('panel.agenda.index'),
                'Novo Agendamento' => route('panel.agenda.create')
            ],
            'panel.agenda.edit' => [
                'Dashboard' => route('panel.dashboard'),
                'Agenda' => route('panel.agenda.index'),
                'Editar Agendamento' => $currentUrl
            ],
            'panel.clientes.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Clientes' => route('panel.clientes.index')
            ],
            'panel.clientes.create' => [
                'Dashboard' => route('panel.dashboard'),
                'Clientes' => route('panel.clientes.index'),
                'Novo Cliente' => route('panel.clientes.create')
            ],
            'panel.clientes.edit' => [
                'Dashboard' => route('panel.dashboard'),
                'Clientes' => route('panel.clientes.index'),
                'Editar Cliente' => $currentUrl
            ],
            'panel.clientes.show' => [
                'Dashboard' => route('panel.dashboard'),
                'Clientes' => route('panel.clientes.index'),
                'Detalhes do Cliente' => $currentUrl
            ],
            'panel.servicos.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Serviços' => route('panel.servicos.index')
            ],
            'panel.servicos.create' => [
                'Dashboard' => route('panel.dashboard'),
                'Serviços' => route('panel.servicos.index'),
                'Novo Serviço' => route('panel.servicos.create')
            ],
            'panel.servicos.edit' => [
                'Dashboard' => route('panel.dashboard'),
                'Serviços' => route('panel.servicos.index'),
                'Editar Serviço' => $currentUrl
            ],
            'panel.configuracoes' => [
                'Dashboard' => route('panel.dashboard'),
                'Configurações' => route('panel.configuracoes')
            ],
            'panel.galeria.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Galeria' => route('panel.galeria.index')
            ],
            'panel.galeria.create' => [
                'Dashboard' => route('panel.dashboard'),
                'Galeria' => route('panel.galeria.index'),
                'Nova Foto' => route('panel.galeria.create')
            ],
            'panel.galeria.edit' => [
                'Dashboard' => route('panel.dashboard'),
                'Galeria' => route('panel.galeria.index'),
                'Editar Foto' => $currentUrl
            ],
            'panel.disponibilidade.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Disponibilidade' => route('panel.disponibilidade.index')
            ],
            'panel.disponibilidade.create' => [
                'Dashboard' => route('panel.dashboard'),
                'Disponibilidade' => route('panel.disponibilidade.index'),
                'Nova Disponibilidade' => route('panel.disponibilidade.create')
            ],
            'panel.relatorios' => [
                'Dashboard' => route('panel.dashboard'),
                'Relatórios' => route('panel.relatorios')
            ],
            'panel.template-customize' => [
                'Dashboard' => route('panel.dashboard'),
                'Personalizar Template' => route('panel.template-customize')
            ],
            'panel.blog.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Blog' => route('panel.blog.index')
            ],
            'panel.blog.create' => [
                'Dashboard' => route('panel.dashboard'),
                'Blog' => route('panel.blog.index'),
                'Nova Postagem' => route('panel.blog.create')
            ],
            'panel.blog.edit' => [
                'Dashboard' => route('panel.dashboard'),
                'Blog' => route('panel.blog.index'),
                'Editar Postagem' => $currentUrl
            ],
            'panel.blog.categories.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Blog' => route('panel.blog.index'),
                'Categorias' => route('panel.blog.categories.index')
            ],
            'panel.blog.categories.create' => [
                'Dashboard' => route('panel.dashboard'),
                'Blog' => route('panel.blog.index'),
                'Categorias' => route('panel.blog.categories.index'),
                'Nova Categoria' => route('panel.blog.categories.create')
            ],
            'panel.blog.categories.edit' => [
                'Dashboard' => route('panel.dashboard'),
                'Blog' => route('panel.blog.index'),
                'Categorias' => route('panel.blog.categories.index'),
                'Editar Categoria' => $currentUrl
            ],
            'panel.blog.comments.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Blog' => route('panel.blog.index'),
                'Comentários' => route('panel.blog.comments.index')
            ],
            'panel.email-marketing.index' => [
                'Dashboard' => route('panel.dashboard'),
                'E-mail Marketing' => route('panel.email-marketing.index')
            ],
            'panel.email-marketing.create' => [
                'Dashboard' => route('panel.dashboard'),
                'E-mail Marketing' => route('panel.email-marketing.index'),
                'Nova Campanha' => route('panel.email-marketing.create')
            ],
            'panel.email-marketing.edit' => [
                'Dashboard' => route('panel.dashboard'),
                'E-mail Marketing' => route('panel.email-marketing.index'),
                'Editar Campanha' => $currentUrl
            ],
            'panel.alerts.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Alertas' => route('panel.alerts.index')
            ],
            'panel.alerts.settings' => [
                'Dashboard' => route('panel.dashboard'),
                'Alertas' => route('panel.alerts.index'),
                'Configurações' => route('panel.alerts.settings')
            ],
            'panel.activity-logs.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Logs de Atividade' => route('panel.activity-logs.index')
            ],
            'panel.reports.financial.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Relatórios' => route('panel.reports.financial.index')
            ],
            'panel.reports.services.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Relatórios' => route('panel.reports.services.index')
            ],
            'panel.dashboard.performance' => [
                'Dashboard' => route('panel.dashboard'),
                'Performance' => route('panel.dashboard.performance')
            ],
            'panel.loyalty.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Fidelidade' => route('panel.loyalty.index')
            ],
            'panel.promotions.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Promoções' => route('panel.promotions.index')
            ],
            'panel.social.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Redes Sociais' => route('panel.social.index')
            ],
            'panel.feedbacks.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Feedbacks' => route('panel.feedbacks.index')
            ],
            'panel.seo.index' => [
                'Dashboard' => route('panel.dashboard'),
                'SEO' => route('panel.seo.index')
            ],
            'panel.analytics.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Analytics' => route('panel.analytics.index')
            ],
            'panel.financial.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Financeiro' => route('panel.financial.index')
            ],
            'panel.quick-booking.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Agendamento Rápido' => route('panel.quick-booking.index')
            ],
            'panel.waitlist.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Lista de Espera' => route('panel.waitlist.index')
            ],
            'panel.professionals.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Profissionais' => route('panel.professionals.index')
            ],
            'panel.professionals.create' => [
                'Dashboard' => route('panel.dashboard'),
                'Profissionais' => route('panel.professionals.index'),
                'Novo Profissional' => route('panel.professionals.create')
            ],
            'panel.professionals.edit' => [
                'Dashboard' => route('panel.dashboard'),
                'Profissionais' => route('panel.professionals.index'),
                'Editar Profissional' => $currentUrl
            ]
        ];
        
        // Se encontrou mapeamento, usar ele
        if (isset($routeMap[$currentRoute])) {
            $items = $routeMap[$currentRoute];
        } else {
            // Fallback: gerar breadcrumb baseado nos segmentos da URL
            $items = ['Dashboard' => route('panel.dashboard')];
            $currentPath = '';
            
            foreach ($segments as $index => $segment) {
                if ($segment === 'panel') continue;
                
                $currentPath .= '/' . $segment;
                $segmentName = ucfirst(str_replace('-', ' ', $segment));
                
                // Se for o último segmento, não adicionar link
                if ($index === count($segments) - 1) {
                    $items[$segmentName] = null;
                } else {
                    $items[$segmentName] = url($currentPath);
                }
            }
        }
    }
@endphp

@if(!empty($items))
<nav class="bg-white border-b border-gray-200 px-4 sm:px-6 lg:px-8" aria-label="Breadcrumb">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center space-x-2 py-3">
            <!-- Home Icon -->
            <a href="{{ route('panel.dashboard') }}" class="text-gray-400 hover:text-gray-500 transition-colors" aria-label="Dashboard">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
            </a>
            
            <!-- Breadcrumb Items -->
            <div class="flex items-center space-x-1 overflow-x-auto">
                @foreach($items as $label => $url)
                    @if(!$loop->first)
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    @endif
                    
                    @if($url && !$loop->last)
                        <a href="{{ $url }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors whitespace-nowrap">
                            {{ $label }}
                        </a>
                    @else
                        <span class="text-sm font-medium text-gray-900 whitespace-nowrap">
                            {{ $label }}
                        </span>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</nav>
@endif
