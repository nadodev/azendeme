<?php

namespace App\Http\Middleware;

use App\Support\Tenancy;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetTenantFromAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $tenantId = null;
        if ($user && method_exists($user, 'professional') && $user->professional) {
            $tenantId = $user->id;
        } elseif ($user && isset($user->id)) {
            $tenantId = $user->id;
        }
        Tenancy::setTenantId($tenantId);
        return $next($request);
    }
}
