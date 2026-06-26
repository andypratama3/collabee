<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class UserTyping implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public function __construct(
        public int $userId,
        public string $userName,
        public int $chatRoomId,
        public bool $isTyping
    ) {}

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('chat.room.'.$this->chatRoomId);
    }

    public function broadcastWith(): array
    {
        return [
            'user_id' => $this->userId,
            'user_name' => $this->userName,
            'chat_room_id' => $this->chatRoomId,
            'is_typing' => $this->isTyping,
        ];
    }
}
