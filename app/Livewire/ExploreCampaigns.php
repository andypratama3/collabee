<?php

namespace App\Livewire;

use App\Models\Campaign;
use App\Services\Campaign\CampaignService;
use Livewire\Component;
use Livewire\WithPagination;

class ExploreCampaigns extends Component
{
    use WithPagination;

    public string $search = '';
    public array $platforms = [];
    public ?string $kol_category = null;
    public ?float $budget_min = null;
    public ?float $budget_max = null;

    protected $queryString = ['search', 'platforms', 'kol_category', 'budget_min', 'budget_max'];

    public function render(CampaignService $campaignService)
    {
        $campaigns = $campaignService->getExploreCampaigns([
            'search' => $this->search,
            'platforms' => $this->platforms,
            'kol_category' => $this->kol_category,
            'budget_min' => $this->budget_min,
            'budget_max' => $this->budget_max,
        ]);

        return view('livewire.explore-campaigns', [
            'campaigns' => $campaigns,
            'platformOptions' => ['instagram', 'tiktok', 'youtube', 'twitter', 'linkedin', 'facebook', 'podcast', 'blog'],
            'categoryOptions' => ['fashion', 'beauty', 'tech', 'gaming', 'food', 'travel', 'fitness', 'music', 'education', 'lifestyle', 'finance', 'parenting'],
        ])->layout('layouts.app');
    }

    public function togglePlatform(string $platform): void
    {
        if (in_array($platform, $this->platforms)) {
            $this->platforms = array_values(array_filter($this->platforms, fn($p) => $p !== $platform));
        } else {
            $this->platforms[] = $platform;
        }
    }

    public function filterByCategory(?string $category): void
    {
        $this->kol_category = $category;
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'platforms', 'kol_category', 'budget_min', 'budget_max']);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingBudgetMin(): void
    {
        $this->resetPage();
    }

    public function updatingBudgetMax(): void
    {
        $this->resetPage();
    }
}
