<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerificationController extends Controller
{
    public function notice(): View
    {
        return view('auth.verify-email');
    }

    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectVerified();
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->redirectVerified()->with('success', 'Email berhasil diverifikasi!');
    }

    public function resend(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectVerified();
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Link verifikasi telah dikirim ulang.');
    }

    protected function redirectVerified(): RedirectResponse
    {
        $user = auth()->user();

        if ($user->isBrand()) {
            return $user->brandProfile?->profile_completed_at
                ? redirect()->intended(route('brand.dashboard'))
                : redirect()->route('brand.profile.create');
        }

        if ($user->isKol()) {
            return $user->kolProfile?->profile_completed_at
                ? redirect()->intended(route('kol.dashboard'))
                : redirect()->route('kol.profile.create');
        }

        return redirect()->intended(route('admin.dashboard'));
    }
}
