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
        ], [
            'name.required' => 'O nome é obrigatório.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Por favor, insira um e-mail válido.',
            'email.unique' => 'Este e-mail já está sendo usado.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
            'business_name.required' => 'O nome do negócio é obrigatório.',
            'business_name.max' => 'O nome do negócio não pode ter mais de 255 caracteres.',
            'slug.required' => 'A URL personalizada é obrigatória.',
            'slug.alpha_dash' => 'A URL personalizada só pode conter letras, números, hífens e underscores.',
            'slug.unique' => 'Esta URL personalizada já está sendo usada.',
        ]);

        // Criar usuário
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'plan' => 'free',
        ]);

        // Criar profissional
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
