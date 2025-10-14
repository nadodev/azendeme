<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Customer;
use App\Models\Service;
use App\Models\CustomerSegment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromotionController extends Controller
{
    protected $professionalId = 1;

    public function index()
    {
        $promotions = Promotion::where('professional_id', $this->professionalId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('panel.promotions.index', compact('promotions'));
    }

    public function create()
    {
        $services = Service::where('professional_id', $this->professionalId)
            ->where('active', true)
            ->get();

        return view('panel.promotions.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:discount,package,bonus_points,free_service',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_fixed' => 'nullable|numeric|min:0',
            'bonus_points' => 'nullable|integer|min:1',
            'service_ids' => 'nullable|array',
            'service_ids.*' => 'exists:services,id',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'max_uses_per_customer' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'target_segment' => 'nullable|in:all,new,loyal,inactive,vip',
            'promo_code' => 'nullable|string|max:50|unique:promotions,promo_code',
        ]);

        $validated['professional_id'] = $this->professionalId;
        $validated['active'] = $request->has('active') ? true : false;
        
        // Gera código do cupom se não fornecido
        if (empty($validated['promo_code'])) {
            $validated['promo_code'] = strtoupper(Str::random(8));
        } else {
            $validated['promo_code'] = strtoupper($validated['promo_code']);
        }

        $promotion = Promotion::create($validated);

        return redirect()->route('panel.promotions.index')
            ->with('success', 'Promoção criada com sucesso!');
    }

    public function edit($id)
    {
        $promotion = Promotion::where('professional_id', $this->professionalId)
            ->findOrFail($id);
        
        $services = Service::where('professional_id', $this->professionalId)
            ->where('active', true)
            ->get();

        return view('panel.promotions.edit', compact('promotion', 'services'));
    }

    public function update(Request $request, $id)
    {
        $promotion = Promotion::where('professional_id', $this->professionalId)
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:discount,package,bonus_points,free_service',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_fixed' => 'nullable|numeric|min:0',
            'bonus_points' => 'nullable|integer|min:1',
            'service_ids' => 'nullable|array',
            'service_ids.*' => 'exists:services,id',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'max_uses_per_customer' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'target_segment' => 'nullable|in:all,new,loyal,inactive,vip',
            'promo_code' => 'nullable|string|max:50|unique:promotions,promo_code,' . $id,
        ]);

        $validated['active'] = $request->has('active') ? true : false;
        
        if (!empty($validated['promo_code'])) {
            $validated['promo_code'] = strtoupper($validated['promo_code']);
        }

        $promotion->update($validated);

        return redirect()->route('panel.promotions.index')
            ->with('success', 'Promoção atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $promotion = Promotion::where('professional_id', $this->professionalId)
            ->findOrFail($id);
        
        $promotion->delete();

        return redirect()->route('panel.promotions.index')
            ->with('success', 'Promoção excluída com sucesso!');
    }

    public function segments()
    {
        // Segmentos baseados em análise automática dos clientes
        $newCustomers = Customer::where('professional_id', $this->professionalId)
            ->whereDoesntHave('appointments')
            ->count();

        $activeCustomers = Customer::where('professional_id', $this->professionalId)
            ->whereHas('appointments', function($q) {
                $q->where('created_at', '>=', now()->subDays(30));
            })
            ->count();

        $loyalCustomers = Customer::where('professional_id', $this->professionalId)
            ->withCount('appointments')
            ->get()
            ->filter(function($customer) {
                return $customer->appointments_count >= 5;
            })
            ->count();

        $inactiveCustomers = Customer::where('professional_id', $this->professionalId)
            ->whereHas('appointments', function($q) {
                $q->where('created_at', '<', now()->subDays(60));
            })
            ->whereDoesntHave('appointments', function($q) {
                $q->where('created_at', '>=', now()->subDays(60));
            })
            ->count();

        $segments = [
            ['name' => 'Novos Clientes', 'key' => 'new', 'count' => $newCustomers, 'description' => 'Clientes que ainda não fizeram nenhum agendamento'],
            ['name' => 'Clientes Ativos', 'key' => 'active', 'count' => $activeCustomers, 'description' => 'Clientes com agendamento nos últimos 30 dias'],
            ['name' => 'Clientes Fiéis', 'key' => 'loyal', 'count' => $loyalCustomers, 'description' => 'Clientes com 5 ou mais agendamentos'],
            ['name' => 'Clientes Inativos', 'key' => 'inactive', 'count' => $inactiveCustomers, 'description' => 'Clientes sem agendamento há mais de 60 dias'],
        ];

        return view('panel.promotions.segments', compact('segments'));
    }
}
