<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Manajemen Campaign</h2>
    </div>

    <div class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari campaign..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <select wire:model.live="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">Semua Status</option>
            @foreach ($statuses as $status)
                <option value="{{ $status->value }}">{{ ucfirst(str_replace('_', ' ', $status->value)) }}</option>
            @endforeach
        </select>
    </div>

    <div class="overflow-hidden bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Campaign</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Brand</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Status</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Budget</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">KOL</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Featured</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-end">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($campaigns as $campaign)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-900">{{ $campaign->title }}</p>
                            <p class="text-xs text-gray-500">{{ $campaign->created_at->format('d M Y') }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $campaign->brandProfile?->brand_name ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                {{ $campaign->status->value === 'open' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $campaign->status->value === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                                {{ $campaign->status->value === 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $campaign->status->value === 'completed' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                {{ $campaign->status->value === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $campaign->status->value === 'paused' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                {{ ucfirst(str_replace('_', ' ', $campaign->status->value)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">Rp {{ number_format($campaign->budget_total, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $campaign->kol_filled }}/{{ $campaign->kol_slots }}</td>
                        <td class="px-6 py-4">
                            @if ($campaign->is_featured)
                                <span class="px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Featured</span>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-end">
                            <div class="flex items-center justify-end gap-2">
                                @if ($campaign->is_featured)
                                    <button wire:click="unfeature({{ $campaign->id }})" class="px-3 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded-lg hover:bg-yellow-200">Unfeature</button>
                                @else
                                    <button wire:click="feature({{ $campaign->id }})" class="px-3 py-1 text-xs font-medium text-indigo-700 bg-indigo-100 rounded-lg hover:bg-indigo-200">Feature</button>
                                @endif
                                @if ($campaign->status->value === 'cancelled')
                                    <button wire:click="activate({{ $campaign->id }})" class="px-3 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-lg hover:bg-green-200">Aktifkan</button>
                                @elseif ($campaign->status->value !== 'completed')
                                    <button wire:click="suspend({{ $campaign->id }})" class="px-3 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-lg hover:bg-red-200">Suspend</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">Tidak ada campaign ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $campaigns->links() }}
    </div>
</div>
