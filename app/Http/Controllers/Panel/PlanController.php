<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $allPlans = config('plans');
        $plans = collect($allPlans)->except('limit_labels')->toArray();
        $current = auth()->user()->plan;
        return view('panel.plans.index', compact('plans', 'current'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:free,premium,master',
        ]);
        $target = $request->string('plan');
        // Poderíamos validar regras de upgrade/downgrade aqui
        $user = auth()->user();
        $user->plan = $target;
        $user->save();
        return redirect()->route('panel.plans.index')->with('success', 'Plano alterado para ' . strtoupper($target) . ' com sucesso!');
    }
}
