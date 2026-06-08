<?php

namespace App\Policies;

use App\Models\Hiring;
use App\Models\User;

class HiringPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Hiring $hiring): bool
    {
        if ($user->isAdmin()) return true;

        return $hiring->brandProfile?->user_id === $user->id
            || $hiring->kolProfile?->user_id  === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isBrand();
    }

    public function apply(User $user): bool
    {
        return $user->isKol();
    }

    public function update(User $user, Hiring $hiring): bool
    {
        return $user->isAdmin()
            || $hiring->brandProfile?->user_id === $user->id;
    }

    public function cancel(User $user, Hiring $hiring): bool
    {
        return $user->isAdmin()
            || $hiring->brandProfile?->user_id === $user->id
            || $hiring->kolProfile?->user_id   === $user->id;
    }
}
