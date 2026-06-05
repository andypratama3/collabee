<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Manajemen Pembayaran</h2>
        <button wire:click="export" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
            Export Excel
        </button>
    </div>

    <div class="flex flex-wrap gap-4">
        <select wire:model.live="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">Semua Status</option>
            @foreach ($statuses as $status)
                <option value="{{ $status->value }}">{{ ucfirst($status->value) }}</option>
            @endforeach
        </select>
    </div>

    <div class="overflow-hidden bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Invoice</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Brand</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Amount</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Fee</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Total</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Status</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($payments as $payment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $payment->invoice_number }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $payment->agreement?->hiring?->campaign?->brandProfile?->brand_name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">Rp {{ number_format($payment->platform_fee, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                {{ $payment->status->value === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $payment->status->value === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $payment->status->value === 'held' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $payment->status->value === 'released' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                {{ in_array($payment->status->value, ['refunded', 'expired', 'failed']) ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($payment->status->value) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $payment->paid_at ? $payment->paid_at->format('d M Y H:i') : $payment->created_at->format('d M Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">Tidak ada pembayaran ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $payments->links() }}
    </div>
</div>
