<?php

namespace App\Livewire\Brand;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        $profile = $user->brandProfile;

        // Spending data for the last 7 days
        $spendingData = [];
        $spendingLabels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $spendingLabels[] = $date->format('D');
            
            $dailySpent = 0;
            if ($profile) {
                $dailySpent = $profile->hirings()
                    ->whereIn('status', ['accepted', 'completed'])
                    ->whereDate('accepted_at', $date->format('Y-m-d'))
                    ->sum('agreed_budget');
            }
            $spendingData[] = (float) $dailySpent;
        }

        return view('livewire.brand.dashboard', [
            'totalCampaigns' => $profile?->total_campaigns ?? 0,
            'totalSpent' => $profile?->total_spent ?? 0,
            'ratingAvg' => $profile?->rating_avg ?? 0,
            'activeHirings' => $profile ? $profile->hirings()->whereIn('status', ['accepted', 'negotiating'])->count() : 0,
            'recentCampaigns' => $profile ? $profile->campaigns()->latest()->take(5)->get() : collect(),
            'recentHirings' => $profile ? $profile->hirings()->with(['kolProfile', 'campaign'])->latest()->take(5)->get() : collect(),
            'spendingData' => $spendingData,
            'spendingLabels' => $spendingLabels,
        ])->layout('layouts.app');
    }
}
