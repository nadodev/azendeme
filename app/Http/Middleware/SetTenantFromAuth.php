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
        
        // Define tenant ID como professional->id (não user->id)
        if ($user && method_exists($user, 'professional') && $user->professional) {
            $tenantId = $user->professional->id;
        }
        
        Tenancy::setTenantId($tenantId);
        return $next($request);
    }
}
