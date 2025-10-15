<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Bug - AzendeMe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #8B5CF6, #EC4899);
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }
        .content {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 0 0 10px 10px;
        }
        .field {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            color: #6B7280;
            display: block;
            margin-bottom: 5px;
        }
        .value {
            background: white;
            padding: 10px;
            border-radius: 5px;
            border-left: 4px solid #8B5CF6;
        }
        .description {
            background: white;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #EC4899;
            white-space: pre-wrap;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #E5E7EB;
            color: #6B7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🐛 Relatório de Bug</h1>
        <p>Novo relatório recebido via {{ $source === 'landing' ? 'Landing Page' : 'Painel Admin' }}</p>
    </div>
    
    <div class="content">
        <div class="field">
            <span class="label">👤 Nome:</span>
            <div class="value">{{ $name }}</div>
        </div>
        
        <div class="field">
            <span class="label">📧 E-mail:</span>
            <div class="value">{{ $email }}</div>
        </div>
        
        <div class="field">
            <span class="label">📝 Assunto:</span>
            <div class="value">{{ $subject }}</div>
        </div>
        
        <div class="field">
            <span class="label">📄 Descrição do Problema:</span>
            <div class="description">{{ $description }}</div>
        </div>
        
        <div class="field">
            <span class="label">🌐 Página/URL:</span>
            <div class="value">{{ $page_url }}</div>
        </div>
        
        <div class="field">
            <span class="label">🖥️ Navegador:</span>
            <div class="value">{{ $user_agent }}</div>
        </div>
        
        <div class="field">
            <span class="label">📍 Origem:</span>
            <div class="value">{{ $source === 'landing' ? 'Landing Page' : 'Painel Administrativo' }}</div>
        </div>
        
        <div class="field">
            <span class="label">⏰ Data/Hora:</span>
            <div class="value">{{ $timestamp }}</div>
        </div>
        
        <div class="field">
            <span class="label">🌍 IP:</span>
            <div class="value">{{ $ip_address }}</div>
        </div>
    </div>
    
    <div class="footer">
        <p>Este e-mail foi enviado automaticamente pelo sistema AzendeMe</p>
        <p>Para responder, use o e-mail: {{ $email }}</p>
    </div>
</body>
</html>
