<div>
    <!-- Back Navigation -->
    <div class="mb-5">
        <a href="{{ route('kol.chat.index') }}" class="inline-flex items-center gap-1.5 text-sm text-primary dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 font-medium transition-colors duration-200 group">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Messages
        </a>
    </div>

    <!-- Chat Container -->
    <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col h-[calc(100vh-12rem)]">
        <!-- Chat Header -->
        <div class="px-5 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-3 shrink-0 bg-white dark:bg-gray-800/60 backdrop-blur-lg">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-primary/20 to-primary/10 dark:from-primary/30 dark:to-primary/15 flex items-center justify-center text-primary dark:text-primary-400 font-bold text-sm ring-1 ring-primary/10 dark:ring-primary/20">
                {{ strtoupper(substr($room->hiring?->brandProfile?->user?->name ?? '?', 0, 2)) }}
            </div>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $room->hiring?->brandProfile?->user?->name ?? 'Unknown Brand' }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">Campaign: {{ $room->hiring?->campaign?->title ?? 'N/A' }}</p>
            </div>
            <div class="ml-auto flex items-center gap-2 shrink-0">
                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg
                    @if($room->hiring?->status->value === 'accepted') bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400 ring-1 ring-emerald-200/50 dark:ring-emerald-700/30
                    @elseif($room->hiring?->status->value === 'negotiating') bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400 ring-1 ring-amber-200/50 dark:ring-amber-700/30
                    @else bg-gray-100 text-gray-600 dark:bg-gray-700/50 dark:text-gray-300 ring-1 ring-gray-200/50 dark:ring-gray-600/30
                    @endif">
                    {{ ucfirst($room->hiring?->status->value ?? 'unknown') }}
                </span>
            </div>
        </div>

        <!-- Messages Area -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-4 bg-gradient-to-b from-gray-50/50 to-white/30 dark:from-gray-900/30 dark:to-gray-800/30" x-data x-init="$el.scrollTop = $el.scrollHeight" wire:poll.5000ms>
            @forelse($messages as $message)
                @php $isMine = $message->sender_id === auth()->id(); @endphp
                <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[85%] sm:max-w-[75%] {{ $isMine ? 'bg-gradient-to-br from-primary to-primary-dark text-white shadow-lg shadow-primary/15' : 'bg-white dark:bg-gray-700/80 text-gray-900 dark:text-gray-100 shadow-md shadow-gray-200/30 dark:shadow-gray-900/20 border border-gray-100/50 dark:border-gray-600/30' }} rounded-2xl px-4 py-3 transition-all duration-200">
                        @if($message->type === 'system')
                            <p class="text-sm italic {{ $isMine ? 'text-primary-200' : 'text-gray-500 dark:text-gray-400' }}">{{ $message->body }}</p>
                        @elseif($message->type === 'offer')
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4 {{ $isMine ? 'text-primary-200' : 'text-primary dark:text-primary-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-sm font-semibold">Budget Offer</p>
                            </div>
                            <p class="text-sm">{{ $message->body }}</p>
                            @if($message->offer_status === 'pending' && !$isMine)
                                <div class="flex gap-2 mt-3 pt-2 border-t border-gray-200/30 dark:border-gray-600/30">
                                    <button wire:click="acceptOffer({{ $message->id }})"
                                            class="px-3.5 py-1.5 text-xs font-medium text-white bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-lg hover:from-emerald-600 hover:to-emerald-700 shadow-sm transition-all duration-200">Accept</button>
                                    <button wire:click="rejectOffer({{ $message->id }})"
                                            class="px-3.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-300 bg-white/80 dark:bg-gray-600/80 border border-gray-200 dark:border-gray-500 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-500 transition-all duration-200">Decline</button>
                                </div>
                            @elseif($message->offer_status === 'accepted')
                                <div class="flex items-center gap-1.5 mt-2">
                                    <svg class="w-3.5 h-3.5 {{ $isMine ? 'text-primary-200' : 'text-emerald-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span class="text-xs font-medium {{ $isMine ? 'text-primary-200' : 'text-emerald-600 dark:text-emerald-400' }}">Accepted</span>
                                </div>
                            @elseif($message->offer_status === 'rejected')
                                <div class="flex items-center gap-1.5 mt-2">
                                    <svg class="w-3.5 h-3.5 {{ $isMine ? 'text-primary-200' : 'text-rose-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    <span class="text-xs font-medium {{ $isMine ? 'text-primary-200' : 'text-rose-600 dark:text-rose-400' }}">Declined</span>
                                </div>
                            @endif
                        @else
                            <p class="text-sm whitespace-pre-wrap leading-relaxed">{{ $message->body }}</p>
                        @endif
                        <p class="text-xs {{ $isMine ? 'text-primary-200/80' : 'text-gray-400 dark:text-gray-500' }} mt-1.5 text-right">
                            {{ $message->created_at->format('H:i') }}
                            @if($isMine && $message->is_read)
                                <span class="ml-1">&#10003;&#10003;</span>
                            @endif
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-16">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <p class="text-gray-400 dark:text-gray-500 font-medium">No messages yet</p>
                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Start the conversation!</p>
                </div>
            @endforelse

            @if($partnerTyping)
                <div class="flex justify-start">
                    <div class="bg-white dark:bg-gray-700/80 text-gray-500 dark:text-gray-400 rounded-2xl px-4 py-3 text-sm italic flex items-center gap-2 shadow-sm border border-gray-100/50 dark:border-gray-600/30">
                        <span class="flex gap-1">
                            <span class="w-2 h-2 bg-gray-400 dark:bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0s"></span>
                            <span class="w-2 h-2 bg-gray-400 dark:bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.15s"></span>
                            <span class="w-2 h-2 bg-gray-400 dark:bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.3s"></span>
                        </span>
                        typing...
                    </div>
                </div>
            @endif
        </div>

        <!-- Input Area -->
        <div class="px-4 sm:px-6 py-4 border-t border-gray-200 dark:border-gray-700 shrink-0 bg-white dark:bg-gray-800/60 backdrop-blur-lg">
            @if($showOfferForm)
                <form wire:submit="sendOffer" class="mb-4 p-4 bg-gradient-to-r from-primary-50/50 to-primary-100/30 dark:from-primary-900/20 dark:to-primary-800/10 rounded-xl border border-primary-200/30 dark:border-primary-700/20">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2.5">Send Budget Offer</label>
                    <div class="flex gap-2">
                        <input type="number" wire:model="offerBudget" placeholder="Amount (Rp)"
                               class="flex-1 px-4 py-2.5 border border-gray-200/80 dark:border-gray-600/80 rounded-xl text-sm bg-white dark:bg-gray-800/80 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200">
                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-primary to-primary-dark rounded-xl hover:shadow-lg hover:shadow-primary/20 transition-all duration-300">Send</button>
                        <button type="button" wire:click="$set('showOfferForm', false)" class="px-4 py-2.5 text-sm text-gray-600 dark:text-gray-400 bg-gray-100/80 dark:bg-gray-700/80 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200">Cancel</button>
                    </div>
                    @error('offerBudget') <p class="text-xs text-red-600 dark:text-red-400 mt-1.5">{{ $message }}</p> @enderror
                </form>
            @endif

            <div class="flex gap-2">
                <input type="text" wire:model="newMessage" wire:keydown.enter="sendMessage"
                       placeholder="Type your message..."
                       class="flex-1 px-4 py-3 border border-gray-200/80 dark:border-gray-600/80 rounded-xl text-sm bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 placeholder:text-gray-400"
                       x-data
                       x-on:keydown="$wire.broadcastTyping()"
                       x-on:keyup.debounce.2000ms="$wire.stopTyping()">
                <button wire:click="$set('showOfferForm', true)"
                        class="px-4 py-3 text-sm font-medium text-primary dark:text-primary-400 bg-primary-50/80 dark:bg-primary-900/20 rounded-xl hover:bg-primary-100 dark:hover:bg-primary-900/40 ring-1 ring-primary-200/30 dark:ring-primary-700/20 shrink-0 transition-all duration-300">
                    Offer
                </button>
                <button wire:click="sendMessage"
                        class="px-5 py-3 text-sm font-medium text-white bg-gradient-to-r from-primary to-primary-dark rounded-xl hover:shadow-lg hover:shadow-primary/20 shrink-0 transition-all duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </button>
            </div>
            @error('newMessage') <p class="text-xs text-red-600 dark:text-red-400 mt-1.5">{{ $message }}</p> @enderror
        </div>
    </div>
</div>
