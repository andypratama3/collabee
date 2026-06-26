<?php

namespace App\Livewire\Brand\Campaign;

use App\Enums\CampaignStatus;
use App\Models\Campaign;
use App\Services\Campaign\CampaignService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use AuthorizesRequests, WithPagination;

    public string $filter = '';

    public $selectedCampaign = null;

    public bool $showDeleteConfirm = false;

    protected $queryString = ['filter'];

    public function render(CampaignService $campaignService)
    {
        $query = Campaign::where('brand_profile_id', auth()->user()->brandProfile->id)
            ->withCount('hirings', 'hiringApplications');

        if ($this->filter) {
            $query->where('status', $this->filter);
        }

        return view('livewire.brand.campaign.index', [
            'campaigns' => $query->orderBy('created_at', 'desc')->paginate(10),
            'statuses' => CampaignStatus::cases(),
        ])->layout('layouts.app');
    }

    public function confirmDelete(Campaign $campaign): void
    {
        $this->authorize('delete', $campaign);
        $this->selectedCampaign = $campaign->id;
        $this->showDeleteConfirm = true;
    }

    public function delete(): void
    {
        $campaign = Campaign::findOrFail($this->selectedCampaign);
        $this->authorize('delete', $campaign);

        $campaign->delete();
        $this->showDeleteConfirm = false;
        $this->selectedCampaign = null;

        session()->flash('success', 'Campaign deleted successfully.');
    }

    public function publish(Campaign $campaign, CampaignService $campaignService): void
    {
        $this->authorize('update', $campaign);
        $campaignService->publish($campaign);
        session()->flash('success', 'Campaign published successfully.');
    }

    public function cancel(Campaign $campaign, CampaignService $campaignService): void
    {
        $this->authorize('update', $campaign);
        $campaignService->cancel($campaign);
        session()->flash('success', 'Campaign cancelled.');
    }

    public function pause(Campaign $campaign, CampaignService $campaignService): void
    {
        $this->authorize('update', $campaign);
        $campaignService->pause($campaign);
        session()->flash('success', 'Campaign paused.');
    }

    public function resume(Campaign $campaign, CampaignService $campaignService): void
    {
        $this->authorize('update', $campaign);
        $campaignService->resume($campaign);
        session()->flash('success', 'Campaign resumed.');
    }

    public function updatingFilter(): void
    {
        $this->resetPage();
    }
}
