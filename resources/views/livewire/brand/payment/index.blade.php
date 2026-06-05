<div>
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pembayaran</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola pembayaran campaign Anda</p>
        </div>
    </div>

    <div class="flex gap-2 mb-6 flex-wrap">
        <button wire:click="$set('filter', '')"
                class="px-3 py-1.5 text-sm rounded-full {{ empty($filter) ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            All
        </button>
        @foreach(['pending', 'paid', 'held', 'released', 'refunded', 'expired', 'failed'] as $s)
            <button wire:click="$set('filter', '{{ $s }}')"
                    class="px-3 py-1.5 text-sm rounded-full {{ $filter === $s ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                {{ ucfirst($s) }}
            </button>
        @endforeach
    </div>

    @if($unpaidAgreements->isNotEmpty())
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-3">Menunggu Pembayaran</h2>
            <div class="space-y-3">
                @foreach($unpaidAgreements as $agreement)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">{{ $agreement->hiring->campaign->title ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $agreement->hiring->kolProfile->display_name ?? 'N/A' }} —
                                Rp {{ number_format($agreement->total_amount, 0, ',', '.') }}
                            </p>
                        </div>
                        <button wire:click="pay({{ $agreement->id }})"
                                class="ml-4 px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                            Bayar Sekarang
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Invoice</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Campaign</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">KOL</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($payments as $payment)
                    <tr>
                        <td class="px-6 py-4 text-sm font-mono text-gray-900">{{ $payment->invoice_number }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $payment->agreement->hiring->campaign->title ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $payment->agreement->hiring->kolProfile->display_name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full
                                @if(in_array($payment->status->value, ['paid', 'released'])) bg-green-100 text-green-700
                                @elseif($payment->status->value === 'held') bg-blue-100 text-blue-700
                                @elseif($payment->status->value === 'refunded') bg-gray-100 text-gray-600
                                @elseif(in_array($payment->status->value, ['expired', 'failed'])) bg-red-100 text-red-700
                                @else bg-yellow-100 text-yellow-700
                                @endif">
                                {{ ucfirst($payment->status->value) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $payment->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            @if($payment->status->value === 'pending' && $payment->agreement->status === 'signed')
                                <button wire:click="pay({{ $payment->agreement_id }})"
                                        class="px-3 py-1.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                                    Bayar
                                </button>
                            @elseif($payment->gateway_invoice_url && $payment->status->value === 'pending')
                                <a href="{{ $payment->gateway_invoice_url }}" target="_blank"
                                   class="px-3 py-1.5 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100">
                                    Lanjutkan
                                </a>
                            @else
                                <span class="text-sm text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">Belum ada pembayaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $payments->links() }}</div>
</div>
