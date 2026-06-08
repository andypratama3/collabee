<?php

namespace App\Livewire\Brand\Content;

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
        $user    = auth()->user();
        $profile = $user->brandProfile;

        if (! $profile) {
            return view('livewire.brand.content.index', [
                'contents' => collect(),
            ])->layout('layouts.app');
        }

        $query = Content::with(['agreement.hiring.campaign', 'kolProfile.user'])
            ->where('brand_profile_id', $profile->id);

        if ($this->filter) {
            $query->where('status', $this->filter);
        }

        return view('livewire.brand.content.index', [
            'contents' => $query->orderBy('created_at', 'desc')->paginate(15),
        ])->layout('layouts.app');
    }

    public function updatingFilter(): void
    {
        $this->resetPage();
    }
}
