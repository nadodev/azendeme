<?php

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
});


// Links de Agendamento Rápido Público
Route::get('/agendar/{token}', [App\Http\Controllers\QuickBookingPublicController::class, 'show'])->name('quick-booking.public.show');
Route::post('/agendar/{token}', [App\Http\Controllers\QuickBookingPublicController::class, 'store'])->name('quick-booking.public.store');

// Sistema de Feedback Público
Route::get('/feedback/{token}', [App\Http\Controllers\FeedbackController::class, 'show'])->name('feedback.show');
Route::post('/feedback/{token}', [App\Http\Controllers\FeedbackController::class, 'store'])->name('feedback.store');

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
