<?php

namespace App\Events;

use App\Models\Content;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class ContentUploaded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public function __construct(
        public Content $content
    ) {}

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('agreement.' . $this->content->agreement_id);
    }

    public function broadcastWith(): array
    {
        return [
            'content_id' => $this->content->id,
            'agreement_id' => $this->content->agreement_id,
            'status' => $this->content->status,
        ];
    }
}
