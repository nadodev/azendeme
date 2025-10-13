<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\BlockedDate;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index()
    {
        $professionalId = 1;
        
        $availabilities = Availability::where('professional_id', $professionalId)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        $blockedDates = BlockedDate::where('professional_id', $professionalId)
            ->where('blocked_date', '>=', now())
            ->orderBy('blocked_date')
            ->get();

        $daysOfWeek = [
            0 => 'Domingo',
            1 => 'Segunda-feira',
            2 => 'Terça-feira',
            3 => 'Quarta-feira',
            4 => 'Quinta-feira',
            5 => 'Sexta-feira',
            6 => 'Sábado',
        ];

        return view('panel.disponibilidade', compact('availabilities', 'blockedDates', 'daysOfWeek'));
    }

    public function create()
    {
        $daysOfWeek = [
            0 => 'Domingo',
            1 => 'Segunda-feira',
            2 => 'Terça-feira',
            3 => 'Quarta-feira',
            4 => 'Quinta-feira',
            5 => 'Sexta-feira',
            6 => 'Sábado',
        ];

        return view('panel.disponibilidade-create', compact('daysOfWeek'));
    }

    public function store(Request $request)
    {
        $professionalId = 1;

        $validated = $request->validate([
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_duration' => 'required|integer|min:1',
        ]);

        Availability::create([
            'professional_id' => $professionalId,
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'slot_duration' => $validated['slot_duration'],
        ]);

        return redirect()->route('panel.disponibilidade.index')
            ->with('success', 'Disponibilidade criada com sucesso!');
    }

    public function show(Availability $disponibilidade)
    {
        //
    }

    public function edit(Availability $disponibilidade)
    {
        $daysOfWeek = [
            0 => 'Domingo',
            1 => 'Segunda-feira',
            2 => 'Terça-feira',
            3 => 'Quarta-feira',
            4 => 'Quinta-feira',
            5 => 'Sexta-feira',
            6 => 'Sábado',
        ];

        return view('panel.disponibilidade-edit', compact('disponibilidade', 'daysOfWeek'));
    }

    public function update(Request $request, Availability $disponibilidade)
    {
        $validated = $request->validate([
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_duration' => 'required|integer|min:1',
        ]);

        $disponibilidade->update([
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'slot_duration' => $validated['slot_duration'],
        ]);

        return redirect()->route('panel.disponibilidade.index')
            ->with('success', 'Disponibilidade atualizada com sucesso!');
    }

    public function destroy(Availability $disponibilidade)
    {
        $disponibilidade->delete();
        return redirect()->route('panel.disponibilidade.index')
            ->with('success', 'Disponibilidade excluída com sucesso!');
    }

    // Métodos para datas bloqueadas
    public function storeBlockedDate(Request $request)
    {
        $professionalId = 1;

        $validated = $request->validate([
            'blocked_date' => 'required|date',
            'reason' => 'nullable|string|max:255',
        ]);

        BlockedDate::create([
            'professional_id' => $professionalId,
            'blocked_date' => $validated['blocked_date'],
            'reason' => $validated['reason'] ?? null,
        ]);

        return redirect()->route('panel.disponibilidade.index')
            ->with('success', 'Data bloqueada com sucesso!');
    }

    public function destroyBlockedDate(BlockedDate $blockedDate)
    {
        $blockedDate->delete();
        return redirect()->route('panel.disponibilidade.index')
            ->with('success', 'Data desbloqueada com sucesso!');
    }
}
