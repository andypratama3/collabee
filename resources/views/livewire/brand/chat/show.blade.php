<div>
    {{-- Back Link --}}
    <div class="mb-6">
        <a href="{{ route('brand.chat.index') }}" wire:navigate class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200 group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Pesan
        </a>
    </div>

    {{-- Chat Container --}}
    <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col h-[calc(100vh-12rem)]">
        
        {{-- Chat Header --}}
        <div class="px-5 sm:px-6 py-4 border-b border-gray-200/80 dark:border-gray-700/80 flex items-center gap-4 shrink-0 bg-white dark:bg-gray-800/50">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-primary-500/25">
                {{ strtoupper(substr($room->hiring?->kolProfile?->user?->name ?? '?', 0, 2)) }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $room->hiring?->kolProfile?->user?->name ?? 'Unknown KOL' }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">Campaign: {{ $room->hiring?->campaign?->title ?? 'N/A' }}</p>
            </div>
            <div class="ml-auto flex items-center gap-2 shrink-0">
                <span class="px-3 py-1 text-xs font-bold rounded-lg
                    @if($room->hiring?->status->value === 'accepted') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400
                    @elseif($room->hiring?->status->value === 'negotiating') bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400
                    @else bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300
                    @endif">
                    {{ ucfirst($room->hiring?->status->value ?? 'unknown') }}
                </span>
            </div>
        </div>

        {{-- Messages Area --}}
        <div class="flex-1 overflow-y-auto p-5 sm:p-6 space-y-4" x-data x-init="$el.scrollTop = $el.scrollHeight" wire:poll.5000ms>
            @forelse($messages as $message)
                @php $isMine = $message->sender_id === auth()->id(); @endphp
                <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[85%] sm:max-w-[70%] {{ $isMine ? 'bg-gradient-to-br from-primary-600 to-indigo-600 text-white shadow-lg shadow-primary-500/20' : 'bg-gray-100 dark:bg-gray-700/80 text-gray-900 dark:text-gray-100' }} rounded-2xl {{ $isMine ? 'rounded-br-md' : 'rounded-bl-md' }} px-4 py-3">
                        @if($message->type === 'system')
                            <p class="text-sm italic {{ $isMine ? 'text-primary-200' : 'text-gray-500 dark:text-gray-400' }}">{{ $message->body }}</p>
                        @elseif($message->type === 'offer')
                            <div class="flex items-center gap-2 mb-1.5">
                                <svg class="w-4 h-4 {{ $isMine ? 'text-primary-200' : 'text-primary-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-sm font-bold">Budget Offer</p>
                            </div>
                            <p class="text-sm">{{ $message->body }}</p>
                            @if($message->offer_status === 'pending' && !$isMine)
                                <div class="flex gap-2 mt-3">
                                    <button wire:click="acceptOffer({{ $message->id }})"
                                            class="px-3.5 py-1.5 text-xs font-bold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 shadow-sm transition-colors">Accept</button>
                                    <button wire:click="rejectOffer({{ $message->id }})"
                                            class="px-3.5 py-1.5 text-xs font-bold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-600 border border-gray-200 dark:border-gray-500 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-500 transition-colors">Decline</button>
                                </div>
                            @elseif($message->offer_status === 'accepted')
                                <span class="inline-flex items-center gap-1 mt-2 text-xs font-bold {{ $isMine ? 'text-emerald-200' : 'text-emerald-600 dark:text-emerald-400' }}">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Accepted
                                </span>
                            @elseif($message->offer_status === 'rejected')
                                <span class="inline-flex items-center gap-1 mt-2 text-xs font-bold {{ $isMine ? 'text-red-200' : 'text-red-600 dark:text-red-400' }}">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Declined
                                </span>
                            @endif
                        @else
                            <p class="text-sm whitespace-pre-wrap leading-relaxed">{{ $message->body }}</p>
                        @endif
                        <p class="text-[11px] {{ $isMine ? 'text-white/50' : 'text-gray-400 dark:text-gray-500' }} mt-1.5 text-right">
                            {{ $message->created_at->format('H:i') }}
                            @if($isMine && $message->is_read)
                                <span class="ml-1 text-emerald-300">&#10003;&#10003;</span>
                            @endif
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-16">
                    <div class="w-16 h-16 rounded-2xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada pesan. Mulai percakapan!</p>
                </div>
            @endforelse

            @if($partnerTyping)
                <div class="flex justify-start">
                    <div class="bg-gray-100 dark:bg-gray-700/80 text-gray-500 dark:text-gray-400 rounded-2xl rounded-bl-md px-4 py-3 text-sm flex items-center gap-2">
                        <span class="flex gap-1">
                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0s"></span>
                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.15s"></span>
                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.3s"></span>
                        </span>
                        mengetik...
                    </div>
                </div>
            @endif
        </div>

        {{-- Input Area --}}
        <div class="px-5 sm:px-6 py-4 border-t border-gray-200/80 dark:border-gray-700/80 shrink-0 bg-white dark:bg-gray-800/50">
            @if($showOfferForm)
                <form wire:submit="sendOffer" class="mb-4 p-4 bg-primary-50/50 dark:bg-primary-900/20 rounded-xl border border-primary-200/50 dark:border-primary-700/30">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Kirim Penawaran Budget</label>
                    <div class="flex gap-2">
                        <input type="number" wire:model="offerBudget" placeholder="Jumlah (Rp)"
                               class="flex-1 px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                        <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-primary-600 to-indigo-600 rounded-xl hover:from-primary-700 hover:to-indigo-700 shadow-lg shadow-primary-500/25 transition-all">Kirim</button>
                        <button type="button" wire:click="$set('showOfferForm', false)" class="px-4 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">Batal</button>
                    </div>
                    @error('offerBudget') <p class="text-xs text-red-600 dark:text-red-400 mt-2">{{ $message }}</p> @enderror
                </form>
            @endif

            <div class="flex gap-2">
                <input type="text" wire:model="newMessage" wire:keydown.enter="sendMessage"
                       placeholder="Ketik pesan Anda..."
                       class="flex-1 px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all"
                       x-data
                       x-on:keydown="$wire.broadcastTyping()"
                       x-on:keyup.debounce.2000ms="$wire.stopTyping()">
                <button wire:click="$set('showOfferForm', true)"
                        class="px-4 py-3 text-sm font-bold text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 rounded-xl hover:bg-primary-100 dark:hover:bg-primary-900/40 border border-primary-200/50 dark:border-primary-700/30 shrink-0 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </button>
                <button wire:click="sendMessage"
                        class="px-5 py-3 text-sm font-bold text-white bg-gradient-to-r from-primary-600 to-indigo-600 rounded-xl hover:from-primary-700 hover:to-indigo-700 shadow-lg shadow-primary-500/25 shrink-0 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </button>
            </div>
            @error('newMessage') <p class="text-xs text-red-600 dark:text-red-400 mt-2">{{ $message }}</p> @enderror
        </div>
    </div>
</div>
