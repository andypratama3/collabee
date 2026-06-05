<?php

use App\Models\ChatRoom;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.room.{chatRoom}', function ($user, ChatRoom $chatRoom) {
    return $user->id === $chatRoom->brand_user_id
        || $user->id === $chatRoom->kol_user_id;
});
