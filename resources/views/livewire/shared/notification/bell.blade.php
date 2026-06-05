<div x-data="{ open: false }" class="relative">
    <button @@click="open = !open" class="relative p-1 text-gray-500 hover:text-gray-700 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if ($unreadCount > 0)
            <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full min-w-[18px]">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>

    <div x-show="open"
         @@click.away="open = false"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="absolute right-0 z-50 w-80 mt-2 bg-white rounded-lg shadow-lg ring-1 ring-black/5">
        <div class="p-3 border-b">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-900">Notifikasi</h3>
                @if ($unreadCount > 0)
                    <button wire:click="markAllAsRead" class="text-xs text-indigo-600 hover:text-indigo-800">
                        Tandai semua dibaca
                    </button>
                @endif
            </div>
        </div>

        <div class="max-h-80 overflow-y-auto">
            @forelse ($notifications as $notification)
                <div class="flex items-start gap-3 p-3 border-b hover:bg-gray-50 {{ $notification['is_read'] ? '' : 'bg-indigo-50/50' }}">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $notification['title'] }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $notification['body'] }}</p>
                        <p class="mt-1 text-xs text-gray-400">{{ \Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}</p>
                    </div>
                    @if (!$notification['is_read'])
                        <button wire:click="markAsRead({{ $notification['id'] }})" class="shrink-0 text-xs text-indigo-600 hover:text-indigo-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    @endif
                </div>
            @empty
                <div class="p-6 text-center">
                    <p class="text-sm text-gray-500">Tidak ada notifikasi</p>
                </div>
            @endforelse
        </div>

        <a href="{{ route('notifications.index') }}" class="block p-3 text-sm text-center text-indigo-600 border-t hover:bg-gray-50 rounded-b-lg">
            Lihat semua notifikasi
        </a>
    </div>

    <script>
        document.addEventListener('livewire:init', function () {
            window.Echo?.private('user.{{ auth()->id() }}')
                .listen('.NewNotification', function (e) {
                    Livewire.dispatch('notification-received');
                });
        });
    </script>
</div>
