<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\LoyaltyProgram;
use App\Models\LoyaltyReward;
use App\Models\LoyaltyPoint;
use App\Models\Customer;
use Illuminate\Http\Request;

class LoyaltyController extends Controller
{
    protected $professionalId = 1;

    public function index()
    {
        $program = LoyaltyProgram::where('professional_id', $this->professionalId)->first();
        $rewards = LoyaltyReward::where('professional_id', $this->professionalId)
            ->orderBy('points_required')
            ->get();
        
        $topCustomers = Customer::where('professional_id', $this->professionalId)
            ->with(['loyaltyPoints' => function($query) {
                $query->where('professional_id', $this->professionalId);
            }])
            ->get()
            ->map(function($customer) {
                $customer->total_points = $customer->loyaltyPoints->sum('points');
                return $customer;
            })
            ->sortByDesc('total_points')
            ->take(10);

        return view('panel.loyalty.index', compact('program', 'rewards', 'topCustomers'));
    }

    public function updateProgram(Request $request)
    {
        $validated = $request->validate([
            'active' => 'required|boolean',
            'points_per_currency' => 'required|numeric|min:0',
            'points_per_visit' => 'required|integer|min:0',
            'points_expiry_days' => 'nullable|integer|min:0',
        ]);

        $program = LoyaltyProgram::updateOrCreate(
            ['professional_id' => $this->professionalId],
            array_merge($validated, [
                'name' => 'Programa de Fidelidade',
                'description' => 'Acumule pontos a cada visita e resgate recompensas!',
            ])
        );

        return redirect()->route('panel.loyalty.index')
            ->with('success', 'Programa de fidelidade atualizado com sucesso!');
    }

    public function createReward()
    {
        return view('panel.loyalty.create-reward');
    }

    public function storeReward(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_required' => 'required|integer|min:1',
            'reward_type' => 'required|in:percentage,fixed,free_service',
            'discount_value' => 'required|numeric|min:0',
            'max_redemptions' => 'nullable|integer|min:1',
            'valid_until' => 'nullable|date',
        ]);

        $validated['professional_id'] = $this->professionalId;
        $validated['active'] = $request->has('active') ? true : false;

        LoyaltyReward::create($validated);

        return redirect()->route('panel.loyalty.index')
            ->with('success', 'Recompensa criada com sucesso!');
    }

    public function editReward($id)
    {
        $reward = LoyaltyReward::where('professional_id', $this->professionalId)
            ->findOrFail($id);
        
        return view('panel.loyalty.edit-reward', compact('reward'));
    }

    public function updateReward(Request $request, $id)
    {
        $reward = LoyaltyReward::where('professional_id', $this->professionalId)
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_required' => 'required|integer|min:1',
            'reward_type' => 'required|in:percentage,fixed,free_service',
            'discount_value' => 'required|numeric|min:0',
            'max_redemptions' => 'nullable|integer|min:1',
            'valid_until' => 'nullable|date',
        ]);

        $validated['active'] = $request->has('active') ? true : false;

        $reward->update($validated);

        return redirect()->route('panel.loyalty.index')
            ->with('success', 'Recompensa atualizada com sucesso!');
    }

    public function destroyReward($id)
    {
        $reward = LoyaltyReward::where('professional_id', $this->professionalId)
            ->findOrFail($id);
        
        $reward->delete();

        return redirect()->route('panel.loyalty.index')
            ->with('success', 'Recompensa excluída com sucesso!');
    }

    public function customerPoints($customerId)
    {
        $customer = Customer::where('professional_id', $this->professionalId)
            ->findOrFail($customerId);
        
        $points = LoyaltyPoint::where('customer_id', $customerId)
            ->where('professional_id', $this->professionalId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $totalPoints = $points->sum('points');
        
        $transactions = \App\Models\LoyaltyTransaction::where('customer_id', $customerId)
            ->where('professional_id', $this->professionalId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $redemptions = \App\Models\LoyaltyRedemption::where('customer_id', $customerId)
            ->where('professional_id', $this->professionalId)
            ->with('reward')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('panel.loyalty.customer-points', compact('customer', 'points', 'totalPoints', 'transactions', 'redemptions'));
    }

    public function manualPoints(Request $request, $customerId)
    {
        $customer = Customer::where('professional_id', $this->professionalId)
            ->findOrFail($customerId);

        $validated = $request->validate([
            'points' => 'required|integer',
            'description' => 'required|string|max:255',
        ]);

        // Busca ou cria o registro de pontos do cliente
        $loyaltyPoint = LoyaltyPoint::firstOrCreate(
            [
                'professional_id' => $this->professionalId,
                'customer_id' => $customerId,
            ],
            [
                'points' => 0,
                'total_earned' => 0,
                'total_redeemed' => 0,
            ]
        );

        // Atualiza os pontos
        if ($validated['points'] > 0) {
            $loyaltyPoint->points += $validated['points'];
            $loyaltyPoint->total_earned += $validated['points'];
            $type = 'earned';
        } else {
            $loyaltyPoint->points += $validated['points']; // já é negativo
            $loyaltyPoint->total_redeemed += abs($validated['points']);
            $type = 'redeemed';
        }
        $loyaltyPoint->save();

        // Cria a transação
        \App\Models\LoyaltyTransaction::create([
            'professional_id' => $this->professionalId,
            'customer_id' => $customerId,
            'type' => $type,
            'points' => $validated['points'],
            'description' => $validated['description'],
        ]);

        return redirect()->back()
            ->with('success', 'Pontos ' . ($validated['points'] > 0 ? 'adicionados' : 'removidos') . ' com sucesso!');
    }
}
