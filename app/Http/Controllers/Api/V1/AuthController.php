<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Http\Responses\ApiResponse;
use App\Services\Auth\RegistrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function __construct(
        private readonly RegistrationService $registrationService
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = match ($data['user_type']) {
            UserRole::BRAND->value => $this->registrationService->registerBrand($data),
            UserRole::KOL->value => $this->registrationService->registerKol($data),
            default => throw new \InvalidArgumentException('Tipe pengguna tidak valid.'),
        };

        $token = $user->createToken('auth-token')->plainTextToken;

        return ApiResponse::success([
            'user' => $user->load($user->isBrand() ? 'brandProfile' : 'kolProfile'),
            'token' => $token,
        ], 'Pendaftaran berhasil.', 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = \App\Models\User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return ApiResponse::error('Email atau password salah.', 401);
        }

        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ]);

        $user->tokens()->delete();
        $token = $user->createToken('auth-token')->plainTextToken;

        return ApiResponse::success([
            'user' => $user->load($user->isBrand() ? 'brandProfile' : 'kolProfile'),
            'token' => $token,
        ], 'Login berhasil.');
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return ApiResponse::success(null, 'Logout berhasil.');
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user()->load($request->user()->isBrand() ? 'brandProfile' : 'kolProfile');

        return ApiResponse::success($user);
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return ApiResponse::success(null, 'Tautan reset password telah dikirim ke email Anda.');
        }

        return ApiResponse::error('Gagal mengirim tautan reset password.', 400, [
            'email' => [__($status)],
        ]);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return ApiResponse::success(null, 'Password berhasil direset.');
        }

        return ApiResponse::error('Gagal mereset password.', 400, [
            'email' => [__($status)],
        ]);
    }
}
