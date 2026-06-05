<div>
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Hiring Invitations</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage your incoming hiring requests</p>
        </div>
    </div>

    <div class="flex gap-2 mb-6 flex-wrap">
        <button wire:click="$set('filter', '')"
                class="px-3 py-1.5 text-sm rounded-full {{ empty($filter) ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
            All
        </button>
        @foreach($statuses as $status)
            <button wire:click="$set('filter', '{{ $status->value }}')"
                    class="px-3 py-1.5 text-sm rounded-full {{ $filter === $status->value ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                {{ ucfirst($status->value) }}
            </button>
        @endforeach
    </div>

    <div class="space-y-4">
        @forelse($hirings as $hiring)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex flex-col sm:flex-row items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1 flex-wrap">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $hiring->campaign->title }}</h3>
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full
                                @if($hiring->status->value === 'pending') bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400
                                @elseif($hiring->status->value === 'accepted') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                @elseif($hiring->status->value === 'rejected') bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400
                                @elseif($hiring->status->value === 'cancelled') bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300
                                @else bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                @endif">
                                {{ ucfirst($hiring->status->value) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                            by {{ $hiring->campaign->brandProfile->brand_name ?? 'Unknown Brand' }}
                        </p>
                        @if($hiring->message)
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-2 italic">"{{ $hiring->message }}"</p>
                        @endif
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4 text-sm text-gray-500 dark:text-gray-400">
                            <span>Budget: Rp {{ number_format($hiring->proposed_budget ?? 0, 0, ',', '.') }}</span>
                            <span>Received: {{ $hiring->created_at->format('d M Y') }}</span>
                            @if($hiring->expires_at)
                                <span>Expires: {{ $hiring->expires_at->format('d M Y') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        @if($hiring->status->value === 'pending')
                            <button wire:click="openRespondModal({{ $hiring->id }}, 'accept')"
                                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                                Accept
                            </button>
                            <button wire:click="openRespondModal({{ $hiring->id }}, 'reject')"
                                    class="px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/30 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/50">
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

    <div class="mt-6">
        {{ $hirings->links() }}
    </div>

    @if($showRespondModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 dark:bg-black/70" wire:click.self="$set('showRespondModal', false)">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 w-full max-w-md mx-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                    {{ $respondAction === 'accept' ? 'Accept Hiring?' : 'Decline Hiring?' }}
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    @if($respondAction === 'accept')
                        By accepting, you agree to work on this campaign under the proposed terms.
                    @else
                        Are you sure you want to decline this hiring invitation?
                    @endif
                </p>
                @if($respondAction === 'reject')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reason (optional)</label>
                        <textarea wire:model="rejectReason" rows="2"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                  placeholder="Let the brand know why..."></textarea>
                    </div>
                @endif
                <div class="flex justify-end gap-3">
                    <button wire:click="$set('showRespondModal', false)"
                            class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">Close</button>
                    <button wire:click="respond"
                            class="px-4 py-2 text-sm text-white {{ $respondAction === 'accept' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} rounded-lg">
                        {{ $respondAction === 'accept' ? 'Yes, Accept' : 'Yes, Decline' }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
