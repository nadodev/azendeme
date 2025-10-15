# 📧 Configuração de E-mail no Laravel

## 1. Configuração do arquivo `.env`

Adicione as seguintes variáveis no seu arquivo `.env`:

### Para Gmail (Recomendado para desenvolvimento):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-de-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu-email@gmail.com
MAIL_FROM_NAME="AzendeMe"
```

### Para Outlook/Hotmail:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp-mail.outlook.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@outlook.com
MAIL_PASSWORD=sua-senha
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu-email@outlook.com
MAIL_FROM_NAME="AzendeMe"
```

### Para provedores brasileiros (UOL, Terra, etc.):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.uol.com.br
MAIL_PORT=587
MAIL_USERNAME=seu-email@uol.com.br
MAIL_PASSWORD=sua-senha
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu-email@uol.com.br
MAIL_FROM_NAME="AzendeMe"
```

### Para Mailtrap (Teste - Recomendado para desenvolvimento):
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=seu-username-mailtrap
MAIL_PASSWORD=sua-senha-mailtrap
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=teste@azendeme.com
MAIL_FROM_NAME="AzendeMe"
```

## 2. Configuração do Gmail (Mais Comum)

### Passo 1: Ativar autenticação de 2 fatores
1. Acesse sua conta do Google
2. Vá em "Segurança"
3. Ative a "Verificação em duas etapas"

### Passo 2: Gerar senha de app
1. Ainda em "Segurança"
2. Procure por "Senhas de app"
3. Selecione "E-mail" e "Outro (nome personalizado)"
4. Digite "Laravel AzendeMe"
5. Copie a senha gerada (16 caracteres)

### Passo 3: Configurar no .env
```env
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=a-senha-de-16-caracteres-gerada
```

## 3. Testando a configuração

### Opção 1: Comando Artisan
```bash
php artisan tinker
```

No tinker, execute:
```php
Mail::raw('Teste de e-mail', function ($message) {
    $message->to('seu-email@teste.com')
            ->subject('Teste Laravel');
});
```

### Opção 2: Criar comando de teste
```bash
php artisan make:command TestEmail
```

## 4. Configurações de produção

### Para produção, considere usar:
- **SendGrid** (gratuito até 100 e-mails/dia)
- **Mailgun** (gratuito até 10.000 e-mails/mês)
- **Amazon SES** (muito barato)
- **Postmark** (pago, mas muito confiável)

### Exemplo com SendGrid:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=sua-api-key-sendgrid
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@seudominio.com
MAIL_FROM_NAME="AzendeMe"
```

## 5. Troubleshooting

### Erro: "Authentication failed"
- Verifique se a senha está correta
- Para Gmail, use senha de app, não a senha normal
- Verifique se a autenticação de 2 fatores está ativa

### Erro: "Connection refused"
- Verifique se a porta está correta (587 para TLS, 465 para SSL)
- Verifique se o firewall não está bloqueando

### Erro: "SSL/TLS"
- Tente mudar `MAIL_ENCRYPTION` para `tls` ou `ssl`
- Para Gmail, use sempre `tls`

## 6. Logs de e-mail

Para debug, você pode usar o driver `log` temporariamente:
```env
MAIL_MAILER=log
```

Os e-mails serão salvos em `storage/logs/laravel.log`

## 7. Configuração recomendada para o AzendeMe

```env
# E-mail principal do sistema
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=suporte@azendeme.com.br
MAIL_PASSWORD=sua-senha-de-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=suporte@azendeme.com.br
MAIL_FROM_NAME="AzendeMe - Suporte"
```

## 8. Comandos úteis

```bash
# Limpar cache de configuração
php artisan config:clear

# Recarregar configurações
php artisan config:cache

# Testar e-mail
php artisan tinker
```
