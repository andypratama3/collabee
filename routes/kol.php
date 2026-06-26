<?php

use App\Livewire\Kol\Agreement\Index as AgreementIndex;
use App\Livewire\Kol\Agreement\Show as AgreementShow;
use App\Livewire\Kol\Chat\Index as ChatIndex;
use App\Livewire\Kol\Chat\Show as ChatShow;
use App\Livewire\Kol\Content\Create as ContentCreate;
use App\Livewire\Kol\Content\Edit as ContentEdit;
use App\Livewire\Kol\Content\Index as ContentIndex;
use App\Livewire\Kol\Content\Show as ContentShow;
use App\Livewire\Kol\Dashboard;
use App\Livewire\Kol\Hiring\Index as HiringIndex;
use App\Livewire\Kol\Profile\CreateProfile;
use App\Livewire\Kol\Profile\EditProfile;
use App\Livewire\Kol\Withdrawal\Index;
use Illuminate\Support\Facades\Route;

Route::middleware(['kol', 'profile.complete'])->prefix('kol')->name('kol.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile/{profile}', EditProfile::class)->name('profile.edit');
    Route::get('/hirings', HiringIndex::class)->name('hiring.index');
    Route::get('/chat', ChatIndex::class)->name('chat.index');
    Route::get('/chat/{chatRoom}', ChatShow::class)->name('chat.show');
    Route::get('/contents', ContentIndex::class)->name('content.index');
    Route::get('/contents/create/{agreement?}', ContentCreate::class)->name('content.create');
    Route::get('/contents/{content}/edit', ContentEdit::class)->name('content.edit');
    Route::get('/contents/{content}', ContentShow::class)->name('content.show');
    Route::get('/agreements', AgreementIndex::class)->name('agreement.index');
    Route::get('/agreements/{agreement}', AgreementShow::class)->name('agreement.show');
    Route::get('/withdrawals', Index::class)->name('withdrawal.index');
});

Route::middleware(['kol'])->prefix('kols')->name('kol.')->group(function () {
    Route::get('/profile/create', CreateProfile::class)->name('profile.create');
});
