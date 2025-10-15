<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Upgrade de Plano - AzendaMe</title>
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
            max-width: 700px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
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
        
        .alert-icon {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .alert-icon .icon {
            display: inline-block;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: white;
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .user-info {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            position: relative;
            overflow: hidden;
        }
        
        .user-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #059669, #047857);
        }
        
        .user-details {
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
        
        .plan-comparison {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 25px 0;
        }
        
        .plan-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            position: relative;
        }
        
        .plan-card.old {
            border-color: #ef4444;
            background: #fef2f2;
        }
        
        .plan-card.new {
            border-color: #10b981;
            background: #f0fdf4;
        }
        
        .plan-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            border-radius: 12px 12px 0 0;
        }
        
        .plan-card.old::before {
            background: #ef4444;
        }
        
        .plan-card.new::before {
            background: #10b981;
        }
        
        .plan-name {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .plan-card.old .plan-name {
            color: #dc2626;
        }
        
        .plan-card.new .plan-name {
            color: #059669;
        }
        
        .plan-price {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 15px;
        }
        
        .plan-card.old .plan-price {
            color: #dc2626;
        }
        
        .plan-card.new .plan-price {
            color: #059669;
        }
        
        .revenue-info {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border: 2px solid #f59e0b;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
        }
        
        .revenue-amount {
            font-size: 36px;
            font-weight: 800;
            color: #92400e;
            margin-bottom: 10px;
        }
        
        .revenue-label {
            font-size: 16px;
            color: #b45309;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .cta-section {
            text-align: center;
            margin: 30px 0;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #059669, #047857);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.4);
            transition: all 0.3s ease;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.6);
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
        
        .timestamp {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
            color: #475569;
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
            
            .user-details {
                grid-template-columns: 1fr;
            }
            
            .plan-comparison {
                grid-template-columns: 1fr;
            }
            
            .contact-info {
                flex-direction: column;
                gap: 15px;
            }
            
            .revenue-amount {
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
                <h1>💰 Novo Upgrade!</h1>
                <p>Cliente fez upgrade de plano</p>
            </div>
        </div>
        
        <!-- Content -->
        <div class="content">
            <!-- Alert Icon -->
            <div class="alert-icon">
                <div class="icon">📈</div>
            </div>
            
            <!-- Timestamp -->
            <div class="timestamp">
                <strong>🕐 Data/Hora:</strong> {{ $upgradeTime ? $upgradeTime->format('d/m/Y H:i:s') : now()->format('d/m/Y H:i:s') }}
            </div>
            
            <!-- User Information -->
            <div class="user-info">
                <h3 style="color: #1e293b; margin-bottom: 20px; font-size: 20px; text-align: center;">
                    👤 Informações do Cliente
                </h3>
                
                <div class="user-details">
                    <div class="detail-item">
                        <div class="detail-label">Nome</div>
                        <div class="detail-value">{{ $user->name }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">E-mail</div>
                        <div class="detail-value">{{ $user->email }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">ID do Usuário</div>
                        <div class="detail-value">#{{ $user->id }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">Data de Cadastro</div>
                        <div class="detail-value">{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Plan Comparison -->
            <div class="plan-comparison">
                <div class="plan-card old">
                    <div class="plan-name">Plano Anterior</div>
                    <div class="plan-price">
                        @if($oldPlan === 'free')
                            Gratuito
                        @else
                            {{ ucfirst($oldPlan) }}
                        @endif
                    </div>
                </div>
                
                <div class="plan-card new">
                    <div class="plan-name">Novo Plano</div>
                    <div class="plan-price">
                        @if(isset($planDetails['price']) && $planDetails['price'] > 0)
                            R$ {{ number_format($planDetails['price'], 2, ',', '.') }}/mês
                        @else
                            Gratuito
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Revenue Information -->
            @if(isset($planDetails['price']) && $planDetails['price'] > 0)
                <div class="revenue-info">
                    <div class="revenue-amount">
                        R$ {{ number_format($planDetails['price'], 2, ',', '.') }}
                    </div>
                    <div class="revenue-label">
                        Receita Mensal Adicional
                    </div>
                </div>
            @endif
            
            <!-- Plan Features -->
            @if(isset($planDetails['features']) && is_array($planDetails['features']))
                <div style="background: #f1f5f9; border-radius: 8px; padding: 20px; margin: 25px 0;">
                    <h3 style="color: #1e293b; margin-bottom: 15px; font-size: 18px;">🎯 Recursos do Novo Plano</h3>
                    <ul style="color: #475569; line-height: 1.8;">
                        @foreach($planDetails['features'] as $feature)
                            <li>• {{ $feature }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- CTA Section -->
            <div class="cta-section">
                <a href="{{ url('/panel') }}" class="cta-button">
                    🔍 Ver Painel Admin
                </a>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <h3>AzendaMe - Sistema de Notificações</h3>
            <p style="color: #64748b; margin-bottom: 20px;">
                Notificação automática de upgrade de plano
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
                    Esta é uma notificação automática do sistema. 
                    Mantenha este e-mail para seus registros.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
