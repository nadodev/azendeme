<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo #{{ $receipt->receipt_number }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            background: white;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #7c3aed;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #7c3aed;
            font-size: 28px;
            margin: 0;
            font-weight: bold;
        }
        .header p {
            color: #666;
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        .receipt-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .receipt-info div {
            flex: 1;
        }
        .receipt-info h3 {
            margin: 0 0 10px 0;
            color: #7c3aed;
            font-size: 16px;
        }
        .receipt-info p {
            margin: 5px 0;
            font-size: 14px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section h2 {
            color: #7c3aed;
            font-size: 18px;
            margin-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .info-item label {
            font-weight: bold;
            color: #374151;
            display: block;
            margin-bottom: 3px;
            font-size: 13px;
        }
        .info-item p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }
        .amount-section {
            background: #f0f9ff;
            border: 2px solid #0ea5e9;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 30px 0;
        }
        .amount-section h2 {
            color: #0c4a6e;
            margin: 0 0 10px 0;
            font-size: 18px;
        }
        .amount-value {
            font-size: 32px;
            font-weight: bold;
            color: #0c4a6e;
            margin: 0;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-rascunho { background: #f3f4f6; color: #374151; }
        .status-emitido { background: #dbeafe; color: #1e40af; }
        .status-pago { background: #dcfce7; color: #166534; }
        .status-cancelado { background: #fee2e2; color: #991b1b; }
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
            padding-top: 30px;
            border-top: 1px solid #e5e7eb;
        }
        .signature {
            text-align: center;
            width: 45%;
        }
        .signature-line {
            border-bottom: 1px solid #333;
            margin-bottom: 5px;
            height: 40px;
        }
        .signature p {
            margin: 0;
            font-size: 12px;
            color: #6b7280;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
        .notes {
            background: #f9fafb;
            border-left: 4px solid #7c3aed;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
        .notes h3 {
            margin: 0 0 10px 0;
            color: #7c3aed;
            font-size: 14px;
        }
        .notes p {
            margin: 0;
            color: #6b7280;
            font-size: 13px;
            line-height: 1.5;
        }
        @media print {
            body { margin: 0; padding: 15px; }
            .container { max-width: none; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>RECIBO</h1>
            <p>{{ $receipt->event->professional->business_name ?? 'Serviços de Eventos' }}</p>
            <p>{{ $receipt->event->professional->address ?? '' }}</p>
            <p>{{ $receipt->event->professional->city ?? '' }}/{{ $receipt->event->professional->state ?? '' }}</p>
        </div>

        <!-- Receipt Information -->
        <div class="receipt-info">
            <div>
                <h3>Dados do Recibo</h3>
                <p><strong>Número:</strong> #{{ $receipt->receipt_number }}</p>
                <p><strong>Data de Emissão:</strong> {{ \Carbon\Carbon::parse($receipt->receipt_date)->format('d/m/Y') }}</p>
                <p><strong>Status:</strong> <span class="status-badge status-{{ $receipt->status }}">{{ ucfirst($receipt->status) }}</span></p>
            </div>
            <div>
                <h3>Forma de Pagamento</h3>
                <p><strong>Método:</strong> {{ ucfirst(str_replace('_', ' ', $receipt->payment_method)) }}</p>
                @if($receipt->payment)
                    <p><strong>Data do Pagamento:</strong> {{ \Carbon\Carbon::parse($receipt->payment->payment_date)->format('d/m/Y') }}</p>
                @endif
            </div>
        </div>

        <!-- Event Information -->
        <div class="section">
            <h2>Informações do Evento</h2>
            <div class="info-grid">
                <div class="info-item">
                    <label>Título do Evento</label>
                    <p>{{ $receipt->event->title }}</p>
                </div>
                <div class="info-item">
                    <label>Tipo de Evento</label>
                    <p>{{ ucfirst($receipt->event->event_type) }}</p>
                </div>
                <div class="info-item">
                    <label>Data do Evento</label>
                    <p>{{ \Carbon\Carbon::parse($receipt->event->event_date)->format('d/m/Y') }}</p>
                </div>
                <div class="info-item">
                    <label>Local</label>
                    <p>{{ $receipt->event->address }}, {{ $receipt->event->city }}/{{ $receipt->event->state }}</p>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="section">
            <h2>Dados do Cliente</h2>
            <div class="info-grid">
                <div class="info-item">
                    <label>Nome</label>
                    <p>{{ $receipt->event->customer->name }}</p>
                </div>
                <div class="info-item">
                    <label>Email</label>
                    <p>{{ $receipt->event->customer->email }}</p>
                </div>
                <div class="info-item">
                    <label>Telefone</label>
                    <p>{{ $receipt->event->customer->phone ?? 'Não informado' }}</p>
                </div>
                <div class="info-item">
                    <label>CPF/CNPJ</label>
                    <p>{{ $receipt->event->customer->document ?? 'Não informado' }}</p>
                </div>
            </div>
        </div>

        <!-- Amount Section -->
        <div class="amount-section">
            <h2>Valor Recebido</h2>
            <p class="amount-value">R$ {{ number_format($receipt->amount, 2, ',', '.') }}</p>
        </div>

        <!-- Payment Information -->
        @if($receipt->payment)
        <div class="section">
            <h2>Informações do Pagamento</h2>
            <div class="info-grid">
                <div class="info-item">
                    <label>Valor Pago</label>
                    <p>R$ {{ number_format($receipt->payment->amount, 2, ',', '.') }}</p>
                </div>
                <div class="info-item">
                    <label>Método de Pagamento</label>
                    <p>{{ ucfirst(str_replace('_', ' ', $receipt->payment->payment_method)) }}</p>
                </div>
                <div class="info-item">
                    <label>Data do Pagamento</label>
                    <p>{{ \Carbon\Carbon::parse($receipt->payment->payment_date)->format('d/m/Y') }}</p>
                </div>
                <div class="info-item">
                    <label>Status</label>
                    <p><span class="status-badge status-{{ $receipt->payment->status }}">{{ ucfirst($receipt->payment->status) }}</span></p>
                </div>
            </div>
        </div>
        @endif

        <!-- Notes -->
        @if($receipt->notes)
        <div class="notes">
            <h3>Observações</h3>
            <p>{{ $receipt->notes }}</p>
        </div>
        @endif

        <!-- Signatures -->
        <div class="signatures">
            <div class="signature">
                <div class="signature-line"></div>
                <p>Assinatura do Prestador de Serviços</p>
            </div>
            <div class="signature">
                <div class="signature-line"></div>
                <p>Assinatura do Cliente</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Este recibo foi gerado automaticamente em {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
            <p>{{ $receipt->event->professional->business_name ?? 'Serviços de Eventos' }} - Todos os direitos reservados</p>
        </div>
    </div>
</body>
</html>
