<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento Cancelado</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .cancel-icon {
            text-align: center;
            font-size: 48px;
            margin-bottom: 20px;
        }
        .info-box {
            background-color: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 15px;
            margin: 20px 0;
        }
        .info-item {
            margin: 10px 0;
        }
        .info-label {
            font-weight: 600;
            color: #374151;
        }
        .info-value {
            color: #6b7280;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #6b7280;
        }
        .button {
            display: inline-block;
            background-color: #6366f1;
            color: #ffffff;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Agendamento Cancelado</h1>
        </div>
        <div class="content">
            <div class="cancel-icon">⚠️</div>
            <p>Olá <strong>{{ $customer->name }}</strong>,</p>
            <p>Informamos que seu agendamento foi cancelado.</p>
            
            <div class="info-box">
                <div class="info-item">
                    <span class="info-label">Serviço:</span>
                    <span class="info-value">{{ $service->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Data:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($appointment->start_time)->format('d/m/Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Horário:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</span>
                </div>
            </div>

            <p>Se você deseja reagendar, fique à vontade para entrar em contato conosco.</p>
            <p>Estamos à disposição para atendê-lo em outro horário!</p>
        </div>
        <div class="footer">
            <p><strong>{{ $professional->business_name ?? $professional->name }}</strong></p>
            @if($professional->phone)
            <p>📞 {{ $professional->phone }}</p>
            @endif
            @if($professional->email)
            <p>📧 {{ $professional->email }}</p>
            @endif
            <p style="margin-top: 20px; font-size: 12px; color: #9ca3af;">
                Este é um e-mail automático, por favor não responda.
            </p>
        </div>
    </div>
</body>
</html>

