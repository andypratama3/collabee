<div>
    <!-- Page Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div class="flex items-center gap-3">
            <div class="p-2.5 bg-gradient-to-br from-primary/20 to-primary/5 dark:from-primary/30 dark:to-primary/10 rounded-xl">
                <svg class="w-6 h-6 text-primary dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">Perjanjian</h1>
                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Tinjau dan tandatangani perjanjian kerjasama</p>
            </div>
        </div>
    </div>

    <!-- Filter Pills -->
    <div class="flex gap-2 mb-6 flex-wrap">
        <button wire:click="$set('filter', '')"
                class="px-4 py-2 text-sm font-medium rounded-xl transition-all duration-300 {{ empty($filter) ? 'bg-primary text-white shadow-md shadow-primary/25' : 'bg-white dark:bg-gray-800/80 backdrop-blur-sm text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:-translate-y-0.5' }}">Semua</button>
        @foreach(['draft', 'signed'] as $s)
            <button wire:click="$set('filter', '{{ $s }}')"
                    class="px-4 py-2 text-sm font-medium rounded-xl transition-all duration-300 {{ $filter === $s ? 'bg-primary text-white shadow-md shadow-primary/25' : 'bg-white dark:bg-gray-800/80 backdrop-blur-sm text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:-translate-y-0.5' }}">{{ $s === 'draft' ? 'Draft' : 'Ditandatangani' }}</button>
        @endforeach
    </div>

    <!-- Table Card -->
    <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200/50 dark:divide-gray-700/50">
                <thead>
                    <tr class="bg-gray-50/80 dark:bg-gray-900/50">
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Nomor</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Brand</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Kampanye</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/50 dark:divide-gray-700/50">
                    @forelse($agreements as $agreement)
                        <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/30 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm font-mono font-semibold text-gray-900 dark:text-white">{{ $agreement->agreement_number }}</td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $agreement->hiring?->brandProfile?->user?->name ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $agreement->hiring?->campaign?->title ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white">Rp. {{ number_format($agreement->total_amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-lg
                                    @if($agreement->status === 'signed') bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 ring-1 ring-emerald-200/50 dark:ring-emerald-800/50
                                    @else bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 ring-1 ring-amber-200/50 dark:ring-amber-800/50
                                    @endif">
                                    @if($agreement->status === 'signed')
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    @else
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                    @endif
                                    {{ $agreement->status === 'signed' ? 'Ditandatangani' : 'Draft' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('kol.agreement.show', $agreement) }}" class="inline-flex items-center gap-1 text-sm font-medium text-primary dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 transition-colors duration-200">
                                    Lihat
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-50 dark:from-gray-700 dark:to-gray-800 rounded-2xl flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada perjanjian.</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Perjanjian akan muncul setelah Anda diterima oleh brand.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $agreements->links() }}</div>
</div>
