<div>
    <div class="mb-4">
        <a href="{{ route('brand.chat.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">&larr; Back to Messages</a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col h-[calc(100vh-12rem)]">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-3 shrink-0">
            <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-sm">
                {{ strtoupper(substr($room->hiring?->kolProfile?->user?->name ?? '?', 0, 2)) }}
            </div>
            <div class="min-w-0">
                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $room->hiring?->kolProfile?->user?->name ?? 'Unknown KOL' }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">Campaign: {{ $room->hiring?->campaign?->title ?? 'N/A' }}</p>
            </div>
            <div class="ml-auto flex items-center gap-2 shrink-0">
                <span class="px-2 py-0.5 text-xs font-medium rounded-full
                    @if($room->hiring?->status->value === 'accepted') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                    @elseif($room->hiring?->status->value === 'negotiating') bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400
                    @else bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300
                    @endif">
                    {{ ucfirst($room->hiring?->status->value ?? 'unknown') }}
                </span>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-4" x-data x-init="$el.scrollTop = $el.scrollHeight" wire:poll.5000ms>
            @forelse($messages as $message)
                @php $isMine = $message->sender_id === auth()->id(); @endphp
                <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[85%] sm:max-w-[75%] {{ $isMine ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100' }} rounded-2xl px-4 py-2.5">
                        @if($message->type === 'system')
                            <p class="text-sm italic {{ $isMine ? 'text-indigo-200' : 'text-gray-500 dark:text-gray-400' }}">{{ $message->body }}</p>
                        @elseif($message->type === 'offer')
                            <p class="text-sm font-medium mb-1">Budget Offer</p>
                            <p class="text-sm">{{ $message->body }}</p>
                            @if($message->offer_status === 'pending' && !$isMine)
                                <div class="flex gap-2 mt-3">
                                    <button wire:click="acceptOffer({{ $message->id }})"
                                            class="px-3 py-1 text-xs font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">Accept</button>
                                    <button wire:click="rejectOffer({{ $message->id }})"
                                            class="px-3 py-1 text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-500">Decline</button>
                                </div>
                            @elseif($message->offer_status === 'accepted')
                                <span class="inline-block mt-1 text-xs font-medium {{ $isMine ? 'text-indigo-200' : 'text-green-600 dark:text-green-400' }}">Accepted</span>
                            @elseif($message->offer_status === 'rejected')
                                <span class="inline-block mt-1 text-xs font-medium {{ $isMine ? 'text-indigo-200' : 'text-red-600 dark:text-red-400' }}">Declined</span>
                            @endif
                        @else
                            <p class="text-sm whitespace-pre-wrap">{{ $message->body }}</p>
                        @endif
                        <p class="text-xs {{ $isMine ? 'text-indigo-200' : 'text-gray-400 dark:text-gray-500' }} mt-1 text-right">
                            {{ $message->created_at->format('H:i') }}
                            @if($isMine && $message->is_read)
                                <span class="ml-1">&#10003;&#10003;</span>
                            @endif
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 dark:text-gray-500 py-12">
                    <p>No messages yet. Start the conversation!</p>
                </div>
            @endforelse

            @if($partnerTyping)
                <div class="flex justify-start">
                    <div class="bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-2xl px-4 py-2.5 text-sm italic flex items-center gap-2">
                        <span class="flex gap-1">
                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0s"></span>
                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.15s"></span>
                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.3s"></span>
                        </span>
                        typing...
                    </div>
                </div>
            @endif
        </div>

        <div class="px-4 sm:px-6 py-4 border-t border-gray-200 dark:border-gray-700 shrink-0">
            @if($showOfferForm)
                <form wire:submit="sendOffer" class="mb-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Send Budget Offer</label>
                    <div class="flex gap-2">
                        <input type="number" wire:model="offerBudget" placeholder="Amount (Rp)"
                               class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">Send</button>
                        <button type="button" wire:click="$set('showOfferForm', false)" class="px-3 py-2 text-sm text-gray-600 dark:text-gray-400 bg-gray-200 dark:bg-gray-700 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">Cancel</button>
                    </div>
                    @error('offerBudget') <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
                </form>
            @endif

            <div class="flex gap-2">
                <input type="text" wire:model="newMessage" wire:keydown.enter="sendMessage"
                       placeholder="Type your message..."
                       class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500"
                       x-data
                       x-on:keydown="$wire.broadcastTyping()"
                       x-on:keyup.debounce.2000ms="$wire.stopTyping()">
                <button wire:click="$set('showOfferForm', true)"
                        class="px-3 py-2.5 text-sm font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/50 shrink-0">
                    Offer
                </button>
                <button wire:click="sendMessage"
                        class="px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shrink-0">
                    Send
                </button>
            </div>
            @error('newMessage') <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>
</div>
