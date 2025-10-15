<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Professional;
use App\Models\User;
use Illuminate\Http\Request;

class TenantRegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register-tenant');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'business_name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|alpha_dash|unique:professionals,slug',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'plan' => 'free',
        ]);

        $professional = Professional::create([
            'user_id' => $user->id,
            'business_name' => $data['business_name'],
            'name' => $data['business_name'],
            'email' => $data['email'],
            'slug' => $data['slug'],
            'is_main' => true,
        ]);

        if (method_exists($user, 'professional')) {
            $user->setRelation('professional', $professional);
        }

        auth()->login($user);

        return redirect()->route('panel.dashboard');
    }
}
