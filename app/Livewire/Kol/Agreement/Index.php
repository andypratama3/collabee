<?php

namespace App\Livewire\Kol\Agreement;

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
        $kolProfile = auth()->user()->kolProfile;

        if (! $kolProfile) {
            return view('livewire.kol.agreement.index', [
                'agreements' => collect(),
            ])->layout('layouts.app');
        }

        $query = Agreement::whereHas('hiring', function ($q) use ($kolProfile) {
            $q->where('kol_profile_id', $kolProfile->id);
        })->with('hiring.campaign', 'hiring.brandProfile.user');

        if ($this->filter) {
            $query->where('status', $this->filter);
        }

        return view('livewire.kol.agreement.index', [
            'agreements' => $query->orderBy('created_at', 'desc')->paginate(15),
        ])->layout('layouts.app');
    }

    public function updatingFilter(): void
    {
        $this->resetPage();
    }
}
