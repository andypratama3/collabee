<?php

use App\Livewire\Brand\Agreement\Index as AgreementIndex;
use App\Livewire\Brand\Agreement\Show as AgreementShow;
use App\Livewire\Brand\BrowseKol;
use App\Livewire\Brand\Campaign\CreateCampaign;
use App\Livewire\Brand\Campaign\EditCampaign;
use App\Livewire\Brand\Campaign\Index as CampaignIndex;
use App\Livewire\Brand\Chat\Index as ChatIndex;
use App\Livewire\Brand\Chat\Show as ChatShow;
use App\Livewire\Brand\Content\Index as ContentIndex;
use App\Livewire\Brand\Content\Show as ContentShow;
use App\Livewire\Brand\Dashboard;
use App\Livewire\Brand\Hiring\Index as HiringIndex;
use App\Livewire\Brand\Profile\CreateProfile;
use App\Livewire\Brand\Profile\EditProfile;
use Illuminate\Support\Facades\Route;

Route::middleware(['brand', 'profile.complete'])->prefix('brand')->name('brand.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile/{profile}', EditProfile::class)->name('profile.edit');
    Route::get('/campaigns', CampaignIndex::class)->name('campaign.index');
    Route::get('/campaign/create', CreateCampaign::class)->name('campaign.create');
    Route::get('/campaign/{campaign}/edit', EditCampaign::class)->name('campaign.edit');
    Route::get('/browse-kol', BrowseKol::class)->name('browse-kol');
    Route::get('/hirings', HiringIndex::class)->name('hiring.index');
    Route::get('/chat', ChatIndex::class)->name('chat.index');
    Route::get('/chat/{chatRoom}', ChatShow::class)->name('chat.show');
    Route::get('/contents', ContentIndex::class)->name('content.index');
    Route::get('/contents/{content}', ContentShow::class)->name('content.show');
});

Route::middleware(['brand'])->prefix('brand')->name('brand.')->group(function () {
    Route::get('/profile/create', CreateProfile::class)->name('profile.create');
});
