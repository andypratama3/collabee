<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Services\Chat\ChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct(
        private readonly ChatService $chatService,
    ) {}

    public function rooms(Request $request): JsonResponse
    {
        $rooms = $this->chatService->getChatRooms($request->user());

        return ApiResponse::success($rooms, 'Daftar ruang chat berhasil diambil.');
    }

    public function messages(Request $request, ChatRoom $chatRoom): JsonResponse
    {
        $user = $request->user();

        if ($user->id !== $chatRoom->brand_user_id && $user->id !== $chatRoom->kol_user_id) {
            return ApiResponse::error('Anda tidak memiliki akses ke ruang chat ini.', 403);
        }

        $perPage = min((int) $request->per_page, 100) ?: 50;
        $messages = ChatMessage::where('chat_room_id', $chatRoom->id)
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $this->chatService->markAsRead($chatRoom, $user);

        $messages->getCollection();

        return ApiResponse::paginated($messages, 'Pesan berhasil diambil.');
    }

    public function send(Request $request, ChatRoom $chatRoom): JsonResponse
    {
        $user = $request->user();

        if ($user->id !== $chatRoom->brand_user_id && $user->id !== $chatRoom->kol_user_id) {
            return ApiResponse::error('Anda tidak memiliki akses ke ruang chat ini.', 403);
        }

        $validated = $request->validate([
            'body' => 'required_without:attachments|string|max:5000',
            'type' => 'nullable|string|in:text,image,file,offer',
            'attachments' => 'nullable|array',
            'attachments.*' => 'string',
            'offer_data' => 'nullable|array',
        ]);

        $message = $this->chatService->sendMessage($chatRoom, $user, $validated);

        return ApiResponse::success($message, 'Pesan berhasil dikirim.', 201);
    }
}
