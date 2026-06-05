<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\RegistrationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisterBrandController extends Controller
{
    public function __construct(
        protected RegistrationService $registrationService
    ) {}

    public function create(): View
    {
        return view('auth.register-brand');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'brand_name' => ['required', 'string', 'max:255'],
            'industry' => ['required', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
        ]);

        $user = $this->registrationService->registerBrand($data);

        auth()->login($user);

        return redirect()->route('verification.notice')
            ->with('success', 'Registrasi berhasil! Silakan verifikasi email Anda.');
    }
}
