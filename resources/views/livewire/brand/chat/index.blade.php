<div>
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Messages</h1>
            <p class="mt-1 text-sm text-gray-500">Chat with KOLs about your campaigns</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @forelse($rooms as $room)
            @php
                $isBrand = auth()->user()->isBrand();
                $otherUser = $isBrand ? $room->hiring?->kolProfile?->user : $room->hiring?->brandProfile?->user;
                $unread = $isBrand ? $room->brand_unread : $room->kol_unread;
                $lastMessage = $room->messages->first();
            @endphp
            <a href="{{ route($isBrand ? 'brand.chat.show' : 'kol.chat.show', $room) }}"
               class="flex items-center px-6 py-4 hover:bg-gray-50 border-b border-gray-100 last:border-b-0 {{ $unread > 0 ? 'bg-indigo-50' : '' }}">
                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm shrink-0">
                    {{ strtoupper(substr($otherUser?->name ?? '?', 0, 2)) }}
                </div>
                <div class="ml-3 flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-900 truncate">{{ $otherUser?->name ?? 'Unknown' }}</span>
                        @if($lastMessage)
                            <span class="text-xs text-gray-400 shrink-0 ml-2">{{ $lastMessage->created_at->diffForHumans() }}</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between mt-0.5">
                        <span class="text-sm text-gray-500 truncate">
                            @if($lastMessage)
                                {{ $lastMessage->type === 'offer' ? 'Sent an offer' : $lastMessage->body }}
                            @else
                                <span class="italic">No messages yet</span>
                            @endif
                        </span>
                        @if($unread > 0)
                            <span class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-indigo-600 rounded-full shrink-0 ml-2">{{ $unread > 99 ? '99+' : $unread }}</span>
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <div class="px-6 py-12 text-center text-gray-500">
                <p class="text-lg font-medium text-gray-400 mb-1">No conversations yet</p>
                <p class="text-sm">Start by hiring a KOL for your campaign</p>
            </div>
        @endforelse
    </div>
</div>
