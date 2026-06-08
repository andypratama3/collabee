<?php

namespace App\Policies;

use App\Models\Content;
use App\Models\User;

class ContentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Content $content): bool
    {
        if ($user->isAdmin()) return true;

        $brandUserId = $content->brandProfile?->user_id;
        $kolUserId   = $content->kolProfile?->user_id;

        return ($brandUserId && $brandUserId === $user->id)
            || ($kolUserId   && $kolUserId   === $user->id);
    }

    public function create(User $user): bool
    {
        return $user->isKol();
    }

    public function update(User $user, Content $content): bool
    {
        return $user->isKol()
            && ($content->kolProfile?->user_id === $user->id);
    }

    public function review(User $user, Content $content): bool
    {
        return $content->brandProfile?->user_id === $user->id;
    }

    public function delete(User $user, Content $content): bool
    {
        return $user->isAdmin();
    }
}
