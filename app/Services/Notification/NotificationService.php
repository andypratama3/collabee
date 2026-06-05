<?php

namespace App\Services\Notification;

use App\Events\NewNotification;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    public function send(User $user, string $type, string $title, string $body, ?array $data = []): Notification
    {
        $notification = DB::transaction(function () use ($user, $type, $title, $body, $data) {
            return Notification::create([
                'user_id' => $user->id,
                'type' => $type,
                'title' => $title,
                'body' => $body,
                'data' => $data,
                'is_read' => false,
            ]);
        });

        broadcast(new NewNotification($notification));

        return $notification;
    }

    public function markAsRead(Notification $notification): void
    {
        DB::transaction(function () use ($notification) {
            $notification->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        });
    }

    public function markAllAsRead(User $user): void
    {
        DB::transaction(function () use ($user) {
            Notification::where('user_id', $user->id)
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => now(),
                ]);
        });
    }

    public function getUnreadNotifications(User $user, int $limit = 10): Collection
    {
        return Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getAllNotifications(User $user, int $perPage = 20): Paginator
    {
        return Notification::where('user_id', $user->id)
            ->latest()
            ->paginate($perPage);
    }

    public function getUnreadCount(User $user): int
    {
        return Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();
    }
}
