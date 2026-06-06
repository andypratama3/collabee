<div class="space-y-8">
    {{-- Page Header --}}
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-900 via-gray-800 to-gray-600 dark:from-white dark:via-gray-200 dark:to-gray-400">Messages</h1>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Chat with KOLs about your campaigns</p>
        </div>
    </div>

    {{-- Conversations List --}}
    <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
        @forelse($rooms as $room)
            @php
                $isBrand = auth()->user()->isBrand();
                $otherUser = $isBrand ? $room->hiring?->kolProfile?->user : $room->hiring?->brandProfile?->user;
                $unread = $isBrand ? $room->brand_unread : $room->kol_unread;
                $lastMessage = $room->messages->first();
            @endphp
            <a href="{{ route($isBrand ? 'brand.chat.show' : 'kol.chat.show', $room) }}"
               class="group flex items-center px-5 sm:px-6 py-4 border-b border-gray-100/80 dark:border-gray-700 last:border-b-0 transition-all duration-300
               {{ $unread > 0 ? 'bg-primary/[0.03] dark:bg-primary/[0.08] hover:bg-primary/[0.06] dark:hover:bg-primary/[0.12]' : 'hover:bg-gray-50/80 dark:hover:bg-gray-700/30' }}">
                {{-- Avatar --}}
                <div class="relative flex-shrink-0">
                    <div class="w-11 h-11 rounded-full bg-gradient-to-br from-primary/20 via-primary/10 to-purple-500/20 dark:from-primary/30 dark:via-primary/15 dark:to-purple-500/30 flex items-center justify-center text-primary dark:text-primary-400 font-bold text-sm ring-2 ring-primary/10 dark:ring-primary/20 transition-all duration-300 group-hover:ring-primary/30 group-hover:shadow-md group-hover:shadow-primary/10">
                        {{ strtoupper(substr($otherUser?->name ?? '?', 0, 2)) }}
                    </div>
                    @if($unread > 0)
                        <span class="absolute -top-0.5 -right-0.5 w-3 h-3 bg-primary rounded-full border-2 border-white dark:border-gray-800 animate-pulse"></span>
                    @endif
                </div>
                {{-- Content --}}
                <div class="ml-4 flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold truncate transition-colors duration-200 {{ $unread > 0 ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-200 group-hover:text-gray-900 dark:group-hover:text-white' }}">{{ $otherUser?->name ?? 'Unknown' }}</span>
                        @if($lastMessage)
                            <span class="text-xs shrink-0 ml-3 {{ $unread > 0 ? 'text-primary dark:text-primary-400 font-semibold' : 'text-gray-400 dark:text-gray-500' }}">{{ $lastMessage->created_at->diffForHumans() }}</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between mt-1">
                        <span class="text-sm truncate {{ $unread > 0 ? 'text-gray-700 dark:text-gray-300 font-medium' : 'text-gray-500 dark:text-gray-400' }}">
                            @if($lastMessage)
                                @if($lastMessage->type === 'offer')
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        Sent an offer
                                    </span>
                                @else
                                    {{ $lastMessage->body }}
                                @endif
                            @else
                                <span class="italic text-gray-400 dark:text-gray-500">No messages yet</span>
                            @endif
                        </span>
                        @if($unread > 0)
                            <span class="inline-flex items-center justify-center min-w-[1.25rem] h-5 px-1.5 text-xs font-bold text-white bg-gradient-to-r from-primary to-primary-dark rounded-full shrink-0 ml-3 shadow-sm shadow-primary/25">{{ $unread > 99 ? '99+' : $unread }}</span>
                        @endif
                    </div>
                </div>
                {{-- Chevron --}}
                <svg class="w-4 h-4 ml-2 text-gray-300 dark:text-gray-600 group-hover:text-gray-400 dark:group-hover:text-gray-500 transition-all duration-200 group-hover:translate-x-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        @empty
            <div class="py-16">
                <x-empty-state icon="message" title="No conversations yet" description="Start by hiring a KOL for your campaign" />
            </div>
        @endforelse
    </div>
</div>
