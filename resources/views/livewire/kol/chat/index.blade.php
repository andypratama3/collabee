<div>
    <!-- Page Header -->
    <div class="relative mb-8">
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-primary/5 dark:bg-primary/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-indigo-500/5 dark:bg-indigo-500/10 rounded-full blur-3xl"></div>
        </div>
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 via-gray-800 to-gray-600 dark:from-white dark:via-gray-100 dark:to-gray-300 bg-clip-text text-transparent">Messages</h1>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Chat with brands about collaborations</p>
            </div>
        </div>
    </div>

    <!-- Chat List -->
    <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
        @forelse($rooms as $room)
            @php
                $isBrand = auth()->user()->isBrand();
                $otherUser = $isBrand ? $room->hiring?->kolProfile?->user : $room->hiring?->brandProfile?->user;
                $unread = $isBrand ? $room->brand_unread : $room->kol_unread;
                $lastMessage = $room->messages->first();
            @endphp
            <a href="{{ route($isBrand ? 'brand.chat.show' : 'kol.chat.show', $room) }}"
               class="group flex items-center px-5 sm:px-6 py-4 hover:bg-gray-50/80 dark:hover:bg-gray-700/40 border-b border-gray-100/80 dark:border-gray-700 last:border-b-0 transition-all duration-300 {{ $unread > 0 ? 'bg-primary-50/50 dark:bg-primary-900/10' : '' }}">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-primary/20 to-primary/10 dark:from-primary/30 dark:to-primary/15 flex items-center justify-center text-primary dark:text-primary-400 font-bold text-sm shrink-0 ring-1 ring-primary/10 dark:ring-primary/20 group-hover:shadow-md group-hover:shadow-primary/10 transition-all duration-300">
                    {{ strtoupper(substr($otherUser?->name ?? '?', 0, 2)) }}
                </div>
                <div class="ml-4 flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-gray-900 dark:text-white truncate group-hover:text-primary dark:group-hover:text-primary-400 transition-colors duration-300">{{ $otherUser?->name ?? 'Unknown' }}</span>
                        @if($lastMessage)
                            <span class="text-xs text-gray-400 dark:text-gray-500 shrink-0 ml-2">{{ $lastMessage->created_at->diffForHumans() }}</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between mt-1">
                        <span class="text-sm text-gray-500 dark:text-gray-400 truncate">
                            @if($lastMessage)
                                {{ $lastMessage->type === 'offer' ? 'Sent an offer' : $lastMessage->body }}
                            @else
                                <span class="italic text-gray-400 dark:text-gray-500">No messages yet</span>
                            @endif
                        </span>
                        @if($unread > 0)
                            <span class="inline-flex items-center justify-center min-w-[22px] h-[22px] px-1.5 text-xs font-bold text-white bg-gradient-to-r from-primary to-primary-dark rounded-full shrink-0 ml-2 shadow-sm shadow-primary/30 animate-pulse">{{ $unread > 99 ? '99+' : $unread }}</span>
                        @endif
                    </div>
                </div>
                <!-- Hover arrow indicator -->
                <svg class="w-5 h-5 text-gray-300 dark:text-gray-600 shrink-0 ml-2 opacity-0 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        @empty
            <x-empty-state icon="message" title="No conversations yet" description="Accept a hiring invitation to start chatting" />
        @endforelse
    </div>
</div>
