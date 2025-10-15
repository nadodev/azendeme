<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fatura {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #7c3aed;
            padding-bottom: 20px;
        }
        .company-info {
            margin-bottom: 20px;
        }
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .client-info, .invoice-details {
            width: 45%;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #7c3aed;
            margin-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }
        .event-details {
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .financial-summary {
            margin-top: 30px;
        }
        .financial-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .financial-row.total {
            font-weight: bold;
            font-size: 18px;
            color: #7c3aed;
            border-top: 2px solid #7c3aed;
            margin-top: 10px;
            padding-top: 15px;
        }
        .status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status.paga { background-color: #dcfce7; color: #166534; }
        .status.enviada { background-color: #dbeafe; color: #1e40af; }
        .status.vencida { background-color: #fecaca; color: #991b1b; }
        .status.rascunho { background-color: #f3f4f6; color: #374151; }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
        .payment-info {
            background-color: #fef3c7;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Cabeçalho -->
    <div class="header">
        <h1 style="color: #7c3aed; margin: 0; font-size: 28px;">FATURA</h1>
        <p style="margin: 5px 0; font-size: 18px; font-weight: bold;">{{ $invoice->invoice_number }}</p>
        <span class="status {{ $invoice->status }}">{{ ucfirst($invoice->status) }}</span>
    </div>

    <!-- Informações da Empresa -->
    <div class="company-info">
        <h2 style="color: #7c3aed; margin: 0 0 10px 0;">{{ $invoice->event->professional->business_name ?? $invoice->event->professional->name }}</h2>
        <p style="margin: 2px 0;">{{ $invoice->event->professional->email }}</p>
        @if($invoice->event->professional->phone)
            <p style="margin: 2px 0;">{{ $invoice->event->professional->phone }}</p>
        @endif
    </div>

    <!-- Informações da Fatura e Cliente -->
    <div class="invoice-info">
        <div class="client-info">
            <div class="section-title">Cliente</div>
            <p style="margin: 5px 0; font-weight: bold;">{{ $invoice->event->customer->name }}</p>
            <p style="margin: 5px 0;">{{ $invoice->event->customer->email }}</p>
            @if($invoice->event->customer->phone)
                <p style="margin: 5px 0;">{{ $invoice->event->customer->phone }}</p>
            @endif
        </div>
        
        <div class="invoice-details">
            <div class="section-title">Detalhes da Fatura</div>
            <p style="margin: 5px 0;"><strong>Data:</strong> {{ $invoice->invoice_date->format('d/m/Y') }}</p>
            <p style="margin: 5px 0;"><strong>Vencimento:</strong> {{ $invoice->due_date->format('d/m/Y') }}</p>
            @if($invoice->budget)
                <p style="margin: 5px 0;"><strong>Orçamento:</strong> {{ $invoice->budget->budget_number }}</p>
            @endif
        </div>
    </div>

    <!-- Detalhes do Evento -->
    <div class="event-details">
        <div class="section-title">Detalhes do Evento</div>
        <p style="margin: 5px 0;"><strong>Evento:</strong> {{ $invoice->event->title }}</p>
        <p style="margin: 5px 0;"><strong>Tipo:</strong> {{ ucfirst($invoice->event->type) }}</p>
        <p style="margin: 5px 0;"><strong>Data:</strong> {{ $invoice->event->event_date->format('d/m/Y') }}</p>
        <p style="margin: 5px 0;"><strong>Horário:</strong> {{ $invoice->event->start_time->format('H:i') }} - {{ $invoice->event->end_time->format('H:i') }}</p>
        <p style="margin: 5px 0;"><strong>Local:</strong> {{ $invoice->event->address }}, {{ $invoice->event->city }}/{{ $invoice->event->state }}</p>
    </div>

    <!-- Resumo Financeiro -->
    <div class="financial-summary">
        <div class="section-title">Resumo Financeiro</div>
        
        <div class="financial-row">
            <span>Subtotal:</span>
            <span>R$ {{ number_format($invoice->subtotal, 2, ',', '.') }}</span>
        </div>
        
        @if($invoice->discount_percentage > 0)
            <div class="financial-row">
                <span>Desconto ({{ $invoice->discount_percentage }}%):</span>
                <span style="color: #dc2626;">- R$ {{ number_format($invoice->discount_value, 2, ',', '.') }}</span>
            </div>
        @endif
        
        @if($invoice->tax_percentage > 0)
            <div class="financial-row">
                <span>Imposto ({{ $invoice->tax_percentage }}%):</span>
                <span>R$ {{ number_format($invoice->tax_value, 2, ',', '.') }}</span>
            </div>
        @endif
        
        <div class="financial-row total">
            <span>TOTAL:</span>
            <span>R$ {{ number_format($invoice->total, 2, ',', '.') }}</span>
        </div>
    </div>

    <!-- Status de Pagamento -->
    @if($invoice->total_paid > 0)
        <div style="margin-top: 20px;">
            <div class="section-title">Status de Pagamento</div>
            <div class="financial-row">
                <span>Valor Pago:</span>
                <span style="color: #059669;">R$ {{ number_format($invoice->total_paid, 2, ',', '.') }}</span>
            </div>
            <div class="financial-row">
                <span>Valor Restante:</span>
                <span style="color: {{ $invoice->remaining_amount > 0 ? '#dc2626' : '#059669' }};">R$ {{ number_format($invoice->remaining_amount, 2, ',', '.') }}</span>
            </div>
        </div>
    @endif

    <!-- Observações -->
    @if($invoice->notes)
        <div style="margin-top: 30px;">
            <div class="section-title">Observações</div>
            <p style="margin: 10px 0; line-height: 1.5;">{{ $invoice->notes }}</p>
        </div>
    @endif

    <!-- Termos de Pagamento -->
    @if($invoice->payment_terms)
        <div class="payment-info">
            <div class="section-title">Termos de Pagamento</div>
            <p style="margin: 10px 0; line-height: 1.5;">{{ $invoice->payment_terms }}</p>
        </div>
    @endif

    <!-- Rodapé -->
    <div class="footer">
        <p>Esta fatura foi gerada automaticamente pelo sistema.</p>
        <p>Para dúvidas, entre em contato conosco.</p>
    </div>
</body>
</html>
