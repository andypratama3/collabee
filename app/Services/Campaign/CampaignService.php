<?php

namespace App\Services\Campaign;

use App\Enums\CampaignStatus;
use App\Models\BrandProfile;
use App\Models\Campaign;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CampaignService
{
    public function create(BrandProfile $brandProfile, array $data): Campaign
    {
        return DB::transaction(function () use ($brandProfile, $data) {
            $data['brand_profile_id'] = $brandProfile->id;
            $data['status'] ??= CampaignStatus::DRAFT;

            return Campaign::create($data);
        });
    }

    public function update(Campaign $campaign, array $data): Campaign
    {
        return DB::transaction(function () use ($campaign, $data) {
            $campaign->update($data);

            return $campaign->fresh();
        });
    }

    public function publish(Campaign $campaign): Campaign
    {
        if ($campaign->status !== CampaignStatus::DRAFT) {
            throw new \RuntimeException('Only draft campaigns can be published.');
        }

        return DB::transaction(function () use ($campaign) {
            $campaign->update(['status' => CampaignStatus::OPEN]);

            return $campaign->fresh();
        });
    }

    public function cancel(Campaign $campaign): Campaign
    {
        if (! in_array($campaign->status, [CampaignStatus::DRAFT, CampaignStatus::OPEN, CampaignStatus::PAUSED])) {
            throw new \RuntimeException('This campaign cannot be cancelled.');
        }

        return DB::transaction(function () use ($campaign) {
            $campaign->update(['status' => CampaignStatus::CANCELLED]);

            return $campaign->fresh();
        });
    }

    public function pause(Campaign $campaign): Campaign
    {
        if ($campaign->status !== CampaignStatus::OPEN) {
            throw new \RuntimeException('Only active campaigns can be paused.');
        }

        return DB::transaction(function () use ($campaign) {
            $campaign->update(['status' => CampaignStatus::PAUSED]);

            return $campaign->fresh();
        });
    }

    public function resume(Campaign $campaign): Campaign
    {
        if ($campaign->status !== CampaignStatus::PAUSED) {
            throw new \RuntimeException('Only paused campaigns can be resumed.');
        }

        return DB::transaction(function () use ($campaign) {
            $campaign->update(['status' => CampaignStatus::OPEN]);

            return $campaign->fresh();
        });
    }

    public function getBrandCampaigns(BrandProfile $brandProfile, ?string $status = null): Collection
    {
        $query = Campaign::where('brand_profile_id', $brandProfile->id)
            ->withCount('hirings', 'hiringApplications')
            ->orderBy('created_at', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        return $query->get();
    }

    public function getExploreCampaigns(array $filters = [])
    {
        $query = Campaign::where('status', CampaignStatus::OPEN)
            ->with('brandProfile')
            ->withCount('hirings', 'hiringApplications')
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc');

        if (! empty($filters['platforms'])) {
            $query->where(function ($q) use ($filters) {
                foreach ((array) $filters['platforms'] as $platform) {
                    $q->orWhereJsonContains('platforms', $platform);
                }
            });
        }

        if (! empty($filters['kol_category'])) {
            $query->where('kol_category', $filters['kol_category']);
        }

        if (! empty($filters['budget_min'])) {
            $query->where('budget_total', '>=', $filters['budget_min']);
        }

        if (! empty($filters['budget_max'])) {
            $query->where('budget_total', '<=', $filters['budget_max']);
        }

        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%'.$filters['search'].'%')
                    ->orWhere('description', 'like', '%'.$filters['search'].'%');
            });
        }

        return $query->paginate(12);
    }
}
