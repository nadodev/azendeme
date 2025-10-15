<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforcePlanLimits
{
    public function handle(Request $request, Closure $next, string $resource): Response
    {
        $user = $request->user();
        if (!$user) { return $next($request); }
        $limits = $user->planLimits();

        $over = false;
        switch ($resource) {
            case 'services':
                $current = \App\Models\Service::count();
                $limit = (int) ($limits['services'] ?? PHP_INT_MAX);
                $over = $current >= $limit;
                break;
            case 'staff':
                $current = \App\Models\Professional::where('user_id', $user->id)->count();
                $limit = (int) ($limits['staff'] ?? PHP_INT_MAX);
                $over = $current >= $limit;
                break;
            case 'appointments':
                $start = now()->startOfMonth();
                $end = now()->endOfMonth();
                $current = \App\Models\Appointment::whereBetween('start_time', [$start, $end])->count();
                $limit = (int) ($limits['appointments_per_month'] ?? PHP_INT_MAX);
                $over = $current >= $limit;
                break;
        }

        if ($over && $request->isMethod('post')) {
            return redirect()->back()->withErrors(['plan' => 'Limite do plano atingido para ' . $resource . '. Faça upgrade para continuar.']);
        }

        return $next($request);
    }
}
