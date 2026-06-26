<?php

namespace App\Livewire\Shared\Rating;

use App\Models\Hiring;
use App\Models\Rating;
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

        // Check if user already submitted a rating for this hiring
        $alreadyRated = Rating::where('hiring_id', $hiring->id)
            ->where('rater_id', auth()->id())
            ->exists();

        if ($alreadyRated) {
            session()->flash('info', 'Anda sudah memberikan rating untuk hiring ini.');
            if (auth()->user()->isBrand()) {
                $this->redirect(route('brand.hiring.index'), navigate: true);
            } else {
                $this->redirect(route('kol.hiring.index'), navigate: true);
            }
        }
    }

    public function render()
    {
        $this->hiring->loadMissing('campaign.brandProfile.user', 'kolProfile.user');

        return view('livewire.shared.rating.create', [
            'communication' => $this->communication,
            'professionalism' => $this->professionalism,
            'quality' => $this->quality,
            'timeliness' => $this->timeliness,
        ])->layout('layouts.app');
    }

    public function submitBrandRating(RatingService $ratingService): void
    {
        $this->validate();

        if (Rating::where('hiring_id', $this->hiring->id)->where('rater_id', auth()->id())->exists()) {
            session()->flash('error', 'Anda sudah memberikan rating untuk hiring ini.');
            $this->redirect(route('brand.hiring.index'), navigate: true);

            return;
        }

        try {
            $ratingService->rateKol($this->hiring, auth()->user(), [
                'communication' => $this->communication,
                'professionalism' => $this->professionalism,
                'quality' => $this->quality,
                'timeliness' => $this->timeliness,
                'review' => $this->review,
            ]);

            session()->flash('success', 'Rating untuk KOL berhasil dikirim! Terima kasih atas penilaian Anda.');
            $this->redirect(route('platform.review.create'), navigate: true);
        } catch (\RuntimeException $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function submitKolRating(RatingService $ratingService): void
    {
        $this->validate();

        if (Rating::where('hiring_id', $this->hiring->id)->where('rater_id', auth()->id())->exists()) {
            session()->flash('error', 'Anda sudah memberikan rating untuk hiring ini.');
            $this->redirect(route('kol.hiring.index'), navigate: true);

            return;
        }

        try {
            $ratingService->rateBrand($this->hiring, auth()->user(), [
                'communication' => $this->communication,
                'professionalism' => $this->professionalism,
                'quality' => $this->quality,
                'timeliness' => $this->timeliness,
                'review' => $this->review,
            ]);

            session()->flash('success', 'Rating untuk Brand berhasil dikirim! Terima kasih atas penilaian Anda.');
            $this->redirect(route('platform.review.create'), navigate: true);
        } catch (\RuntimeException $e) {
            session()->flash('error', $e->getMessage());
        }
    }
}
