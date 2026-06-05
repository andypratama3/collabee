<?php

use App\Models\Agreement;
use App\Models\ChatRoom;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('chat.room.{chatRoom}', function ($user, ChatRoom $chatRoom) {
    return $user->id === $chatRoom->brand_user_id
        || $user->id === $chatRoom->kol_user_id;
});

Broadcast::channel('agreement.{agreement}', function ($user, Agreement $agreement) {
    return $user->id === $agreement->hiring->brandProfile->user_id
        || $user->id === $agreement->hiring->kolProfile->user_id;
});
