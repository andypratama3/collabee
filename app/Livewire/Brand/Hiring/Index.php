<?php

namespace App\Livewire\Brand\Hiring;

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
    public bool $showCancelConfirm = false;
    public ?string $cancelReason = null;

    protected $queryString = ['filter'];

    public function render()
    {
        $query = Hiring::where('brand_profile_id', auth()->user()->brandProfile->id)
            ->with(['campaign', 'kolProfile.user']);

        if ($this->filter) {
            $query->where('status', $this->filter);
        }

        return view('livewire.brand.hiring.index', [
            'hirings' => $query->orderBy('created_at', 'desc')->paginate(15),
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

        session()->flash('success', 'Hiring cancelled.');
    }

    public function updatingFilter(): void
    {
        $this->resetPage();
    }
}
