<?php

namespace App\Livewire\Shared\Notification;

use App\Models\Notification;
use App\Services\Notification\NotificationService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function markAsRead(int $notificationId, NotificationService $notificationService): void
    {
        $notification = Notification::findOrFail($notificationId);
        $notificationService->markAsRead($notification);
    }

    public function markAllAsRead(NotificationService $notificationService): void
    {
        $notificationService->markAllAsRead(auth()->user());
    }

    public function render(NotificationService $notificationService)
    {
        return view('livewire.shared.notification.index', [
            'notifications' => $notificationService->getAllNotifications(auth()->user(), 20),
            'unreadCount' => $notificationService->getUnreadCount(auth()->user()),
        ])->layout('layouts.app');
    }
}
