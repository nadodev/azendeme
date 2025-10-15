<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembrete de Evento</title>
</head>
<body style="font-family: Arial, sans-serif; color:#111;">
    <h2>Olá {{ $event->customer->name }},</h2>
    <p>Este é um lembrete do seu evento <strong>{{ $event->title }}</strong> marcado para <strong>{{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}</strong> às <strong>{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</strong>.</p>

    <p><strong>Local:</strong> {{ $event->address }}, {{ $event->city }}/{{ $event->state }}</p>

    <p>Por favor, confirme sua presença clicando no botão abaixo:</p>
    <p>
        <a href="{{ $confirmationUrl }}" style="display:inline-block;padding:10px 16px;background:#6D28D9;color:#fff;text-decoration:none;border-radius:6px;">Confirmar Presença</a>
    </p>

    <p>Se tiver dúvidas, responda este e-mail.</p>

    <p>Obrigado,<br>{{ $event->professional->business_name ?? 'Equipe' }}</p>
</body>
</html>


