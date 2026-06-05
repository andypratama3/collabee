<?php

namespace App\Events;

use App\Models\ChatRoom;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class ChatRoomUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public function __construct(
        public ChatRoom $chatRoom
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.room.' . $this->chatRoom->id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->chatRoom->id,
            'hiring_id' => $this->chatRoom->hiring_id,
            'last_message_at' => $this->chatRoom->last_message_at?->toISOString(),
            'brand_unread' => $this->chatRoom->brand_unread,
            'kol_unread' => $this->chatRoom->kol_unread,
        ];
    }
}
