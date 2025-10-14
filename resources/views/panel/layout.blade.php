<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Painel') - AzendaMe</title>
    @include('partials.favicon')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0">
            <div class="h-full flex flex-col">
                <!-- Logo -->
                <div class="p-6 border-b border-gray-200">
                    <a href="{{ route('panel.dashboard') }}" class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-500 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-xl">A</span>
                        </div>
                        <span class="text-xl font-bold text-gray-800">AzendaMe</span>
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                    <!-- Dashboard -->
                    <a href="{{ route('panel.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('panel.dashboard') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-50' }} transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <!-- Seção: Gestão de Negócio -->
                    <div class="border-t border-gray-200 my-3"></div>
                    <div class="px-4 py-2">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Gestão de Negócio</h3>
                    </div>

                    <div x-data="{ open: {{ request()->routeIs('panel.agenda.*') || request()->routeIs('panel.clientes.*') || request()->routeIs('panel.servicos.*') || request()->routeIs('panel.professionals.*') || request()->routeIs('panel.disponibilidade.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('panel.agenda.*') || request()->routeIs('panel.clientes.*') || request()->routeIs('panel.servicos.*') || request()->routeIs('panel.professionals.*') || request()->routeIs('panel.disponibilidade.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-50' }} transition">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="font-medium">Agendamentos</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                            <a href="{{ route('panel.agenda.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.agenda.*') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Agenda
                            </a>
                            <a href="{{ route('panel.clientes.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.clientes.*') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Clientes
                            </a>
                            <a href="{{ route('panel.servicos.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.servicos.*') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Serviços
                            </a>
                            <a href="{{ route('panel.professionals.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.professionals.*') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Profissionais
                            </a>
                            <a href="{{ route('panel.disponibilidade.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.disponibilidade.*') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Disponibilidade
                            </a>
                        </div>
                    </div>

                    <div x-data="{ open: {{ request()->routeIs('panel.financeiro.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('panel.financeiro.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-50' }} transition">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-medium">Financeiro</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                            <a href="{{ route('panel.financeiro.dashboard') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.financeiro.dashboard') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('panel.financeiro.transacoes') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.financeiro.transacoes*') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Transações
                            </a>
                            <a href="{{ route('panel.financeiro.caixa') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.financeiro.caixa') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Caixa
                            </a>
                            <a href="{{ route('panel.financeiro.periodos') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.financeiro.periodos*') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Períodos
                            </a>
                        </div>
                    </div>

                    <!-- Seção: Marketing e Vendas -->
                    <div class="border-t border-gray-200 my-3"></div>
                    <div class="px-4 py-2">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Marketing e Vendas</h3>
                    </div>

                    <div x-data="{ open: {{ request()->routeIs('panel.loyalty.*') || request()->routeIs('panel.promotions.*') || request()->routeIs('panel.social.*') || request()->routeIs('panel.feedbacks.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('panel.loyalty.*') || request()->routeIs('panel.promotions.*') || request()->routeIs('panel.social.*') || request()->routeIs('panel.feedbacks.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-50' }} transition">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                <span class="font-medium">Marketing</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                            <a href="{{ route('panel.loyalty.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.loyalty.*') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Programa de Fidelidade
                            </a>
                            <a href="{{ route('panel.promotions.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.promotions.*') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Promoções
                            </a>
                            <a href="{{ route('panel.social.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.social.*') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Redes Sociais
                            </a>
                            <a href="{{ route('panel.feedbacks.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.feedbacks.*') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Feedbacks
                            </a>
                            {{-- <a href="{{ route('panel.email-marketing.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.email-marketing.*') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                              Email Marketing
                            </a> --}}
                        </div>
                    </div>

                    <div x-data="{ open: {{ request()->routeIs('panel.blog.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('panel.blog.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-50' }} transition">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="font-medium">Blog</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                            <a href="{{ route('panel.blog.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.blog.index') || request()->routeIs('panel.blog.create') || request()->routeIs('panel.blog.show') || request()->routeIs('panel.blog.edit') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Posts
                            </a>
                            <a href="{{ route('panel.blog.categories.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.blog.categories.*') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Categorias
                            </a>
                            <a href="{{ route('panel.blog.tags.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.blog.tags.*') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Tags
                            </a>
                            <a href="{{ route('panel.blog.comments.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.blog.comments.*') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Comentários
                            </a>
                        </div>
                    </div>

                    <!-- Seção: Relatórios e Analytics -->
                    <div class="border-t border-gray-200 my-3"></div>
                    <div class="px-4 py-2">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Relatórios e Analytics</h3>
                    </div>

                    <a href="{{ route('panel.dashboard.performance') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('panel.dashboard.performance') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-50' }} transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span class="font-medium">Dashboard de Performance</span>
                    </a>

                    <div x-data="{ open: {{ request()->routeIs('panel.reports.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('panel.reports.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-50' }} transition">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="font-medium">Relatórios</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                            <a href="{{ route('panel.reports.financial.dashboard') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.reports.financial.*') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Financeiros
                            </a>
                            <a href="{{ route('panel.reports.services.dashboard') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.reports.services.*') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Serviços e Analytics
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('panel.alerts.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('panel.alerts.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-50' }} transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.828 7l2.586 2.586a2 2 0 102.828 2.828L7.828 9.828a2 2 0 00-2.828-2.828L2.414 7.414A2 2 0 104.828 7z"/>
                        </svg>
                        <span class="font-medium">Alertas</span>
                        @php
                            $unreadCount = \App\Models\Alert::forProfessional(1)->unread()->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Seção: Ferramentas -->
                    <div class="border-t border-gray-200 my-3"></div>
                    <div class="px-4 py-2">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Ferramentas</h3>
                    </div>

                    <a href="{{ route('panel.galeria.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('panel.galeria.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-50' }} transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="font-medium">Galeria</span>
                    </a>

                    <a href="{{ route('panel.waitlist.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('panel.waitlist.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-50' }} transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="font-medium">Fila de Espera</span>
                    </a>

                    <a href="{{ route('panel.quick-booking.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('panel.quick-booking.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-50' }} transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        <span class="font-medium">Links Rápidos</span>
                    </a>

                    <a href="{{ route('panel.analytics.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('panel.analytics.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-50' }} transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span class="font-medium">Analytics</span>
                    </a>

                    <!-- Seção: Configurações -->
                    <div class="border-t border-gray-200 my-3"></div>
                    <div class="px-4 py-2">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Configurações</h3>
                    </div>

                    <div x-data="{ open: {{ request()->routeIs('panel.seo.*') || request()->routeIs('panel.configuracoes.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('panel.seo.*') || request()->routeIs('panel.configuracoes.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-50' }} transition">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="font-medium">Configurações</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                            <a href="{{ route('panel.configuracoes.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.configuracoes.*') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Gerais
                            </a>
                            <a href="{{ route('panel.seo.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.seo.*') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                SEO
                            </a>
                            <a href="{{ route('panel.activity-logs.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('panel.activity-logs.*') ? 'text-purple-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Logs de Atividade
                            </a>
                        </div>
                    </div>
                </nav>

                <!-- User Profile -->
                <div class="p-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">{{ substr(auth()->user()->name, 0, 2) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-400 hover:text-gray-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Bar -->
            <header class="bg-white border-b border-gray-200 px-8 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">@yield('page-title', 'Painel')</h1>
                        @hasSection('page-subtitle')
                            <p class="text-sm text-gray-500 mt-1">@yield('page-subtitle')</p>
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        @php
                            $professional = \App\Models\Professional::find(1);
                            $publicUrl = $professional ? url('/' . $professional->slug) : url('/');
                        @endphp
                        <a href="{{ $publicUrl }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white rounded-lg font-semibold hover:shadow-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            Ver meu site
                        </a>
                        @hasSection('header-actions')
                            <div>
                                @yield('header-actions')
                            </div>
                        @endif
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-8">
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-lg flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-lg">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="font-semibold">Erro ao processar:</p>
                                <ul class="mt-2 text-sm space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
