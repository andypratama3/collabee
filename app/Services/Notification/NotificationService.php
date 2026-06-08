<?php

namespace App\Services\Notification;

use App\Events\NewNotification;
use App\Mail\ContentReminderMail;
use App\Mail\HiringNotificationMail;
use App\Mail\PaymentConfirmationMail;
use App\Mail\WelcomeMail;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    private function getMailableForType(string $type, ?array $data = []): ?\Illuminate\Mail\Mailable
    {
        return match ($type) {
            'welcome' => isset($data['user']) ? new WelcomeMail($data['user']) : null,
            'hiring' => isset($data['hiring']) && $data['hiring'] instanceof \App\Models\Hiring ? new HiringNotificationMail($data['hiring']) : null,
            'payment' => isset($data['payment']) ? new PaymentConfirmationMail($data['payment']) : null,
            'content_reminder' => isset($data['content']) ? new ContentReminderMail($data['content']) : null,
            default => null,
        };
    }

    public function send(User $user, string $type, string $title, string $body, ?array $data = [], ?string $actionUrl = null): Notification
    {
        $notification = DB::transaction(function () use ($user, $type, $title, $body, $data, $actionUrl) {
            return Notification::create([
                'user_id' => $user->id,
                'type' => $type,
                'title' => $title,
                'body' => $body,
                'data' => $data,
                'action_url' => $actionUrl,
                'is_read' => false,
            ]);
        });

        broadcast(new NewNotification($notification));

        $mailable = $this->getMailableForType($type, $data);
        if ($mailable) {
            Mail::to($user->email)->queue($mailable);
        }

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
