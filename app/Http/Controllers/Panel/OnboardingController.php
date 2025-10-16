<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function get(Request $request)
    {
        $user = $request->user();
        $data = $user->onboarding ?? [
            'completed' => false,
            'steps' => [
                'profile' => false,
                'services' => false,
                'availability' => false,
                'bio' => false,
                'payments' => false,
            ],
        ];
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $payload = $request->validate([
            'step' => 'required|string|in:profile,services,availability,bio,payments',
            'done' => 'required|boolean',
        ]);

        $data = $user->onboarding ?? [ 'completed' => false, 'steps' => [] ];
        $data['steps'] = array_merge([
            'profile' => false,
            'services' => false,
            'availability' => false,
            'bio' => false,
            'payments' => false,
        ], $data['steps'] ?? []);
        $data['steps'][$payload['step']] = $payload['done'];
        $data['completed'] = collect($data['steps'])->every(fn($v) => (bool) $v);

        $user->onboarding = $data;
        $user->save();

        return response()->json($data);
    }
}


