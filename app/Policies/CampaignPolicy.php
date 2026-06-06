<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\User;

class CampaignPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Campaign $campaign): bool
    {
        if (!$user) {
            return $campaign->status === \App\Enums\CampaignStatus::OPEN;
        }

        return $user->isAdmin()
            || $campaign->brandProfile->user_id === $user->id
            || $user->isKol();
    }

    public function create(User $user): bool
    {
        return $user->isBrand();
    }

    public function update(User $user, Campaign $campaign): bool
    {
        return $user->isAdmin()
            || $campaign->brandProfile->user_id === $user->id;
    }

    public function delete(User $user, Campaign $campaign): bool
    {
        return $user->isAdmin()
            || $campaign->brandProfile->user_id === $user->id;
    }

    public function feature(User $user): bool
    {
        return $user->isAdmin();
    }

    public function suspend(User $user): bool
    {
        return $user->isAdmin();
    }
}
