<div class="space-y-8">
    {{-- Page Header --}}
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-900 via-gray-800 to-gray-600 dark:from-white dark:via-gray-200 dark:to-gray-400">Hiring Management</h1>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Track all your KOL hiring invitations</p>
        </div>
    </div>

    {{-- Filter Pills --}}
    <div class="flex flex-wrap gap-2 p-1.5 bg-white dark:bg-gray-800/60 backdrop-blur-xl rounded-2xl w-fit border border-gray-200 dark:border-gray-700 shadow-sm">
        <button wire:click="$set('filter', '')"
                class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-300 {{ empty($filter) ? 'bg-gradient-to-r from-primary to-primary-dark text-white shadow-md shadow-primary/25' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100/80 dark:hover:bg-gray-700/50' }}">
            All
        </button>
        @foreach($statuses as $status)
            <button wire:click="$set('filter', '{{ $status->value }}')"
                    class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-300 {{ $filter === $status->value ? 'bg-gradient-to-r from-primary to-primary-dark text-white shadow-md shadow-primary/25' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100/80 dark:hover:bg-gray-700/50' }}">
                {{ ucfirst($status->value) }}
            </button>
        @endforeach
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200/50 dark:divide-gray-700/50">
                <thead>
                    <tr class="bg-gray-50/80 dark:bg-gray-900/50">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">KOL</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Campaign</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Budget</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    @forelse($hirings as $hiring)
                        <tr class="transition-colors duration-200 hover:bg-primary/[0.02] dark:hover:bg-primary/[0.05] even:bg-gray-50/30 dark:even:bg-gray-800/30">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary/20 to-primary/5 dark:from-primary/30 dark:to-primary/10 flex items-center justify-center text-primary dark:text-primary-400 font-bold text-xs ring-2 ring-primary/10 dark:ring-primary/20">
                                        {{ strtoupper(substr($hiring->kolProfile->display_name ?? '??', 0, 2)) }}
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $hiring->kolProfile->display_name ?? 'Unknown' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $hiring->campaign->title }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white">Rp. {{ number_format($hiring->proposed_budget ?? 0, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold rounded-full border
                                    @if($hiring->status->value === 'pending') bg-amber-50 text-amber-600 border-amber-200/50 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800/50
                                    @elseif($hiring->status->value === 'accepted') bg-emerald-50 text-emerald-600 border-emerald-200/50 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800/50
                                    @elseif($hiring->status->value === 'rejected') bg-red-50 text-red-600 border-red-200/50 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800/50
                                    @elseif($hiring->status->value === 'cancelled') bg-gray-50 text-gray-500 border-gray-200/50 dark:bg-gray-700/50 dark:text-gray-300 dark:border-gray-600/50
                                    @else bg-blue-50 text-blue-600 border-blue-200/50 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-800/50
                                    @endif">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                        @if($hiring->status->value === 'pending') bg-amber-500
                                        @elseif($hiring->status->value === 'accepted') bg-emerald-500
                                        @elseif($hiring->status->value === 'rejected') bg-red-500
                                        @elseif($hiring->status->value === 'cancelled') bg-gray-400
                                        @else bg-blue-500
                                        @endif"></span>
                                    {{ ucfirst($hiring->status->value) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $hiring->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                @if(in_array($hiring->status->value, ['pending', 'negotiating']))
                                    <button wire:click="confirmCancel({{ $hiring->id }})"
                                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-red-600 dark:text-red-400 bg-red-50/50 dark:bg-red-900/10 hover:bg-red-100 dark:hover:bg-red-900/20 rounded-lg transition-all duration-200 border border-red-200/30 dark:border-red-800/30">Cancel</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">No hiring records found.</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Try adjusting your filters or create a new hiring.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $hirings->links() }}
    </div>

    {{-- Cancel Confirmation Modal --}}
    @if($showCancelConfirm)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 dark:bg-black/60 backdrop-blur-sm" wire:click.self="$set('showCancelConfirm', false)"
             x-data x-init="$el.classList.add('animate-fade-in')"
             style="animation: fadeIn 0.2s ease-out">
            <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-xl rounded-2xl shadow-2xl shadow-gray-900/20 dark:shadow-black/40 p-6 w-full max-w-md mx-4 border border-gray-200 dark:border-gray-700"
                 style="animation: slideUp 0.3s ease-out">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Cancel Hiring?</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">This action cannot be undone.</p>
                    </div>
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Reason (optional)</label>
                    <textarea wire:model="cancelReason" rows="2"
                              class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 placeholder-gray-400"
                              placeholder="Why are you cancelling?"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button wire:click="$set('showCancelConfirm', false)"
                            class="px-5 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200">Close</button>
                    <button wire:click="cancel"
                            class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-red-500 to-red-600 rounded-xl hover:from-red-600 hover:to-red-700 shadow-lg shadow-red-500/25 transition-all duration-200">Yes, Cancel</button>
                </div>
            </div>
        </div>
    @endif

    <style>
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(10px) scale(0.98); } to { opacity: 1; transform: translateY(0) scale(1); } }
    </style>
</div>
