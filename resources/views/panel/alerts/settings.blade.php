@extends('panel.layout')

@section('page-title', 'Configurações de Alertas')
@section('page-subtitle', 'Configure quais alertas deseja receber')

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Configurações de Alertas</h3>
            <p class="text-gray-600">Configure quais tipos de alertas você deseja receber e como deseja ser notificado.</p>
        </div>

        <form id="alert-settings-form">
            <div class="space-y-6">
                @foreach($alertTypes as $type => $label)
                    @php
                        $setting = $settings->firstWhere('alert_type', $type);
                        $enabled = $setting ? $setting->enabled : true;
                    @endphp
                    
                    <div class="border border-gray-200 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                    @switch($type)
                                        @case('new_appointment')
                                            📅
                                            @break
                                        @case('cancelled_appointment')
                                            ❌
                                            @break
                                        @case('new_customer')
                                            👤
                                            @break
                                        @case('payment_received')
                                            💰
                                            @break
                                        @case('appointment_reminder')
                                            ⏰
                                            @break
                                        @case('no_show')
                                            🚫
                                            @break
                                        @case('feedback_received')
                                            ⭐
                                            @break
                                        @case('service_completed')
                                            ✅
                                            @break
                                        @default
                                            📢
                                    @endswitch
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $label }}</h4>
                                    <p class="text-sm text-gray-500">
                                        @switch($type)
                                            @case('new_appointment')
                                                Receba notificações quando um novo agendamento for criado
                                                @break
                                            @case('cancelled_appointment')
                                                Receba notificações quando um agendamento for cancelado
                                                @break
                                            @case('new_customer')
                                                Receba notificações quando um novo cliente se cadastrar
                                                @break
                                            @case('payment_received')
                                                Receba notificações quando um pagamento for recebido
                                                @break
                                            @case('appointment_reminder')
                                                Receba lembretes antes dos agendamentos
                                                @break
                                            @case('no_show')
                                                Receba notificações quando um cliente não comparecer
                                                @break
                                            @case('feedback_received')
                                                Receba notificações quando receber feedback de clientes
                                                @break
                                            @case('service_completed')
                                                Receba notificações quando um serviço for concluído
                                                @break
                                        @endswitch
                                    </p>
                                </div>
                            </div>
                            
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="settings[{{ $loop->index }}][enabled]" 
                                       value="1" 
                                       class="sr-only peer" 
                                       {{ $enabled ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                            </label>
                        </div>
                        
                        <input type="hidden" name="settings[{{ $loop->index }}][alert_type]" value="{{ $type }}">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Canais de Notificação</label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" 
                                               name="settings[{{ $loop->index }}][channels][email]" 
                                               value="email" 
                                               class="rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                                               {{ $setting && isset($setting->channels['email']) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">📧 E-mail</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" 
                                               name="settings[{{ $loop->index }}][channels][sms]" 
                                               value="sms" 
                                               class="rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                                               {{ $setting && isset($setting->channels['sms']) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">📱 SMS</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" 
                                               name="settings[{{ $loop->index }}][channels][push]" 
                                               value="push" 
                                               class="rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                                               {{ $setting && isset($setting->channels['push']) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">🔔 Notificação Push</span>
                                    </label>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Condições Especiais</label>
                                <div class="space-y-2">
                                    @if($type === 'appointment_reminder')
                                        <div>
                                            <label class="block text-xs text-gray-500 mb-1">Lembrar com antecedência</label>
                                            <select name="settings[{{ $loop->index }}][conditions][reminder_time]" 
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                                <option value="1" {{ $setting && isset($setting->conditions['reminder_time']) && $setting->conditions['reminder_time'] == '1' ? 'selected' : '' }}>1 hora antes</option>
                                                <option value="2" {{ $setting && isset($setting->conditions['reminder_time']) && $setting->conditions['reminder_time'] == '2' ? 'selected' : '' }}>2 horas antes</option>
                                                <option value="24" {{ $setting && isset($setting->conditions['reminder_time']) && $setting->conditions['reminder_time'] == '24' ? 'selected' : '' }}>1 dia antes</option>
                                                <option value="48" {{ $setting && isset($setting->conditions['reminder_time']) && $setting->conditions['reminder_time'] == '48' ? 'selected' : '' }}>2 dias antes</option>
                                            </select>
                                        </div>
                                    @endif
                                    
                                    @if($type === 'payment_received')
                                        <div>
                                            <label class="block text-xs text-gray-500 mb-1">Valor mínimo</label>
                                            <input type="number" 
                                                   name="settings[{{ $loop->index }}][conditions][min_amount]" 
                                                   value="{{ $setting && isset($setting->conditions['min_amount']) ? $setting->conditions['min_amount'] : '' }}"
                                                   placeholder="R$ 0,00"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                        </div>
                                    @endif
                                    
                                    @if($type === 'cancelled_appointment')
                                        <div>
                                            <label class="block text-xs text-gray-500 mb-1">Horário limite</label>
                                            <select name="settings[{{ $loop->index }}][conditions][time_limit]" 
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                                <option value="any" {{ $setting && isset($setting->conditions['time_limit']) && $setting->conditions['time_limit'] == 'any' ? 'selected' : '' }}>Qualquer horário</option>
                                                <option value="same_day" {{ $setting && isset($setting->conditions['time_limit']) && $setting->conditions['time_limit'] == 'same_day' ? 'selected' : '' }}>Mesmo dia</option>
                                                <option value="24h" {{ $setting && isset($setting->conditions['time_limit']) && $setting->conditions['time_limit'] == '24h' ? 'selected' : '' }}>24h antes</option>
                                            </select>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8 flex justify-end gap-4">
                <a href="{{ route('panel.alerts.index') }}" 
                   class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                    💾 Salvar Configurações
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('alert-settings-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const settings = [];
    
    // Processar dados do formulário
    const formDataObj = {};
    for (let [key, value] of formData.entries()) {
        const keys = key.split('[').map(k => k.replace(']', ''));
        if (keys.length === 3) {
            const [prefix, index, field] = keys;
            if (!formDataObj[index]) formDataObj[index] = {};
            formDataObj[index][field] = value;
        }
    }
    
    // Converter para array
    Object.values(formDataObj).forEach(setting => {
        settings.push({
            alert_type: setting.alert_type,
            enabled: setting.enabled === '1',
            channels: {
                email: formData.has(`settings[${Object.keys(formDataObj).find(i => formDataObj[i].alert_type === setting.alert_type)}][channels][email]`),
                sms: formData.has(`settings[${Object.keys(formDataObj).find(i => formDataObj[i].alert_type === setting.alert_type)}][channels][sms]`),
                push: formData.has(`settings[${Object.keys(formDataObj).find(i => formDataObj[i].alert_type === setting.alert_type)}][channels][push]`)
            },
            conditions: {
                reminder_time: setting.reminder_time || null,
                min_amount: setting.min_amount || null,
                time_limit: setting.time_limit || null
            }
        });
    });
    
    fetch('{{ route("panel.alerts.settings.update") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ settings })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Configurações salvas com sucesso!');
            window.location.href = '{{ route("panel.alerts.index") }}';
        } else {
            alert('Erro ao salvar configurações. Tente novamente.');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao salvar configurações. Tente novamente.');
    });
});
</script>

@endsection
