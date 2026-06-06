<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Activity Log</h2>
    </div>

    <div class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari aktivitas atau user..."
                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-gray-200">
        </div>
        <select wire:model.live="eventFilter" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-gray-200">
            <option value="">Semua Event</option>
            @foreach ($events as $event)
                <option value="{{ $event }}">{{ ucfirst($event) }}</option>
            @endforeach
        </select>
        <div>
            <input type="date" wire:model.live="dateFrom" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-gray-200">
        </div>
        <div>
            <input type="date" wire:model.live="dateTo" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-gray-200">
        </div>
    </div>

    <div class="overflow-hidden bg-white dark:bg-gray-800 rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase text-start">Waktu</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase text-start">User</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase text-start">Aktivitas</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase text-start">Target</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase text-end">Detail</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($activities as $activity)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer" wire:click="toggleExpand({{ $activity->id }})">
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $activity->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $activity->causer?->name ?? 'System' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $activity->description }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                            @if($activity->subject)
                                {{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 text-end">
                            <svg class="w-4 h-4 inline text-gray-400 dark:text-gray-500 transition-transform {{ $expandedId === $activity->id ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </td>
                    </tr>
                    @if($expandedId === $activity->id)
                        <tr>
                            <td colspan="5" class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50">
                                <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                    <p><strong>Event:</strong> {{ $activity->event ?? '-' }}</p>
                                    <p><strong>Log Name:</strong> {{ $activity->log_name }}</p>
                                    @if($activity->properties)
                                        <div>
                                            <strong>Properties:</strong>
                                            <pre class="mt-1 p-2 bg-gray-100 dark:bg-gray-700 rounded text-xs overflow-x-auto">{{ json_encode($activity->properties, JSON_PRETTY_PRINT) }}</pre>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada aktivitas ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $activities->links() }}
    </div>
</div>
