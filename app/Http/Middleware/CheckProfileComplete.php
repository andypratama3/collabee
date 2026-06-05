<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProfileComplete
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user->isBrand() && ! $user->brandProfile?->profile_completed_at) {
            if (! $request->routeIs('brand.profile.create')) {
                return redirect()->route('brand.profile.create')
                    ->with('warning', 'Lengkapi profil Brand Anda terlebih dahulu.');
            }
        }

        if ($user->isKol() && ! $user->kolProfile?->profile_completed_at) {
            if (! $request->routeIs('kol.profile.create')) {
                return redirect()->route('kol.profile.create')
                    ->with('warning', 'Lengkapi profil KOL Anda terlebih dahulu.');
            }
        }

        return $next($request);
    }
}
