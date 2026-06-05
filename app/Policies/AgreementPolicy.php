<?php

namespace App\Policies;

use App\Models\Agreement;
use App\Models\User;

class AgreementPolicy
{
    public function view(User $user, Agreement $agreement): bool
    {
        return $user->isAdmin()
            || $agreement->hiring->brandProfile->user_id === $user->id
            || $agreement->hiring->kolProfile->user_id === $user->id;
    }

    public function sign(User $user, Agreement $agreement): bool
    {
        return $agreement->hiring->brandProfile->user_id === $user->id
            || $agreement->hiring->kolProfile->user_id === $user->id;
    }
}
