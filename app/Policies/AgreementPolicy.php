<?php

namespace App\Policies;

use App\Models\Agreement;
use App\Models\User;

class AgreementPolicy
{
    public function view(User $user, Agreement $agreement): bool
    {
        if ($user->isAdmin()) return true;

        $hiring = $agreement->hiring;
        if (! $hiring) return false;

        return $hiring->brandProfile?->user_id === $user->id
            || $hiring->kolProfile?->user_id  === $user->id;
    }

    public function sign(User $user, Agreement $agreement): bool
    {
        $hiring = $agreement->hiring;
        if (! $hiring) return false;

        return $hiring->brandProfile?->user_id === $user->id
            || $hiring->kolProfile?->user_id  === $user->id;
    }
}
