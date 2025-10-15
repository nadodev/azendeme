<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato {{ $contract->contract_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .contract-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .contract-number {
            font-size: 18px;
            color: #666;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            color: #555;
        }
        .info-value {
            margin-top: 2px;
        }
        .financial-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .amount {
            font-size: 18px;
            font-weight: bold;
            color: #2d3748;
        }
        .terms {
            background-color: #f7fafc;
            padding: 15px;
            border-left: 4px solid #4299e1;
            margin: 15px 0;
        }
        .signature-section {
            margin-top: 50px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
        }
        .signature-box {
            border-top: 1px solid #333;
            padding-top: 10px;
            text-align: center;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pendente {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-assinado {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-cancelado {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="contract-title">CONTRATO DE PRESTAÇÃO DE SERVIÇOS</div>
        <div class="contract-number">Contrato Nº {{ $contract->contract_number }}</div>
        <div style="margin-top: 10px;">
            <span class="status-badge status-{{ $contract->status }}">
                {{ ucfirst($contract->status) }}
            </span>
        </div>
    </div>

    <!-- Contract Information -->
    <div class="section">
        <div class="section-title">INFORMAÇÕES DO CONTRATO</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Data do Contrato:</div>
                <div class="info-value">{{ $contract->contract_date->format('d/m/Y') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Período de Vigência:</div>
                <div class="info-value">{{ $contract->start_date->format('d/m/Y') }} a {{ $contract->end_date->format('d/m/Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Event Information -->
    <div class="section">
        <div class="section-title">INFORMAÇÕES DO EVENTO</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Cliente:</div>
                <div class="info-value">{{ $contract->event->customer->name }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Tipo de Evento:</div>
                <div class="info-value">{{ ucfirst($contract->event->event_type) }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Data do Evento:</div>
                <div class="info-value">{{ $contract->event->event_date->format('d/m/Y') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Horário:</div>
                <div class="info-value">{{ $contract->event->start_time->format('H:i') }} às {{ $contract->event->end_time->format('H:i') }}</div>
            </div>
        </div>
    </div>

    <!-- Financial Information -->
    <div class="section">
        <div class="section-title">INFORMAÇÕES FINANCEIRAS</div>
        <div class="financial-info">
            <div class="info-item">
                <div class="info-label">Valor Total do Contrato:</div>
                <div class="info-value amount">R$ {{ number_format($contract->total_value, 2, ',', '.') }}</div>
            </div>
            @if($contract->advance_payment)
            <div class="info-item">
                <div class="info-label">Pagamento Antecipado:</div>
                <div class="info-value">R$ {{ number_format($contract->advance_payment, 2, ',', '.') }}</div>
            </div>
            @endif
            @if($contract->final_payment)
            <div class="info-item">
                <div class="info-label">Pagamento Final:</div>
                <div class="info-value">R$ {{ number_format($contract->final_payment, 2, ',', '.') }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Terms and Conditions -->
    <div class="section">
        <div class="section-title">TERMOS E CONDIÇÕES</div>
        <div class="terms">
            {{ $contract->terms_and_conditions }}
        </div>
    </div>

    <!-- Payment Terms -->
    <div class="section">
        <div class="section-title">TERMOS DE PAGAMENTO</div>
        <div class="terms">
            {{ $contract->payment_terms }}
        </div>
    </div>

    <!-- Cancellation Policy -->
    <div class="section">
        <div class="section-title">POLÍTICA DE CANCELAMENTO</div>
        <div class="terms">
            {{ $contract->cancellation_policy }}
        </div>
    </div>

    <!-- Liability Terms -->
    <div class="section">
        <div class="section-title">TERMOS DE RESPONSABILIDADE</div>
        <div class="terms">
            {{ $contract->liability_terms }}
        </div>
    </div>

    @if($contract->notes)
    <!-- Notes -->
    <div class="section">
        <div class="section-title">OBSERVAÇÕES</div>
        <div class="terms">
            {{ $contract->notes }}
        </div>
    </div>
    @endif

    <!-- Signatures -->
    <div class="signature-section">
        <div class="signature-box">
            <div style="margin-bottom: 50px;">
                <div>_________________________________</div>
                <div style="margin-top: 5px; font-size: 12px;">{{ $contract->event->customer->name }}</div>
                <div style="font-size: 12px; color: #666;">Cliente</div>
            </div>
        </div>
        <div class="signature-box">
            <div style="margin-bottom: 50px;">
                <div>_________________________________</div>
                <div style="margin-top: 5px; font-size: 12px;">{{ Auth::user()->professional->name ?? 'Profissional' }}</div>
                <div style="font-size: 12px; color: #666;">Prestador de Serviços</div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Este contrato foi gerado automaticamente em {{ now()->format('d/m/Y H:i') }}</p>
        <p>Contrato Nº {{ $contract->contract_number }} - Evento: {{ $contract->event->title }}</p>
    </div>
</body>
</html>
