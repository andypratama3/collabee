<?php

namespace App\Livewire\Kol\Chat;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Services\Chat\ChatService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    use AuthorizesRequests;

    public ChatRoom $chatRoom;
    public string $newMessage = '';
    public ?int $offerBudget = null;
    public bool $showOfferForm = false;
    public bool $partnerTyping = false;

    public function mount(ChatRoom $chatRoom): void
    {
        $this->authorize('view', $chatRoom);
    }

    public function render(ChatService $chatService)
    {
        $chatService->markAsRead($this->chatRoom, auth()->user());
        $messages = $chatService->getMessages($this->chatRoom, auth()->user());

        return view('livewire.kol.chat.show', [
            'messages' => $messages,
            'room' => $this->chatRoom->loadMissing('hiring.campaign', 'hiring.brandProfile.user'),
        ])->layout('layouts.app');
    }

    public function sendMessage(ChatService $chatService): void
    {
        $this->validate([
            'newMessage' => 'required|string|max:5000',
        ]);

        $chatService->sendMessage($this->chatRoom, auth()->user(), [
            'body' => $this->newMessage,
            'type' => 'text',
        ]);

        $this->newMessage = '';
        $chatService->broadcastTyping($this->chatRoom, auth()->user(), false);
    }

    public function sendOffer(ChatService $chatService): void
    {
        $this->validate([
            'offerBudget' => 'required|numeric|min:10000',
        ]);

        $chatService->sendMessage($this->chatRoom, auth()->user(), [
            'type' => 'offer',
            'body' => 'Budget offer: Rp ' . number_format($this->offerBudget, 0, ',', '.'),
            'offer_data' => [
                'budget' => $this->offerBudget,
            ],
        ]);

        $this->offerBudget = null;
        $this->showOfferForm = false;
    }

    public function acceptOffer(ChatMessage $message, ChatService $chatService): void
    {
        if ($message->type !== 'offer' || $message->offer_status !== 'pending') {
            return;
        }

        $chatService->handleOfferAccept($message);
    }

    public function rejectOffer(ChatMessage $message, ChatService $chatService): void
    {
        if ($message->type !== 'offer' || $message->offer_status !== 'pending') {
            return;
        }

        $chatService->handleOfferReject($message);
    }

    public function broadcastTyping(ChatService $chatService): void
    {
        $chatService->broadcastTyping($this->chatRoom, auth()->user(), true);
    }

    public function stopTyping(ChatService $chatService): void
    {
        $chatService->broadcastTyping($this->chatRoom, auth()->user(), false);
    }

    public function updatedNewMessage(ChatService $chatService): void
    {
        if (!empty($this->newMessage)) {
            $chatService->broadcastTyping($this->chatRoom, auth()->user(), true);
        }
    }

    #[On('echo:chat.room.{chatRoom.id},MessageSent')]
    public function refreshMessages(): void
    {
        $this->dispatch('$refresh');
    }

    #[On('echo:chat.room.{chatRoom.id},UserTyping')]
    public function onUserTyping($payload): void
    {
        if ($payload['user_id'] === auth()->id()) {
            return;
        }

        $this->partnerTyping = $payload['is_typing'];
    }
}
