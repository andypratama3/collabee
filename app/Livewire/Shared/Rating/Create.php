<?php

namespace App\Livewire\Shared\Rating;

use App\Models\Hiring;
use App\Services\Rating\RatingService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Create extends Component
{
    use AuthorizesRequests;

    public Hiring $hiring;
    public string $type = 'kol';
    public int $communication = 0;
    public int $professionalism = 0;
    public int $quality = 0;
    public int $timeliness = 0;
    public string $review = '';

    protected $rules = [
        'communication' => 'required|integer|min:1|max:5',
        'professionalism' => 'required|integer|min:1|max:5',
        'quality' => 'required|integer|min:1|max:5',
        'timeliness' => 'required|integer|min:1|max:5',
        'review' => 'nullable|string|max:1000',
    ];

    public function mount(Hiring $hiring, string $type = 'kol'): void
    {
        $this->hiring = $hiring;
        $this->type = $type;
    }

    public function render()
    {
        return view('livewire.shared.rating.create')
            ->layout('layouts.app');
    }

    public function submitBrandRating(RatingService $ratingService): void
    {
        $this->validate();

        $ratingService->rateKol($this->hiring, auth()->user(), [
            'communication' => $this->communication,
            'professionalism' => $this->professionalism,
            'quality' => $this->quality,
            'timeliness' => $this->timeliness,
            'review' => $this->review,
        ]);

        session()->flash('success', 'Rating untuk KOL berhasil dikirim.');
        $this->redirect(route('brand.hiring.index'), navigate: true);
    }

    public function submitKolRating(RatingService $ratingService): void
    {
        $this->validate();

        $ratingService->rateBrand($this->hiring, auth()->user(), [
            'communication' => $this->communication,
            'professionalism' => $this->professionalism,
            'quality' => $this->quality,
            'timeliness' => $this->timeliness,
            'review' => $this->review,
        ]);

        session()->flash('success', 'Rating untuk Brand berhasil dikirim.');
        $this->redirect(route('kol.hiring.index'), navigate: true);
    }
}
