<?php

namespace App\Policies;

use App\Models\ChatRoom;
use App\Models\User;

class ChatPolicy
{
    public function view(User $user, ChatRoom $chatRoom): bool
    {
        return $user->id === $chatRoom->brand_user_id
            || $user->id === $chatRoom->kol_user_id
            || $user->isAdmin();
    }

    public function send(User $user, ChatRoom $chatRoom): bool
    {
        return $user->id === $chatRoom->brand_user_id
            || $user->id === $chatRoom->kol_user_id;
    }
}
