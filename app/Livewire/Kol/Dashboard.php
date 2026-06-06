<?php

namespace App\Livewire\Kol;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        $profile = $user->kolProfile;

        $profileCompletion = 0;
        if ($profile) {
            $fields = ['display_name', 'bio', 'category', 'location', 'gender', 'date_of_birth', 'min_budget'];
            $filled = 0;
            foreach ($fields as $field) {
                if (!empty($profile->$field)) {
                    $filled++;
                }
            }
            $hasSocial = $profile->socialAccounts()->exists();
            $hasRateCard = $profile->rateCards()->exists();
            $totalFields = count($fields) + 2;
            $filled += $hasSocial ? 1 : 0;
            $filled += $hasRateCard ? 1 : 0;
            $profileCompletion = round(($filled / $totalFields) * 100);
        }

        return view('livewire.kol.dashboard', [
            'walletBalance' => $profile?->wallet_balance ?? 0,
            'pendingBalance' => $profile?->pending_balance ?? 0,
            'totalCampaignsDone' => $profile?->total_campaigns_done ?? 0,
            'ratingAvg' => $profile?->rating_avg ?? 0,
            'recentHirings' => $profile?->hirings()->latest()->take(5)->get() ?? collect(),
            'activeAgreements' => $profile?->hirings()
                ->whereHas('agreement', function($q) {
                    $q->where('status', 'active')->orWhere('status', 'signed');
                })
                ->with(['agreement', 'campaign'])
                ->latest()
                ->take(5)
                ->get() ?? collect(),
            'recentNotifications' => $user->notifications()
                ->latest()
                ->take(5)
                ->get(),
            'earnings' => $profile?->withdrawals()
                ->selectRaw('SUM(amount) as total, strftime(\'%Y-%m\', created_at) as month')
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month')
                ->toArray() ?? [],
            'profileCompletion' => $profileCompletion,
        ])->layout('layouts.app');
    }
}
