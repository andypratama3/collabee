<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminImpersonation
{
    public function handle(Request $request, Closure $next): Response
    {
        $originalAdminId = session('original_admin_id');

        if ($originalAdminId) {
            $admin = User::find($originalAdminId);
            view()->share('isImpersonating', true);
            view()->share('impersonatedBy', $admin);
        } else {
            view()->share('isImpersonating', false);
            view()->share('impersonatedBy', null);
        }

        return $next($request);
    }
}
