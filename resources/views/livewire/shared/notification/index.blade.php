<div class="max-w-3xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="p-2.5 bg-gradient-to-br from-primary/20 to-primary/5 dark:from-primary/30 dark:to-primary/10 rounded-xl">
                <svg class="w-6 h-6 text-primary dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">Notifikasi</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    @if($unreadCount > 0)
                        <span class="inline-flex items-center gap-1">
                            <span class="w-2 h-2 bg-primary rounded-full animate-pulse"></span>
                            {{ $unreadCount }} belum dibaca
                        </span>
                    @else
                        Semua notifikasi sudah dibaca
                    @endif
                </p>
            </div>
        </div>
        @if ($unreadCount > 0)
            <button wire:click="markAllAsRead" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-primary to-primary-dark rounded-xl shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-0.5 transition-all duration-300 focus:ring-4 focus:ring-primary/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Tandai semua dibaca
            </button>
        @endif
    </div>

    <!-- Notifications List -->
    <div class="space-y-3">
        @forelse ($notifications as $notification)
            <div class="flex items-start gap-4 p-5 bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-sm border transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg {{ $notification->is_read ? 'border-gray-200 dark:border-gray-700' : 'border-l-4 border-primary-500 border-t border-r border-b border-t-gray-200/50 dark:border-t-gray-700/50 border-r-gray-200/50 dark:border-r-gray-700/50 border-b-gray-200/50 dark:border-b-gray-700/50 bg-primary-50/30 dark:bg-primary-900/10' }}">
                <div class="flex-shrink-0 mt-0.5">
                    <div class="p-2 rounded-xl {{ $notification->is_read ? 'bg-gray-100 dark:bg-gray-700' : 'bg-primary/10 dark:bg-primary-900/30' }}">
                        <svg class="w-4 h-4 {{ $notification->is_read ? 'text-gray-400 dark:text-gray-500' : 'text-primary dark:text-primary-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $notification->title }}</p>
                        @if (!$notification->is_read)
                            <span class="px-2 py-0.5 text-[10px] font-bold text-primary-dark dark:text-primary-300 bg-primary-100 dark:bg-primary-900/50 rounded-lg uppercase tracking-wider">Baru</span>
                        @endif
                    </div>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">{{ $notification->body }}</p>
                    <div class="flex items-center gap-3 mt-2.5">
                        <span class="text-xs text-gray-400 dark:text-gray-500 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                        @if ($notification->action_url)
                            <a href="{{ $notification->action_url }}" class="text-xs font-medium text-primary dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 transition-colors inline-flex items-center gap-1">
                                Lihat Detail
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
                @if (!$notification->is_read)
                    <button wire:click="markAsRead({{ $notification->id }})" class="shrink-0 p-2 text-primary dark:text-primary-400 hover:bg-primary/10 rounded-lg transition-all duration-200" title="Tandai dibaca">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                @endif
            </div>
        @empty
            <div class="p-12 text-center bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700">
                <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-50 dark:from-gray-700 dark:to-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </div>
                <p class="text-base font-semibold text-gray-500 dark:text-gray-400">Tidak ada notifikasi</p>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Anda akan menerima notifikasi saat ada aktivitas baru.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
</div>
