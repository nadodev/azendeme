<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Bug - AzendeMe</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            margin: 0;
            padding: 40px 20px;
            min-height: 100vh;
        }
        
        .email-container {
            max-width: 700px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(139, 92, 246, 0.15);
            position: relative;
        }
        
        .email-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #8b5cf6, #ec4899, #f59e0b);
        }
        
        .header {
            background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
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
        
        .bug-icon {
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
        
        .priority-badge {
            display: inline-block;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 30px;
        }
        
        .bug-details {
            display: grid;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .detail-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        
        .detail-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #8b5cf6, #ec4899);
        }
        
        .detail-label {
            font-weight: 600;
            color: #475569;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        
        .detail-value {
            color: #1e293b;
            font-weight: 500;
            font-size: 15px;
            word-break: break-word;
        }
        
        .description-card {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border: 1px solid #fecaca;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            position: relative;
            overflow: hidden;
        }
        
        .description-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #ef4444, #dc2626);
        }
        
        .description-label {
            font-weight: 600;
            color: #991b1b;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }
        
        .description-text {
            color: #1f2937;
            font-size: 15px;
            line-height: 1.6;
            white-space: pre-wrap;
            background: rgba(255, 255, 255, 0.7);
            padding: 15px;
            border-radius: 8px;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
        
        .technical-info {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
            border-left: 4px solid #3b82f6;
        }
        
        .technical-info h3 {
            color: #1e40af;
            font-size: 16px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .tech-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .tech-item {
            background: white;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        
        .tech-label {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        
        .tech-value {
            font-size: 13px;
            color: #1e293b;
            font-weight: 500;
            word-break: break-all;
        }
        
        .footer {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        
        .footer h3 {
            color: #1e293b;
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .footer p {
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
            margin: 10px 0;
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
            
            .tech-grid {
                grid-template-columns: 1fr;
            }
            
            .bug-details {
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="header-content">
                <div class="bug-icon">🐛</div>
                <h1>Relatório de Bug</h1>
                <p>Novo relatório recebido via {{ $source === 'landing' ? 'Landing Page' : 'Painel Admin' }}</p>
            </div>
        </div>
        
        <div class="content">
            <div class="priority-badge">Prioridade: Alta</div>
            
            <div class="bug-details">
                <div class="detail-card">
                    <div class="detail-label">👤 Nome</div>
                    <div class="detail-value">{{ $name }}</div>
                </div>
                
                <div class="detail-card">
                    <div class="detail-label">📧 E-mail</div>
                    <div class="detail-value">{{ $email }}</div>
                </div>
                
                <div class="detail-card">
                    <div class="detail-label">📝 Assunto</div>
                    <div class="detail-value">{{ $subject }}</div>
                </div>
                
                <div class="detail-card">
                    <div class="detail-label">📍 Origem</div>
                    <div class="detail-value">{{ $source === 'landing' ? 'Landing Page' : 'Painel Administrativo' }}</div>
                </div>
            </div>
            
            <div class="description-card">
                <div class="description-label">📄 Descrição do Problema</div>
                <div class="description-text">{{ $description }}</div>
            </div>
            
            <div class="technical-info">
                <h3>🔧 Informações Técnicas</h3>
                <div class="tech-grid">
                    <div class="tech-item">
                        <div class="tech-label">🌐 Página/URL</div>
                        <div class="tech-value">{{ $page_url }}</div>
                    </div>
                    <div class="tech-item">
                        <div class="tech-label">⏰ Data/Hora</div>
                        <div class="tech-value">{{ $timestamp }}</div>
                    </div>
                    <div class="tech-item">
                        <div class="tech-label">🌍 IP Address</div>
                        <div class="tech-value">{{ $ip_address }}</div>
                    </div>
                    <div class="tech-item">
                        <div class="tech-label">🖥️ User Agent</div>
                        <div class="tech-value">{{ $user_agent }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <h3>📧 Informações de Contato</h3>
            <p>Para responder ao usuário, use o e-mail: <strong>{{ $email }}</strong></p>
            <p>Este relatório foi enviado automaticamente pelo sistema AzendeMe</p>
            
            <div class="disclaimer">
                Este e-mail foi gerado automaticamente. Por favor, não responda diretamente a esta mensagem.<br>
                Use o e-mail do usuário fornecido acima para entrar em contato.
            </div>
        </div>
    </div>
</body>
</html>