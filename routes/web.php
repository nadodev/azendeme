<?php

use App\Http\Controllers\BugReportController;
use App\Http\Controllers\Panel\ActivityLogController;
use App\Http\Controllers\Panel\AgendaController;
use App\Http\Controllers\Panel\AlertController;
use App\Http\Controllers\Panel\AvailabilityController;
use App\Http\Controllers\Panel\BlogController;
use App\Http\Controllers\Panel\BlogCategoryController;
use App\Http\Controllers\Panel\BlogTagController;
use App\Http\Controllers\Panel\BlogCommentController;
use App\Http\Controllers\Panel\CustomerController;
use App\Http\Controllers\Panel\DashboardController;
use App\Http\Controllers\Panel\EmailMarketingController;
use App\Http\Controllers\Panel\FinancialReportController;
use App\Http\Controllers\Panel\GalleryController;
use App\Http\Controllers\Panel\ProfessionalController;
use App\Http\Controllers\Panel\ReportController;
use App\Http\Controllers\Panel\SeoController;
use App\Http\Controllers\Panel\ServiceAnalyticsController;
use App\Http\Controllers\Panel\ServiceController;
use App\Http\Controllers\Panel\SettingsController;
use App\Http\Controllers\Panel\PerformanceDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PublicBlogController;
use Illuminate\Support\Facades\Route;






// Landing Page
Route::get('/', function () {
    return view('landing-new');
})->name('home');

// Página de Funcionalidades
Route::get('/funcionalidades', function () {
    return view('funcionalidades');
})->name('funcionalidades');

// Página Sobre
Route::get('/sobre', function () {
    return view('sobre');
})->name('sobre');

// Self-service signup (multi-tenant)
Route::get('/registrar', [\App\Http\Controllers\Auth\TenantRegisterController::class, 'showForm'])->name('tenant.register');
Route::post('/registrar', [\App\Http\Controllers\Auth\TenantRegisterController::class, 'store'])->name('tenant.register.store');

// Templates de Demonstração
Route::get('/templates/clinic', function () {
    return view('templates.clinic');
})->name('templates.clinic');

Route::get('/templates/salon', function () {
    return view('templates.salon');
})->name('templates.salon');

Route::get('/templates/tattoo', function () {
    return view('templates.tattoo');
})->name('templates.tattoo');

Route::get('/templates/barber', function () {
    return view('templates.barber');
})->name('templates.barber');


// Rotas de autenticação (devem vir ANTES das rotas dinâmicas)
require __DIR__.'/auth.php';

// Dashboard (redireciona para panel)
// Central de Ajuda (pública)
Route::get('/ajuda', function () {
    // Dados básicos para a página (categorias e FAQs podem ser carregados no futuro do BD)
    return view('help.center');
})->name('help.center');

// Páginas legais (públicas)
Route::view('/termos', 'legal.terms')->name('legal.terms');
Route::view('/privacidade', 'legal.privacy')->name('legal.privacy');
Route::view('/cookies', 'legal.cookies')->name('legal.cookies');

// FASE 3 — Marketing e Aquisição de Leads (Landing de conversão)
Route::view('/marketing', 'landing-leads')->name('marketing.leads');

