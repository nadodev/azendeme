# aZendame – Documentação do Projeto

Este documento resume funcionalidades, arquitetura e estrutura do aZendame, com referências às principais rotas, models, controllers e views.

## Visão Geral
- Framework: Laravel 12.x (PHP 8.x)
- Front-end: Blade + Tailwind CSS + Vite (+ Alpine em alguns trechos)
- Banco: MySQL (Eloquent ORM)
- Áreas: Público (templates por profissional) e Painel (admin)

## Funcionalidades
- Site público por profissional (slug) com 4 templates: Clínica, Salão, Tatuagem e Barbearia
  - Cores e textos dinâmicos por seção (TemplateSettings)
  - Seções: Hero, Serviços, Galeria (com modal), Agendamento, Feedbacks, Contato, Footer
  - Blog por profissional: `/{slug}/blog`
  - Badge “Versão de Demonstração” (`$isDemo`)
- Painel Administrativo
  - Agenda: listagem, filtros, calendário custom, modal de pagamento (com fidelidade)
  - Clientes, Serviços, Disponibilidade, Galeria
  - Fidelidade (pontos/recompensas), Promoções, Social, SEO
  - Relatórios Financeiros: por método, por serviço, receita mensal (filtros por período)
  - Analytics de Serviços: mais agendados, taxa presença/cancelamento, top clientes
  - Dashboard de Performance: KPIs e tendências (30 dias)
  - Alertas: novos agendamentos, cancelamentos, cliente novo, pagamento, lembrete etc.
  - Email Marketing: index e create (em evolução)
- Páginas públicas auxiliares: Central de Ajuda, Termos, Privacidade e Cookies
- Favicon unificado via partial e SVG em `public/favicon.svg`

## Estrutura (pastas principais)
```
app/
  Helpers/AlertManager.php
  Http/Controllers/Panel/
    AgendaController.php
    AlertController.php
    FinancialReportController.php
    PerformanceDashboardController.php
    ServiceAnalyticsController.php
    EmailMarketingController.php
  Models/
    Appointment.php  Payment.php  Alert.php  AlertSetting.php  ...

database/
  migrations/ (alerts, alert_settings, payments, blog, etc.)
  seeders/PaymentSeeder.php

public/
  favicon.svg

resources/views/
  landing-new.blade.php
  landing/layout.blade.php
  landing/sections/*
  partials/favicon.blade.php
  panel/layout.blade.php
  panel/** (agenda, reports, dashboard, alerts, email-marketing, ...)
  panel/email-marketing/{index,create}.blade.php
  public/templates/{clinic,salon,tattoo,barber}.blade.php
  public/sections/{booking,gallery,contact,...}.blade.php
  legal/{terms,privacy,cookies}.blade.php
  help/center.blade.php
routes/web.php
```

## Rotas (amostra)
- Público:
  - `/{slug}` (página do profissional – template dinâmico)
  - `/{slug}/blog` (blog público)
  - Auxiliares: `/ajuda`, `/termos`, `/privacidade`, `/cookies`
- Painel (`/panel`):
  - Agenda, Clientes, Serviços, Disponibilidade, Galeria
  - Relatórios financeiros: dashboard, métodos de pagamento, receita por serviço, receita mensal
  - Analytics de serviços: mais agendados, presença/cancelamento, top clientes
  - Dashboard de performance: KPIs e tendências
  - Alertas: index, configurações, APIs (get/stats/mark)
  - Email Marketing: index, create

## Models e Relacionamentos
- `Appointment` — relaciona-se com `Customer`, `Service`, `Professional`; `payments()` (hasMany)
- `Payment` — `belongsTo` `Appointment`, `PaymentMethod`, `Professional`
- `Alert` — escopos: `forProfessional`, `unread`, `archived`; status/priority
- `AlertSetting` — preferências por tipo/canal/condições; escopo `forProfessional`
- `Professional` — possui `templateSetting` (cores/textos por seção)

## Controllers – Destaques
- `FinancialReportController`: usa `payments.created_at`; total por período, método, serviço, receita mensal
- `ServiceAnalyticsController`: mais agendados, taxas, top clientes
- `PerformanceDashboardController`: KPIs, tendências por dia, desempenho por serviço/cliente
- `AlertController`: listagem, leitura/arquivo, configurações e estatísticas
- `AgendaController`: calendário custom, modais de agendamento/pagamento, fidelidade

## Views – Destaques
- Painel: `panel/layout.blade.php` (inclui “Ver meu site”), relatórios em `panel/reports/*`, performance em `panel/dashboard/performance.blade.php`, alertas em `panel/alerts/*`, email marketing em `panel/email-marketing/*`
- Público: templates em `resources/views/public/templates/*` com badge de demonstração no header; galeria com modal centralizado
- Landing: `landing-new.blade.php` com flags para habilitar/desabilitar seções
- Legais/Ajuda: páginas estilizadas com hero + sidebar

## Favicon
- Partial: `resources/views/partials/favicon.blade.php`
- Incluído em: landing-new, layout da landing, layout do painel e todos templates públicos
- Arquivo principal: `public/favicon.svg`

## Calendário da Agenda
- Implementação própria (JS/Blade); modais globais (`openPaymentModal`, etc.)
- Fidelidade: `/panel/agenda/{appointment}/customer-loyalty`

## Alertas
- `AlertManager` helper e `AlertSetting` por profissional
- Endpoints para leitura, arquivamento e estatísticas (badges)

## Relatórios & Dashboards
- Financeiros: totais, por método, por serviço, mensal
- Serviços: mais agendados, presença/cancelamento, clientes
- Performance: KPIs e tendências por dia (últimos 30)

## Email Marketing (evolução)
- Views criadas: index e create
- Próximos passos: show/edit, pré-visualização, fila/entrega, métricas detalhadas

## Execução Local
1. Copiar `.env.example` para `.env` e configurar DB
2. `composer install` e `php artisan key:generate`
3. `php artisan migrate --seed`
4. `npm install && npm run dev`
5. `php artisan serve`

## Troubleshooting
- View não encontrada: confirmar caminho em `resources/views` e nome em `view()`
- Ambiguidade SQL: prefira colunas qualificadas (`payments.created_at`)
- Cache: `php artisan view:clear && php artisan config:clear && php artisan route:clear`
- Favicon: garantir `@include('partials.favicon')` no `<head>` e limpar cache do navegador

## Extensões Futuras
- Notificações em tempo real (WebSockets), integrações de e-mail (Sendgrid/Mailgun)
- Exportações CSV/PDF, melhorias multi-tenant (por usuário)

---
Documento de referência rápida. Para detalhes, consulte controllers e views mencionados.
