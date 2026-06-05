<div>
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Hiring Invitations</h1>
            <p class="mt-1 text-sm text-gray-500">Manage your incoming hiring requests</p>
        </div>
    </div>

    <div class="flex gap-2 mb-6 flex-wrap">
        <button wire:click="$set('filter', '')"
                class="px-3 py-1.5 text-sm rounded-full {{ empty($filter) ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            All
        </button>
        @foreach($statuses as $status)
            <button wire:click="$set('filter', '{{ $status->value }}')"
                    class="px-3 py-1.5 text-sm rounded-full {{ $filter === $status->value ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                {{ ucfirst($status->value) }}
            </button>
        @endforeach
    </div>

    <div class="space-y-4">
        @forelse($hirings as $hiring)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $hiring->campaign->title }}</h3>
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full
                                @if($hiring->status->value === 'pending') bg-yellow-100 text-yellow-700
                                @elseif($hiring->status->value === 'accepted') bg-green-100 text-green-700
                                @elseif($hiring->status->value === 'rejected') bg-red-100 text-red-700
                                @elseif($hiring->status->value === 'cancelled') bg-gray-100 text-gray-600
                                @else bg-blue-100 text-blue-700
                                @endif">
                                {{ ucfirst($hiring->status->value) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mb-1">
                            by {{ $hiring->campaign->brandProfile->brand_name ?? 'Unknown Brand' }}
                        </p>
                        @if($hiring->message)
                            <p class="text-sm text-gray-600 mb-2 italic">"{{ $hiring->message }}"</p>
                        @endif
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span>Budget: Rp {{ number_format($hiring->proposed_budget ?? 0, 0, ',', '.') }}</span>
                            <span>Received: {{ $hiring->created_at->format('d M Y') }}</span>
                            @if($hiring->expires_at)
                                <span>Expires: {{ $hiring->expires_at->format('d M Y') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-2 ml-4">
                        @if($hiring->status->value === 'pending')
                            <button wire:click="openRespondModal({{ $hiring->id }}, 'accept')"
                                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                                Accept
                            </button>
                            <button wire:click="openRespondModal({{ $hiring->id }}, 'reject')"
                                    class="px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100">
                                Decline
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white rounded-xl border border-gray-200">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">No hiring invitations</h3>
                <p class="mt-1 text-sm text-gray-500">Apply to campaigns to get hired!</p>
                <a href="{{ route('campaigns.explore') }}" wire:navigate
                   class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
                    Explore Campaigns
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $hirings->links() }}
    </div>

    @if($showRespondModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" wire:click.self="$set('showRespondModal', false)">
            <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md mx-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    {{ $respondAction === 'accept' ? 'Accept Hiring?' : 'Decline Hiring?' }}
                </h3>
                <p class="text-sm text-gray-500 mb-4">
                    @if($respondAction === 'accept')
                        By accepting, you agree to work on this campaign under the proposed terms.
                    @else
                        Are you sure you want to decline this hiring invitation?
                    @endif
                </p>
                @if($respondAction === 'reject')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Reason (optional)</label>
                        <textarea wire:model="rejectReason" rows="2"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                                  placeholder="Let the brand know why..."></textarea>
                    </div>
                @endif
                <div class="flex justify-end gap-3">
                    <button wire:click="$set('showRespondModal', false)"
                            class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Close</button>
                    <button wire:click="respond"
                            class="px-4 py-2 text-sm text-white {{ $respondAction === 'accept' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} rounded-lg">
                        {{ $respondAction === 'accept' ? 'Yes, Accept' : 'Yes, Decline' }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
