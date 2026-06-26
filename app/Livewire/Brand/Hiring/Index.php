<?php

namespace App\Livewire\Brand\Hiring;

use App\Enums\HiringStatus;
use App\Models\Hiring;
use App\Models\HiringApplication;
use App\Services\Campaign\HiringService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use AuthorizesRequests, WithPagination;

    public string $filter = '';

    public string $activeTab = 'outbound'; // 'outbound' | 'applications'

    public $selectedHiring = null;

    public bool $showCancelConfirm = false;

    public ?string $cancelReason = null;

    // Application review
    public $selectedApplicationId = null;

    public bool $showApplicationModal = false;

    public string $applicationAction = ''; // 'accept' | 'reject'

    public ?string $applicationRejectReason = null;

    protected $queryString = ['filter', 'activeTab'];

    public function render()
    {
        $brandProfile = auth()->user()->brandProfile;

        if (! $brandProfile) {
            return view('livewire.brand.hiring.index', [
                'hirings' => collect(),
                'applications' => collect(),
                'statuses' => HiringStatus::cases(),
            ])->layout('layouts.app');
        }

        $hiringQuery = Hiring::where('brand_profile_id', $brandProfile->id)
            ->with(['campaign', 'kolProfile.user', 'agreement']);

        if ($this->filter) {
            $hiringQuery->where('status', $this->filter);
        }

        $applicationQuery = HiringApplication::whereHas('campaign', function ($q) use ($brandProfile) {
            $q->where('brand_profile_id', $brandProfile->id);
        })->with(['campaign', 'kolProfile.user']);

        return view('livewire.brand.hiring.index', [
            'hirings' => $hiringQuery->orderBy('created_at', 'desc')->paginate(15, pageName: 'hiringsPage'),
            'applications' => $applicationQuery->orderBy('created_at', 'desc')->paginate(15, pageName: 'appsPage'),
            'statuses' => HiringStatus::cases(),
        ])->layout('layouts.app');
    }

    public function confirmCancel(Hiring $hiring): void
    {
        $this->authorize('cancel', $hiring);
        $this->selectedHiring = $hiring->id;
        $this->cancelReason = null;
        $this->showCancelConfirm = true;
    }

    public function cancel(HiringService $hiringService): void
    {
        $hiring = Hiring::findOrFail($this->selectedHiring);
        $this->authorize('cancel', $hiring);

        $hiringService->cancel($hiring, $this->cancelReason);
        $this->showCancelConfirm = false;
        $this->selectedHiring = null;
        $this->cancelReason = null;

        session()->flash('success', 'Hiring dibatalkan.');
    }

    public function openApplicationModal(HiringApplication $application, string $action): void
    {
        $this->selectedApplicationId = $application->id;
        $this->applicationAction = $action;
        $this->applicationRejectReason = null;
        $this->showApplicationModal = true;
    }

    public function processApplication(HiringService $hiringService): void
    {
        $application = HiringApplication::findOrFail($this->selectedApplicationId);
        $brandProfile = auth()->user()->brandProfile;

        if ($this->applicationAction === 'accept') {
            try {
                $hiring = $hiringService->acceptApplication($application, $brandProfile);
                session()->flash('success', 'Lamaran diterima! Agreement telah dibuat secara otomatis. Silakan cek tab Outbound Hiring.');
            } catch (\RuntimeException $e) {
                session()->flash('error', $e->getMessage());
            }
        } else {
            try {
                $hiringService->rejectApplication($application, $this->applicationRejectReason);
                session()->flash('success', 'Lamaran ditolak.');
            } catch (\RuntimeException $e) {
                session()->flash('error', $e->getMessage());
            }
        }

        $this->showApplicationModal = false;
        $this->selectedApplicationId = null;
    }

    public function updatingFilter(): void
    {
        $this->resetPage();
    }

    public function switchTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }
}
