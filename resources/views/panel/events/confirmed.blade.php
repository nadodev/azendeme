@extends('panel.layout')

@section('title', 'Confirmação registrada')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-lg shadow p-6 text-center">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">Presença confirmada!</h1>
    <p class="text-gray-600">Obrigado por confirmar sua presença no evento <strong>{{ $event->title }}</strong> em {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }} às {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}.</p>
    <p class="text-gray-500 mt-4">Qualquer dúvida, entre em contato com {{ $event->professional->business_name ?? 'o prestador' }}.</p>
</div>
@endsection


