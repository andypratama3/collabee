<div>
    <!-- Page Header -->
    <div class="relative mb-8">
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-primary/5 dark:bg-primary/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-pink-500/5 dark:bg-pink-500/10 rounded-full blur-3xl"></div>
        </div>
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 via-gray-800 to-gray-600 dark:from-white dark:via-gray-100 dark:to-gray-300 bg-clip-text text-transparent">Konten Saya</h1>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Kelola konten yang telah kamu kirim</p>
            </div>
            <a href="{{ route('kol.content.create') }}" wire:navigate
               class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-primary to-primary-dark rounded-xl hover:shadow-lg hover:shadow-primary/25 hover:-translate-y-0.5 transition-all duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Upload Konten Baru
            </a>
        </div>
    </div>

    <!-- Filter Pills -->
    <div class="flex gap-2 mb-8 flex-wrap">
        <button wire:click="$set('filter', '')"
                class="px-4 py-2 text-sm font-medium rounded-xl transition-all duration-300 {{ empty($filter) ? 'bg-gradient-to-r from-primary to-primary-dark text-white shadow-lg shadow-primary/25' : 'bg-white dark:bg-gray-800/80 backdrop-blur-sm text-gray-600 dark:text-gray-400 hover:bg-white dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 hover:shadow-md' }}">Semua</button>
        @foreach(['draft', 'submitted', 'under_review', 'revision_requested', 'approved', 'rejected', 'posted'] as $s)
            <button wire:click="$set('filter', '{{ $s }}')"
                    class="px-4 py-2 text-sm font-medium rounded-xl transition-all duration-300 {{ $filter === $s ? 'bg-gradient-to-r from-primary to-primary-dark text-white shadow-lg shadow-primary/25' : 'bg-white dark:bg-gray-800/80 backdrop-blur-sm text-gray-600 dark:text-gray-400 hover:bg-white dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 hover:shadow-md' }}">{{ ucfirst(str_replace('_', ' ', $s)) }}</button>
        @endforeach
    </div>

    <!-- Content Table -->
    <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200/50 dark:divide-gray-700/50">
                <thead class="bg-gray-50/80 dark:bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Brand</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tgl Upload</th>
                        <th class="px-6 py-3.5 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/80 dark:divide-gray-700/50">
                    @forelse($contents as $content)
                        <tr class="group hover:bg-gray-50/80 dark:hover:bg-gray-700/30 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white group-hover:text-primary dark:group-hover:text-primary-400 transition-colors duration-200">{{ $content->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $content->brandProfile?->brand_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg
                                    @if($content->status->value === 'approved') bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400 ring-1 ring-emerald-200/50 dark:ring-emerald-700/30
                                    @elseif($content->status->value === 'revision_requested') bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400 ring-1 ring-amber-200/50 dark:ring-amber-700/30
                                    @elseif($content->status->value === 'rejected') bg-rose-50 text-rose-700 dark:bg-rose-900/20 dark:text-rose-400 ring-1 ring-rose-200/50 dark:ring-rose-700/30
                                    @elseif($content->status->value === 'submitted') bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 ring-1 ring-blue-200/50 dark:ring-blue-700/30
                                    @elseif($content->status->value === 'posted') bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400 ring-1 ring-emerald-200/50 dark:ring-emerald-700/30
                                    @else bg-gray-50 text-gray-600 dark:bg-gray-700/50 dark:text-gray-300 ring-1 ring-gray-200/50 dark:ring-gray-600/30
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $content->status->value)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $content->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('kol.content.show', $content) }}" wire:navigate
                                   class="inline-flex items-center gap-1.5 text-sm font-medium text-primary dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 transition-colors duration-200">
                                    Detail
                                    <svg class="w-3.5 h-3.5 opacity-0 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 mb-4 rounded-2xl bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada konten.</p>
                                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Upload konten pertamamu untuk memulai</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8">{{ $contents->links() }}</div>
</div>
