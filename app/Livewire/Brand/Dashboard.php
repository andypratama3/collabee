<?php

namespace App\Livewire\Brand;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        $profile = $user->brandProfile;

        return view('livewire.brand.dashboard', [
            'totalCampaigns' => $profile?->total_campaigns ?? 0,
            'totalSpent' => $profile?->total_spent ?? 0,
            'ratingAvg' => $profile?->rating_avg ?? 0,
            'activeHirings' => $profile?->hirings()->whereIn('status', ['accepted', 'negotiating'])->count() ?? 0,
            'recentCampaigns' => $profile?->campaigns()->latest()->take(5)->get() ?? collect(),
        ])->layout('layouts.app');
    }
}
