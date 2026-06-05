<div>
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Hiring Management</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Track all your KOL hiring invitations</p>
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

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">KOL</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Campaign</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Budget</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($hirings as $hiring)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-xs">
                                        {{ strtoupper(substr($hiring->kolProfile->display_name ?? '??', 0, 2)) }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $hiring->kolProfile->display_name ?? 'Unknown' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $hiring->campaign->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">Rp {{ number_format($hiring->proposed_budget ?? 0, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full
                                    @if($hiring->status->value === 'pending') bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400
                                    @elseif($hiring->status->value === 'accepted') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                    @elseif($hiring->status->value === 'rejected') bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400
                                    @elseif($hiring->status->value === 'cancelled') bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300
                                    @else bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                    @endif">
                                    {{ ucfirst($hiring->status->value) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $hiring->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                @if(in_array($hiring->status->value, ['pending', 'negotiating']))
                                    <button wire:click="confirmCancel({{ $hiring->id }})"
                                            class="text-sm text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">Cancel</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">No hiring records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $hirings->links() }}
    </div>

    @if($showCancelConfirm)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 dark:bg-black/70" wire:click.self="$set('showCancelConfirm', false)">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 w-full max-w-md mx-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Cancel Hiring?</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">This action cannot be undone.</p>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reason (optional)</label>
                    <textarea wire:model="cancelReason" rows="2"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                              placeholder="Why are you cancelling?"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button wire:click="$set('showCancelConfirm', false)"
                            class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">Close</button>
                    <button wire:click="cancel"
                            class="px-4 py-2 text-sm text-white bg-red-600 rounded-lg hover:bg-red-700">Yes, Cancel</button>
                </div>
            </div>
        </div>
    @endif
</div>
