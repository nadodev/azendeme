<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordem de Serviço - {{ $serviceOrder->order_number }}</title>
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
            border-bottom: 2px solid #8B5CF6;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #8B5CF6;
            font-size: 24px;
            margin: 0;
        }
        
        .header h2 {
            color: #666;
            font-size: 18px;
            margin: 5px 0 0 0;
        }
        
        .info-section {
            margin-bottom: 25px;
        }
        
        .info-section h3 {
            color: #8B5CF6;
            font-size: 14px;
            margin-bottom: 10px;
            border-bottom: 1px solid #E5E7EB;
            padding-bottom: 5px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            font-weight: bold;
            width: 30%;
            padding: 5px 0;
            vertical-align: top;
        }
        
        .info-value {
            display: table-cell;
            padding: 5px 0;
            vertical-align: top;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-pendente {
            background-color: #FEF3C7;
            color: #92400E;
        }
        
        .status-em_andamento {
            background-color: #DBEAFE;
            color: #1E40AF;
        }
        
        .status-concluida {
            background-color: #D1FAE5;
            color: #065F46;
        }
        
        .status-cancelada {
            background-color: #FEE2E2;
            color: #991B1B;
        }
        
        .equipment-list {
            background-color: #F9FAFB;
            padding: 15px;
            border-radius: 6px;
            margin: 10px 0;
        }
        
        .employee-assignments {
            background-color: #F0F9FF;
            padding: 15px;
            border-radius: 6px;
            margin: 10px 0;
        }
        
        .instructions {
            background-color: #FEFCE8;
            padding: 15px;
            border-radius: 6px;
            margin: 10px 0;
        }
        
        .requirements {
            background-color: #FDF2F8;
            padding: 15px;
            border-radius: 6px;
            margin: 10px 0;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #E5E7EB;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        
        .signature-section {
            margin-top: 30px;
            display: table;
            width: 100%;
        }
        
        .signature-box {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 20px;
        }
        
        .signature-line {
            border-bottom: 1px solid #333;
            margin-bottom: 5px;
            height: 40px;
        }
        
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <!-- Cabeçalho -->
    <div class="header">
        <h1>ORDEM DE SERVIÇO</h1>
        <h2>{{ $serviceOrder->order_number }}</h2>
    </div>

    <!-- Informações da Ordem de Serviço -->
    <div class="info-section">
        <h3>Informações da Ordem de Serviço</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Número da OS:</div>
                <div class="info-value">{{ $serviceOrder->order_number }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Data de Criação:</div>
                <div class="info-value">{{ $serviceOrder->order_date->format('d/m/Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Status:</div>
                <div class="info-value">
                    <span class="status-badge status-{{ $serviceOrder->status }}">
                        {{ ucfirst($serviceOrder->status) }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Valor Total:</div>
                <div class="info-value">R$ {{ number_format($serviceOrder->total_value, 2, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Informações do Evento -->
    <div class="info-section">
        <h3>Informações do Evento</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Cliente:</div>
                <div class="info-value">{{ $serviceOrder->event->customer->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Evento:</div>
                <div class="info-value">{{ $serviceOrder->event->title }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tipo:</div>
                <div class="info-value">{{ ucfirst($serviceOrder->event->type) }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Data do Evento:</div>
                <div class="info-value">{{ $serviceOrder->scheduled_date->format('d/m/Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Horário:</div>
                <div class="info-value">
                    {{ \Carbon\Carbon::parse($serviceOrder->scheduled_start_time)->format('H:i') }} - 
                    {{ \Carbon\Carbon::parse($serviceOrder->scheduled_end_time)->format('H:i') }}
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Local:</div>
                <div class="info-value">{{ $serviceOrder->event->address }}, {{ $serviceOrder->event->city }}/{{ $serviceOrder->event->state }}</div>
            </div>
        </div>
    </div>

    <!-- Descrição -->
    @if($serviceOrder->description)
        <div class="info-section">
            <h3>Descrição do Serviço</h3>
            <p>{{ $serviceOrder->description }}</p>
        </div>
    @endif

    <!-- Lista de Equipamentos -->
    @if($serviceOrder->equipment_list)
        <div class="info-section">
            <h3>Equipamentos</h3>
            <div class="equipment-list">
                {{ $serviceOrder->equipment_list }}
            </div>
        </div>
    @endif

    <!-- Atribuições de Funcionários -->
    @if($serviceOrder->employee_assignments)
        <div class="info-section">
            <h3>Atribuições de Funcionários</h3>
            <div class="employee-assignments">
                {{ $serviceOrder->employee_assignments }}
            </div>
        </div>
    @endif

    <!-- Instruções de Montagem -->
    @if($serviceOrder->setup_instructions)
        <div class="info-section">
            <h3>Instruções de Montagem</h3>
            <div class="instructions">
                {{ $serviceOrder->setup_instructions }}
            </div>
        </div>
    @endif

    <!-- Requisitos Especiais -->
    @if($serviceOrder->special_requirements)
        <div class="info-section">
            <h3>Requisitos Especiais</h3>
            <div class="requirements">
                {{ $serviceOrder->special_requirements }}
            </div>
        </div>
    @endif

    <!-- Notas de Conclusão -->
    @if($serviceOrder->completion_notes)
        <div class="info-section">
            <h3>Notas de Conclusão</h3>
            <p>{{ $serviceOrder->completion_notes }}</p>
        </div>
    @endif

    <!-- Problemas Encontrados -->
    @if($serviceOrder->issues_encountered)
        <div class="info-section">
            <h3>Problemas Encontrados</h3>
            <p>{{ $serviceOrder->issues_encountered }}</p>
        </div>
    @endif

    <!-- Assinaturas -->
    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line"></div>
            <p><strong>Responsável Técnico</strong></p>
            <p>Data: ___/___/_______</p>
        </div>
        <div class="signature-box">
            <div class="signature-line"></div>
            <p><strong>Cliente</strong></p>
            <p>Data: ___/___/_______</p>
        </div>
    </div>

    <!-- Rodapé -->
    <div class="footer">
        <p>Este documento foi gerado automaticamente em {{ now()->format('d/m/Y H:i') }}</p>
        <p>Para dúvidas, entre em contato conosco.</p>
    </div>
</body>
</html>
