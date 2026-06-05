<?php

namespace App\Livewire\Kol\Profile;

use App\Enums\KolCategory;
use App\Enums\SocialPlatform;
use App\Models\KolProfile;
use App\Services\Kol\KolProfileService;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProfile extends Component
{
    use WithFileUploads;

    public KolProfile $profile;

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

    public string $existing_avatar_url = '';

    public array $social_accounts = [];

    public array $portfolios = [];

    public array $rate_cards = [];

    public string $bank_name = '';

    public string $account_name = '';

    public string $account_number = '';

    public string $bank_code = '';

    public string $branch = '';

    public function mount(KolProfile $profile): void
    {
        $this->profile = $profile;
        $this->display_name = $profile->display_name;
        $this->bio = $profile->bio ?? '';
        $this->category = $profile->category ?? '';
        $this->sub_categories = $profile->sub_categories ?? [];
        $this->location = $profile->location ?? '';
        $this->gender = $profile->gender ?? '';
        $this->date_of_birth = $profile->date_of_birth?->format('Y-m-d') ?? '';
        $this->languages = $profile->languages ?? [];
        $this->is_open_for_work = $profile->is_open_for_work ?? true;
        $this->min_budget = (string) ($profile->min_budget ?? '');
        $this->existing_avatar_url = $profile->user->getFirstMediaUrl('avatar');
        $this->social_accounts = $profile->socialAccounts->toArray();
        $this->portfolios = $profile->portfolios->sortBy('sort_order')->toArray();
        $this->rate_cards = $profile->rateCards->toArray();

        $bank = $profile->bankAccount;
        if ($bank) {
            $this->bank_name = $bank->bank_name ?? '';
            $this->account_name = $bank->account_name ?? '';
            $this->account_number = $bank->account_number ?? '';
            $this->bank_code = $bank->bank_code ?? '';
            $this->branch = $bank->branch ?? '';
        }
    }

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

    public function update(KolProfileService $service)
    {
        $this->validate([
            'display_name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:2000',
            'category' => 'nullable|string|in:' . implode(',', array_column(KolCategory::cases(), 'value')),
            'sub_categories' => 'nullable|array',
            'location' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'date_of_birth' => 'nullable|date',
            'languages' => 'nullable|array',
            'is_open_for_work' => 'boolean',
            'min_budget' => 'nullable|numeric|min:0',
            'avatar' => 'nullable|image|max:2048',
            'social_accounts.*.platform' => 'required|string|in:' . implode(',', array_column(SocialPlatform::cases(), 'value')),
            'social_accounts.*.username' => 'required|string|max:255',
            'social_accounts.*.followers_count' => 'nullable|integer|min:0',
            'portfolios.*.title' => 'required|string|max:255',
            'portfolios.*.external_link' => 'nullable|url|max:255',
            'rate_cards.*.platform' => 'required|string|in:' . implode(',', array_column(SocialPlatform::cases(), 'value')),
            'rate_cards.*.content_type' => 'required|string|max:255',
            'rate_cards.*.price' => 'required|numeric|min:0',
            'bank_name' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
        ]);

        $service->update([
            'display_name' => $this->display_name,
            'bio' => $this->bio ?: null,
            'category' => $this->category ?: null,
            'sub_categories' => !empty($this->sub_categories) ? $this->sub_categories : null,
            'location' => $this->location ?: null,
            'gender' => $this->gender ?: null,
            'date_of_birth' => $this->date_of_birth ?: null,
            'languages' => !empty($this->languages) ? $this->languages : null,
            'is_open_for_work' => $this->is_open_for_work,
            'min_budget' => $this->min_budget ? (float) $this->min_budget : null,
            'avatar' => $this->avatar?->getRealPath(),
            'social_accounts' => $this->social_accounts,
            'portfolios' => $this->portfolios,
            'rate_cards' => $this->rate_cards,
        ], $this->profile);

        if ($this->bank_name && $this->account_name && $this->account_number) {
            $service->saveBankAccount($this->profile, [
                'bank_name' => $this->bank_name,
                'account_name' => $this->account_name,
                'account_number' => $this->account_number,
                'bank_code' => $this->bank_code ?: null,
                'branch' => $this->branch ?: null,
            ]);
        }

        session()->flash('success', 'Profil KOL berhasil diperbarui.');

        $this->redirect(route('kol.profile.edit', $this->profile), navigate: true);
    }

    public function render()
    {
        return view('livewire.kol.profile.edit-profile', [
            'categories' => KolCategory::cases(),
            'platforms' => SocialPlatform::cases(),
        ])->layout('layouts.app');
    }
}
