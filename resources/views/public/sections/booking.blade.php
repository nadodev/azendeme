<!-- Agendamento -->
<section id="agendar" class="py-20 bg-gradient-to-br from-gray-50 to-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold mb-4 text-white shadow-lg" style="background: var(--brand)">
                📅 Agendamento Online
            </span>
            <h3 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Agende Seu Horário</h3>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Selecione o serviço, escolha a data no calendário e confirme seu agendamento</p>
        </div>
        
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="grid lg:grid-cols-2 gap-0">
                <!-- Calendário -->
                <div class="p-8 bg-gradient-to-br from-purple-50 to-pink-50">
                    <h4 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-10 h-10 rounded-xl flex items-center justify-center text-white mr-3 shadow-lg" style="background: var(--brand)">
                            📅
                        </span>
                        Escolha a Data
                    </h4>
                    <div id="calendar-container" class="bg-white rounded-2xl p-6 shadow-lg">
                        <div class="flex items-center justify-between mb-6">
                            <button type="button" id="prev-month" class="p-2 hover:bg-gray-100 rounded-lg transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <h5 id="calendar-month" class="text-lg font-bold text-gray-900"></h5>
                            <button type="button" id="next-month" class="p-2 hover:bg-gray-100 rounded-lg transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                        <div class="grid grid-cols-7 gap-2 mb-2">
                            <div class="text-center text-xs font-semibold text-gray-500">Dom</div>
                            <div class="text-center text-xs font-semibold text-gray-500">Seg</div>
                            <div class="text-center text-xs font-semibold text-gray-500">Ter</div>
                            <div class="text-center text-xs font-semibold text-gray-500">Qua</div>
                            <div class="text-center text-xs font-semibold text-gray-500">Qui</div>
                            <div class="text-center text-xs font-semibold text-gray-500">Sex</div>
                            <div class="text-center text-xs font-semibold text-gray-500">Sáb</div>
                        </div>
                        <div id="calendar-days" class="grid grid-cols-7 gap-2"></div>
                        <div class="mt-6 flex items-center justify-center gap-6 text-xs">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded border-2 border-[var(--brand)] bg-[var(--brand)]/10"></div>
                                <span class="text-gray-600">Disponível</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded bg-gray-200"></div>
                                <span class="text-gray-600">Indisponível</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulário -->
                <div class="p-8">
                    <form id="booking-form" class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Selecione o(s) Serviço(s) *</label>
                            <div class="space-y-3 max-h-80 overflow-y-auto pr-2">
                                @foreach($services as $service)
                                    <label class="flex items-start p-4 border-2 border-gray-200 rounded-xl hover:border-[var(--brand)] transition-all cursor-pointer group">
                                        <input 
                                            type="checkbox" 
                                            name="service_ids[]" 
                                            value="{{ $service->id }}" 
                                            data-duration="{{ $service->duration }}"
                                            data-price="{{ $service->price }}"
                                            class="service-checkbox mt-1 w-5 h-5 rounded border-gray-300 text-[var(--brand)] focus:ring-[var(--brand)] focus:ring-offset-0"
                                            onchange="updateServiceSelection()"
                                        >
                                        <div class="ml-3 flex-1">
                                            <div class="font-bold text-gray-900 group-hover:text-[var(--brand)] transition-colors">{{ $service->name }}</div>
                                            <div class="text-sm text-gray-600 mt-1">
                                                <span class="inline-flex items-center mr-3">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
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

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Profissional (Opcional)</label>
                            <select id="professional-select" name="professional_id" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[var(--brand)] focus:ring-2 focus:ring-[var(--brand)]/20 transition-all">
                                <option value="">Qualquer profissional disponível</option>
                                @foreach($professionals as $prof)
                                    <option value="{{ $prof->id }}">
                                        {{ $prof->name }}@if($prof->specialty) - {{ $prof->specialty }}@endif
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-2">Se não selecionar, o agendamento será feito com qualquer profissional disponível</p>
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

