<?php

use App\Livewire\Kol\Chat\Index as ChatIndex;
use App\Livewire\Kol\Chat\Show as ChatShow;
use App\Livewire\Kol\Dashboard;
use App\Livewire\Kol\Hiring\Index as HiringIndex;
use App\Livewire\Kol\Profile\CreateProfile;
use App\Livewire\Kol\Profile\EditProfile;
use Illuminate\Support\Facades\Route;

Route::middleware(['kol', 'profile.complete'])->prefix('kol')->name('kol.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile/{profile}', EditProfile::class)->name('profile.edit');
    Route::get('/hirings', HiringIndex::class)->name('hiring.index');
    Route::get('/chat', ChatIndex::class)->name('chat.index');
    Route::get('/chat/{chatRoom}', ChatShow::class)->name('chat.show');
});

Route::middleware(['kol'])->prefix('kol')->name('kol.')->group(function () {
    Route::get('/profile/create', CreateProfile::class)->name('profile.create');
});
