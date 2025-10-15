<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plano Atualizado - AzendaMe</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        
        .success-icon {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .success-icon .icon {
            display: inline-block;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: white;
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .plan-card {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .plan-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }
        
        .plan-name {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .plan-price {
            font-size: 32px;
            font-weight: 800;
            color: #059669;
            margin-bottom: 15px;
        }
        
        .plan-features {
            list-style: none;
            margin: 20px 0;
        }
        
        .plan-features li {
            padding: 8px 0;
            color: #475569;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .plan-features li::before {
            content: '✅';
            margin-right: 10px;
            font-size: 16px;
        }
        
        .cta-section {
            text-align: center;
            margin: 30px 0;
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
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
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
        
        .upgrade-info {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }
        
        .upgrade-info h3 {
            color: #92400e;
            margin-bottom: 10px;
            font-size: 18px;
        }
        
        .upgrade-info p {
            color: #b45309;
            font-weight: 500;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            
            .header, .content, .footer {
                padding: 25px 20px;
            }
            
            .contact-info {
                flex-direction: column;
                gap: 15px;
            }
            
            .plan-name {
                font-size: 20px;
            }
            
            .plan-price {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <h1>🎉 Parabéns!</h1>
                <p>Seu plano foi atualizado com sucesso</p>
            </div>
        </div>
        
        <!-- Content -->
        <div class="content">
            <!-- Success Icon -->
            <div class="success-icon">
                <div class="icon">🚀</div>
            </div>
            
            <!-- Greeting -->
            <h2 style="text-align: center; color: #1e293b; margin-bottom: 20px; font-size: 24px;">
                Olá, {{ $user->name }}!
            </h2>
            
            <p style="text-align: center; color: #64748b; font-size: 16px; margin-bottom: 30px;">
                Seu plano foi atualizado com sucesso! Agora você tem acesso a recursos ainda mais poderosos.
            </p>
            
            <!-- Upgrade Info -->
            <div class="upgrade-info">
                <h3>📈 Upgrade Realizado</h3>
                <p>De <strong>{{ ucfirst($oldPlan) }}</strong> para <strong>{{ ucfirst($newPlan) }}</strong></p>
            </div>
            
            <!-- Plan Details -->
            <div class="plan-card">
                <div class="plan-name">{{ $planDetails['name'] ?? ucfirst($newPlan) }}</div>
                <div class="plan-price">
                    @if(isset($planDetails['price']) && $planDetails['price'] > 0)
                        R$ {{ number_format($planDetails['price'], 2, ',', '.') }}/mês
                    @else
                        Gratuito
                    @endif
                </div>
                
                @if(isset($planDetails['features']) && is_array($planDetails['features']))
                    <ul class="plan-features">
                        @foreach($planDetails['features'] as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            
            <!-- CTA Section -->
            <div class="cta-section">
                <a href="{{ url('/panel') }}" class="cta-button">
                    🎯 Acessar Meu Painel
                </a>
            </div>
            
            <!-- Additional Info -->
            <div style="background: #f1f5f9; border-radius: 8px; padding: 20px; margin: 25px 0;">
                <h3 style="color: #1e293b; margin-bottom: 15px; font-size: 18px;">💡 Próximos Passos</h3>
                <ul style="color: #475569; line-height: 1.8;">
                    <li>• Explore os novos recursos disponíveis no seu painel</li>
                    <li>• Configure suas preferências e personalizações</li>
                    <li>• Aproveite ao máximo todas as funcionalidades do seu plano</li>
                    <li>• Entre em contato conosco se precisar de ajuda</li>
                </ul>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <h3>AzendaMe</h3>
            <p style="color: #64748b; margin-bottom: 20px;">
                A plataforma completa para gerenciar seu negócio
            </p>
            
            <div class="contact-info">
                <div class="contact-item">
                    <span>📧</span>
                    <span>{{ config('mail.from.address') }}</span>
                </div>
                <div class="contact-item">
                    <span>🌐</span>
                    <span>{{ config('app.url') }}</span>
                </div>
            </div>
            
            <div class="disclaimer">
                <p>
                    Este e-mail foi enviado automaticamente. Se você não solicitou esta atualização, 
                    entre em contato conosco imediatamente.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
