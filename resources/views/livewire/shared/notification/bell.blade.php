<div x-data="{ open: false }" class="relative">
    <button @@click="open = !open" class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all duration-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if ($unreadCount > 0)
            <span class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold text-white bg-red-500 rounded-full min-w-[18px] ring-2 ring-white dark:ring-gray-900 animate-pulse">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>

    <div x-show="open"
         @@click.away="open = false"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-1 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-1 scale-95"
          class="absolute right-0 z-50 w-80 mt-2 bg-white/95 dark:bg-gray-800/95 backdrop-blur-xl rounded-2xl shadow-xl shadow-gray-200/30 dark:shadow-gray-900/50 ring-1 ring-gray-200/50 dark:ring-gray-700/50 border border-gray-200/30 dark:border-gray-700/30 overflow-hidden">
        <div class="p-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-gray-50/80 to-white/80 dark:from-gray-800/80 dark:to-gray-800/50">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100">Notifikasi</h3>
                @if ($unreadCount > 0)
                    <button wire:click="markAllAsRead" class="text-xs font-medium text-primary dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 transition-colors duration-200">
                        Tandai semua dibaca
                    </button>
                @endif
            </div>
        </div>

        <div class="max-h-80 overflow-y-auto">
            @forelse ($notifications as $notification)
                <div class="flex items-start gap-3 p-3.5 border-b border-gray-50 dark:border-gray-700/30 hover:bg-gray-50/80 dark:hover:bg-gray-700/30 transition-colors duration-200 {{ $notification['is_read'] ? '' : 'bg-primary-50/30 dark:bg-primary-900/10' }}">
                    <div class="flex-shrink-0 mt-0.5">
                        <div class="w-2 h-2 rounded-full mt-1.5 {{ $notification['is_read'] ? 'bg-gray-200 dark:bg-gray-600' : 'bg-primary animate-pulse' }}"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $notification['title'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5">{{ $notification['body'] }}</p>
                        <p class="mt-1.5 text-[10px] text-gray-400 dark:text-gray-500 font-medium">{{ \Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}</p>
                    </div>
                    @if (!$notification['is_read'])
                        <button wire:click="markAsRead({{ $notification['id'] }})" class="shrink-0 p-1.5 text-primary dark:text-primary-400 hover:bg-primary/10 rounded-lg transition-all duration-200" title="Tandai dibaca">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    @endif
                </div>
            @empty
                <div class="p-8 text-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-gray-100 to-gray-50 dark:from-gray-700 dark:to-gray-800 rounded-xl flex items-center justify-center mx-auto mb-2">
                        <svg class="w-5 h-5 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Tidak ada notifikasi</p>
                </div>
            @endforelse
        </div>

        <a href="{{ route('notifications.index') }}" class="flex items-center justify-center gap-1.5 p-3 text-sm font-medium text-primary dark:text-primary-400 border-t border-gray-100 dark:border-gray-700 hover:bg-gray-50/80 dark:hover:bg-gray-700/30 rounded-b-2xl transition-colors duration-200">
            Lihat semua notifikasi
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
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
