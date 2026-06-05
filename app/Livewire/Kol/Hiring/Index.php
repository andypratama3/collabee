<?php

namespace App\Livewire\Kol\Hiring;

use App\Enums\HiringStatus;
use App\Models\Hiring;
use App\Services\Campaign\HiringService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use AuthorizesRequests, WithPagination;

    public string $filter = '';
    public $selectedHiring = null;
    public bool $showRespondModal = false;
    public string $respondAction = '';
    public ?string $rejectReason = null;

    protected $queryString = ['filter'];

    public function render()
    {
        $query = Hiring::where('kol_profile_id', auth()->user()->kolProfile->id)
            ->with(['campaign.brandProfile.user']);

        if ($this->filter) {
            $query->where('status', $this->filter);
        }

        return view('livewire.kol.hiring.index', [
            'hirings' => $query->orderBy('created_at', 'desc')->paginate(15),
            'statuses' => HiringStatus::cases(),
        ])->layout('layouts.app');
    }

    public function openRespondModal(Hiring $hiring, string $action): void
    {
        $this->authorize('view', $hiring);
        $this->selectedHiring = $hiring->id;
        $this->respondAction = $action;
        $this->rejectReason = null;
        $this->showRespondModal = true;
    }

    public function respond(HiringService $hiringService): void
    {
        $hiring = Hiring::with('campaign')->findOrFail($this->selectedHiring);
        $this->authorize('view', $hiring);

        if ($this->respondAction === 'accept') {
            $hiringService->accept($hiring);
            session()->flash('success', 'Hiring accepted! You can now start working on the campaign.');
        } else {
            $hiringService->reject($hiring, $this->rejectReason);
            session()->flash('success', 'Hiring declined.');
        }

        $this->showRespondModal = false;
        $this->selectedHiring = null;
    }

    public function updatingFilter(): void
    {
        $this->resetPage();
    }
}
