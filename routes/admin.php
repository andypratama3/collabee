<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:super_admin|admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
    Route::get('/users', fn () => view('admin.users'))->name('users');
    Route::get('/campaigns', fn () => view('admin.campaigns'))->name('campaigns');
    Route::get('/payments', fn () => view('admin.payments'))->name('payments');
    Route::get('/withdrawals', fn () => view('admin.withdrawals'))->name('withdrawals');
    Route::get('/disputes', fn () => view('admin.disputes'))->name('disputes');
    Route::get('/settings', fn () => view('admin.settings'))->name('settings');
});
