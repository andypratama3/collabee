<?php

namespace App\Livewire\Admin;

use App\Enums\CampaignStatus;
use App\Models\Campaign;
use Livewire\Component;
use Livewire\WithPagination;

class CampaignManagement extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';

    protected $queryString = ['search', 'statusFilter'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function feature(Campaign $campaign): void
    {
        $campaign->update(['is_featured' => true]);
        session()->flash('success', 'Campaign berhasil di-feature.');
    }

    public function unfeature(Campaign $campaign): void
    {
        $campaign->update(['is_featured' => false]);
        session()->flash('success', 'Campaign berhasil di-unfeature.');
    }

    public function suspend(Campaign $campaign): void
    {
        $campaign->update(['status' => CampaignStatus::CANCELLED]);
        session()->flash('success', 'Campaign berhasil di-suspend.');
    }

    public function activate(Campaign $campaign): void
    {
        $campaign->update(['status' => CampaignStatus::OPEN]);
        session()->flash('success', 'Campaign berhasil diaktifkan.');
    }

    public function render()
    {
        $query = Campaign::with('brandProfile.user');

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return view('admin.campaigns', [
            'campaigns' => $query->latest()->paginate(15),
            'statuses' => CampaignStatus::cases(),
        ])->layout('layouts.app');
    }
}
