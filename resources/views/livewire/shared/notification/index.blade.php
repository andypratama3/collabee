<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Notifikasi</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $unreadCount }} belum dibaca</p>
        </div>
        @if ($unreadCount > 0)
            <button wire:click="markAllAsRead" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                Tandai semua dibaca
            </button>
        @endif
    </div>

    <div class="space-y-2">
        @forelse ($notifications as $notification)
            <div class="flex items-start gap-4 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm {{ $notification->is_read ? '' : 'border-l-4 border-indigo-500' }}">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $notification->title }}</p>
                        @if (!$notification->is_read)
                            <span class="px-1.5 py-0.5 text-xs font-medium text-indigo-700 dark:text-indigo-300 bg-indigo-100 dark:bg-indigo-900/50 rounded-full">Baru</span>
                        @endif
                    </div>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $notification->body }}</p>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-xs text-gray-400 dark:text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                        @if ($notification->action_url)
                            <a href="{{ $notification->action_url }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-800">Lihat Detail</a>
                        @endif
                    </div>
                </div>
                @if (!$notification->is_read)
                    <button wire:click="markAsRead({{ $notification->id }})" class="shrink-0 text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-800">
                        Tandai dibaca
                    </button>
                @endif
            </div>
        @empty
            <div class="p-8 text-center bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                <x-empty-state icon="bell" title="Tidak ada notifikasi" />
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
</div>
