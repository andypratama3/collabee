<?php

namespace App\Livewire\Shared\Rating;

use App\Models\KolProfile;
use App\Services\Rating\RatingService;
use Livewire\Component;

class Show extends Component
{
    public KolProfile $profile;

    public function mount(KolProfile $profile): void
    {
        $this->profile = $profile;
    }

    public function render(RatingService $ratingService)
    {
        return view('livewire.shared.rating.show', [
            'stats' => $ratingService->getProfileRating($this->profile),
        ])->layout('layouts.app');
    }
}
