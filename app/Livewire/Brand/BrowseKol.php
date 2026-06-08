<?php

namespace App\Livewire\Brand;

use App\Models\Campaign;
use App\Models\Hiring;
use App\Models\KolProfile;
use App\Services\Campaign\HiringService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class BrowseKol extends Component
{
    use AuthorizesRequests, WithPagination;

    public string $search = '';
    public ?string $category = null;
    public ?int $minFollowers = null;
    public ?int $maxFollowers = null;
    public ?float $minEngagement = null;
    public ?float $maxBudget = null;
    public ?string $location = null;
    public bool $openForWork = true;

    public bool $showHireModal = false;
    public $selectedKolId = null;
    public $selectedKolName = '';
    public ?int $hireCampaignId = null;
    public ?float $proposedBudget = null;
    public string $hireMessage = '';
    public array $campaigns = [];

    protected $queryString = ['search', 'category', 'minFollowers', 'minEngagement'];

    public function render()
    {
        $query = KolProfile::query()
            ->with('user')
            ->withCount('hirings');

        if ($this->openForWork) {
            $query->where('is_open_for_work', true);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('display_name', 'like', '%' . $this->search . '%')
                    ->orWhere('bio', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->category) {
            $query->where('category', $this->category);
        }

        if ($this->minFollowers) {
            $query->where('total_followers', '>=', $this->minFollowers);
        }

        if ($this->maxFollowers) {
            $query->where('total_followers', '<=', $this->maxFollowers);
        }

        if ($this->minEngagement) {
            $query->where('avg_engagement_rate', '>=', $this->minEngagement);
        }

        if ($this->maxBudget) {
            $query->where('min_budget', '<=', $this->maxBudget);
        }

        if ($this->location) {
            $query->where('location', 'like', '%' . $this->location . '%');
        }

        return view('livewire.brand.browse-kol', [
            'kols' => $query->orderBy('total_followers', 'desc')->paginate(12),
        ])->layout('layouts.app');
    }

    public function openHireModal(int $kolId, string $kolName): void
    {
        $this->selectedKolId = $kolId;
        $this->selectedKolName = $kolName;
        $this->proposedBudget = null;
        $this->hireMessage = '';
        $this->hireCampaignId = null;
        $this->campaigns = auth()->user()->brandProfile->campaigns()
            ->whereIn('status', ['draft', 'open'])
            ->get()
            ->toArray();
        $this->showHireModal = true;
    }

    public function hire(HiringService $hiringService): void
    {
        $this->validate([
            'hireCampaignId' => 'required|exists:campaigns,id',
            'proposedBudget' => 'nullable|numeric|min:0',
            'hireMessage' => 'nullable|string|max:1000',
        ]);

        $campaign = Campaign::findOrFail($this->hireCampaignId);
        $this->authorize('update', $campaign);

        $brandProfile = auth()->user()->brandProfile;
        $kolProfile = KolProfile::findOrFail($this->selectedKolId);

        try {
            $hiringService->brandHire($campaign, $brandProfile, $kolProfile, [
                'proposed_budget' => $this->proposedBudget,
                'message' => $this->hireMessage,
            ]);
        } catch (\RuntimeException $e) {
            $this->showHireModal = false;
            session()->flash('error', $e->getMessage());
            return;
        }

        $this->showHireModal = false;
        session()->flash('success', 'Hiring invitation sent to ' . $this->selectedKolName . '!');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
}
