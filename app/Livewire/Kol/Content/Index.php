<?php

namespace App\Livewire\Kol\Content;

use App\Models\Content;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Index extends Component
{
    use AuthorizesRequests;

    public string $filter = '';

    protected $queryString = ['filter'];

    public function render()
    {
        $user = auth()->user();
        $profile = $user->kolProfile;

        $query = Content::with(['agreement.hiring.campaign', 'brandProfile.user'])
            ->where('kol_profile_id', $profile->id);

        if ($this->filter) {
            $query->where('status', $this->filter);
        }

        return view('livewire.kol.content.index', [
            'contents' => $query->orderBy('created_at', 'desc')->paginate(15),
        ])->layout('layouts.app');
    }

    public function updatingFilter(): void
    {
        $this->resetPage();
    }
}
