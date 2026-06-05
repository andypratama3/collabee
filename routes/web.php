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

Route::get('/', fn () => view('welcome'))->name('home');
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
