<div class="space-y-8">
    {{-- Page Header --}}
    <div class="relative">
        <div class="absolute -top-4 -left-4 w-72 h-72 bg-gradient-to-br from-rose-400/20 to-red-400/20 rounded-full blur-3xl opacity-50 dark:opacity-30"></div>
        <div class="relative flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-3xl font-extrabold tracking-tight">
                    <span class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 dark:from-white dark:via-gray-100 dark:to-gray-300 bg-clip-text text-transparent">Manajemen Dispute</span>
                </h2>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Tinjau dan selesaikan sengketa antar pengguna.</p>
            </div>
            <select wire:model.live="statusFilter" class="px-4 py-2.5 bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-200 dark:text-gray-200 shadow-sm cursor-pointer">
                <option value="">Semua Status</option>
                <option value="open">Open</option>
                <option value="in_review">In Review</option>
                <option value="resolved">Resolved</option>
                <option value="closed">Closed</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200/80 dark:divide-gray-700/80">
                <thead>
                    <tr class="bg-gray-50/80 dark:bg-gray-900/40">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">ID</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">Subject</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">Diajukan Oleh</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">Terhadap</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">Severity</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800/80">
                    @forelse ($disputes as $dispute)
                        <tr class="hover:bg-primary-50/40 dark:hover:bg-primary-900/10 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 bg-gray-100 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300 text-sm font-mono font-medium rounded-lg">#{{ $dispute->id }}</span>
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate block">{{ $dispute->subject }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $dispute->raisedBy?->name ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $dispute->against?->name ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full
                                    @switch($dispute->status)
                                        @case('open') bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 @break
                                        @case('in_review') bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 @break
                                        @case('resolved') bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 @break
                                        @case('closed') bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 @break
                                        @default bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300
                                    @endswitch
                                ">
                                    @if($dispute->status === 'open')
                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-1.5 animate-pulse"></span>
                                    @elseif($dispute->status === 'in_review')
                                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-1.5 animate-pulse"></span>
                                    @endif
                                    {{ ucfirst(str_replace('_', ' ', $dispute->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full
                                    @switch($dispute->severity)
                                        @case('low') bg-gray-100 text-gray-600 dark:bg-gray-700/50 dark:text-gray-400 @break
                                        @case('medium') bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 @break
                                        @case('high') bg-orange-50 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400 @break
                                        @case('critical') bg-rose-50 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400 @break
                                        @default bg-gray-100 text-gray-600 dark:bg-gray-700/50 dark:text-gray-400
                                    @endswitch
                                ">
                                    @if($dispute->severity === 'critical')
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    @endif
                                    {{ ucfirst($dispute->severity) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-end">
                                <div class="flex items-center justify-end gap-2">
                                    @if($dispute->status !== 'resolved' && $dispute->status !== 'closed')
                                        <button wire:click="confirmResolve({{ $dispute->id }})"
                                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-semibold text-white bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl hover:from-emerald-600 hover:to-emerald-700 shadow-sm shadow-emerald-500/25 hover:shadow-md hover:shadow-emerald-500/30 transition-all duration-200">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Selesaikan
                                        </button>
                                    @endif
                                    <button wire:click="confirmAddNote({{ $dispute->id }})"
                                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 shadow-sm hover:shadow-md transition-all duration-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Catatan
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gradient-to-br from-rose-100 to-red-100 dark:from-rose-900/30 dark:to-red-900/30 rounded-2xl flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-rose-400 dark:text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400 font-semibold">Tidak ada dispute ditemukan</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Sengketa antar pengguna akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $disputes->links() }}
    </div>

    {{-- Resolve Modal --}}
    @if($showResolveModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-transition>
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="$set('showResolveModal', false)"></div>
            <div class="relative w-full max-w-lg bg-white/95 dark:bg-gray-800/95 backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-gray-700 shadow-2xl shadow-gray-900/20">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/25">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Selesaikan Dispute</h3>
                    </div>
                    <textarea wire:model="resolution" rows="4" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/80 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-200 dark:text-gray-200 placeholder-gray-400 resize-none" placeholder="Masukkan resolusi..."></textarea>
                    @error('resolution') <span class="text-sm text-rose-600 dark:text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    <div class="flex justify-end gap-3 mt-5">
                        <button wire:click="$set('showResolveModal', false)" class="px-5 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200">Batal</button>
                        <button wire:click="resolve" class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl hover:from-emerald-600 hover:to-emerald-700 shadow-sm shadow-emerald-500/25 hover:shadow-md transition-all duration-200">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Note Modal --}}
    @if($showNoteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-transition>
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="$set('showNoteModal', false)"></div>
            <div class="relative w-full max-w-lg bg-white/95 dark:bg-gray-800/95 backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-gray-700 shadow-2xl shadow-gray-900/20">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/25">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Tambah Catatan</h3>
                    </div>
                    <textarea wire:model="note" rows="4" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/80 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-200 dark:text-gray-200 placeholder-gray-400 resize-none" placeholder="Masukkan catatan..."></textarea>
                    @error('note') <span class="text-sm text-rose-600 dark:text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    <div class="flex justify-end gap-3 mt-5">
                        <button wire:click="$set('showNoteModal', false)" class="px-5 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200">Batal</button>
                        <button wire:click="addNote" class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl hover:from-primary-600 hover:to-primary-700 shadow-sm shadow-primary-500/25 hover:shadow-md transition-all duration-200">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
