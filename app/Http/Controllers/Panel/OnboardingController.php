<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    /**
     * Marcar uma etapa do onboarding como completa
     */
    public function completeStep(Request $request)
    {
        $request->validate([
            'step' => 'required|string'
        ]);

        $user = Auth::user();
        $steps = $user->onboarding_steps ?? [];
        
        if (!in_array($request->step, $steps)) {
            $steps[] = $request->step;
            $user->onboarding_steps = $steps;
            $user->save();
        }

        return response()->json(['success' => true, 'steps' => $steps]);
    }

    /**
     * Marcar todo o onboarding como completo
     */
    public function complete(Request $request)
    {
        $user = Auth::user();
        $user->onboarding_completed = true;
        $user->save();

        return response()->json(['success' => true]);
    }

    /**
     * Resetar o onboarding
     */
    public function reset(Request $request)
    {
        $user = Auth::user();
        $user->onboarding_completed = false;
        $user->onboarding_steps = [];
        $user->save();

        return response()->json(['success' => true]);
    }

    /**
     * Pular o onboarding
     */
    public function skip(Request $request)
    {
        $user = Auth::user();
        $user->onboarding_completed = true;
        $user->save();

        return response()->json(['success' => true]);
    }
}
