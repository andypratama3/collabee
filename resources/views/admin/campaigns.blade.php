<div class="space-y-8">
    {{-- Page Header --}}
    <div class="relative">
        <div class="absolute -top-4 -left-4 w-72 h-72 bg-gradient-to-br from-pink-400/20 to-orange-400/20 rounded-full blur-3xl opacity-50 dark:opacity-30"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-extrabold tracking-tight">
                    <span class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 dark:from-white dark:via-gray-100 dark:to-gray-300 bg-clip-text text-transparent">Manajemen Kampanye</span>
                </h2>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Pantau dan kelola semua kampanye yang berjalan di platform.</p>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white dark:bg-gray-800/60 backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg shadow-gray-200/10 dark:shadow-gray-900/20 p-5">
        <div class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-primary-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari kampanye..."
                           class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-gray-900/80 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-200 dark:text-gray-200 placeholder-gray-400">
                </div>
            </div>
            <select wire:model.live="statusFilter" class="px-4 py-2.5 bg-white dark:bg-gray-900/80 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-200 dark:text-gray-200 cursor-pointer">
                <option value="">Semua Status</option>
                <option value="open">Open</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200/80 dark:divide-gray-700/80">
                <thead>
                    <tr class="bg-gray-50/80 dark:bg-gray-900/40">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">Judul</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">Brand</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">Deadline</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-end">Anggaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800/80">
                    @forelse ($campaigns as $campaign)
                        <tr class="hover:bg-primary-50/40 dark:hover:bg-primary-900/10 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $campaign->title }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $campaign->brandProfile?->brand_name ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full
                                    @switch($campaign->status->value ?? $campaign->status)
                                        @case('open') bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 @break
                                        @case('in_progress') bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 @break
                                        @case('completed') bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 @break
                                        @default bg-rose-50 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400
                                    @endswitch">{{ ucfirst(str_replace('_', ' ', $campaign->status->value ?? $campaign->status)) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $campaign->deadline_apply?->format('d M Y') ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 text-end">
                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">Rp. {{ number_format($campaign->budget_total ?? 0, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gradient-to-br from-pink-100 to-orange-100 dark:from-pink-900/30 dark:to-orange-900/30 rounded-2xl flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-pink-400 dark:text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400 font-semibold">Tidak ada kampanye ditemukan</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Coba ubah filter pencarian Anda</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $campaigns->links() }}</div>
</div>
