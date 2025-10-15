<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembrete de Agendamento - {{ $appointment->professional->business_name }}</title>
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
            background-color: #f8fafc;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .header-content {
            position: relative;
            z-index: 1;
        }
        
        .header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .header p {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 300;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .reminder-icon {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .reminder-icon .icon {
            display: inline-block;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: white;
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .appointment-card {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            position: relative;
            overflow: hidden;
        }
        
        .appointment-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #1d4ed8);
        }
        
        .appointment-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .detail-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            text-align: center;
        }
        
        .detail-label {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        
        .detail-value {
            font-size: 16px;
            color: #1e293b;
            font-weight: 600;
        }
        
        .service-info {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        
        .service-name {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 10px;
        }
        
        .service-price {
            font-size: 18px;
            color: #059669;
            font-weight: 600;
        }
        
        .confirmation-section {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border: 2px solid #f59e0b;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
        }
        
        .confirmation-section h3 {
            color: #92400e;
            margin-bottom: 15px;
            font-size: 20px;
        }
        
        .confirmation-section p {
            color: #b45309;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .confirm-button {
            display: inline-block;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
            transition: all 0.3s ease;
        }
        
        .confirm-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.6);
        }
        
        .cta-section {
            text-align: center;
            margin: 30px 0;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
            transition: all 0.3s ease;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.6);
        }
        
        .footer {
            background: #f8fafc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        
        .footer h3 {
            color: #1e293b;
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .contact-info {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 20px 0;
            flex-wrap: wrap;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            font-size: 14px;
        }
        
        .disclaimer {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 20px;
            line-height: 1.5;
        }
        
        .business-info {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }
        
        .business-name {
            font-size: 22px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 10px;
        }
        
        .business-description {
            color: #64748b;
            font-size: 14px;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            
            .header, .content, .footer {
                padding: 25px 20px;
            }
            
            .appointment-details {
                grid-template-columns: 1fr;
            }
            
            .contact-info {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <h1>📅 Lembrete de Agendamento</h1>
                <p>Seu agendamento é amanhã!</p>
            </div>
        </div>
        
        <!-- Content -->
        <div class="content">
            <!-- Reminder Icon -->
            <div class="reminder-icon">
                <div class="icon">⏰</div>
            </div>
            
            <!-- Greeting -->
            <h2 style="text-align: center; color: #1e293b; margin-bottom: 20px; font-size: 24px;">
                Olá! Seu agendamento é amanhã
            </h2>
            
            <p style="text-align: center; color: #64748b; font-size: 16px; margin-bottom: 30px;">
                Este é um lembrete amigável sobre seu agendamento. Confirme sua presença clicando no botão abaixo.
            </p>
            
            <!-- Business Info -->
            <div class="business-info">
                <div class="business-name">{{ $appointment->professional->business_name }}</div>
                <div class="business-description">{{ $appointment->professional->name }}</div>
            </div>
            
            <!-- Appointment Details -->
            <div class="appointment-card">
                <h3 style="color: #1e293b; margin-bottom: 20px; font-size: 20px; text-align: center;">
                    📋 Detalhes do Agendamento
                </h3>
                
                <div class="appointment-details">
                    <div class="detail-item">
                        <div class="detail-label">Data</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($appointment->start_time)->format('d/m/Y') }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">Horário</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">Duração</div>
                        <div class="detail-value">{{ $appointment->service->duration ?? 60 }} min</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">Status</div>
                        <div class="detail-value" style="color: #059669;">Confirmado</div>
                    </div>
                </div>
            </div>
            
            <!-- Service Info -->
            <div class="service-info">
                <div class="service-name">{{ $appointment->service->name ?? 'Serviço' }}</div>
                @if($appointment->service && $appointment->service->price)
                    <div class="service-price">R$ {{ number_format($appointment->service->price, 2, ',', '.') }}</div>
                @endif
            </div>
            
            <!-- Confirmation Section -->
            <div class="confirmation-section">
                <h3>✅ Confirmar Presença</h3>
                <p>Clique no botão abaixo para confirmar que você comparecerá ao agendamento:</p>
                <a href="{{ $confirmUrl }}" class="confirm-button">
                    🎯 Confirmar Presença
                </a>
            </div>
            
            <!-- CTA Section -->
            <div class="cta-section">
                <a href="{{ url('/' . $appointment->professional->slug) }}" class="cta-button">
                    🌐 Ver Site do Profissional
                </a>
            </div>
            
            <!-- Additional Info -->
            <div style="background: #f1f5f9; border-radius: 8px; padding: 20px; margin: 25px 0;">
                <h3 style="color: #1e293b; margin-bottom: 15px; font-size: 18px;">💡 Informações Importantes</h3>
                <ul style="color: #475569; line-height: 1.8;">
                    <li>• Chegue com 10 minutos de antecedência</li>
                    <li>• Em caso de cancelamento, entre em contato com antecedência</li>
                    <li>• Traga um documento de identificação</li>
                    <li>• Em caso de dúvidas, entre em contato conosco</li>
                </ul>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <h3>{{ $appointment->professional->business_name }}</h3>
            <p style="color: #64748b; margin-bottom: 20px;">
                Agradecemos pela preferência!
            </p>
            
            <div class="contact-info">
                <div class="contact-item">
                    <span>📧</span>
                    <span>{{ $appointment->professional->email }}</span>
                </div>
                <div class="contact-item">
                    <span>📱</span>
                    <span>{{ $appointment->professional->phone ?? 'N/A' }}</span>
                </div>
            </div>
            
            <div class="disclaimer">
                <p>
                    Este é um lembrete automático. Se você não solicitou este agendamento, 
                    entre em contato conosco imediatamente.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
