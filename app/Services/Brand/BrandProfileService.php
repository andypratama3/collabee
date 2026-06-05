<?php

namespace App\Services\Brand;

use App\Models\BrandProfile;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BrandProfileService
{
    public function create(array $data, User $user): BrandProfile
    {
        return DB::transaction(function () use ($data, $user) {
            $profile = $user->brandProfile()->create([
                'brand_name' => $data['brand_name'],
                'description' => $data['description'] ?? null,
                'industry' => $data['industry'] ?? null,
                'website' => $data['website'] ?? null,
                'target_market' => $data['target_market'] ?? null,
                'location' => $data['location'] ?? null,
                'profile_completed_at' => now(),
            ]);

            if (!empty($data['logo'])) {
                $profile->addMedia($data['logo'])
                    ->toMediaCollection('brand_logo');
            }

            if (!empty($data['banner'])) {
                $profile->addMedia($data['banner'])
                    ->toMediaCollection('brand_banner');
            }

            return $profile;
        });
    }

    public function update(array $data, BrandProfile $profile): BrandProfile
    {
        return DB::transaction(function () use ($data, $profile) {
            $profile->update([
                'brand_name' => $data['brand_name'] ?? $profile->brand_name,
                'description' => $data['description'] ?? $profile->description,
                'industry' => $data['industry'] ?? $profile->industry,
                'website' => $data['website'] ?? $profile->website,
                'target_market' => $data['target_market'] ?? $profile->target_market,
                'location' => $data['location'] ?? $profile->location,
            ]);

            if (!empty($data['logo'])) {
                $profile->clearMediaCollection('brand_logo');
                $profile->addMedia($data['logo'])
                    ->toMediaCollection('brand_logo');
            }

            if (!empty($data['banner'])) {
                $profile->clearMediaCollection('brand_banner');
                $profile->addMedia($data['banner'])
                    ->toMediaCollection('brand_banner');
            }

            if (!$profile->profile_completed_at) {
                $profile->update(['profile_completed_at' => now()]);
            }

            return $profile->fresh();
        });
    }

    public function getLogoUrl(BrandProfile $profile): ?string
    {
        return $profile->getFirstMediaUrl('brand_logo');
    }

    public function getBannerUrl(BrandProfile $profile): ?string
    {
        return $profile->getFirstMediaUrl('brand_banner');
    }
}
