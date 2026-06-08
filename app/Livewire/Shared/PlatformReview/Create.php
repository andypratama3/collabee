<?php

namespace App\Livewire\Shared\PlatformReview;

use App\Models\PlatformReview;
use App\Services\Rating\RatingService;
use Livewire\Component;

class Create extends Component
{
    public int $rating = 0;
    public string $review = '';

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'nullable|string|max:2000',
    ];

    protected $messages = [
        'rating.required' => 'Pilih rating terlebih dahulu.',
        'rating.min'      => 'Rating minimal 1 bintang.',
    ];

    public function mount(): void
    {
        // Check if user already submitted a platform review recently (within 30 days)
        $recent = PlatformReview::where('user_id', auth()->id())
            ->where('created_at', '>=', now()->subDays(30))
            ->exists();

        if ($recent) {
            session()->flash('info', 'Anda sudah memberikan review platform dalam 30 hari terakhir. Terima kasih!');
            $this->redirectToDashboard();
        }
    }

    public function render()
    {
        return view('livewire.shared.platform-review.create', [
            'rating' => $this->rating,
        ])->layout('layouts.app');
    }

    public function submit(RatingService $ratingService): void
    {
        $this->validate();

        $ratingService->submitPlatformReview(auth()->user(), [
            'rating' => $this->rating,
            'review' => $this->review ?: null,
        ]);

        session()->flash('success', 'Terima kasih atas review Anda untuk Collabee! 🎉');
        $this->redirectToDashboard();
    }

    public function skip(): void
    {
        $this->redirectToDashboard();
    }

    private function redirectToDashboard(): void
    {
        $user = auth()->user();
        if ($user->isBrand()) {
            $this->redirect(route('brand.dashboard'), navigate: true);
        } elseif ($user->isKol()) {
            $this->redirect(route('kol.dashboard'), navigate: true);
        } else {
            $this->redirect(route('home'), navigate: true);
        }
    }
}
