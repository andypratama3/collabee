<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\UserManagement;
use App\Livewire\Admin\CampaignManagement;
use App\Livewire\Admin\PaymentManagement;
use App\Livewire\Admin\WithdrawalManagement;
use App\Livewire\Admin\DisputeManagement;
use App\Livewire\Admin\Settings;
use App\Livewire\Admin\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::middleware(['auth', 'role:super_admin|admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/users', UserManagement::class)->name('users');
    Route::get('/campaigns', CampaignManagement::class)->name('campaigns');
    Route::get('/payments', PaymentManagement::class)->name('payments');
    Route::get('/withdrawals', WithdrawalManagement::class)->name('withdrawals');
    Route::get('/disputes', DisputeManagement::class)->name('disputes');
    Route::get('/activity-log', ActivityLog::class)->name('activity-log');
    Route::get('/settings', Settings::class)->name('settings');

    Route::post('/users/{user}/impersonate', function (\App\Models\User $user) {
        if (!auth()->user()->isAdmin() || $user->isAdmin()) {
            return back()->with('error', 'Tidak dapat melakukan impersonasi.');
        }

        session()->put('original_admin_id', auth()->id());

        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties(['impersonated_user_id' => $user->id, 'impersonated_user_email' => $user->email])
            ->log('Admin melakukan impersonasi ke user');

        Auth::login($user);

        return redirect()->to('/')->with('success', 'Anda sekarang login sebagai ' . $user->name);
    })->name('users.impersonate');

    Route::post('/users/stop-impersonate', function () {
        $originalAdminId = session('original_admin_id');

        if (!$originalAdminId) {
            return back()->with('error', 'Tidak dalam mode impersonasi.');
        }

        $admin = \App\Models\User::find($originalAdminId);

        if (!$admin) {
            session()->forget('original_admin_id');
            return redirect()->route('login');
        }

        activity()
            ->causedBy($admin)
            ->withProperties(['returned_from_user_id' => auth()->id()])
            ->log('Admin kembali dari impersonasi');

        Auth::login($admin);
        session()->forget('original_admin_id');

        return redirect()->route('admin.users')->with('success', 'Kembali ke mode admin.');
    })->name('users.stop-impersonate');
});
