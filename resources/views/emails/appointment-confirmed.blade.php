<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento Confirmado</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 40px 20px;
            min-height: 100vh;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            position: relative;
        }
        
        .email-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #10b981, #059669, #047857);
        }
        
        .header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shimmer 3s ease-in-out infinite;
        }
        
        @keyframes shimmer {
            0%, 100% { transform: translateX(-100%) translateY(-100%) rotate(30deg); }
            50% { transform: translateX(100%) translateY(100%) rotate(30deg); }
        }
        
        .header-content {
            position: relative;
            z-index: 2;
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 36px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        .header p {
            margin: 10px 0 0;
            font-size: 16px;
            opacity: 0.9;
            font-weight: 400;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 30px;
            font-weight: 500;
        }
        
        .info-card {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
            border: 1px solid #bbf7d0;
            border-radius: 16px;
            padding: 25px;
            margin: 25px 0;
            position: relative;
            overflow: hidden;
        }
        
        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #10b981, #059669);
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 15px 0;
            padding: 8px 0;
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
        }
        
        .info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .info-label {
            font-weight: 600;
            color: #065f46;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-value {
            color: #1f2937;
            font-weight: 500;
            font-size: 15px;
        }
        
        .price-highlight {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }
        
        .instructions {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
            border-left: 4px solid #3b82f6;
        }
        
        .instructions h3 {
            color: #1e40af;
            font-size: 16px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .instructions p {
            color: #475569;
            font-size: 14px;
            line-height: 1.6;
            margin: 5px 0;
        }
        
        .reschedule-section {
            background: #f8fafc;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
            border-left: 4px solid #3b82f6;
        }
        
        .reschedule-section h3 {
            color: #1e40af;
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .reschedule-section p {
            color: #475569;
            font-size: 15px;
            line-height: 1.6;
            margin: 10px 0;
        }
        
        .reschedule-button {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            padding: 15px 35px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            margin-top: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
            font-size: 16px;
        }
        
        .reschedule-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }
        
        .footer {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        
        .business-info {
            margin-bottom: 20px;
        }
        
        .business-name {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 10px;
        }
        
        .contact-info {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 15px 0;
            flex-wrap: wrap;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
        }
        
        .disclaimer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.5;
        }
        
        @media (max-width: 600px) {
            body {
                padding: 20px 10px;
            }
            
            .header, .content, .footer {
                padding: 25px 20px;
            }
            
            .contact-info {
                flex-direction: column;
                gap: 10px;
            }
            
            .info-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="header-content">
                <div class="success-icon">✅</div>
                <h1>Agendamento Confirmado!</h1>
                <p>Seu agendamento foi confirmado com sucesso</p>
            </div>
        </div>
        
        <div class="content">
            <div class="greeting">
                Olá <strong>{{ $customer->name }}</strong>,<br>
                Estamos muito felizes em confirmar seu agendamento!
            </div>
            
            <div class="info-card">
                <div class="info-item">
                    <span class="info-label">Serviço</span>
                    <span class="info-value">{{ $service->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Data</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($appointment->start_time)->format('d/m/Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Horário</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Duração</span>
                    <span class="info-value">{{ $service->duration }} minutos</span>
                </div>
                @if($service->price)
                <div class="info-item">
                    <span class="info-label">Valor</span>
                    <span class="info-value">
                        <span class="price-highlight">R$ {{ number_format($service->price, 2, ',', '.') }}</span>
                    </span>
                </div>
                @endif
            </div>

            <div class="instructions">
                <h3>📋 Instruções Importantes</h3>
                <p>• Chegue com <strong>10 minutos de antecedência</strong></p>
                <p>• Em caso de imprevistos, entre em contato conosco o quanto antes</p>
                <p>• Traga um documento de identificação</p>
            </div>

            <div class="reschedule-section">
                <h3>🔄 Precisa de Outro Serviço?</h3>
                <p>Que tal agendar outro serviço enquanto está aqui?</p>
                <p>Clique no botão abaixo para ver nossa agenda disponível!</p>
                <a href="https://azendeme.com.br/{{ $slug }}#agendar" class="reschedule-button">
                    📅 Agendar Outro Serviço
                </a>
            </div>
        </div>
        
        <div class="footer">
            <div class="business-info">
                <div class="business-name">{{ $professional->business_name ?? $professional->name }}</div>
                <div class="contact-info">
                    @if($professional->phone)
                    <div class="contact-item">
                        <span>📞</span>
                        <span>{{ $professional->phone }}</span>
                    </div>
                    @endif
                    @if($professional->email)
                    <div class="contact-item">
                        <span>📧</span>
                        <span>{{ $professional->email }}</span>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="disclaimer">
                Este é um e-mail automático. Por favor, não responda diretamente a esta mensagem.<br>
                Para dúvidas ou alterações, entre em contato através dos canais oficiais.
            </div>
        </div>
    </div>
</body>
</html>

