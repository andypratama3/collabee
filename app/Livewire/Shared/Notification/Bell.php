<?php

namespace App\Livewire\Shared\Notification;

use App\Models\Notification;
use App\Services\Notification\NotificationService;
use Livewire\Component;

class Bell extends Component
{
    public int $unreadCount = 0;

    public $notifications = [];

    protected $listeners = ['notification-received' => 'refreshNotifications'];

    public function mount(NotificationService $notificationService): void
    {
        $user = auth()->user();
        if ($user) {
            $this->unreadCount = $notificationService->getUnreadCount($user);
            $this->notifications = $notificationService->getUnreadNotifications($user, 5)->toArray();
        }
    }

    public function refreshNotifications(NotificationService $notificationService): void
    {
        $user = auth()->user();
        if ($user) {
            $this->unreadCount = $notificationService->getUnreadCount($user);
            $this->notifications = $notificationService->getUnreadNotifications($user, 5)->toArray();
        }
    }

    public function markAsRead(int $notificationId, NotificationService $notificationService): void
    {
        $notification = Notification::findOrFail($notificationId);
        $notificationService->markAsRead($notification);
        $this->refreshNotifications($notificationService);
    }

    public function markAllAsRead(NotificationService $notificationService): void
    {
        $notificationService->markAllAsRead(auth()->user());
        $this->refreshNotifications($notificationService);
    }

    public function render()
    {
        return view('livewire.shared.notification.bell');
    }
}