// Captura de email para marketing
Route::post('/api/capture-email', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'segment' => 'required|string|in:salon,makeup,tattoo,barber,other'
    ]);
    
    // Aqui você pode salvar no banco de dados ou integrar com email marketing
    \Log::info('Lead capturado para marketing', [
        'name' => $request->name,
        'email' => $request->email,
        'segment' => $request->segment,
        'ip' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'created_at' => now()
    ]);
    
    return response()->json([
        'success' => true,
        'message' => 'Cadastro realizado com sucesso!'
    ]);
})->name('api.capture-email');
Route::get('/dashboard', function () {
    return redirect()->route('panel.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Perfil do usuário
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Painel Administrativo (protegido por autenticação)
Route::prefix('panel')->name('panel.')->middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Perfil/Plano
    Route::get('/perfil', function(){ return view('panel.profile'); })->name('profile');
    Route::get('/perfil/editar', [\App\Http\Controllers\Panel\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [\App\Http\Controllers\Panel\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/perfil/senha', [\App\Http\Controllers\Panel\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/planos', [\App\Http\Controllers\Panel\PlanController::class, 'index'])->name('plans.index');
    Route::put('/planos', [\App\Http\Controllers\Panel\PlanController::class, 'update'])->name('plans.update');
    Route::post('/planos/checkout', [\App\Http\Controllers\Panel\PlanCheckoutController::class, 'checkout'])->name('plans.checkout');
    Route::post('/planos/billing-portal', [\App\Http\Controllers\Panel\PlanCheckoutController::class, 'billingPortal'])->name('plans.billing-portal');

    // Agenda
    Route::resource('agenda', AgendaController::class);
    Route::post('agenda/{appointment}/update-status', [AgendaController::class, 'updateStatus'])
        ->name('agenda.update-status');
    Route::post('agenda/{appointment}/mark-completed', [AgendaController::class, 'markAsCompleted'])
        ->name('agenda.mark-completed');
    Route::post('agenda/{id}/generate-feedback', [AgendaController::class, 'generateFeedbackLink'])
        ->name('agenda.generate-feedback');
    Route::get('agenda/{appointment}/customer-loyalty', [AgendaController::class, 'getCustomerLoyalty'])
        ->name('agenda.customer-loyalty');

    // Serviços
    Route::resource('servicos', ServiceController::class);

    // Profissionais
    Route::resource('professionals', ProfessionalController::class)->except(['show']);

    // Clientes
    Route::resource('clientes', CustomerController::class);

    // Disponibilidade
    Route::resource('disponibilidade', AvailabilityController::class);
    Route::post('disponibilidade/blocked-dates', [AvailabilityController::class, 'storeBlockedDate'])
        ->name('disponibilidade.blocked-dates.store');
    Route::delete('disponibilidade/blocked-dates/{blockedDate}', [AvailabilityController::class, 'destroyBlockedDate'])
        ->name('disponibilidade.blocked-dates.destroy');

    // Galeria
    Route::resource('galeria', GalleryController::class);

    // Relatórios
    Route::get('relatorios', [ReportController::class, 'index'])->name('relatorios.index');

    // Logs de Atividade
    Route::get('logs-atividade', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('logs-atividade/{activityLog}', [ActivityLogController::class, 'show'])->name('activity-logs.show');
    Route::get('logs-atividade/export/csv', [ActivityLogController::class, 'export'])->name('activity-logs.export');
    Route::get('logs-atividade/api/stats', [ActivityLogController::class, 'getStats'])->name('activity-logs.stats');

    // E-mail Marketing
    Route::get('email-marketing', [EmailMarketingController::class, 'index'])->name('email-marketing.index');
    Route::get('email-marketing/criar', [EmailMarketingController::class, 'create'])->name('email-marketing.create');
    Route::post('email-marketing', [EmailMarketingController::class, 'store'])->name('email-marketing.store');
    Route::get('email-marketing/{emailCampaign}', [EmailMarketingController::class, 'show'])->name('email-marketing.show');
    Route::get('email-marketing/{emailCampaign}/editar', [EmailMarketingController::class, 'edit'])->name('email-marketing.edit');
    Route::put('email-marketing/{emailCampaign}', [EmailMarketingController::class, 'update'])->name('email-marketing.update');
    Route::post('email-marketing/{emailCampaign}/enviar', [EmailMarketingController::class, 'send'])->name('email-marketing.send');
    Route::post('email-marketing/{emailCampaign}/cancelar', [EmailMarketingController::class, 'cancel'])->name('email-marketing.cancel');
    Route::delete('email-marketing/{emailCampaign}', [EmailMarketingController::class, 'destroy'])->name('email-marketing.destroy');
    
    // Templates de E-mail
    Route::get('email-marketing/templates', [EmailMarketingController::class, 'templates'])->name('email-marketing.templates');
    Route::get('email-marketing/templates/criar', [EmailMarketingController::class, 'createTemplate'])->name('email-marketing.templates.create');
    Route::post('email-marketing/templates', [EmailMarketingController::class, 'storeTemplate'])->name('email-marketing.templates.store');
    
    // APIs
    Route::post('email-marketing/api/preview-template', [EmailMarketingController::class, 'previewTemplate'])->name('email-marketing.api.preview');
    Route::post('email-marketing/api/recipients', [EmailMarketingController::class, 'getRecipients'])->name('email-marketing.api.recipients');

    // Sistema de Alertas
    Route::get('alertas', [AlertController::class, 'index'])->name('alerts.index');
    Route::get('alertas/configuracoes', [AlertController::class, 'settings'])->name('alerts.settings');
    Route::post('alertas/configuracoes', [AlertController::class, 'updateSettings'])->name('alerts.settings.update');
    Route::get('alertas/api/alerts', [AlertController::class, 'getAlerts'])->name('alerts.api.get');
    Route::post('alertas/{alert}/marcar-lido', [AlertController::class, 'markAsRead'])->name('alerts.mark-read');
    Route::post('alertas/marcar-todos-lidos', [AlertController::class, 'markAllAsRead'])->name('alerts.mark-all-read');
    Route::post('alertas/{alert}/arquivar', [AlertController::class, 'archive'])->name('alerts.archive');
    Route::get('alertas/api/stats', [AlertController::class, 'getStats'])->name('alerts.api.stats');

    // Relatórios Financeiros
    Route::get('relatorios/financeiro', [FinancialReportController::class, 'dashboard'])->name('reports.financial.dashboard');
    Route::get('relatorios/financeiro/metodos-pagamento', [FinancialReportController::class, 'paymentMethods'])->name('reports.financial.payment-methods');
    Route::get('relatorios/financeiro/receita-por-servico', [FinancialReportController::class, 'revenueByService'])->name('reports.financial.revenue-by-service');
    Route::get('relatorios/financeiro/receita-mensal', [FinancialReportController::class, 'monthlyRevenue'])->name('reports.financial.monthly-revenue');
    Route::get('relatorios/financeiro/api/dashboard', [FinancialReportController::class, 'getDashboardData'])->name('reports.financial.api.dashboard');
    Route::get('relatorios/financeiro/exportar', [FinancialReportController::class, 'export'])->name('reports.financial.export');

    // Analytics de Serviços
    Route::get('relatorios/servicos', [ServiceAnalyticsController::class, 'dashboard'])->name('reports.services.dashboard');
    Route::get('relatorios/servicos/mais-agendados', [ServiceAnalyticsController::class, 'mostBookedServices'])->name('reports.services.most-booked');
    Route::get('relatorios/servicos/taxa-comparecimento', [ServiceAnalyticsController::class, 'attendanceRate'])->name('reports.services.attendance-rate');
    Route::get('relatorios/servicos/clientes-frequentes', [ServiceAnalyticsController::class, 'topCustomers'])->name('reports.services.top-customers');
    Route::get('relatorios/servicos/api/analytics', [ServiceAnalyticsController::class, 'getAnalyticsData'])->name('reports.services.api.analytics');

    // Dashboard de Performance Geral
    Route::get('dashboard/performance', [PerformanceDashboardController::class, 'index'])->name('dashboard.performance');
    Route::get('dashboard/performance/api/data', [PerformanceDashboardController::class, 'getDashboardData'])->name('dashboard.performance.api.data');

    // Configurações
    Route::get('configuracoes', [SettingsController::class, 'index'])->name('configuracoes.index');
    Route::post('configuracoes', [SettingsController::class, 'update'])->name('configuracoes.update');
    
    // Personalização de Template
    Route::get('personalizar-template', [SettingsController::class, 'customizeTemplate'])->name('template.customize');
    Route::post('personalizar-template', [SettingsController::class, 'updateTemplate'])->name('template.update');
    
    // Módulo Financeiro
    Route::prefix('financeiro')->name('financeiro.')->group(function () {
        Route::get('/', [App\Http\Controllers\Panel\FinancialController::class, 'dashboard'])->name('dashboard');
        Route::get('transacoes', [App\Http\Controllers\Panel\FinancialController::class, 'transactions'])->name('transacoes');
        Route::get('transacoes/nova', [App\Http\Controllers\Panel\FinancialController::class, 'createTransaction'])->name('transacoes.create');
        Route::post('transacoes', [App\Http\Controllers\Panel\FinancialController::class, 'storeTransaction'])->name('transacoes.store');
        Route::post('transacoes/{id}/gerar-recibo', [App\Http\Controllers\Panel\FinancialController::class, 'generateReceipt'])->name('transacoes.generate-receipt');
        Route::get('transacoes/{id}/recibo', [App\Http\Controllers\Panel\FinancialController::class, 'viewReceipt'])->name('transacoes.view-receipt');
        Route::get('caixa', [App\Http\Controllers\Panel\FinancialController::class, 'cashRegister'])->name('caixa');
        Route::post('caixa/abrir', [App\Http\Controllers\Panel\FinancialController::class, 'openCashRegister'])->name('caixa.open');
        Route::post('caixa/{id}/fechar', [App\Http\Controllers\Panel\FinancialController::class, 'closeCashRegister'])->name('caixa.close');
        Route::get('periodos', [App\Http\Controllers\Panel\FinancialController::class, 'cashPeriods'])->name('periodos');
        Route::post('periodos/abrir', [App\Http\Controllers\Panel\FinancialController::class, 'openCashPeriod'])->name('periodos.open');
        Route::post('periodos/{id}/fechar', [App\Http\Controllers\Panel\FinancialController::class, 'closeCashPeriod'])->name('periodos.close');
        Route::get('periodos/{id}/relatorio', [App\Http\Controllers\Panel\FinancialController::class, 'viewCashPeriodReport'])->name('periodos.report');
    });

    // Fila de Espera
    Route::prefix('fila-espera')->name('waitlist.')->group(function () {
        Route::get('/', [App\Http\Controllers\Panel\WaitlistController::class, 'index'])->name('index');
        Route::get('novo', [App\Http\Controllers\Panel\WaitlistController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Panel\WaitlistController::class, 'store'])->name('store');
        Route::post('{id}/notificar', [App\Http\Controllers\Panel\WaitlistController::class, 'notify'])->name('notify');
        Route::post('{id}/converter', [App\Http\Controllers\Panel\WaitlistController::class, 'convert'])->name('convert');
        Route::delete('{id}', [App\Http\Controllers\Panel\WaitlistController::class, 'destroy'])->name('destroy');
    });

    // Links de Agendamento Rápido
    Route::prefix('links-rapidos')->name('quick-booking.')->group(function () {
        Route::get('/', [App\Http\Controllers\Panel\QuickBookingController::class, 'index'])->name('index');
        Route::get('novo', [App\Http\Controllers\Panel\QuickBookingController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Panel\QuickBookingController::class, 'store'])->name('store');
        Route::get('{id}/editar', [App\Http\Controllers\Panel\QuickBookingController::class, 'edit'])->name('edit');
        Route::put('{id}', [App\Http\Controllers\Panel\QuickBookingController::class, 'update'])->name('update');
        Route::post('{id}/toggle', [App\Http\Controllers\Panel\QuickBookingController::class, 'toggleActive'])->name('toggle');
        Route::delete('{id}', [App\Http\Controllers\Panel\QuickBookingController::class, 'destroy'])->name('destroy');
    });

    // Analytics e Relatórios
    Route::prefix('analytics')->name('analytics.')->group(function () {
        Route::get('/', [App\Http\Controllers\Panel\AnalyticsController::class, 'index'])->name('index');
        Route::get('export', [App\Http\Controllers\Panel\AnalyticsController::class, 'export'])->name('export');
    });

    // Programa de Fidelidade
    Route::prefix('loyalty')->name('loyalty.')->group(function () {
        Route::get('/', [App\Http\Controllers\Panel\LoyaltyController::class, 'index'])->name('index');
        Route::put('program', [App\Http\Controllers\Panel\LoyaltyController::class, 'updateProgram'])->name('update-program');
        Route::get('rewards/create', [App\Http\Controllers\Panel\LoyaltyController::class, 'createReward'])->name('create-reward');
        Route::post('rewards', [App\Http\Controllers\Panel\LoyaltyController::class, 'storeReward'])->name('store-reward');
        Route::get('rewards/{id}/edit', [App\Http\Controllers\Panel\LoyaltyController::class, 'editReward'])->name('edit-reward');
        Route::put('rewards/{id}', [App\Http\Controllers\Panel\LoyaltyController::class, 'updateReward'])->name('update-reward');
        Route::delete('rewards/{id}', [App\Http\Controllers\Panel\LoyaltyController::class, 'destroyReward'])->name('destroy-reward');
        Route::get('customers/{id}/points', [App\Http\Controllers\Panel\LoyaltyController::class, 'customerPoints'])->name('customer-points');
        Route::post('customers/{id}/points', [App\Http\Controllers\Panel\LoyaltyController::class, 'manualPoints'])->name('manual-points');
    });

    // Promoções e Pacotes
    Route::prefix('promotions')->name('promotions.')->group(function () {
        Route::get('/', [App\Http\Controllers\Panel\PromotionController::class, 'index'])->name('index');
        Route::get('create', [App\Http\Controllers\Panel\PromotionController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Panel\PromotionController::class, 'store'])->name('store');
        Route::get('{id}/edit', [App\Http\Controllers\Panel\PromotionController::class, 'edit'])->name('edit');
        Route::put('{id}', [App\Http\Controllers\Panel\PromotionController::class, 'update'])->name('update');
        Route::delete('{id}', [App\Http\Controllers\Panel\PromotionController::class, 'destroy'])->name('destroy');
        Route::get('segments', [App\Http\Controllers\Panel\PromotionController::class, 'segments'])->name('segments');
    });

    // Redes Sociais
    Route::prefix('social')->name('social.')->group(function () {
        Route::get('/', [App\Http\Controllers\Panel\SocialController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\Panel\SocialController::class, 'store'])->name('store');
        Route::put('{id}', [App\Http\Controllers\Panel\SocialController::class, 'update'])->name('update');
        Route::delete('{id}', [App\Http\Controllers\Panel\SocialController::class, 'destroy'])->name('destroy');
        Route::put('bio/update', [App\Http\Controllers\Panel\SocialController::class, 'updateBio'])->name('update-bio');
    });

    // Gerenciamento de Feedbacks
    Route::prefix('feedbacks')->name('feedbacks.')->group(function () {
        Route::get('/', [App\Http\Controllers\Panel\FeedbackManagementController::class, 'index'])->name('index');
        Route::post('{id}/approve', [App\Http\Controllers\Panel\FeedbackManagementController::class, 'approve'])->name('approve');
        Route::post('{id}/toggle-visibility', [App\Http\Controllers\Panel\FeedbackManagementController::class, 'toggleVisibility'])->name('toggle-visibility');
        Route::delete('{id}', [App\Http\Controllers\Panel\FeedbackManagementController::class, 'destroy'])->name('destroy');
    });

    // SEO
    Route::prefix('seo')->name('seo.')->group(function () {
        Route::get('/', [SeoController::class, 'index'])->name('index');
        Route::get('{pageType}/edit', [SeoController::class, 'edit'])->name('edit');
        Route::put('{pageType}', [SeoController::class, 'update'])->name('update');
        Route::post('bulk-update', [SeoController::class, 'bulkUpdate'])->name('bulk-update');
    });

    // Blog
    Route::prefix('blog')->name('blog.')->group(function () {
        // Posts
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::get('create', [BlogController::class, 'create'])->name('create');
        Route::post('/', [BlogController::class, 'store'])->name('store');
        Route::get('{id}', [BlogController::class, 'show'])->name('show');
        Route::get('{id}/edit', [BlogController::class, 'edit'])->name('edit');
        Route::put('{id}', [BlogController::class, 'update'])->name('update');
        Route::delete('{id}', [BlogController::class, 'destroy'])->name('destroy');
        Route::post('{id}/toggle-status', [BlogController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('{id}/toggle-featured', [BlogController::class, 'toggleFeatured'])->name('toggle-featured');

        // Categorias
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/show', [BlogCategoryController::class, 'index'])->name('index');
            Route::get('create', [BlogCategoryController::class, 'create'])->name('create');
            Route::post('/', [BlogCategoryController::class, 'store'])->name('store');
            Route::get('{id}/edit', [BlogCategoryController::class, 'edit'])->name('edit');
            Route::put('{id}', [BlogCategoryController::class, 'update'])->name('update');
            Route::delete('{id}', [BlogCategoryController::class, 'destroy'])->name('destroy');
            Route::post('update-order', [BlogCategoryController::class, 'updateOrder'])->name('update-order');
        });

        // Tags
        Route::prefix('tags')->name('tags.')->group(function () {
            Route::get('/show', [BlogTagController::class, 'index'])->name('index');
            Route::post('/create', [BlogTagController::class, 'store'])->name('store');
            Route::put('update/{id}', [BlogTagController::class, 'update'])->name('update');
            Route::delete('{id}', [BlogTagController::class, 'destroy'])->name('destroy');
        });

        // Comentários
        Route::prefix('comments')->name('comments.')->group(function () {
            Route::get('/show', [BlogCommentController::class, 'index'])->name('index');
            Route::get('{id}', [BlogCommentController::class, 'show'])->name('show');
            Route::post('{id}/approve', [BlogCommentController::class, 'approve'])->name('approve');
            Route::post('{id}/reject', [BlogCommentController::class, 'reject'])->name('reject');
            Route::delete('{id}', [BlogCommentController::class, 'destroy'])->name('destroy');
            Route::post('bulk-action', [BlogCommentController::class, 'bulkAction'])->name('bulk-action');
        });
    });

    // Sistema de Eventos
    Route::prefix('eventos')->name('events.')->group(function () {
        // Equipamentos (rotas mais específicas primeiro)
        Route::prefix('equipamentos')->name('equipment.')->group(function () {
            Route::get('/', [App\Http\Controllers\Panel\EventEquipmentController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Panel\EventEquipmentController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Panel\EventEquipmentController::class, 'store'])->name('store');
            Route::get('/{equipment}', [App\Http\Controllers\Panel\EventEquipmentController::class, 'show'])->name('show');
            Route::get('/{equipment}/edit', [App\Http\Controllers\Panel\EventEquipmentController::class, 'edit'])->name('edit');
            Route::put('/{equipment}', [App\Http\Controllers\Panel\EventEquipmentController::class, 'update'])->name('update');
            Route::delete('/{equipment}', [App\Http\Controllers\Panel\EventEquipmentController::class, 'destroy'])->name('destroy');
            Route::post('/{equipment}/toggle-status', [App\Http\Controllers\Panel\EventEquipmentController::class, 'toggleStatus'])->name('toggle-status');
        });

        // Orçamentos (rotas mais específicas primeiro)
        Route::prefix('orcamentos')->name('budgets.')->group(function () {
            Route::get('/', [App\Http\Controllers\Panel\EventBudgetController::class, 'index'])->name('index');
            Route::get('/{event}/criar', [App\Http\Controllers\Panel\EventBudgetController::class, 'create'])->name('create');
            Route::post('/{event}', [App\Http\Controllers\Panel\EventBudgetController::class, 'store'])->name('store');
            Route::get('/{budget}', [App\Http\Controllers\Panel\EventBudgetController::class, 'show'])->name('show');
            Route::get('/{budget}/editar', [App\Http\Controllers\Panel\EventBudgetController::class, 'edit'])->name('edit');
            Route::put('/{budget}', [App\Http\Controllers\Panel\EventBudgetController::class, 'update'])->name('update');
            Route::delete('/{budget}', [App\Http\Controllers\Panel\EventBudgetController::class, 'destroy'])->name('destroy');
            Route::get('/{budget}/pdf', [App\Http\Controllers\Panel\EventBudgetController::class, 'generatePdf'])->name('pdf');
            Route::post('/{budget}/enviar', [App\Http\Controllers\Panel\EventBudgetController::class, 'sendToCustomer'])->name('send');
            Route::post('/{budget}/aprovar', [App\Http\Controllers\Panel\EventBudgetController::class, 'approve'])->name('approve');
            Route::post('/{budget}/rejeitar', [App\Http\Controllers\Panel\EventBudgetController::class, 'reject'])->name('reject');
            Route::post('/{budget}/faturar', [App\Http\Controllers\Panel\EventBudgetController::class, 'createInvoice'])->name('create-invoice');
            Route::post('/{budget}/criar-os', [App\Http\Controllers\Panel\EventBudgetController::class, 'createServiceOrder'])->name('create-service-order');
        });

        // Faturas
        Route::prefix('faturas')->name('invoices.')->group(function () {
            Route::get('/', [App\Http\Controllers\Panel\EventInvoiceController::class, 'index'])->name('index');
            Route::get('/{event}/criar', [App\Http\Controllers\Panel\EventInvoiceController::class, 'create'])->name('create');
            Route::post('/{event}', [App\Http\Controllers\Panel\EventInvoiceController::class, 'store'])->name('store');
            Route::get('/{invoice}', [App\Http\Controllers\Panel\EventInvoiceController::class, 'show'])->name('show');
            Route::get('/{invoice}/editar', [App\Http\Controllers\Panel\EventInvoiceController::class, 'edit'])->name('edit');
            Route::put('/{invoice}', [App\Http\Controllers\Panel\EventInvoiceController::class, 'update'])->name('update');
            Route::delete('/{invoice}', [App\Http\Controllers\Panel\EventInvoiceController::class, 'destroy'])->name('destroy');
            Route::get('/{invoice}/pdf', [App\Http\Controllers\Panel\EventInvoiceController::class, 'generatePdf'])->name('pdf');
            Route::post('/{invoice}/enviar', [App\Http\Controllers\Panel\EventInvoiceController::class, 'sendToCustomer'])->name('send');
            Route::post('/{invoice}/pagar', [App\Http\Controllers\Panel\EventInvoiceController::class, 'markAsPaid'])->name('mark-paid');
            Route::post('/os/{serviceOrder}/faturar', [App\Http\Controllers\Panel\EventInvoiceController::class, 'createFromServiceOrder'])->name('create-from-service-order');
        });

        // Pagamentos
        Route::prefix('pagamentos')->name('payments.')->group(function () {
            Route::get('/', [App\Http\Controllers\Panel\EventPaymentController::class, 'index'])->name('index');
            Route::get('/{event}/criar', [App\Http\Controllers\Panel\EventPaymentController::class, 'create'])->name('create');
            Route::post('/{event}', [App\Http\Controllers\Panel\EventPaymentController::class, 'store'])->name('store');
            Route::get('/{payment}', [App\Http\Controllers\Panel\EventPaymentController::class, 'show'])->name('show');
            Route::get('/{payment}/editar', [App\Http\Controllers\Panel\EventPaymentController::class, 'edit'])->name('edit');
            Route::put('/{payment}', [App\Http\Controllers\Panel\EventPaymentController::class, 'update'])->name('update');
            Route::delete('/{payment}', [App\Http\Controllers\Panel\EventPaymentController::class, 'destroy'])->name('destroy');
            Route::post('/{payment}/confirmar', [App\Http\Controllers\Panel\EventPaymentController::class, 'confirm'])->name('confirm');
            Route::post('/{payment}/cancelar', [App\Http\Controllers\Panel\EventPaymentController::class, 'cancel'])->name('cancel');
        });

            // Ordens de Serviço
            Route::prefix('ordens-servico')->name('service-orders.')->group(function () {
                Route::get('/', [App\Http\Controllers\Panel\EventServiceOrderController::class, 'index'])->name('index');
                Route::get('/criar', [App\Http\Controllers\Panel\EventServiceOrderController::class, 'selectEvent'])->name('select-event');
                Route::get('/{event}/criar', [App\Http\Controllers\Panel\EventServiceOrderController::class, 'create'])->name('create');
            Route::post('/{event}', [App\Http\Controllers\Panel\EventServiceOrderController::class, 'store'])->name('store');
            Route::get('/{serviceOrder}', [App\Http\Controllers\Panel\EventServiceOrderController::class, 'show'])->name('show');
            Route::get('/{serviceOrder}/editar', [App\Http\Controllers\Panel\EventServiceOrderController::class, 'edit'])->name('edit');
            Route::put('/{serviceOrder}', [App\Http\Controllers\Panel\EventServiceOrderController::class, 'update'])->name('update');
            Route::delete('/{serviceOrder}', [App\Http\Controllers\Panel\EventServiceOrderController::class, 'destroy'])->name('destroy');
            Route::get('/{serviceOrder}/pdf', [App\Http\Controllers\Panel\EventServiceOrderController::class, 'generatePdf'])->name('pdf');
            Route::post('/{serviceOrder}/iniciar', [App\Http\Controllers\Panel\EventServiceOrderController::class, 'startExecution'])->name('start');
            Route::post('/{serviceOrder}/concluir', [App\Http\Controllers\Panel\EventServiceOrderController::class, 'complete'])->name('complete');
            Route::post('/{serviceOrder}/cancelar', [App\Http\Controllers\Panel\EventServiceOrderController::class, 'cancel'])->name('cancel');
        });

        // Rotas específicas de eventos (antes do resource)
        Route::post('/{event}/add-service', [App\Http\Controllers\Panel\EventController::class, 'addService'])->name('add-service');
        Route::delete('/services/{service}', [App\Http\Controllers\Panel\EventController::class, 'removeService'])->name('remove-service');
        Route::post('/{event}/add-employee', [App\Http\Controllers\Panel\EventController::class, 'addEmployee'])->name('add-employee');
        Route::delete('/employees/{employee}', [App\Http\Controllers\Panel\EventController::class, 'removeEmployee'])->name('remove-employee');

            // Agenda
            Route::prefix('agenda')->name('schedule.')->group(function () {
                Route::get('/', [App\Http\Controllers\Panel\EventScheduleController::class, 'index'])->name('index');
                Route::get('/eventos-data', [App\Http\Controllers\Panel\EventScheduleController::class, 'getEventsForDate'])->name('events-for-date');
            });

            // Relatórios
            Route::prefix('relatorios')->name('reports.')->group(function () {
                Route::get('/', [App\Http\Controllers\Panel\EventReportController::class, 'index'])->name('index');
                Route::get('/financeiro', [App\Http\Controllers\Panel\EventReportController::class, 'financial'])->name('financial');
                Route::get('/equipamentos', [App\Http\Controllers\Panel\EventReportController::class, 'equipment'])->name('equipment');
                Route::get('/tipos-eventos', [App\Http\Controllers\Panel\EventReportController::class, 'eventTypes'])->name('event-types');
                Route::get('/metodos-pagamento', [App\Http\Controllers\Panel\EventReportController::class, 'paymentMethods'])->name('payment-methods');
            });

            // Analytics
            Route::get('/analytics', [App\Http\Controllers\Panel\EventAnalyticsController::class, 'index'])->name('analytics.index');

            // Confirmação de presença (pública)

            // Contratos
            Route::prefix('contratos')->name('contracts.')->group(function () {
                Route::get('/', [App\Http\Controllers\Panel\EventContractController::class, 'index'])->name('index');
                Route::get('/criar', [App\Http\Controllers\Panel\EventContractController::class, 'selectEvent'])->name('select-event');
                Route::get('/{event}/criar', [App\Http\Controllers\Panel\EventContractController::class, 'create'])->name('create');
                Route::post('/{event}', [App\Http\Controllers\Panel\EventContractController::class, 'store'])->name('store');
                Route::get('/{contract}', [App\Http\Controllers\Panel\EventContractController::class, 'show'])->name('show');
                Route::get('/{contract}/editar', [App\Http\Controllers\Panel\EventContractController::class, 'edit'])->name('edit');
                Route::put('/{contract}', [App\Http\Controllers\Panel\EventContractController::class, 'update'])->name('update');
                Route::delete('/{contract}', [App\Http\Controllers\Panel\EventContractController::class, 'destroy'])->name('destroy');
                Route::get('/{contract}/pdf', [App\Http\Controllers\Panel\EventContractController::class, 'pdf'])->name('pdf');
                Route::post('/{contract}/enviar', [App\Http\Controllers\Panel\EventContractController::class, 'send'])->name('send');
                Route::post('/{contract}/assinar', [App\Http\Controllers\Panel\EventContractController::class, 'sign'])->name('sign');
            });

            // Bio (admin)
            Route::get('/bio', [App\Http\Controllers\Panel\BioPageController::class, 'edit'])->name('bio.edit');
            Route::put('/bio', [App\Http\Controllers\Panel\BioPageController::class, 'update'])->name('bio.update');

            // Notas de Serviço
            Route::prefix('notas-servico')->name('service-notes.')->group(function () {
                Route::get('/', [App\Http\Controllers\Panel\EventServiceNoteController::class, 'index'])->name('index');
                Route::get('/{event}/criar', [App\Http\Controllers\Panel\EventServiceNoteController::class, 'create'])->name('create');
                Route::post('/{event}', [App\Http\Controllers\Panel\EventServiceNoteController::class, 'store'])->name('store');
                Route::get('/{serviceNote}', [App\Http\Controllers\Panel\EventServiceNoteController::class, 'show'])->name('show');
                Route::get('/{serviceNote}/editar', [App\Http\Controllers\Panel\EventServiceNoteController::class, 'edit'])->name('edit');
                Route::put('/{serviceNote}', [App\Http\Controllers\Panel\EventServiceNoteController::class, 'update'])->name('update');
                Route::delete('/{serviceNote}', [App\Http\Controllers\Panel\EventServiceNoteController::class, 'destroy'])->name('destroy');
                Route::get('/{serviceNote}/pdf', [App\Http\Controllers\Panel\EventServiceNoteController::class, 'pdf'])->name('pdf');
            });

            // Propostas Comerciais
            Route::prefix('propostas-comerciais')->name('commercial-proposals.')->group(function () {
                Route::get('/', [App\Http\Controllers\Panel\EventCommercialProposalController::class, 'index'])->name('index');
                Route::get('/{event}/criar', [App\Http\Controllers\Panel\EventCommercialProposalController::class, 'create'])->name('create');
                Route::post('/{event}', [App\Http\Controllers\Panel\EventCommercialProposalController::class, 'store'])->name('store');
                Route::get('/{commercialProposal}', [App\Http\Controllers\Panel\EventCommercialProposalController::class, 'show'])->name('show');
                Route::get('/{commercialProposal}/editar', [App\Http\Controllers\Panel\EventCommercialProposalController::class, 'edit'])->name('edit');
                Route::put('/{commercialProposal}', [App\Http\Controllers\Panel\EventCommercialProposalController::class, 'update'])->name('update');
                Route::delete('/{commercialProposal}', [App\Http\Controllers\Panel\EventCommercialProposalController::class, 'destroy'])->name('destroy');
                Route::get('/{commercialProposal}/pdf', [App\Http\Controllers\Panel\EventCommercialProposalController::class, 'pdf'])->name('pdf');
                Route::post('/{commercialProposal}/enviar', [App\Http\Controllers\Panel\EventCommercialProposalController::class, 'send'])->name('send');
                Route::post('/{commercialProposal}/aprovar', [App\Http\Controllers\Panel\EventCommercialProposalController::class, 'approve'])->name('approve');
                Route::post('/{commercialProposal}/rejeitar', [App\Http\Controllers\Panel\EventCommercialProposalController::class, 'reject'])->name('reject');
            });

            // Recibos
            Route::prefix('recibos')->name('receipts.')->group(function () {
                Route::get('/', [App\Http\Controllers\Panel\EventReceiptController::class, 'index'])->name('index');
                Route::get('/criar', [App\Http\Controllers\Panel\EventReceiptController::class, 'selectEvent'])->name('select-event');
                Route::get('/{event}/criar', [App\Http\Controllers\Panel\EventReceiptController::class, 'create'])->name('create');
                Route::post('/{event}', [App\Http\Controllers\Panel\EventReceiptController::class, 'store'])->name('store');
                Route::get('/{receipt}', [App\Http\Controllers\Panel\EventReceiptController::class, 'show'])->name('show');
                Route::get('/{receipt}/editar', [App\Http\Controllers\Panel\EventReceiptController::class, 'edit'])->name('edit');
                Route::put('/{receipt}', [App\Http\Controllers\Panel\EventReceiptController::class, 'update'])->name('update');
                Route::delete('/{receipt}', [App\Http\Controllers\Panel\EventReceiptController::class, 'destroy'])->name('destroy');
                Route::get('/{receipt}/pdf', [App\Http\Controllers\Panel\EventReceiptController::class, 'pdf'])->name('pdf');
                Route::post('/{receipt}/emitir', [App\Http\Controllers\Panel\EventReceiptController::class, 'issue'])->name('issue');
                Route::post('/{receipt}/marcar-pago', [App\Http\Controllers\Panel\EventReceiptController::class, 'markAsPaid'])->name('mark-as-paid');
            });

            // Categorias de Custos
            Route::prefix('categorias-custos')->name('cost-categories.')->group(function () {
                Route::get('/', [App\Http\Controllers\Panel\EventCostCategoryController::class, 'index'])->name('index');
                Route::get('/criar', [App\Http\Controllers\Panel\EventCostCategoryController::class, 'create'])->name('create');
                Route::post('/', [App\Http\Controllers\Panel\EventCostCategoryController::class, 'store'])->name('store');
                Route::get('/{costCategory}', [App\Http\Controllers\Panel\EventCostCategoryController::class, 'show'])->name('show');
                Route::get('/{costCategory}/editar', [App\Http\Controllers\Panel\EventCostCategoryController::class, 'edit'])->name('edit');
                Route::put('/{costCategory}', [App\Http\Controllers\Panel\EventCostCategoryController::class, 'update'])->name('update');
                Route::delete('/{costCategory}', [App\Http\Controllers\Panel\EventCostCategoryController::class, 'destroy'])->name('destroy');
            });

            // Custos
            Route::prefix('custos')->name('costs.')->group(function () {
                Route::get('/', [App\Http\Controllers\Panel\EventCostController::class, 'index'])->name('index');
                Route::get('/criar', [App\Http\Controllers\Panel\EventCostController::class, 'selectEvent'])->name('select-event');
                Route::get('/{event}/criar', [App\Http\Controllers\Panel\EventCostController::class, 'create'])->name('create');
                Route::post('/{event}', [App\Http\Controllers\Panel\EventCostController::class, 'store'])->name('store');
                Route::get('/{cost}', [App\Http\Controllers\Panel\EventCostController::class, 'show'])->name('show');
                Route::get('/{cost}/editar', [App\Http\Controllers\Panel\EventCostController::class, 'edit'])->name('edit');
                Route::put('/{cost}', [App\Http\Controllers\Panel\EventCostController::class, 'update'])->name('update');
                Route::delete('/{cost}', [App\Http\Controllers\Panel\EventCostController::class, 'destroy'])->name('destroy');
                Route::post('/{cost}/marcar-pago', [App\Http\Controllers\Panel\EventCostController::class, 'markPaid'])->name('mark-paid');
            });

            // Eventos (resource por último)
            Route::resource('/', App\Http\Controllers\Panel\EventController::class)->parameters(['' => 'event']);
        });
});

// Stripe Webhook (public, signed by Stripe) — disable CSRF and session
Route::post('/stripe/webhook', [\App\Http\Controllers\WebhookController::class, 'handleStripe'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class, \Illuminate\Session\Middleware\StartSession::class, \Illuminate\View\Middleware\ShareErrorsFromSession::class])
    ->name('stripe.webhook');
// Alternate path to match external configuration (ngrok etc.)
Route::post('/webhook/stripe', [\App\Http\Controllers\WebhookController::class, 'handleStripe'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class, \Illuminate\Session\Middleware\StartSession::class, \Illuminate\View\Middleware\ShareErrorsFromSession::class])
    ->name('stripe.webhook.alt');


// Confirmação de presença de evento (link público)
Route::get('/evento/confirmar/{token}', [App\Http\Controllers\Panel\EventConfirmationController::class, 'confirm'])->name('event.confirm');


// Links de Agendamento Rápido Público
Route::get('/agendar/{token}', [App\Http\Controllers\QuickBookingPublicController::class, 'show'])->name('quick-booking.public.show');
Route::post('/agendar/{token}', [App\Http\Controllers\QuickBookingPublicController::class, 'store'])->name('quick-booking.public.store');

// Sistema de Feedback Público
Route::get('/feedback/{token}', [App\Http\Controllers\FeedbackController::class, 'show'])->name('feedback.show');
Route::post('/feedback/{token}', [App\Http\Controllers\FeedbackController::class, 'store'])->name('feedback.store');

// Página pública de Bio (antes da rota dinâmica do perfil)
Route::get('/bio/{slug}', [App\Http\Controllers\PublicBioController::class, 'show'])->name('public.bio');

// Página pública do profissional (DEVE SER A ÚLTIMA rota pois é dinâmica)
// Constraint: aceita apenas letras, números, hífens e underscores
// IMPORTANTE: Rotas com parâmetros adicionais DEVEM vir ANTES da rota genérica /{slug}
Route::get('/{slug}/availability', [PublicController::class, 'getMonthAvailability'])
    ->where('slug', '[a-zA-Z0-9\-_]+')
    ->name('public.availability');
Route::get('/{slug}/available-slots', [PublicController::class, 'getAvailableSlots'])
    ->where('slug', '[a-zA-Z0-9\-_]+')
    ->name('public.slots');
Route::post('/{slug}/validate-promo', [PublicController::class, 'validatePromo'])
    ->where('slug', '[a-zA-Z0-9\-_]+')
    ->name('public.validate-promo');
Route::post('/{slug}/check-loyalty', [PublicController::class, 'checkLoyalty'])
    ->where('slug', '[a-zA-Z0-9\-_]+')
    ->name('public.check-loyalty');
Route::post('/bug-report', [BugReportController::class, 'store'])->name('bug-report.store');

Route::post('/{slug}/book', [PublicController::class, 'book'])
    ->where('slug', '[a-zA-Z0-9\-_]+')
    ->name('public.book');
// Blog Público (específico por profissional) - deve vir por último
Route::get('{professional_slug}/blog', [PublicBlogController::class, 'index'])->name('blog.index');
Route::get('{professional_slug}/blog/{post_slug}', [PublicBlogController::class, 'show'])->name('blog.show');
Route::get('{professional_slug}/blog/categoria/{category_slug}', [PublicBlogController::class, 'category'])->name('blog.category');
Route::get('{professional_slug}/blog/tag/{tag_slug}', [PublicBlogController::class, 'tag'])->name('blog.tag');
Route::post('{professional_slug}/blog/{post_slug}/comentario', [PublicBlogController::class, 'storeComment'])->name('blog.comment.store');

Route::get('/{slug}', [PublicController::class, 'show'])
    ->where('slug', '[a-zA-Z0-9\-_]+')
    ->name('public.show');
