<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Analytics</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #9333ea;
        }
        
        .header h1 {
            font-size: 24px;
            color: #9333ea;
            margin-bottom: 5px;
        }
        
        .header .subtitle {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .period {
            background: #f3f4f6;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }
        
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #9333ea;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .metrics-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        
        .metric-row {
            display: table-row;
        }
        
        .metric-cell {
            display: table-cell;
            padding: 12px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
        }
        
        .metric-cell:nth-child(odd) {
            background: #fff;
        }
        
        .metric-label {
            font-weight: bold;
            color: #6b7280;
            font-size: 11px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .metric-value {
            font-size: 20px;
            font-weight: bold;
            color: #111827;
        }
        
        .metric-value.positive {
            color: #10b981;
        }
        
        .metric-value.negative {
            color: #ef4444;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        table th {
            background: #9333ea;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }
        
        table td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        table tr:nth-child(even) {
            background: #f9fafb;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }
        
        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }
        
        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .summary-box {
            background: #f3f4f6;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .summary-item {
            margin-bottom: 8px;
        }
        
        .summary-item strong {
            color: #9333ea;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    
    <!-- Header -->
    <div class="header">
        <h1>📊 Relatório de Analytics</h1>
        <div class="subtitle">AzendaMe - Sistema de Gestão Profissional</div>
    </div>

    <!-- Período -->
    <div class="period">
        Período: {{ $startDate }} a {{ $endDate }}
    </div>

    <!-- Resumo Executivo -->
    <div class="section">
        <div class="section-title">📈 Resumo Executivo</div>
        <div class="summary-box">
            <div class="summary-item">
                <strong>Total de Agendamentos:</strong> {{ $data['appointments']['total'] }}
            </div>
            <div class="summary-item">
                <strong>Taxa de Conclusão:</strong> {{ $data['appointments']['completion_rate'] }}%
            </div>
            <div class="summary-item">
                <strong>Receita Total:</strong> R$ {{ number_format($data['revenue']['income'], 2, ',', '.') }}
            </div>
            <div class="summary-item">
                <strong>Lucro Líquido:</strong> R$ {{ number_format($data['revenue']['profit'], 2, ',', '.') }}
            </div>
            <div class="summary-item">
                <strong>Novos Clientes:</strong> {{ $data['customers']['new'] }}
            </div>
            <div class="summary-item">
                <strong>Clientes Recorrentes:</strong> {{ $data['customers']['returning'] }}
            </div>
        </div>
    </div>

    <!-- Métricas de Agendamentos -->
    <div class="section">
        <div class="section-title">📅 Agendamentos</div>
        
        <div class="metrics-grid">
            <div class="metric-row">
                <div class="metric-cell">
                    <div class="metric-label">Total</div>
                    <div class="metric-value">{{ $data['appointments']['total'] }}</div>
                </div>
                <div class="metric-cell">
                    <div class="metric-label">Concluídos</div>
                    <div class="metric-value positive">{{ $data['appointments']['completed'] }}</div>
                </div>
                <div class="metric-cell">
                    <div class="metric-label">Cancelados</div>
                    <div class="metric-value negative">{{ $data['appointments']['cancelled'] }}</div>
                </div>
            </div>
            <div class="metric-row">
                <div class="metric-cell">
                    <div class="metric-label">Pendentes</div>
                    <div class="metric-value">{{ $data['appointments']['pending'] }}</div>
                </div>
                <div class="metric-cell">
                    <div class="metric-label">No-Show</div>
                    <div class="metric-value negative">{{ $data['appointments']['no_show'] }}</div>
                </div>
                <div class="metric-cell">
                    <div class="metric-label">Taxa de Conclusão</div>
                    <div class="metric-value positive">{{ $data['appointments']['completion_rate'] }}%</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Métricas Financeiras -->
    <div class="section">
        <div class="section-title">💰 Financeiro</div>
        
        <div class="metrics-grid">
            <div class="metric-row">
                <div class="metric-cell">
                    <div class="metric-label">Receita</div>
                    <div class="metric-value positive">R$ {{ number_format($data['revenue']['income'], 2, ',', '.') }}</div>
                </div>
                <div class="metric-cell">
                    <div class="metric-label">Despesas</div>
                    <div class="metric-value negative">R$ {{ number_format($data['revenue']['expense'], 2, ',', '.') }}</div>
                </div>
                <div class="metric-cell">
                    <div class="metric-label">Lucro Líquido</div>
                    <div class="metric-value {{ $data['revenue']['profit'] >= 0 ? 'positive' : 'negative' }}">
                        R$ {{ number_format($data['revenue']['profit'], 2, ',', '.') }}
                    </div>
                </div>
            </div>
            <div class="metric-row">
                <div class="metric-cell">
                    <div class="metric-label">Total de Transações</div>
                    <div class="metric-value">{{ $data['revenue']['transactions_count'] }}</div>
                </div>
                <div class="metric-cell">
                    <div class="metric-label">Ticket Médio</div>
                    <div class="metric-value">R$ {{ number_format($data['revenue']['avg_transaction'], 2, ',', '.') }}</div>
                </div>
                <div class="metric-cell">
                    <div class="metric-label">Margem de Lucro</div>
                    <div class="metric-value {{ $data['revenue']['income'] > 0 ? 'positive' : '' }}">
                        {{ $data['revenue']['income'] > 0 ? number_format(($data['revenue']['profit'] / $data['revenue']['income']) * 100, 2) : 0 }}%
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Break -->
    <div class="page-break"></div>

    <!-- Serviços Mais Vendidos -->
    <div class="section">
        <div class="section-title">🏆 Top 10 Serviços Mais Vendidos</div>
        
        @if(count($data['services']) > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 10%;">#</th>
                        <th style="width: 50%;">Serviço</th>
                        <th style="width: 20%;">Quantidade</th>
                        <th style="width: 20%;">Receita</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['services'] as $index => $service)
                        <tr>
                            <td style="text-align: center; font-weight: bold;">{{ $index + 1 }}</td>
                            <td>{{ $service['service_name'] }}</td>
                            <td style="text-align: center;">{{ $service['count'] }}</td>
                            <td style="text-align: right; font-weight: bold;">R$ {{ number_format($service['revenue'], 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #6b7280; padding: 20px;">Nenhum serviço registrado neste período.</p>
        @endif
    </div>

    <!-- Análise de Clientes -->
    <div class="section">
        <div class="section-title">👥 Análise de Clientes</div>
        
        <div class="metrics-grid">
            <div class="metric-row">
                <div class="metric-cell">
                    <div class="metric-label">Novos Clientes</div>
                    <div class="metric-value positive">{{ $data['customers']['new'] }}</div>
                </div>
                <div class="metric-cell">
                    <div class="metric-label">Clientes Recorrentes</div>
                    <div class="metric-value positive">{{ $data['customers']['returning'] }}</div>
                </div>
                <div class="metric-cell">
                    <div class="metric-label">Total Ativos</div>
                    <div class="metric-value">{{ $data['customers']['total_active'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Análise de Horários -->
    <div class="section">
        <div class="section-title">⏰ Horários Mais Populares</div>
        
        @if(count($data['schedule']['popular_times']) > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 50%;">Horário</th>
                        <th style="width: 50%;">Total de Agendamentos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['schedule']['popular_times'] as $time)
                        <tr>
                            <td>{{ $time['hour'] }}</td>
                            <td style="text-align: center; font-weight: bold;">{{ $time['count'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #6b7280; padding: 20px;">Nenhum dado disponível para este período.</p>
        @endif
    </div>

    <!-- Análise de Dias da Semana -->
    <div class="section">
        <div class="section-title">📆 Dias da Semana Mais Ocupados</div>
        
        @if(count($data['schedule']['popular_days']) > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 50%;">Dia da Semana</th>
                        <th style="width: 50%;">Total de Agendamentos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['schedule']['popular_days'] as $day)
                        <tr>
                            <td>{{ $day['day'] }}</td>
                            <td style="text-align: center; font-weight: bold;">{{ $day['count'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #6b7280; padding: 20px;">Nenhum dado disponível para este período.</p>
        @endif
    </div>

    <!-- Insights e Recomendações -->
    <div class="section">
        <div class="section-title">💡 Insights e Recomendações</div>
        
        <div style="background: #f9fafb; padding: 15px; border-left: 4px solid #9333ea; margin-bottom: 10px;">
            <strong>Taxa de No-Show:</strong> 
            @if($data['appointments']['no_show_rate'] > 10)
                <span class="badge badge-danger">Alto ({{ $data['appointments']['no_show_rate'] }}%)</span>
                <p style="margin-top: 5px; font-size: 11px;">Recomenda-se implementar lembretes automáticos ou política de confirmação.</p>
            @elseif($data['appointments']['no_show_rate'] > 5)
                <span class="badge badge-warning">Moderado ({{ $data['appointments']['no_show_rate'] }}%)</span>
                <p style="margin-top: 5px; font-size: 11px;">Considere enviar lembretes 24h antes dos agendamentos.</p>
            @else
                <span class="badge badge-success">Excelente ({{ $data['appointments']['no_show_rate'] }}%)</span>
                <p style="margin-top: 5px; font-size: 11px;">Sua taxa de no-show está dentro do esperado!</p>
            @endif
        </div>

        <div style="background: #f9fafb; padding: 15px; border-left: 4px solid #9333ea; margin-bottom: 10px;">
            <strong>Taxa de Conclusão:</strong> 
            @if($data['appointments']['completion_rate'] >= 80)
                <span class="badge badge-success">Excelente ({{ $data['appointments']['completion_rate'] }}%)</span>
                <p style="margin-top: 5px; font-size: 11px;">Parabéns! Sua taxa de conclusão está ótima!</p>
            @elseif($data['appointments']['completion_rate'] >= 60)
                <span class="badge badge-warning">Bom ({{ $data['appointments']['completion_rate'] }}%)</span>
                <p style="margin-top: 5px; font-size: 11px;">Considere analisar os motivos de não conclusão.</p>
            @else
                <span class="badge badge-danger">Precisa Melhorar ({{ $data['appointments']['completion_rate'] }}%)</span>
                <p style="margin-top: 5px; font-size: 11px;">Recomenda-se revisar processos e reduzir cancelamentos.</p>
            @endif
        </div>

        <div style="background: #f9fafb; padding: 15px; border-left: 4px solid #9333ea;">
            <strong>Clientes Recorrentes:</strong> 
            @if($data['customers']['total_active'] > 0 && ($data['customers']['returning'] / $data['customers']['total_active']) >= 0.5)
                <span class="badge badge-success">Ótima Retenção</span>
                <p style="margin-top: 5px; font-size: 11px;">Mais de 50% dos seus clientes estão retornando!</p>
            @else
                <span class="badge badge-warning">Oportunidade de Melhoria</span>
                <p style="margin-top: 5px; font-size: 11px;">Considere implementar um programa de fidelidade para aumentar o retorno.</p>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Relatório gerado em {{ date('d/m/Y H:i') }}</p>
        <p>AzendaMe - Sistema de Gestão Profissional</p>
        <p>www.AzendaMe</p>
    </div>

</body>
</html>

