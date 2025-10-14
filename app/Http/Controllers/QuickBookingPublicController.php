<?php

namespace App\Http\Controllers;

use App\Models\QuickBookingLink;
use App\Models\Customer;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;

class QuickBookingPublicController extends Controller
{
    public function show($token)
    {
        $link = QuickBookingLink::where('token', $token)->firstOrFail();

        if (!$link->isValid()) {
            return view('quick-booking.expired', compact('link'));
        }

        $services = Service::where('professional_id', $link->professional_id)
            ->where('active', true)
            ->when($link->service_id, function($query) use ($link) {
                return $query->where('id', $link->service_id);
            })
            ->get();

        return view('quick-booking.form', compact('link', 'services'));
    }

    public function store(Request $request, $token)
    {
        $link = QuickBookingLink::where('token', $token)->firstOrFail();

        if (!$link->isValid()) {
            return redirect()->back()->with('error', 'Este link não está mais válido.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'service_id' => 'required|exists:services,id',
            'preferred_date' => 'required|date|after:today',
            'preferred_time' => 'required',
            'notes' => 'nullable|string',
        ]);

        // Buscar ou criar cliente
        $customer = Customer::where('professional_id', $link->professional_id)
            ->where('phone', $validated['phone'])
            ->first();

        if (!$customer) {
            $customer = Customer::create([
                'professional_id' => $link->professional_id,
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
            ]);
        }

        // Criar agendamento
        $service = Service::findOrFail($validated['service_id']);
        $startTime = Carbon::parse($validated['preferred_date'] . ' ' . $validated['preferred_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        $appointment = Appointment::create([
            'professional_id' => $link->professional_id,
            'customer_id' => $customer->id,
            'service_id' => $validated['service_id'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'pending',
            'notes' => $validated['notes'],
        ]);

        // Incrementar uso do link
        $link->incrementUses();

        return view('quick-booking.success', compact('appointment', 'customer'));
    }
}
