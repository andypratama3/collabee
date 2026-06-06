<div>
    <!-- Page Header -->
    <div class="relative mb-8">
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-primary/5 dark:bg-primary/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-violet-500/5 dark:bg-violet-500/10 rounded-full blur-3xl"></div>
        </div>
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 via-gray-800 to-gray-600 dark:from-white dark:via-gray-100 dark:to-gray-300 bg-clip-text text-transparent">Hiring Invitations</h1>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Manage your incoming hiring requests</p>
            </div>
        </div>
    </div>

    <!-- Filter Pills -->
    <div class="flex gap-2 mb-8 flex-wrap">
        <button wire:click="$set('filter', '')"
                class="px-4 py-2 text-sm font-medium rounded-xl transition-all duration-300 {{ empty($filter) ? 'bg-gradient-to-r from-primary to-primary-dark text-white shadow-lg shadow-primary/25' : 'bg-white dark:bg-gray-800/80 backdrop-blur-sm text-gray-600 dark:text-gray-400 hover:bg-white dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 hover:shadow-md' }}">
            All
        </button>
        @foreach($statuses as $status)
            <button wire:click="$set('filter', '{{ $status->value }}')"
                    class="px-4 py-2 text-sm font-medium rounded-xl transition-all duration-300 {{ $filter === $status->value ? 'bg-gradient-to-r from-primary to-primary-dark text-white shadow-lg shadow-primary/25' : 'bg-white dark:bg-gray-800/80 backdrop-blur-sm text-gray-600 dark:text-gray-400 hover:bg-white dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 hover:shadow-md' }}">
                {{ ucfirst($status->value) }}
            </button>
        @endforeach
    </div>

    <!-- Hiring Cards -->
    <div class="space-y-4">
        @forelse($hirings as $hiring)
            <div class="group bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 p-6 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-2xl hover:shadow-gray-200/40 dark:hover:shadow-gray-900/50">
                <div class="flex flex-col sm:flex-row items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 mb-2 flex-wrap">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-primary dark:group-hover:text-primary-400 transition-colors duration-300">{{ $hiring->campaign->title }}</h3>
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-lg
                                @if($hiring->status->value === 'pending') bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400 ring-1 ring-amber-200/50 dark:ring-amber-700/30
                                @elseif($hiring->status->value === 'accepted') bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400 ring-1 ring-emerald-200/50 dark:ring-emerald-700/30
                                @elseif($hiring->status->value === 'rejected') bg-rose-50 text-rose-700 dark:bg-rose-900/20 dark:text-rose-400 ring-1 ring-rose-200/50 dark:ring-rose-700/30
                                @elseif($hiring->status->value === 'cancelled') bg-gray-50 text-gray-600 dark:bg-gray-700/50 dark:text-gray-300 ring-1 ring-gray-200/50 dark:ring-gray-600/30
                                @else bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 ring-1 ring-blue-200/50 dark:ring-blue-700/30
                                @endif">
                                {{ ucfirst($hiring->status->value) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            by <span class="font-medium text-gray-700 dark:text-gray-300">{{ $hiring->campaign->brandProfile->brand_name ?? 'Unknown Brand' }}</span>
                        </p>
                        @if($hiring->message)
                            <div class="mb-3 px-4 py-2.5 bg-gray-50/80 dark:bg-gray-700/30 rounded-xl border-l-3 border-primary/30">
                                <p class="text-sm text-gray-600 dark:text-gray-300 italic">"{{ $hiring->message }}"</p>
                            </div>
                        @endif
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4 text-sm text-gray-500 dark:text-gray-400">
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Rp. {{ number_format($hiring->proposed_budget ?? 0, 0, ',', '.') }}
                            </span>
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $hiring->created_at->format('d M Y') }}
                            </span>
                            @if($hiring->expires_at)
                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Expires: {{ $hiring->expires_at->format('d M Y') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        @if($hiring->status->value === 'pending')
                            <button wire:click="openRespondModal({{ $hiring->id }}, 'accept')"
                                    class="px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl hover:from-emerald-600 hover:to-emerald-700 shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 transition-all duration-300 hover:-translate-y-0.5">
                                Accept
                            </button>
                            <button wire:click="openRespondModal({{ $hiring->id }}, 'reject')"
                                    class="px-5 py-2.5 text-sm font-medium text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-900/20 rounded-xl hover:bg-rose-100 dark:hover:bg-rose-900/40 ring-1 ring-rose-200/50 dark:ring-rose-700/30 transition-all duration-300 hover:-translate-y-0.5">
                                Decline
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <x-empty-state icon="message" title="No hiring invitations" description="Apply to campaigns to get hired!" actionLabel="Explore Campaigns" actionUrl="{{ route('campaigns.explore') }}" />
        @endforelse
    </div>

    <div class="mt-8">
        {{ $hirings->links() }}
    </div>

    <!-- Respond Modal -->
    @if($showRespondModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 dark:bg-black/60 backdrop-blur-sm" wire:click.self="$set('showRespondModal', false)"
             x-data x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-xl rounded-2xl shadow-2xl shadow-gray-900/20 dark:shadow-black/40 border border-gray-200 dark:border-gray-700 p-6 w-full max-w-md mx-4"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ $respondAction === 'accept' ? 'bg-emerald-100 dark:bg-emerald-900/30' : 'bg-rose-100 dark:bg-rose-900/30' }}">
                        @if($respondAction === 'accept')
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @else
                            <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        @endif
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ $respondAction === 'accept' ? 'Accept Hiring?' : 'Decline Hiring?' }}
                    </h3>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">
                    @if($respondAction === 'accept')
                        By accepting, you agree to work on this campaign under the proposed terms.
                    @else
                        Are you sure you want to decline this hiring invitation?
                    @endif
                </p>
                @if($respondAction === 'reject')
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Reason (optional)</label>
                        <textarea wire:model="rejectReason" rows="2"
                                  class="w-full px-4 py-3 border border-gray-200/80 dark:border-gray-600/80 rounded-xl text-sm bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 placeholder:text-gray-400"
                                  placeholder="Let the brand know why..."></textarea>
                    </div>
                @endif
                <div class="flex justify-end gap-3">
                    <button wire:click="$set('showRespondModal', false)"
                            class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100/80 dark:bg-gray-700/80 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-300">Close</button>
                    <button wire:click="respond"
                            class="px-5 py-2.5 text-sm font-medium text-white rounded-xl shadow-lg transition-all duration-300 hover:-translate-y-0.5 {{ $respondAction === 'accept' ? 'bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 shadow-emerald-500/20' : 'bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 shadow-rose-500/20' }}">
                        {{ $respondAction === 'accept' ? 'Yes, Accept' : 'Yes, Decline' }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
