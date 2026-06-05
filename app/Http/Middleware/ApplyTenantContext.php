<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplyTenantContext
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->company_id) {
            app()->instance('tenant.company_id', $request->user()->company_id);
        }

        return $next($request);
    }
}
