<div>
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Konten KOL</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Review dan kelola konten dari KOL</p>
        </div>
    </div>

    <div class="flex gap-2 mb-6 flex-wrap">
        <button wire:click="$set('filter', '')"
                class="px-3 py-1.5 text-sm rounded-full {{ empty($filter) ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }}">Semua</button>
        @foreach(['draft', 'submitted', 'under_review', 'revision_requested', 'approved', 'rejected', 'posted'] as $s)
            <button wire:click="$set('filter', '{{ $s }}')"
                    class="px-3 py-1.5 text-sm rounded-full {{ $filter === $s ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }}">{{ ucfirst(str_replace('_', ' ', $s)) }}</button>
        @endforeach
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">KOL</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Campaign</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tgl Upload</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($contents as $content)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $content->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $content->kolProfile?->display_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $content->agreement?->hiring?->campaign?->title ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full
                                    @if($content->status->value === 'approved') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                    @elseif($content->status->value === 'revision_requested') bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400
                                    @elseif($content->status->value === 'rejected') bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400
                                    @elseif($content->status->value === 'submitted') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                    @elseif($content->status->value === 'posted') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400
                                    @else bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $content->status->value)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $content->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('brand.content.show', $content) }}" wire:navigate
                                   class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">Review</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">Belum ada konten.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $contents->links() }}</div>
</div>
