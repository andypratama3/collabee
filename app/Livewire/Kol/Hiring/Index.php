<?php

namespace App\Livewire\Kol\Hiring;

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
    public string $activeTab = 'invitations'; // 'invitations' | 'applications'
    public $selectedHiring = null;
    public bool $showRespondModal = false;
    public string $respondAction = '';
    public ?string $rejectReason = null;
    public ?int $counterOfferAmount = null;

    protected $queryString = ['filter', 'activeTab'];

    public function render()
    {
        $kolProfile = auth()->user()->kolProfile;

        if (! $kolProfile) {
            return view('livewire.kol.hiring.index', [
                'hirings'     => collect(),
                'applications' => collect(),
                'statuses'    => HiringStatus::cases(),
            ])->layout('layouts.app');
        }

        // Outbound hiring invitations from brands
        $hiringQuery = Hiring::where('kol_profile_id', $kolProfile->id)
            ->with(['campaign.brandProfile.user', 'agreement', 'chatRoom', 'kolProfile.rateCards']);

        if ($this->filter) {
            $hiringQuery->where('status', $this->filter);
        }

        // KOL's own submitted applications
        $applicationQuery = HiringApplication::where('kol_profile_id', $kolProfile->id)
            ->with(['campaign.brandProfile.user']);

        return view('livewire.kol.hiring.index', [
            'hirings'      => $hiringQuery->orderBy('created_at', 'desc')->paginate(15, pageName: 'hiringsPage'),
            'applications' => $applicationQuery->orderBy('created_at', 'desc')->paginate(15, pageName: 'appsPage'),
            'statuses'     => HiringStatus::cases(),
        ])->layout('layouts.app');
    }

    public function openRespondModal(Hiring $hiring, string $action): void
    {
        $this->authorize('view', $hiring);
        $this->selectedHiring = $hiring->id;
        $this->respondAction = $action;
        $this->rejectReason = null;
        $this->counterOfferAmount = (int) ($hiring->agreed_budget ?? $hiring->proposed_budget);
        $this->showRespondModal = true;
    }

    public function respond(HiringService $hiringService): void
    {
        $hiring = Hiring::with('campaign')->findOrFail($this->selectedHiring);
        $this->authorize('view', $hiring);

        if ($this->respondAction === 'accept') {
            $this->validate([
                'counterOfferAmount' => 'required|numeric|min:1',
            ]);

            $isCounterOffer = $this->counterOfferAmount !== (int) ($hiring->proposed_budget ?? 0);

            if ($isCounterOffer) {
                $hiringService->counterOffer($hiring, $this->counterOfferAmount);
                session()->flash('success', 'Counter-offer Anda telah dikirim ke brand untuk disetujui.');
            } else {
                $hiringService->accept($hiring);
                session()->flash('success', 'Hiring diterima! Agreement telah dibuat secara otomatis.');
            }
        } else {
            $hiringService->reject($hiring, $this->rejectReason);
            session()->flash('success', 'Hiring ditolak.');
        }

        $this->showRespondModal = false;
        $this->selectedHiring = null;
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
