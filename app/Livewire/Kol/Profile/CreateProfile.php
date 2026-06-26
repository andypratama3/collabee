<?php

namespace App\Livewire\Kol\Profile;

use App\Enums\KolCategory;
use App\Enums\SocialPlatform;
use App\Services\Kol\KolProfileService;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateProfile extends Component
{
    use WithFileUploads;

    public string $display_name = '';

    public string $bio = '';

    public string $category = '';

    public array $sub_categories = [];

    public string $location = '';

    public string $gender = '';

    public string $date_of_birth = '';

    public array $languages = [];

    public bool $is_open_for_work = true;

    public string $min_budget = '';

    public $avatar = null;

    public array $social_accounts = [];

    public array $portfolios = [];

    public array $rate_cards = [];

    public function addSocialAccount(): void
    {
        $this->social_accounts[] = [
            'platform' => '',
            'username' => '',
            'profile_url' => '',
            'followers_count' => 0,
            'engagement_rate' => 0,
            'is_primary' => false,
        ];
    }

    public function removeSocialAccount(int $index): void
    {
        unset($this->social_accounts[$index]);
        $this->social_accounts = array_values($this->social_accounts);
    }

    public function addPortfolio(): void
    {
        $this->portfolios[] = [
            'title' => '',
            'description' => '',
            'media_type' => 'image',
            'media_url' => '',
            'external_link' => '',
        ];
    }

    public function removePortfolio(int $index): void
    {
        unset($this->portfolios[$index]);
        $this->portfolios = array_values($this->portfolios);
    }

    public function addRateCard(): void
    {
        $this->rate_cards[] = [
            'platform' => '',
            'content_type' => '',
            'price' => 0,
            'description' => '',
        ];
    }

    public function removeRateCard(int $index): void
    {
        unset($this->rate_cards[$index]);
        $this->rate_cards = array_values($this->rate_cards);
    }

    public function save(KolProfileService $service)
    {
        $this->validate([
            'display_name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:2000',
            'category' => 'required|string|in:'.implode(',', array_column(KolCategory::cases(), 'value')),
            'sub_categories' => 'nullable|array',
            'location' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'date_of_birth' => 'nullable|date',
            'languages' => 'nullable|array',
            'is_open_for_work' => 'boolean',
            'min_budget' => 'nullable|numeric|min:0',
            'avatar' => 'nullable|image|max:2048',
            'social_accounts.*.platform' => 'required|string|in:'.implode(',', array_column(SocialPlatform::cases(), 'value')),
            'social_accounts.*.username' => 'required|string|max:255',
            'social_accounts.*.followers_count' => 'nullable|integer|min:0',
            'portfolios.*.title' => 'required|string|max:255',
            'portfolios.*.external_link' => 'nullable|url|max:255',
            'rate_cards.*.platform' => 'required|string|in:'.implode(',', array_column(SocialPlatform::cases(), 'value')),
            'rate_cards.*.content_type' => 'required|string|max:255',
            'rate_cards.*.price' => 'required|numeric|min:0',
        ]);

        $profile = $service->create([
            'display_name' => $this->display_name,
            'bio' => $this->bio ?: null,
            'category' => $this->category,
            'sub_categories' => ! empty($this->sub_categories) ? $this->sub_categories : null,
            'location' => $this->location ?: null,
            'gender' => $this->gender ?: null,
            'date_of_birth' => $this->date_of_birth ?: null,
            'languages' => ! empty($this->languages) ? $this->languages : null,
            'is_open_for_work' => $this->is_open_for_work,
            'min_budget' => $this->min_budget ? (float) $this->min_budget : null,
            'avatar' => $this->avatar?->getRealPath(),
            'social_accounts' => $this->social_accounts,
            'portfolios' => $this->portfolios,
            'rate_cards' => $this->rate_cards,
        ], auth()->user());

        session()->flash('success', 'Profil KOL berhasil dibuat.');

        return $this->redirect(route('kol.profile.edit', $profile), navigate: true);
    }

    public function render()
    {
        return view('livewire.kol.profile.create-profile', [
            'categories' => KolCategory::cases(),
            'platforms' => SocialPlatform::cases(),
        ])->layout('layouts.app');
    }
}
