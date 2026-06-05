<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Notification;
use App\Services\Notification\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(
        private readonly NotificationService $notificationService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $perPage = min((int) $request->per_page, 50) ?: 20;

        $notifications = $this->notificationService->getAllNotifications($user, $perPage);

        return ApiResponse::paginated($notifications, 'Notifikasi berhasil diambil.');
    }

    public function read(Request $request, Notification $notification): JsonResponse
    {
        $user = $request->user();

        if ($notification->user_id !== $user->id) {
            return ApiResponse::error('Anda tidak memiliki akses ke notifikasi ini.', 403);
        }

        $this->notificationService->markAsRead($notification);

        return ApiResponse::success($notification->fresh(), 'Notifikasi ditandai sudah dibaca.');
    }

    public function readAll(Request $request): JsonResponse
    {
        $this->notificationService->markAllAsRead($request->user());

        return ApiResponse::success(null, 'Semua notifikasi ditandai sudah dibaca.');
    }
}
