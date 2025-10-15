<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Agendamento</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            max-width: 500px;
            width: 100%;
            background: white;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 0 auto 30px;
            animation: pulse 2s infinite;
        }
        
        .success .icon {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }
        
        .error .icon {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #1e293b;
        }
        
        .success h1 {
            color: #059669;
        }
        
        .error h1 {
            color: #dc2626;
        }
        
        p {
            font-size: 16px;
            color: #64748b;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .appointment-details {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
        }
        
        .appointment-details h3 {
            color: #1e293b;
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #475569;
        }
        
        .detail-value {
            color: #1e293b;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
            margin-top: 20px;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #94a3b8;
            font-size: 14px;
        }
        
        @media (max-width: 600px) {
            .container {
                padding: 30px 20px;
            }
            
            h1 {
                font-size: 24px;
            }
            
            .icon {
                width: 60px;
                height: 60px;
                font-size: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container {{ $success ? 'success' : 'error' }}">
        <div class="icon">
            @if($success)
                ✅
            @else
                ❌
            @endif
        </div>
        
        <h1>
            @if($success)
                Agendamento Confirmado!
            @else
                Erro na Confirmação
            @endif
        </h1>
        
        <p>{{ $message }}</p>
        
        @if($success && isset($appointment))
            <div class="appointment-details">
                <h3>📋 Detalhes do Agendamento</h3>
                
                <div class="detail-row">
                    <span class="detail-label">Profissional:</span>
                    <span class="detail-value">{{ $appointment->professional->business_name }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Serviço:</span>
                    <span class="detail-value">{{ $appointment->service->name ?? 'N/A' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Data:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($appointment->start_time)->format('d/m/Y') }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Horário:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</span>
                </div>
                
                @if($appointment->service && $appointment->service->price)
                    <div class="detail-row">
                        <span class="detail-label">Valor:</span>
                        <span class="detail-value">R$ {{ number_format($appointment->service->price, 2, ',', '.') }}</span>
                    </div>
                @endif
            </div>
            
            <a href="{{ url('/' . $appointment->professional->slug) }}" class="cta-button">
                🌐 Ver Site do Profissional
            </a>
        @endif
        
        <div class="footer">
            <p>Obrigado por usar o AzendaMe!</p>
        </div>
    </div>
</body>
</html>
