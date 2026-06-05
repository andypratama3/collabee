<?php

namespace App\Services\Chat;

use App\Enums\HiringStatus;
use App\Events\MessageSent;
use App\Events\ChatRoomUpdated;
use App\Events\UserTyping;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\Hiring;
use App\Models\User;
use App\Services\Campaign\AgreementService;
use Illuminate\Support\Facades\DB;

class ChatService
{
    public function createRoom(Hiring $hiring): ChatRoom
    {
        return DB::transaction(function () use ($hiring) {
            $existing = ChatRoom::where('hiring_id', $hiring->id)->first();
            if ($existing) {
                return $existing;
            }

            $campaign = $hiring->campaign;
            $brandUser = $campaign->brandProfile->user;
            $kolUser = $hiring->kolProfile->user;

            return ChatRoom::create([
                'hiring_id' => $hiring->id,
                'brand_user_id' => $brandUser->id,
                'kol_user_id' => $kolUser->id,
            ]);
        });
    }

    public function sendMessage(ChatRoom $chatRoom, User $sender, array $data): ChatMessage
    {
        return DB::transaction(function () use ($chatRoom, $sender, $data) {
            $message = ChatMessage::create([
                'chat_room_id' => $chatRoom->id,
                'sender_id' => $sender->id,
                'body' => $data['body'] ?? null,
                'type' => $data['type'] ?? 'text',
                'attachments' => $data['attachments'] ?? null,
                'offer_data' => $data['offer_data'] ?? null,
                'offer_status' => $data['type'] === 'offer' ? 'pending' : null,
                'is_read' => false,
            ]);

            $chatRoom->update([
                'last_message_at' => now(),
            ]);

            if ($sender->id === $chatRoom->brand_user_id) {
                $chatRoom->increment('kol_unread');
            } else {
                $chatRoom->increment('brand_unread');
            }

            broadcast(new MessageSent($message))->toOthers();
            broadcast(new ChatRoomUpdated($chatRoom))->toOthers();

            return $message->fresh()->load('sender');
        });
    }

    public function broadcastTyping(ChatRoom $chatRoom, User $user, bool $isTyping): void
    {
        broadcast(new UserTyping(
            userId: $user->id,
            userName: $user->name,
            chatRoomId: $chatRoom->id,
            isTyping: $isTyping,
        ))->toOthers();
    }

    public function markAsRead(ChatRoom $chatRoom, User $user): void
    {
        if ($user->id === $chatRoom->brand_user_id) {
            $chatRoom->update(['brand_unread' => 0]);
        } elseif ($user->id === $chatRoom->kol_user_id) {
            $chatRoom->update(['kol_unread' => 0]);
        }

        ChatMessage::where('chat_room_id', $chatRoom->id)
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    public function getChatRooms(User $user, array $filters = [])
    {
        $query = ChatRoom::with([
            'hiring.campaign',
            'hiring.kolProfile.user',
            'hiring.brandProfile.user',
            'messages' => function ($q) {
                $q->latest()->limit(1);
            },
        ]);

        if ($user->isBrand()) {
            $query->where('brand_user_id', $user->id);
        } else {
            $query->where('kol_user_id', $user->id);
        }

        return $query->orderBy('last_message_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getMessages(ChatRoom $chatRoom, User $user, int $limit = 50, ?int $beforeId = null)
    {
        $query = ChatMessage::where('chat_room_id', $chatRoom->id)
            ->with('sender');

        if ($beforeId) {
            $query->where('id', '<', $beforeId);
        }

        return $query->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->reverse();
    }

    public function handleOfferAccept(ChatMessage $message): ChatMessage
    {
        return DB::transaction(function () use ($message) {
            $message->update([
                'offer_status' => 'accepted',
            ]);

            $hiring = $message->chatRoom->hiring;
            $offerData = $message->offer_data;

            if ($hiring && $offerData) {
                $hiring->update([
                    'status' => HiringStatus::NEGOTIATING,
                    'agreed_budget' => $offerData['budget'] ?? $hiring->agreed_budget,
                ]);
            }

            $agreementService = app(AgreementService::class);
            $agreementService->generate($hiring);

            $systemMessage = ChatMessage::create([
                'chat_room_id' => $message->chat_room_id,
                'sender_id' => $message->sender_id,
                'body' => 'Offer accepted',
                'type' => 'system',
                'is_read' => false,
            ]);

            broadcast(new MessageSent($systemMessage))->toOthers();

            return $message->fresh();
        });
    }

    public function handleOfferReject(ChatMessage $message): ChatMessage
    {
        return DB::transaction(function () use ($message) {
            $message->update([
                'offer_status' => 'rejected',
            ]);

            $systemMessage = ChatMessage::create([
                'chat_room_id' => $message->chat_room_id,
                'sender_id' => $message->sender_id,
                'body' => 'Offer declined',
                'type' => 'system',
                'is_read' => false,
            ]);

            broadcast(new MessageSent($systemMessage))->toOthers();

            return $message->fresh();
        });
    }

    public function getUnreadCount(User $user): int
    {
        if ($user->isBrand()) {
            return ChatRoom::where('brand_user_id', $user->id)
                ->where('brand_unread', '>', 0)
                ->count();
        }

        return ChatRoom::where('kol_user_id', $user->id)
            ->where('kol_unread', '>', 0)
            ->count();
    }
}
