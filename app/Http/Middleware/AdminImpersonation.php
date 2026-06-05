<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminImpersonation
{
    public function handle(Request $request, Closure $next): Response
    {
        $originalAdminId = session('original_admin_id');

        if ($originalAdminId) {
            $admin = \App\Models\User::find($originalAdminId);
            view()->share('isImpersonating', true);
            view()->share('impersonatedBy', $admin);
        } else {
            view()->share('isImpersonating', false);
            view()->share('impersonatedBy', null);
        }

        return $next($request);
    }
}
