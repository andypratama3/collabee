<?php

namespace App\Livewire\Brand\Chat;

use App\Services\Chat\ChatService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Index extends Component
{
    use AuthorizesRequests;

    public function render(ChatService $chatService)
    {
        $rooms = $chatService->getChatRooms(auth()->user());

        return view('livewire.brand.chat.index', [
            'rooms' => $rooms,
            'unreadCount' => $chatService->getUnreadCount(auth()->user()),
        ])->layout('layouts.app');
    }
}
