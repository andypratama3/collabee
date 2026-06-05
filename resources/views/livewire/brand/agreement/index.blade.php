<div>
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Perjanjian</h1>
            <p class="mt-1 text-sm text-gray-500">Tinjau dan tandatangani perjanjian kerjasama</p>
        </div>
    </div>

    <div class="flex gap-2 mb-6 flex-wrap">
        <button wire:click="$set('filter', '')"
                class="px-3 py-1.5 text-sm rounded-full {{ empty($filter) ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Semua</button>
        @foreach(['draft', 'signed'] as $s)
            <button wire:click="$set('filter', '{{ $s }}')"
                    class="px-3 py-1.5 text-sm rounded-full {{ $filter === $s ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">{{ $s === 'draft' ? 'Draft' : 'Ditandatangani' }}</button>
        @endforeach
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nomor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">KOL</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kampanye</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($agreements as $agreement)
                    <tr>
                        <td class="px-6 py-4 text-sm font-mono text-gray-900">{{ $agreement->agreement_number }}</td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-900">{{ $agreement->hiring->kolProfile->display_name ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $agreement->hiring->campaign->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($agreement->total_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full
                                @if($agreement->status === 'signed') bg-green-100 text-green-700
                                @else bg-yellow-100 text-yellow-700
                                @endif">
                                {{ $agreement->status === 'signed' ? 'Ditandatangani' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('brand.agreement.show', $agreement) }}"
                               class="text-sm text-indigo-600 hover:text-indigo-800">Lihat</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">Belum ada perjanjian.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $agreements->links() }}</div>
</div>
