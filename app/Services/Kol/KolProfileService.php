<?php

namespace App\Services\Kol;

use App\Models\KolProfile;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class KolProfileService
{
    public function create(array $data, User $user): KolProfile
    {
        return DB::transaction(function () use ($data, $user) {
            $profile = $user->kolProfile()->create([
                'display_name' => $data['display_name'],
                'bio' => $data['bio'] ?? null,
                'category' => $data['category'] ?? null,
                'sub_categories' => $data['sub_categories'] ?? null,
                'location' => $data['location'] ?? null,
                'gender' => $data['gender'] ?? null,
                'date_of_birth' => $data['date_of_birth'] ?? null,
                'languages' => $data['languages'] ?? null,
                'is_open_for_work' => $data['is_open_for_work'] ?? true,
                'min_budget' => $data['min_budget'] ?? null,
                'profile_completed_at' => now(),
            ]);

            if (!empty($data['avatar'])) {
                $user->addMedia($data['avatar'])
                    ->toMediaCollection('avatar');
            }

            if (!empty($data['social_accounts'])) {
                $this->syncSocialAccounts($profile, $data['social_accounts']);
            }

            if (!empty($data['portfolios'])) {
                $this->syncPortfolios($profile, $data['portfolios']);
            }

            if (!empty($data['rate_cards'])) {
                $this->syncRateCards($profile, $data['rate_cards']);
            }

            return $profile;
        });
    }

    public function update(array $data, KolProfile $profile): KolProfile
    {
        return DB::transaction(function () use ($data, $profile) {
            $profile->update([
                'display_name' => $data['display_name'] ?? $profile->display_name,
                'bio' => $data['bio'] ?? $profile->bio,
                'category' => $data['category'] ?? $profile->category,
                'sub_categories' => $data['sub_categories'] ?? $profile->sub_categories,
                'location' => $data['location'] ?? $profile->location,
                'gender' => $data['gender'] ?? $profile->gender,
                'date_of_birth' => $data['date_of_birth'] ?? $profile->date_of_birth,
                'languages' => $data['languages'] ?? $profile->languages,
                'is_open_for_work' => $data['is_open_for_work'] ?? $profile->is_open_for_work,
                'min_budget' => $data['min_budget'] ?? $profile->min_budget,
            ]);

            if (!empty($data['avatar'])) {
                $profile->user->clearMediaCollection('avatar');
                $profile->user->addMedia($data['avatar'])
                    ->toMediaCollection('avatar');
            }

            if (isset($data['social_accounts'])) {
                $this->syncSocialAccounts($profile, $data['social_accounts']);
            }

            if (isset($data['portfolios'])) {
                $this->syncPortfolios($profile, $data['portfolios']);
            }

            if (isset($data['rate_cards'])) {
                $this->syncRateCards($profile, $data['rate_cards']);
            }

            if (!$profile->profile_completed_at) {
                $profile->update(['profile_completed_at' => now()]);
            }

            return $profile->fresh();
        });
    }

    public function syncSocialAccounts(KolProfile $profile, array $accounts): void
    {
        $profile->socialAccounts()->delete();

        foreach ($accounts as $account) {
            $profile->socialAccounts()->create([
                'platform' => $account['platform'],
                'username' => $account['username'],
                'profile_url' => $account['profile_url'] ?? null,
                'followers_count' => $account['followers_count'] ?? 0,
                'engagement_rate' => $account['engagement_rate'] ?? 0,
                'is_primary' => $account['is_primary'] ?? false,
            ]);
        }
    }

    public function syncPortfolios(KolProfile $profile, array $portfolios): void
    {
        $profile->portfolios()->delete();

        foreach ($portfolios as $index => $portfolio) {
            $profile->portfolios()->create([
                'title' => $portfolio['title'],
                'description' => $portfolio['description'] ?? null,
                'media_type' => $portfolio['media_type'] ?? 'image',
                'media_url' => $portfolio['media_url'] ?? null,
                'external_link' => $portfolio['external_link'] ?? null,
                'sort_order' => $portfolio['sort_order'] ?? $index,
            ]);
        }
    }

    public function syncRateCards(KolProfile $profile, array $rateCards): void
    {
        $profile->rateCards()->delete();

        foreach ($rateCards as $rateCard) {
            $profile->rateCards()->create([
                'platform' => $rateCard['platform'],
                'content_type' => $rateCard['content_type'],
                'price' => $rateCard['price'],
                'description' => $rateCard['description'] ?? null,
                'is_active' => $rateCard['is_active'] ?? true,
            ]);
        }
    }

    public function saveBankAccount(KolProfile $profile, array $data): void
    {
        DB::transaction(function () use ($profile, $data) {
            $profile->bankAccount()->updateOrCreate(
                ['kol_profile_id' => $profile->id],
                [
                    'bank_name' => $data['bank_name'],
                    'account_name' => $data['account_name'],
                    'account_number' => $data['account_number'],
                    'bank_code' => $data['bank_code'] ?? null,
                    'branch' => $data['branch'] ?? null,
                ]
            );
        });
    }

    public function getAvatarUrl(KolProfile $profile): ?string
    {
        return $profile->user->getFirstMediaUrl('avatar');
    }
}
