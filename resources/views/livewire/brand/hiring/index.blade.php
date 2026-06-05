<div>
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Hiring Management</h1>
            <p class="mt-1 text-sm text-gray-500">Track all your KOL hiring invitations</p>
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

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">KOL</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Campaign</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Budget</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($hirings as $hiring)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs">
                                    {{ strtoupper(substr($hiring->kolProfile->display_name ?? '??', 0, 2)) }}
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ $hiring->kolProfile->display_name ?? 'Unknown' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $hiring->campaign->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($hiring->proposed_budget ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full
                                @if($hiring->status->value === 'pending') bg-yellow-100 text-yellow-700
                                @elseif($hiring->status->value === 'accepted') bg-green-100 text-green-700
                                @elseif($hiring->status->value === 'rejected') bg-red-100 text-red-700
                                @elseif($hiring->status->value === 'cancelled') bg-gray-100 text-gray-600
                                @else bg-blue-100 text-blue-700
                                @endif">
                                {{ ucfirst($hiring->status->value) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $hiring->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            @if(in_array($hiring->status->value, ['pending', 'negotiating']))
                                <button wire:click="confirmCancel({{ $hiring->id }})"
                                        class="text-sm text-red-600 hover:text-red-800">Cancel</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">No hiring records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $hirings->links() }}
    </div>

    @if($showCancelConfirm)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" wire:click.self="$set('showCancelConfirm', false)">
            <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md mx-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Cancel Hiring?</h3>
                <p class="text-sm text-gray-500 mb-4">This action cannot be undone.</p>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reason (optional)</label>
                    <textarea wire:model="cancelReason" rows="2"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                              placeholder="Why are you cancelling?"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button wire:click="$set('showCancelConfirm', false)"
                            class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Close</button>
                    <button wire:click="cancel"
                            class="px-4 py-2 text-sm text-white bg-red-600 rounded-lg hover:bg-red-700">Yes, Cancel</button>
                </div>
            </div>
        </div>
    @endif
</div>
