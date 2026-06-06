<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterBrandController;
use App\Http\Controllers\Auth\RegisterKolController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\TrackingController;
use App\Livewire\ExploreCampaigns;
use App\Livewire\Kol\Campaign\Detail as CampaignDetail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $stats = [
        'brands' => \App\Models\User::where('user_type', \App\Enums\UserRole::BRAND)->count(),
        'kols' => \App\Models\User::where('user_type', \App\Enums\UserRole::KOL)->count(),
        'campaigns' => \App\Models\Campaign::count(),
        'transactions' => \App\Models\Payment::where('status', \App\Enums\PaymentStatus::PAID)->sum('total_amount'),
    ];
    $campaigns = \App\Models\Campaign::with('brandProfile.user')->where('status', \App\Enums\CampaignStatus::OPEN)->latest()->take(6)->get();
    $kols = \App\Models\KolProfile::with('user')->orderByDesc('rating_avg')->orderByDesc('total_followers')->take(8)->get();
    $brands = \App\Models\BrandProfile::with('user')->inRandomOrder()->take(6)->get();
    return view('welcome', compact('stats', 'campaigns', 'kols', 'brands'));
})->name('home');

Route::get('/dashboard', function () {
    if (!auth()->check()) return redirect()->route('login');
    $user = auth()->user();
    if ($user->isAdmin()) return redirect()->route('admin.dashboard');
    if ($user->isBrand()) return redirect()->route('brand.dashboard');
    if ($user->isKol()) return redirect()->route('kol.dashboard');
    return redirect()->route('login');
})->name('dashboard');

Route::get('/discover', fn () => redirect()->route('campaigns.explore'))->name('discover');

Route::get('/onboarding', fn () => redirect()->route('home'))->name('onboarding');

Route::get('/about', fn () => view('about'))->name('about');

Route::get('/my-profile', function () {
    if (!auth()->check()) return redirect()->route('login');
    $user = auth()->user();
    if ($user->isBrand() && $user->brandProfile) return redirect()->route('brand.profile.edit', $user->brandProfile);
    if ($user->isKol() && $user->kolProfile) return redirect()->route('kol.profile.edit', $user->kolProfile);
    return redirect()->route('home');
})->name('my-profile');

Route::get('/campaigns', ExploreCampaigns::class)->name('campaigns.explore');
Route::get('/campaigns/{campaign}', CampaignDetail::class)->name('campaigns.detail');

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
    Route::get('register/brand', [RegisterBrandController::class, 'create'])->name('register.brand');
    Route::post('register/brand', [RegisterBrandController::class, 'store']);
    Route::get('register/kol', [RegisterKolController::class, 'create'])->name('register.kol');
    Route::post('register/kol', [RegisterKolController::class, 'store']);
    Route::get('forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'store'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LogoutController::class, 'destroy'])->name('logout');
    Route::get('email/verify', [VerificationController::class, 'notice'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
    Route::get('/notifications', \App\Livewire\Shared\Notification\Index::class)->name('notifications.index');
});

Route::get('/track/{trackingCode}', [TrackingController::class, 'click'])->name('track.click');
