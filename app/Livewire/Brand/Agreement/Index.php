<?php

namespace App\Livewire\Brand\Agreement;

use App\Models\Agreement;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Index extends Component
{
    use AuthorizesRequests;

    public string $filter = '';

    protected $queryString = ['filter'];

    public function render()
    {
        $brandProfile = auth()->user()->brandProfile;

        if (! $brandProfile) {
            return view('livewire.brand.agreement.index', [
                'agreements' => collect(),
            ])->layout('layouts.app');
        }

        $query = Agreement::whereHas('hiring', function ($q) use ($brandProfile) {
            $q->where('brand_profile_id', $brandProfile->id);
        })->with('hiring.campaign', 'hiring.kolProfile.user');

        if ($this->filter) {
            $query->where('status', $this->filter);
        }

        return view('livewire.brand.agreement.index', [
            'agreements' => $query->orderBy('created_at', 'desc')->paginate(15),
        ])->layout('layouts.app');
    }

    public function updatingFilter(): void
    {
        $this->resetPage();
    }
}
