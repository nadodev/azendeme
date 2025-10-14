<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo {{ $transaction->receipt_number }}</title>
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
        .receipt-number {
            font-size: 14px;
            font-weight: bold;
            color: #666;
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
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .info-label {
            display: table-cell;
            width: 30%;
            font-weight: bold;
            color: #555;
        }
        .info-value {
            display: table-cell;
            width: 70%;
        }
        .divider {
            border-top: 1px dashed #ddd;
            margin: 20px 0;
        }
        .amount-box {
            background: #8B5CF6;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            margin: 20px 0;
        }
        .amount-box .label {
            font-size: 12px;
            margin-bottom: 5px;
        }
        .amount-box .value {
            font-size: 32px;
            font-weight: bold;
        }
        .service-details {
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-left: 4px solid #8B5CF6;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        .signature-line {
            margin-top: 50px;
            border-top: 1px solid #333;
            width: 300px;
            margin-left: auto;
            margin-right: auto;
            padding-top: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>RECIBO DE PAGAMENTO</h1>
        <div class="receipt-number">Nº {{ $transaction->receipt_number }}</div>
    </div>

    <div class="company-info">
        <h2>{{ $transaction->professional->name ?? 'Estabelecimento' }}</h2>
        @if($transaction->professional->email)
            <div>E-mail: {{ $transaction->professional->email }}</div>
        @endif
        @if($transaction->professional->phone)
            <div>Telefone: {{ $transaction->professional->phone }}</div>
        @endif
    </div>

    <div class="info-row">
        <div class="info-label">Cliente:</div>
        <div class="info-value">{{ $transaction->customer->name ?? 'N/A' }}</div>
    </div>

    @if($transaction->customer && $transaction->customer->phone)
    <div class="info-row">
        <div class="info-label">Telefone:</div>
        <div class="info-value">{{ $transaction->customer->phone }}</div>
    </div>
    @endif

    <div class="info-row">
        <div class="info-label">Data:</div>
        <div class="info-value">{{ $transaction->transaction_date->format('d/m/Y H:i') }}</div>
    </div>

    <div class="info-row">
        <div class="info-label">Forma de Pagamento:</div>
        <div class="info-value">{{ $transaction->paymentMethod->name ?? 'N/A' }}</div>
    </div>

    @if($transaction->appointment && $transaction->appointment->service)
    <div class="divider"></div>
    <div class="service-details">
        <strong>Serviço Prestado:</strong><br>
        {{ $transaction->appointment->service->name }}<br>
        @if($transaction->appointment->service->description)
            <small>{{ $transaction->appointment->service->description }}</small>
        @endif
    </div>
    @endif

    @if($transaction->description)
    <div class="info-row">
        <div class="info-label">Descrição:</div>
        <div class="info-value">{{ $transaction->description }}</div>
    </div>
    @endif

    <div class="amount-box">
        <div class="label">VALOR RECEBIDO</div>
        <div class="value">R$ {{ number_format($transaction->amount, 2, ',', '.') }}</div>
    </div>

    @if($transaction->notes)
    <div class="info-row">
        <div class="info-label">Observações:</div>
        <div class="info-value">{{ $transaction->notes }}</div>
    </div>
    @endif

    <div class="signature-line">
        Assinatura do Responsável
    </div>

    <div class="footer">
        <p>Documento gerado em {{ now()->format('d/m/Y H:i') }}</p>
        <p>Este recibo comprova o pagamento realizado | AzendaMe</p>
    </div>
</body>
</html>

