<div id="onboarding-banner" class="mb-6 hidden">
    <div class="rounded-xl border-2 border-purple-200 bg-gradient-to-r from-purple-50 to-pink-50 p-4">
        <div class="flex items-start gap-4">
            <div class="shrink-0 w-10 h-10 rounded-full bg-purple-600 text-white flex items-center justify-center font-bold">1</div>
            <div class="flex-1">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-bold text-purple-800">Bem-vindo! Vamos configurar seu espaço</h3>
                    <button id="onboarding-dismiss" class="text-purple-700 hover:text-purple-900 text-sm">Ocultar</button>
                </div>
                <p class="text-sm text-purple-800/80 mb-3">Complete os passos abaixo para começar a receber agendamentos:</p>
                <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-2" id="onboarding-steps">
                    <!-- Steps render via JS -->
                </div>
                <div class="mt-3">
                    <div class="w-full bg-white/60 rounded-full h-2">
                        <div id="onboarding-progress" class="h-2 rounded-full bg-gradient-to-r from-purple-600 to-pink-600" style="width:0%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', async function() {
        if (!window.fetch) return;
        try {
            const res = await fetch('{{ url('/panel/onboarding') }}', { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            if (!res.ok) return;
            const data = await res.json();
            const banner = document.getElementById('onboarding-banner');
            if (!banner) return;
            if (data.completed) return; // não mostra se já terminou
            banner.classList.remove('hidden');

            const stepsConfig = [
                { key: 'profile', label: 'Perfil', href: '{{ url('/panel/perfil/editar') }}' },
                { key: 'services', label: 'Serviços', href: '{{ url('/panel/servicos') }}' },
                { key: 'availability', label: 'Disponibilidade', href: '{{ url('/panel/disponibilidade') }}' },
                { key: 'bio', label: 'Página Bio', href: '{{ url('/panel/eventos/bio') }}' },
                { key: 'payments', label: 'Pagamentos', href: '{{ url('/panel/planos') }}' },
            ];

            const container = document.getElementById('onboarding-steps');
            container.innerHTML = '';
            let doneCount = 0;
            stepsConfig.forEach(step => {
                const isDone = (data.steps && data.steps[step.key]) ? true : false;
                if (isDone) doneCount++;
                const item = document.createElement('a');
                item.href = step.href;
                item.className = 'flex items-center gap-2 p-2 rounded-lg border ' + (isDone ? 'border-green-200 bg-green-50 text-green-700' : 'border-purple-200 bg-white text-purple-700 hover:bg-purple-50');
                item.innerHTML = `
                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full text-xs font-bold ${isDone ? 'bg-green-600 text-white' : 'bg-purple-600 text-white'}">${isDone ? '✓' : '•'}</span>
                    <span class="text-sm font-semibold">${step.label}</span>
                    <button type="button" data-step="${step.key}" data-done="${!isDone}" class="ml-auto text-xs underline ${isDone ? 'text-green-700' : 'text-purple-700'}">${isDone ? 'Concluído' : 'Marcar concluído'}</button>
                `;
                container.appendChild(item);
            });

            const percent = Math.round((doneCount / stepsConfig.length) * 100);
            document.getElementById('onboarding-progress').style.width = percent + '%';

            container.addEventListener('click', async (e) => {
                const btn = e.target.closest('button[data-step]');
                if (!btn) return;
                e.preventDefault();
                const step = btn.getAttribute('data-step');
                const done = btn.getAttribute('data-done') === 'true';
                const resp = await fetch('{{ url('/panel/onboarding') }}', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ step, done })
                });
                if (resp.ok) location.reload();
            });

            const dismiss = document.getElementById('onboarding-dismiss');
            dismiss.addEventListener('click', () => banner.classList.add('hidden'));
        } catch (err) {
            // fail silently
        }
    });
    </script>
</div>


