<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orçamento {{ $budget->budget_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #6B46C1;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #6B46C1;
            font-size: 24px;
            margin: 0;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .budget-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .budget-info .left, .budget-info .right {
            width: 48%;
        }
        .budget-info h3 {
            color: #6B46C1;
            font-size: 14px;
            margin: 0 0 10px 0;
            border-bottom: 1px solid #E5E7EB;
            padding-bottom: 5px;
        }
        .budget-info p {
            margin: 3px 0;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th {
            background-color: #6B46C1;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 11px;
        }
        .items-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #E5E7EB;
        }
        .items-table tr:nth-child(even) {
            background-color: #F9FAFB;
        }
        .total-section {
            margin-top: 20px;
            text-align: right;
        }
        .total-line {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid #E5E7EB;
        }
        .total-line.final {
            font-weight: bold;
            font-size: 14px;
            border-top: 2px solid #6B46C1;
            border-bottom: 2px solid #6B46C1;
            margin-top: 10px;
            padding: 10px 0;
        }
        .notes {
            margin-top: 30px;
            padding: 15px;
            background-color: #F9FAFB;
            border-left: 4px solid #6B46C1;
        }
        .notes h3 {
            color: #6B46C1;
            margin: 0 0 10px 0;
            font-size: 14px;
        }
        .terms {
            margin-top: 20px;
            padding: 15px;
            background-color: #FEF3C7;
            border-left: 4px solid #F59E0B;
        }
        .terms h3 {
            color: #92400E;
            margin: 0 0 10px 0;
            font-size: 14px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #E5E7EB;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ORÇAMENTO</h1>
        <p><strong>{{ $budget->budget_number }}</strong></p>
        <p>Válido até: {{ $budget->valid_until->format('d/m/Y') }}</p>
    </div>

    <div class="budget-info">
        <div class="left">
            <h3>DADOS DO EVENTO</h3>
            <p><strong>Evento:</strong> {{ $budget->event->title }}</p>
            <p><strong>Tipo:</strong> {{ ucfirst($budget->event->type) }}</p>
            <p><strong>Data:</strong> {{ $budget->event->event_date->format('d/m/Y') }}</p>
            <p><strong>Horário:</strong> {{ $budget->event->start_time }} - {{ $budget->event->end_time }}</p>
            <p><strong>Local:</strong> {{ $budget->event->address }}, {{ $budget->event->city }}/{{ $budget->event->state }}</p>
        </div>
        <div class="right">
            <h3>DADOS DO CLIENTE</h3>
            <p><strong>Nome:</strong> {{ $budget->event->customer->name }}</p>
            @if($budget->event->customer->phone)
                <p><strong>Telefone:</strong> {{ $budget->event->customer->phone }}</p>
            @endif
            @if($budget->event->customer->email)
                <p><strong>Email:</strong> {{ $budget->event->customer->email }}</p>
            @endif
        </div>
    </div>

    @if($budget->event->services->count() > 0)
        <h3 style="color: #6B46C1; font-size: 14px; margin: 20px 0 10px 0;">EQUIPAMENTOS</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Equipamento</th>
                    <th>Horas</th>
                    <th>Valor/Hora</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($budget->event->services as $service)
                    <tr>
                        <td>{{ $service->equipment->name }}</td>
                        <td>{{ $service->hours }}h</td>
                        <td>R$ {{ number_format($service->hourly_rate, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($service->total_value, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if($budget->event->employees->count() > 0)
        <h3 style="color: #6B46C1; font-size: 14px; margin: 20px 0 10px 0;">FUNCIONÁRIOS</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Função</th>
                    <th>Horas</th>
                    <th>Valor/Hora</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($budget->event->employees as $employee)
                    <tr>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->role }}</td>
                        <td>{{ $employee->hours }}h</td>
                        <td>R$ {{ number_format($employee->hourly_rate, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($employee->total_value, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="total-section">
        <div class="total-line">
            <span>Subtotal:</span>
            <span>R$ {{ number_format($budget->subtotal, 2, ',', '.') }}</span>
        </div>
        @if($budget->discount_value > 0)
            <div class="total-line">
                <span>Desconto ({{ $budget->discount_percentage }}%):</span>
                <span>-R$ {{ number_format($budget->discount_value, 2, ',', '.') }}</span>
            </div>
        @endif
        <div class="total-line final">
            <span>TOTAL:</span>
            <span>R$ {{ number_format($budget->total, 2, ',', '.') }}</span>
        </div>
    </div>

    @if($budget->notes)
        <div class="notes">
            <h3>OBSERVAÇÕES</h3>
            <p>{{ $budget->notes }}</p>
        </div>
    @endif

    @if($budget->terms)
        <div class="terms">
            <h3>TERMOS E CONDIÇÕES</h3>
            <p style="white-space: pre-line;">{{ $budget->terms }}</p>
        </div>
    @endif

    <div class="footer">
        <p>Orçamento gerado em {{ $budget->created_at->format('d/m/Y H:i') }}</p>
        <p>Este orçamento é válido até {{ $budget->valid_until->format('d/m/Y') }}</p>
    </div>
</body>
</html>
