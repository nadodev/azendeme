<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fechamento de Caixa - {{ $period->period_start->format('d/m/Y') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #8B5CF6;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #8B5CF6;
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header .subtitle {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }
        .period-type {
            display: inline-block;
            background: #8B5CF6;
            color: white;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 11px;
            margin-top: 10px;
        }
        .company-info {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .company-info h2 {
            font-size: 16px;
            color: #333;
            margin-bottom: 5px;
        }
        .summary-grid {
            display: table;
            width: 100%;
            margin: 20px 0;
        }
        .summary-item {
            display: table-row;
        }
        .summary-label {
            display: table-cell;
            padding: 10px;
            font-weight: bold;
            color: #555;
            width: 60%;
            border-bottom: 1px solid #eee;
        }
        .summary-value {
            display: table-cell;
            padding: 10px;
            text-align: right;
            font-weight: bold;
            border-bottom: 1px solid #eee;
        }
        .summary-value.positive {
            color: #10b981;
        }
        .summary-value.negative {
            color: #ef4444;
        }
        .summary-value.neutral {
            color: #6b7280;
        }
        .total-row {
            background: #f8f9fa;
            font-size: 16px;
        }
        .total-row .summary-label,
        .total-row .summary-value {
            border-bottom: 2px solid #8B5CF6;
            padding: 15px 10px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #8B5CF6;
            margin: 30px 0 15px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #8B5CF6;
        }
        .info-box {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        .signature-section {
            margin-top: 50px;
            display: table;
            width: 100%;
        }
        .signature-box {
            display: table-cell;
            width: 48%;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>RELATÓRIO DE FECHAMENTO DE CAIXA</h1>
        <div class="subtitle">
            Período: {{ $period->period_start->format('d/m/Y') }} a {{ $period->period_end->format('d/m/Y') }}
        </div>
        <div class="period-type">
            {{ $period->period_type === 'daily' ? 'DIÁRIO' : ($period->period_type === 'weekly' ? 'SEMANAL' : 'MENSAL') }}
        </div>
    </div>

    <div class="company-info">
        <h2>{{ $period->professional->name ?? 'Estabelecimento' }}</h2>
        @if($period->professional->email)
            <div>E-mail: {{ $period->professional->email }}</div>
        @endif
        @if($period->professional->phone)
            <div>Telefone: {{ $period->professional->phone }}</div>
        @endif
    </div>

    <div class="section-title">Resumo Financeiro</div>

    <div class="summary-grid">
        <div class="summary-item">
            <div class="summary-label">Saldo Inicial</div>
            <div class="summary-value neutral">R$ {{ number_format($period->opening_balance, 2, ',', '.') }}</div>
        </div>
        
        <div class="summary-item">
            <div class="summary-label">Total de Entradas</div>
            <div class="summary-value positive">R$ {{ number_format($period->total_income, 2, ',', '.') }}</div>
        </div>
        
        <div class="summary-item">
            <div class="summary-label">Total de Saídas</div>
            <div class="summary-value negative">(-) R$ {{ number_format($period->total_expense, 2, ',', '.') }}</div>
        </div>
        
        <div class="summary-item total-row">
            <div class="summary-label">SALDO FINAL</div>
            <div class="summary-value {{ $period->closing_balance >= 0 ? 'positive' : 'negative' }}">
                R$ {{ number_format($period->closing_balance, 2, ',', '.') }}
            </div>
        </div>
    </div>

    <div class="info-box">
        <strong>Informações Adicionais:</strong><br>
        Total de Transações: {{ $period->total_transactions }}<br>
        Total de Agendamentos: {{ $period->total_appointments }}<br>
        Fechado em: {{ $period->closed_at ? $period->closed_at->format('d/m/Y H:i') : 'Em aberto' }}<br>
        @if($period->closedBy)
            Responsável: {{ $period->closedBy->name }}
        @endif
    </div>

    @if($period->notes)
    <div class="section-title">Observações</div>
    <div style="padding: 15px; background: #f8f9fa; border-radius: 5px;">
        {{ $period->notes }}
    </div>
    @endif

    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line">
                Responsável pelo Fechamento
            </div>
        </div>
        <div class="signature-box">
            <div class="signature-line">
                Gerente/Proprietário
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Relatório gerado em {{ now()->format('d/m/Y H:i') }}</p>
        <p>Sistema de Gestão AzendaMe | Este documento é válido como comprovante de fechamento de caixa</p>
    </div>
</body>
</html>

