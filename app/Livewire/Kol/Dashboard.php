<?php

namespace App\Livewire\Kol;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        $profile = $user->kolProfile;

        return view('livewire.kol.dashboard', [
            'walletBalance' => $profile?->wallet_balance ?? 0,
            'pendingBalance' => $profile?->pending_balance ?? 0,
            'totalCampaignsDone' => $profile?->total_campaigns_done ?? 0,
            'ratingAvg' => $profile?->rating_avg ?? 0,
            'recentHirings' => $profile?->hirings()->latest()->take(5)->get() ?? collect(),
            'earnings' => $profile?->withdrawals()
                ->selectRaw('SUM(amount) as total, DATE_FORMAT(created_at, "%Y-%m") as month')
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month')
                ->toArray() ?? [],
        ])->layout('layouts.app');
    }
}
