<!-- Agendamento -->
<section id="agendar" class="py-12 lg:py-20 bg-gradient-to-br from-gray-50 to-white">
    <div class="md:max-w-5xl md:mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="text-center mb-8 lg:mb-12">
            <span class="inline-block px-3 lg:px-4 py-1.5 lg:py-2 rounded-full text-xs lg:text-sm font-semibold mb-3 lg:mb-4 text-white shadow-lg" style="background: var(--brand)">
                📅 Agendamento Online
            </span>
            <h3 class="text-3xl lg:text-4xl xl:text-5xl font-bold text-gray-900 mb-3 lg:mb-4">Agende Seu Horário</h3>
            <p class="text-gray-600 text-base lg:text-lg max-w-2xl mx-auto">Selecione o serviço, escolha a data no calendário e confirme seu agendamento</p>
        </div>
        
        <div class="bg-white rounded-2xl lg:rounded-3xl shadow-2xl overflow-hidden">
            <div class="grid lg:grid-cols-2 gap-0">
                <!-- Calendário -->
                <div class="p-4 lg:p-8 bg-gradient-to-br from-purple-50 to-pink-50">
                    <h4 class="text-lg lg:text-xl font-bold text-gray-900 mb-4 lg:mb-6 flex items-center">
                        <span class="w-8 h-8 lg:w-10 lg:h-10 rounded-lg lg:rounded-xl flex items-center justify-center text-white mr-2 lg:mr-3 shadow-lg text-sm lg:text-base" style="background: var(--brand)">
                            📅
                        </span>
                        Escolha a Data
                    </h4>
                    <div id="calendar-container" class="relative bg-white rounded-xl lg:rounded-2xl p-4 lg:p-6 shadow-lg">
                        <div id="calendar-overlay" class="absolute inset-0 bg-white/70 backdrop-blur-sm rounded-xl lg:rounded-2xl flex items-center justify-center text-gray-500 text-sm hidden">
                            Selecione o serviço e o funcionário para ver o calendário
                        </div>
                        <div class="flex items-center justify-between mb-4 lg:mb-6">
                            <button type="button" id="prev-month" class="p-1.5 lg:p-2 hover:bg-gray-100 rounded-lg transition">
                                <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <h5 id="calendar-month" class="text-base lg:text-lg font-bold text-gray-900"></h5>
                            <button type="button" id="next-month" class="p-1.5 lg:p-2 hover:bg-gray-100 rounded-lg transition">
                                <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                        <div class="grid grid-cols-7 gap-1 lg:gap-2 mb-2">
                            <div class="text-center text-xs font-semibold text-gray-500">Dom</div>
                            <div class="text-center text-xs font-semibold text-gray-500">Seg</div>
                            <div class="text-center text-xs font-semibold text-gray-500">Ter</div>
                            <div class="text-center text-xs font-semibold text-gray-500">Qua</div>
                            <div class="text-center text-xs font-semibold text-gray-500">Qui</div>
                            <div class="text-center text-xs font-semibold text-gray-500">Sex</div>
                            <div class="text-center text-xs font-semibold text-gray-500">Sáb</div>
                        </div>
                        <div id="calendar-days" class="grid grid-cols-7 gap-1 lg:gap-2"></div>
                        <div class="mt-4 lg:mt-6 flex items-center justify-center gap-3 lg:gap-6 text-xs">
                            <div class="flex items-center gap-1 lg:gap-2">
                                <div class="w-3 h-3 lg:w-4 lg:h-4 rounded border-2 border-[var(--brand)] bg-[var(--brand)]/10"></div>
                                <span class="text-gray-600">Disponível</span>
                            </div>
                            <div class="flex items-center gap-1 lg:gap-2">
                                <div class="w-3 h-3 lg:w-4 lg:h-4 rounded bg-gray-200"></div>
                                <span class="text-gray-600">Indisponível</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulário -->
                <div class="p-4 lg:p-8">
                    <form id="booking-form" class="space-y-4 lg:space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 lg:mb-3">Selecione o(s) Serviço(s) *</label>
                            <div class="space-y-2 lg:space-y-3 max-h-60 lg:max-h-80 overflow-y-auto pr-1 lg:pr-2">
                                @foreach($services as $service)
                                    <label class="flex items-start p-3 lg:p-4 border-2 border-gray-200 rounded-lg lg:rounded-xl hover:border-[var(--brand)] transition-all cursor-pointer group">
                                        <input 
                                            type="checkbox" 
                                            name="service_ids[]" 
                                            value="{{ $service->id }}" 
                                            data-duration="{{ $service->duration }}"
                                            data-price="{{ $service->price }}"
                                            data-employees='{{ json_encode($service->employees->pluck("id")->toArray()) }}'
                                            class="service-checkbox mt-1 w-4 h-4 lg:w-5 lg:h-5 rounded border-gray-300 text-[var(--brand)] focus:ring-[var(--brand)] focus:ring-offset-0"
                                            onchange="updateServiceSelection()"
                                        >
                                        <div class="ml-2 lg:ml-3 flex-1">
                                            <div class="font-bold text-gray-900 group-hover:text-[var(--brand)] transition-colors text-sm lg:text-base">{{ $service->name }}</div>
                                            <div class="text-xs lg:text-sm text-gray-600 mt-1">
                                                <span class="inline-flex items-center mr-2 lg:mr-3">
                                                    <svg class="w-3 h-3 lg:w-4 lg:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    {{ $service->duration }}min
                                                </span>
                                                <span class="font-bold text-[var(--brand)]">R$ {{ number_format($service->price, 2, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            <div id="services-summary" class="hidden mt-4 p-4 bg-green-50 border-2 border-green-200 rounded-xl">
                                <div class="text-sm font-semibold text-green-800 mb-2">Resumo:</div>
                                <div id="services-summary-content" class="text-sm text-green-700 space-y-1"></div>
                                <div class="mt-3 pt-3 border-t border-green-300 flex justify-between items-center">
                                    <span class="font-bold text-green-900">Total:</span>
                                    <div class="text-right">
                                        <div class="text-sm text-green-700">
                                            <span id="total-duration">0</span> minutos
                                        </div>
                                        <div class="text-lg font-bold text-green-900">
                                            R$ <span id="total-price">0,00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="employee-section" class="hidden">
                            <label class="block text-sm font-bold text-gray-700 mb-3">Quem irá realizar o atendimento? *</label>
                            <select id="employee-select" name="employee_id" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[var(--brand)] focus:ring-2 focus:ring-[var(--brand)]/20 transition-all" onchange="onEmployeeChange()">
                                <option value="">Selecione o profissional/funcionário</option>
                                <!-- Opção "Profissional" será adicionada dinamicamente se serviço não tiver funcionários -->
                                <option value="professional" data-is-professional="true" class="professional-option hidden">{{ $professional->name ?? 'Profissional' }}</option>
                                @foreach(($employees ?? []) as $emp)
                                    <option value="{{ $emp->id }}" data-employee-id="{{ $emp->id }}">{{ $emp->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-2">Escolha quem irá realizar o atendimento</p>
                        </div>

                        <div id="selected-date-display" class="hidden p-4 bg-[var(--brand)]/10 rounded-xl border-2 border-[var(--brand)]/20">
                            <div class="text-sm text-gray-600 mb-1">Data selecionada:</div>
                            <div id="selected-date-text" class="text-lg font-bold" style="color: var(--brand)"></div>
                        </div>

                        <div id="time-slots-container" class="hidden">
                            <label class="block text-sm font-bold text-gray-700 mb-3">Horários Disponíveis *</label>
                            <div id="time-slots" class="grid grid-cols-3 gap-2 max-h-64 overflow-y-auto"></div>
                            <input type="hidden" id="selected-time" required>
                            <input type="hidden" id="selected-date-value">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nome *</label>
                                <input type="text" id="customer-name" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[var(--brand)] focus:ring-2 focus:ring-[var(--brand)]/20 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Telefone *</label>
                                <input type="tel" id="customer-phone" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[var(--brand)] focus:ring-2 focus:ring-[var(--brand)]/20 transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">E-mail</label>
                            <input type="email" id="customer-email" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[var(--brand)] focus:ring-2 focus:ring-[var(--brand)]/20 transition-all">
                        </div>

                        <!-- Cupom de Desconto -->
                        <div class="border-t border-gray-200 pt-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                🎫 Cupom de Desconto (Opcional)
                            </label>
                            <div class="flex gap-2">
                                <input type="text" 
                                       id="promo-code" 
                                       placeholder="Digite o código do cupom"
                                       class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[var(--brand)] focus:ring-2 focus:ring-[var(--brand)]/20 transition-all uppercase">
                                <button type="button" 
                                        onclick="applyPromoCode()"
                                        class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                                    Aplicar
                                </button>
                            </div>
                            <div id="promo-message" class="mt-2 text-sm hidden"></div>
                            <input type="hidden" id="applied-promo-id">
                            <input type="hidden" id="discount-amount">
                        </div>

                        <div id="booking-message" class="hidden"></div>

                        @if(config('services.turnstile.enabled'))
                        <div>
                            <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
                            <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>
                        </div>
                        @endif

                        <button type="submit" class="w-full py-4 rounded-xl text-white font-bold text-lg shadow-xl hover:shadow-2xl transition-all hover:scale-105" style="background: var(--brand)">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Confirmar Agendamento
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Estado inicial: calendário e horários bloqueados até escolher serviço + funcionário
document.addEventListener('DOMContentLoaded', () => {
    setBookingState();
});

// As funções updateServiceSelection(), setBookingState() e onEmployeeChange() estão definidas em scripts.blade.php
</script>

<!-- Success Modal -->
<div id="success-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div id="modal-content" class="bg-white rounded-3xl shadow-2xl p-10 max-w-md w-full text-center transform scale-95 transition-transform duration-300">
        <div class="w-20 h-20 rounded-full mx-auto mb-6 flex items-center justify-center text-4xl shadow-xl" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%)">
            ✓
        </div>
        <h4 class="text-2xl font-bold text-gray-900 mb-2">Agendamento Confirmado!</h4>
        <p class="text-gray-600 mb-6" id="success-details"></p>
        <button onclick="closeSuccessModal()" class="px-8 py-3 rounded-full text-white font-bold shadow-lg hover:shadow-xl transition-all" style="background: var(--brand)">
            Entendi
        </button>
    </div>
</div>

