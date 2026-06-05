<div>
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Agreements</h1>
            <p class="mt-1 text-sm text-gray-500">Review and sign collaboration agreements</p>
        </div>
    </div>

    <div class="flex gap-2 mb-6 flex-wrap">
        <button wire:click="$set('filter', '')"
                class="px-3 py-1.5 text-sm rounded-full {{ empty($filter) ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">All</button>
        @foreach(['pending', 'signed'] as $s)
            <button wire:click="$set('filter', '{{ $s }}')"
                    class="px-3 py-1.5 text-sm rounded-full {{ $filter === $s ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">{{ ucfirst($s) }}</button>
        @endforeach
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Number</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Brand</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Campaign</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($agreements as $agreement)
                    <tr>
                        <td class="px-6 py-4 text-sm font-mono text-gray-900">{{ $agreement->agreement_number }}</td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-900">{{ $agreement->hiring->brandProfile->user->name ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $agreement->hiring->campaign->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($agreement->total_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full
                                @if($agreement->status === 'signed') bg-green-100 text-green-700
                                @else bg-yellow-100 text-yellow-700
                                @endif">{{ ucfirst($agreement->status) }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('kol.agreement.show', $agreement) }}" class="text-sm text-indigo-600 hover:text-indigo-800">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">No agreements found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $agreements->links() }}</div>
</div>
