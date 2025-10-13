<?php

use App\Http\Controllers\Panel\AgendaController;
use App\Http\Controllers\Panel\AvailabilityController;
use App\Http\Controllers\Panel\CustomerController;
use App\Http\Controllers\Panel\DashboardController;
use App\Http\Controllers\Panel\ReportController;
use App\Http\Controllers\Panel\ServiceController;
use App\Http\Controllers\Panel\SettingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;






// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('home');

// Rotas de autenticação (devem vir ANTES das rotas dinâmicas)
require __DIR__.'/auth.php';

// Dashboard (redireciona para panel)
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

    // Serviços
    Route::resource('servicos', ServiceController::class);

    // Clientes
    Route::resource('clientes', CustomerController::class);

    // Disponibilidade
    Route::resource('disponibilidade', AvailabilityController::class);
    Route::post('disponibilidade/blocked-dates', [AvailabilityController::class, 'storeBlockedDate'])
        ->name('disponibilidade.blocked-dates.store');
    Route::delete('disponibilidade/blocked-dates/{blockedDate}', [AvailabilityController::class, 'destroyBlockedDate'])
        ->name('disponibilidade.blocked-dates.destroy');

    // Relatórios
    Route::get('relatorios', [ReportController::class, 'index'])->name('relatorios.index');

    // Configurações
    Route::get('configuracoes', [SettingsController::class, 'index'])->name('configuracoes.index');
    Route::post('configuracoes', [SettingsController::class, 'update'])->name('configuracoes.update');
});


// Página pública do profissional (DEVE SER A ÚLTIMA rota pois é dinâmica)
// Constraint: aceita apenas letras, números, hífens e underscores
Route::get('/{slug}', [PublicController::class, 'show'])
    ->where('slug', '[a-zA-Z0-9\-_]+')
    ->name('public.show');
Route::get('/{slug}/available-slots', [PublicController::class, 'getAvailableSlots'])
    ->where('slug', '[a-zA-Z0-9\-_]+')
    ->name('public.slots');
Route::post('/{slug}/book', [PublicController::class, 'book'])
    ->where('slug', '[a-zA-Z0-9\-_]+')
    ->name('public.book');
