<?php

namespace App\Helpers;

class BreadcrumbHelper
{
    /**
     * Verifica se uma rota existe
     */
    private static function routeExists($routeName)
    {
        try {
            route($routeName);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Gera breadcrumb automático baseado na rota atual
     */
    public static function generate($customItems = [])
    {
        if (!empty($customItems)) {
            return $customItems;
        }

        // Verificar se há uma rota ativa
        if (!request()->route()) {
            return ['Dashboard' => route('panel.dashboard')];
        }

        $currentRoute = request()->route()->getName();
        
        // Mapeamento de rotas conhecidas
        $knownRoutes = [
            'panel.dashboard' => ['Dashboard' => route('panel.dashboard')],
            'panel.agenda.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Agenda' => route('panel.agenda.index')
            ],
            'panel.clientes.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Clientes' => route('panel.clientes.index')
            ],
            'panel.servicos.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Serviços' => route('panel.servicos.index')
            ],
            'panel.configuracoes.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Configurações' => route('panel.configuracoes.index')
            ],
            'panel.galeria.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Galeria' => route('panel.galeria.index')
            ],
            'panel.disponibilidade.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Disponibilidade' => route('panel.disponibilidade.index')
            ],
            'panel.relatorios.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Relatórios' => route('panel.relatorios.index')
            ],
            'panel.template.customize' => [
                'Dashboard' => route('panel.dashboard'),
                'Personalizar Template' => route('panel.template.customize')
            ],
            'panel.blog.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Blog' => route('panel.blog.index')
            ],
            'panel.email-marketing.index' => [
                'Dashboard' => route('panel.dashboard'),
                'E-mail Marketing' => route('panel.email-marketing.index')
            ],
            'panel.alerts.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Alertas' => route('panel.alerts.index')
            ],
            'panel.activity-logs.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Logs de Atividade' => route('panel.activity-logs.index')
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
            'panel.financeiro.dashboard' => [
                'Dashboard' => route('panel.dashboard'),
                'Financeiro' => route('panel.financeiro.dashboard')
            ],
            'panel.quick-booking.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Links Rápidos' => route('panel.quick-booking.index')
            ],
            'panel.waitlist.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Fila de Espera' => route('panel.waitlist.index')
            ],
            'panel.professionals.index' => [
                'Dashboard' => route('panel.dashboard'),
                'Profissionais' => route('panel.professionals.index')
            ]
        ];
        
        // Se temos um mapeamento conhecido, usar ele
        if (isset($knownRoutes[$currentRoute])) {
            return $knownRoutes[$currentRoute];
        }
        
        // Para rotas não mapeadas, gerar breadcrumb dinâmico
        $segments = request()->segments();
        $items = ['Dashboard' => route('panel.dashboard')];
        
        // Remover 'panel' dos segmentos
        $segments = array_filter($segments, function($segment) {
            return $segment !== 'panel';
        });
        
        $currentPath = '/panel';
        
        foreach ($segments as $index => $segment) {
            $currentPath .= '/' . $segment;
            $segmentName = ucfirst(str_replace('-', ' ', $segment));
            
            // Se for o último segmento, não adicionar link
            if ($index === count($segments) - 1) {
                $items[$segmentName] = null;
            } else {
                // Tentar diferentes padrões de nome de rota
                $possibleRoutes = [
                    'panel.' . implode('.', array_slice($segments, 0, $index + 1)) . '.index',
                    'panel.' . implode('.', array_slice($segments, 0, $index + 1))
                ];
                
                $foundRoute = null;
                foreach ($possibleRoutes as $routeName) {
                    if (self::routeExists($routeName)) {
                        $foundRoute = $routeName;
                        break;
                    }
                }
                
                if ($foundRoute) {
                    $items[$segmentName] = route($foundRoute);
                } else {
                    $items[$segmentName] = url($currentPath);
                }
            }
        }
        
        return $items;
    }
    
    /**
     * Cria breadcrumb customizado
     */
    public static function custom($items)
    {
        return $items;
    }
}