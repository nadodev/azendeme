<script>
    const professionalSlug = '{{ $professional->slug }}';
    let currentMonth = new Date();
    let selectedDate = null;
    let selectedServiceIds = []; // Array para múltiplos serviços
    let totalDuration = 0; // Duração total
    let totalPrice = 0; // Preço total
    let selectedTime = null;

    const calendarMonth = document.getElementById('calendar-month');
    const calendarDays = document.getElementById('calendar-days');
    const prevMonthBtn = document.getElementById('prev-month');
    const nextMonthBtn = document.getElementById('next-month');
    const selectedDateDisplay = document.getElementById('selected-date-display');
    const selectedDateText = document.getElementById('selected-date-text');
    const timeSlotsContainer = document.getElementById('time-slots-container');
    const timeSlotsDiv = document.getElementById('time-slots');
    const selectedTimeInput = document.getElementById('selected-time');
    const selectedDateValueInput = document.getElementById('selected-date-value');
    const bookingForm = document.getElementById('booking-form');
    const bookingMessage = document.getElementById('booking-message');
    const customerNameInput = document.getElementById('customer-name');
    const customerPhoneInput = document.getElementById('customer-phone');
    const customerEmailInput = document.getElementById('customer-email');

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                // Update active nav link
                document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });

    // Helper to format date
    function formatDate(date) {
        return date.toLocaleDateString('pt-BR', { weekday: 'short', day: 'numeric', month: 'long', year: 'numeric' });
    }

    // Render Calendar
    async function renderCalendar() {
        calendarDays.innerHTML = '<div class="col-span-7 text-center py-4 text-gray-500">Carregando...</div>';
        
        const year = currentMonth.getFullYear();
        const month = currentMonth.getMonth() + 1; // JavaScript months are 0-indexed
        calendarMonth.textContent = currentMonth.toLocaleDateString('pt-BR', { month: 'long', year: 'numeric' });

        // Fetch availability for the month from API
        try {
            const response = await fetch(`/${professionalSlug}/availability?month=${month}&year=${year}`);
            const availabilityData = await response.json();
            
            calendarDays.innerHTML = '';
            
            const firstDayOfMonth = new Date(year, month - 1, 1);
            const lastDayOfMonth = new Date(year, month, 0);
            const daysInMonth = lastDayOfMonth.getDate();
            const startDayOfWeek = firstDayOfMonth.getDay(); // 0 for Sunday, 1 for Monday

            // Add empty cells for days before the 1st
            for (let i = 0; i < startDayOfWeek; i++) {
                const emptyCell = document.createElement('div');
                emptyCell.classList.add('text-center', 'py-2', 'text-gray-400');
                calendarDays.appendChild(emptyCell);
            }

            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            const availableDays = new Set(availabilityData.available_days);
            const blockedDates = new Set(availabilityData.blocked_dates);

            for (let day = 1; day <= daysInMonth; day++) {
                const date = new Date(year, month - 1, day);
                const dateStr = date.toISOString().split('T')[0];
                const dayCell = document.createElement('button');
                dayCell.type = 'button';
                dayCell.textContent = day;
                dayCell.classList.add('w-full', 'aspect-square', 'grid', 'place-content-center', 'rounded-lg', 'font-semibold', 'transition-all', 'duration-200');

                const isToday = date.toDateString() === today.toDateString();
                const isPastDay = date < today;
                const isBlocked = blockedDates.has(dateStr);
                const isAvailable = availableDays.has(dateStr) && !isBlocked && !isPastDay;

                if (!isAvailable) {
                    dayCell.classList.add('bg-gray-100', 'text-gray-400', 'cursor-not-allowed');
                    dayCell.disabled = true;
                } else {
                    dayCell.classList.add('bg-white', 'text-gray-700', 'hover:bg-[var(--brand)]/10', 'hover:border-[var(--brand)]', 'border-2', 'border-gray-200');
                    dayCell.addEventListener('click', () => selectDate(date, dayCell));
                }

                if (isToday) {
                    dayCell.classList.add('ring-2', 'ring-blue-400');
                }

                if (selectedDate && selectedDate.toDateString() === date.toDateString()) {
                    dayCell.classList.add('bg-[var(--brand)]', 'text-white', 'ring-2', 'ring-[var(--brand)]');
                }

                calendarDays.appendChild(dayCell);
            }
        } catch (error) {
            console.error('Error loading calendar:', error);
            calendarDays.innerHTML = '<div class="col-span-7 text-center py-4 text-red-500">Erro ao carregar calendário</div>';
        }
    }

    async function selectDate(date, dayCell) {
        // Clear previous selection
        document.querySelectorAll('#calendar-days button').forEach(btn => {
            if (!btn.disabled) {
                btn.classList.remove('bg-[var(--brand)]', 'text-white', 'ring-2', 'ring-[var(--brand)]');
                btn.classList.add('bg-white', 'text-gray-700', 'hover:bg-[var(--brand)]/10', 'hover:border-[var(--brand)]', 'border-2', 'border-gray-200');
            }
        });

        // Apply new selection
        dayCell.classList.remove('bg-white', 'text-gray-700', 'hover:bg-[var(--brand)]/10', 'hover:border-[var(--brand)]', 'border-2', 'border-gray-200');
        dayCell.classList.add('bg-[var(--brand)]', 'text-white', 'ring-2', 'ring-[var(--brand)]');
        selectedDate = date;
        selectedDateText.textContent = formatDate(date);
        selectedDateDisplay.classList.remove('hidden');
        selectedDateValueInput.value = date.toISOString().split('T')[0]; // YYYY-MM-DD

        await fetchTimeSlots();
    }

    // Atualiza seleção de serviços
    window.updateServiceSelection = function() {
        const checkboxes = document.querySelectorAll('.service-checkbox:checked');
        selectedServiceIds = Array.from(checkboxes).map(cb => cb.value);
        
        totalDuration = 0;
        totalPrice = 0;
        
        const summaryContent = document.getElementById('services-summary-content');
        const servicesSummary = document.getElementById('services-summary');
        
        if (selectedServiceIds.length === 0) {
            servicesSummary.classList.add('hidden');
            if (selectedDate) {
                timeSlotsContainer.classList.add('hidden');
            }
            return;
        }
        
        summaryContent.innerHTML = '';
        checkboxes.forEach(cb => {
            const duration = parseInt(cb.dataset.duration);
            const price = parseFloat(cb.dataset.price);
            const label = cb.parentElement.querySelector('.font-bold').textContent;
            
            totalDuration += duration;
            totalPrice += price;
            
            const div = document.createElement('div');
            div.innerHTML = `✓ ${label}`;
            summaryContent.appendChild(div);
        });
        
        document.getElementById('total-duration').textContent = totalDuration;
        document.getElementById('total-price').textContent = totalPrice.toFixed(2).replace('.', ',');
        servicesSummary.classList.remove('hidden');
        
        // Recarrega os horários se já tiver data selecionada
        if (selectedDate) {
            fetchTimeSlots();
        }
    };

    async function fetchTimeSlots() {
        if (!selectedDate || selectedServiceIds.length === 0) {
            timeSlotsContainer.classList.add('hidden');
            return;
        }

        const dateStr = selectedDate.toISOString().split('T')[0];
        
        // Usa o primeiro serviço selecionado para buscar slots
        // A duração total será considerada no backend
        try {
            const response = await fetch(`/${professionalSlug}/available-slots?date=${dateStr}&service_id=${selectedServiceIds[0]}`);
            const slots = await response.json();

            timeSlotsDiv.innerHTML = '';
            if (Array.isArray(slots) && slots.length > 0) {
                slots.forEach(time => {
                    const slotButton = document.createElement('button');
                    slotButton.type = 'button';
                    slotButton.textContent = time;
                    slotButton.classList.add('px-4', 'py-2', 'rounded-lg', 'border-2', 'border-gray-200', 'bg-white', 'text-gray-700', 'hover:bg-[var(--brand)]/10', 'hover:border-[var(--brand)]', 'transition-all', 'font-medium');
                    slotButton.addEventListener('click', () => selectTime(time, slotButton));
                    timeSlotsDiv.appendChild(slotButton);
                });
                timeSlotsContainer.classList.remove('hidden');
            } else {
                timeSlotsDiv.innerHTML = '<p class="col-span-full text-center text-gray-500 py-4">Nenhum horário disponível para este dia e serviço(s).</p>';
                timeSlotsContainer.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Erro ao carregar horários:', error);
            timeSlotsDiv.innerHTML = '<p class="col-span-full text-center text-red-500 py-4">Erro ao carregar horários. Tente novamente.</p>';
            timeSlotsContainer.classList.remove('hidden');
        }
    }

    function selectTime(time, timeButton) {
        document.querySelectorAll('#time-slots button').forEach(btn => {
            btn.classList.remove('bg-[var(--brand)]', 'text-white', 'ring-2', 'ring-[var(--brand)]');
            btn.classList.add('bg-white', 'text-gray-700', 'hover:bg-[var(--brand)]/10', 'hover:border-[var(--brand)]');
        });
        timeButton.classList.remove('bg-white', 'text-gray-700', 'hover:bg-[var(--brand)]/10', 'hover:border-[var(--brand)]');
        timeButton.classList.add('bg-[var(--brand)]', 'text-white', 'ring-2', 'ring-[var(--brand)]');
        selectedTime = time;
        selectedTimeInput.value = time;
    }

    // Event Listeners
    prevMonthBtn.addEventListener('click', () => {
        currentMonth.setMonth(currentMonth.getMonth() - 1);
        renderCalendar();
    });

    nextMonthBtn.addEventListener('click', () => {
        currentMonth.setMonth(currentMonth.getMonth() + 1);
        renderCalendar();
    });

    // Function to select service from service card button
    window.selectService = function(serviceId) {
        const checkbox = document.querySelector(`.service-checkbox[value="${serviceId}"]`);
        if (checkbox) {
            checkbox.checked = true;
            updateServiceSelection();
        }
    };

    // Function to apply promo code
    window.applyPromoCode = async function() {
        const promoCodeInput = document.getElementById('promo-code');
        const promoMessage = document.getElementById('promo-message');
        const appliedPromoId = document.getElementById('applied-promo-id');
        const discountAmount = document.getElementById('discount-amount');
        const code = promoCodeInput.value.trim().toUpperCase();

        // Reset
        promoMessage.classList.add('hidden');
        promoMessage.classList.remove('text-green-700', 'bg-green-50', 'border-green-200', 'text-red-700', 'bg-red-50', 'border-red-200');
        appliedPromoId.value = '';
        discountAmount.value = '';

        if (!code) {
            return;
        }

        try {
            const response = await fetch(`/${professionalSlug}/validate-promo`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ code: code })
            });

            const result = await response.json();

            promoMessage.classList.remove('hidden');
            promoMessage.classList.add('p-3', 'rounded-xl', 'border-2');

            if (result.valid) {
                promoMessage.textContent = '✅ Cupom aplicado! ' + result.discount;
                promoMessage.classList.add('text-green-700', 'bg-green-50', 'border-green-200');
                appliedPromoId.value = result.promotion_id;
                discountAmount.value = result.discount_percentage || result.discount_fixed || 0;
            } else {
                promoMessage.textContent = '❌ ' + result.message;
                promoMessage.classList.add('text-red-700', 'bg-red-50', 'border-red-200');
            }
        } catch (error) {
            promoMessage.classList.remove('hidden');
            promoMessage.classList.add('p-3', 'rounded-xl', 'border-2', 'text-red-700', 'bg-red-50', 'border-red-200');
            promoMessage.textContent = '❌ Erro ao validar cupom. Tente novamente.';
        }
    };

    bookingForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        bookingMessage.classList.add('hidden');
        bookingMessage.classList.remove('text-red-700', 'bg-red-50', 'border-red-200', 'text-green-700', 'bg-green-50', 'border-green-200');

        if (selectedServiceIds.length === 0 || !selectedDate || !selectedTime || !customerNameInput.value || !customerPhoneInput.value) {
            bookingMessage.textContent = 'Por favor, preencha todos os campos obrigatórios e selecione pelo menos um serviço, data e horário.';
            bookingMessage.classList.remove('hidden');
            bookingMessage.classList.add('text-red-700', 'bg-red-50', 'border-red-200', 'p-4', 'rounded-xl', 'border-2');
            return;
        }

        const professionalSelect = document.getElementById('professional-select');
        const appliedPromoId = document.getElementById('applied-promo-id');
        const formData = {
            service_ids: selectedServiceIds,
            date: selectedDateValueInput.value,
            time: selectedTime,
            name: customerNameInput.value,
            phone: customerPhoneInput.value,
            email: customerEmailInput.value || null,
            professional_id: professionalSelect?.value || null,
            promotion_id: appliedPromoId?.value || null,
        };

        try {
            const response = await fetch(`/${professionalSlug}/book`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (response.ok && result.success) {
                const servicesText = selectedServiceIds.length > 1 
                    ? `${selectedServiceIds.length} serviços`
                    : document.querySelector('.service-checkbox:checked').parentElement.querySelector('.font-bold').textContent;
                
                const dateStr = selectedDate.toLocaleDateString('pt-BR');
                
                document.getElementById('success-details').textContent = 
                    `${servicesText} agendado(s) para ${dateStr} às ${selectedTime}. Total: R$ ${totalPrice.toFixed(2).replace('.', ',')} (${totalDuration} min)`;
                
                document.getElementById('success-modal').classList.remove('hidden');
                setTimeout(() => {
                    document.getElementById('modal-content').classList.add('scale-100');
                    document.getElementById('modal-content').classList.remove('scale-95');
                }, 10);
                
                // Clear form and selections
                bookingForm.reset();
                document.querySelectorAll('.service-checkbox').forEach(cb => cb.checked = false);
                selectedDate = null;
                selectedServiceIds = [];
                totalDuration = 0;
                totalPrice = 0;
                selectedTime = null;
                selectedDateDisplay.classList.add('hidden');
                timeSlotsContainer.classList.add('hidden');
                document.getElementById('services-summary').classList.add('hidden');
                renderCalendar();
            } else {
                bookingMessage.textContent = result.message || 'Erro ao realizar agendamento. Tente novamente.';
                bookingMessage.classList.remove('hidden');
                bookingMessage.classList.add('text-red-700', 'bg-red-50', 'border-red-200', 'p-4', 'rounded-xl', 'border-2');
            }
        } catch (error) {
            bookingMessage.textContent = 'Erro de conexão. Tente novamente.';
            bookingMessage.classList.remove('hidden');
            bookingMessage.classList.add('text-red-700', 'bg-red-50', 'border-red-200', 'p-4', 'rounded-xl', 'border-2');
            console.error('Booking error:', error);
        }
    });

    function closeSuccessModal() {
        document.getElementById('modal-content').classList.add('scale-95');
        document.getElementById('modal-content').classList.remove('scale-100');
        setTimeout(() => {
            document.getElementById('success-modal').classList.add('hidden');
        }, 200);
    }

    window.closeSuccessModal = closeSuccessModal;

    // Gallery Modal
    const galleryModal = document.getElementById('gallery-modal');
    const galleryModalImg = document.getElementById('gallery-modal-img');
    const galleryModalTitle = document.getElementById('gallery-modal-title');
    const galleryModalDesc = document.getElementById('gallery-modal-description');
    const galleryCloseBtn = document.getElementById('gallery-close-btn');

    document.querySelectorAll('.gallery-item').forEach(item => {
        item.addEventListener('click', () => {
            const img = item.querySelector('img');
            const title = item.querySelector('.font-bold');
            const desc = item.querySelector('.text-sm');
            
            galleryModalImg.src = img.src;
            galleryModalTitle.textContent = title ? title.textContent : 'Nosso Trabalho';
            galleryModalDesc.textContent = desc ? desc.textContent : '';
            galleryModal.classList.remove('hidden');
        });
    });

    galleryCloseBtn.addEventListener('click', () => {
        galleryModal.classList.add('hidden');
    });
    
    galleryModal.addEventListener('click', (e) => {
        if (e.target === galleryModal) {
            galleryModal.classList.add('hidden');
        }
    });

    // Initial render
    renderCalendar();

    // Active nav link on scroll
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                navLinks.forEach(link => {
                    link.classList.toggle('active', link.getAttribute('href') === '#' + entry.target.id);
                });
            }
        });
    }, { threshold: 0.3 });

    sections.forEach(section => {
        observer.observe(section);
    });
</script>

