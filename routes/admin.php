<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\UserManagement;
use App\Livewire\Admin\CampaignManagement;
use App\Livewire\Admin\PaymentManagement;
use App\Livewire\Admin\WithdrawalManagement;
use App\Livewire\Admin\DisputeManagement;
use App\Livewire\Admin\Settings;

Route::middleware(['auth', 'role:super_admin|admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/users', UserManagement::class)->name('users');
    Route::get('/campaigns', CampaignManagement::class)->name('campaigns');
    Route::get('/payments', PaymentManagement::class)->name('payments');
    Route::get('/withdrawals', WithdrawalManagement::class)->name('withdrawals');
    Route::get('/disputes', DisputeManagement::class)->name('disputes');
    Route::get('/settings', Settings::class)->name('settings');
});
