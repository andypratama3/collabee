<?php

namespace App\Livewire\Kol\Campaign;

use App\Models\Campaign;
use App\Models\HiringApplication;
use App\Services\Campaign\HiringService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Detail extends Component
{
    use AuthorizesRequests;

    public Campaign $campaign;
    public bool $showApplyModal = false;
    public ?float $proposedBudget = null;
    public string $applyMessage = '';
    public bool $hasApplied = false;

    public function mount(Campaign $campaign): void
    {
        $this->authorize('view', $campaign);
        $this->campaign = $campaign->loadCount('hirings', 'hiringApplications');

        if (auth()->check() && auth()->user()->isKol() && auth()->user()->kolProfile) {
            $this->hasApplied = HiringApplication::where('campaign_id', $campaign->id)
                ->where('kol_profile_id', auth()->user()->kolProfile->id)
                ->exists();
        }
    }

    public function render()
    {
        return view('livewire.kol.campaign.detail', [
            'brand' => $this->campaign->brandProfile,
        ])->layout('layouts.app');
    }

    public function openApplyModal(): void
    {
        $this->showApplyModal = true;
        $this->proposedBudget = null;
        $this->applyMessage = '';
    }

    public function apply(HiringService $hiringService): void
    {
        $this->validate([
            'proposedBudget' => 'nullable|numeric|min:0',
            'applyMessage' => 'nullable|string|max:1000',
        ]);

        $hiringService->apply(
            $this->campaign,
            auth()->user()->kolProfile,
            [
                'proposed_budget' => $this->proposedBudget,
                'message' => $this->applyMessage,
            ]
        );

        $this->showApplyModal = false;
        $this->hasApplied = true;
        session()->flash('success', 'Application submitted successfully!');
    }

    public function incrementViews(): void
    {
        $this->campaign->increment('views_count');
    }
}
