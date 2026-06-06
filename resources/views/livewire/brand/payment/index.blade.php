<div class="space-y-8">
    {{-- Page Header --}}
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-900 via-gray-800 to-gray-600 dark:from-white dark:via-gray-200 dark:to-gray-400">Pembayaran</h1>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Kelola pembayaran campaign Anda</p>
        </div>
    </div>

    {{-- Filter Pills --}}
    <div class="flex flex-wrap gap-2 p-1.5 bg-white dark:bg-gray-800/60 backdrop-blur-xl rounded-2xl w-fit border border-gray-200 dark:border-gray-700 shadow-sm">
        <button wire:click="$set('filter', '')"
                class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-300 {{ empty($filter) ? 'bg-gradient-to-r from-primary to-primary-dark text-white shadow-md shadow-primary/25' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100/80 dark:hover:bg-gray-700/50' }}">
            All
        </button>
        @foreach(['pending', 'paid', 'held', 'released', 'refunded', 'expired', 'failed'] as $s)
            <button wire:click="$set('filter', '{{ $s }}')"
                    class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-300 {{ $filter === $s ? 'bg-gradient-to-r from-primary to-primary-dark text-white shadow-md shadow-primary/25' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100/80 dark:hover:bg-gray-700/50' }}">
                {{ ucfirst($s) }}
            </button>
        @endforeach
    </div>

    {{-- Pending Payments Section --}}
    @if($unpaidAgreements->isNotEmpty())
        <div class="relative">
            {{-- Gradient glow behind --}}
            <div class="absolute -inset-1 bg-gradient-to-r from-amber-400/20 via-orange-400/20 to-amber-400/20 rounded-2xl blur-lg"></div>
            <div class="relative bg-gradient-to-br from-amber-50/90 via-white/90 to-orange-50/90 dark:from-amber-900/20 dark:via-gray-800/90 dark:to-orange-900/20 backdrop-blur-xl rounded-2xl border border-amber-200/50 dark:border-amber-700/30 p-6 shadow-xl shadow-amber-200/20 dark:shadow-amber-900/20">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-400/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Menunggu Pembayaran</h2>
                        <p class="text-xs text-amber-600 dark:text-amber-400 font-medium">{{ $unpaidAgreements->count() }} payment{{ $unpaidAgreements->count() > 1 ? 's' : '' }} awaiting</p>
                    </div>
                </div>
                <div class="space-y-3">
                    @foreach($unpaidAgreements as $agreement)
                        <div class="bg-white dark:bg-gray-800/70 backdrop-blur-sm rounded-xl border border-amber-200/30 dark:border-amber-800/30 p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 transition-all duration-200 hover:bg-white/90 dark:hover:bg-gray-800/90 hover:border-amber-300/50">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $agreement->hiring->campaign->title ?? 'N/A' }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $agreement->hiring->kolProfile->display_name ?? 'N/A' }}</span>
                                    <span class="text-gray-300 dark:text-gray-600">—</span>
                                    <span class="text-sm font-bold text-amber-600 dark:text-amber-400">Rp. {{ number_format($agreement->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <button wire:click="pay({{ $agreement->id }})"
                                    class="shrink-0 px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl hover:from-amber-600 hover:to-orange-600 shadow-lg shadow-amber-500/25 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-amber-500/30">
                                Bayar Sekarang
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Payments Table --}}
    <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200/50 dark:divide-gray-700/50">
                <thead>
                    <tr class="bg-gray-50/80 dark:bg-gray-900/50">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Invoice</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Campaign</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">KOL</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    @forelse($payments as $payment)
                        <tr class="transition-colors duration-200 hover:bg-primary/[0.02] dark:hover:bg-primary/[0.05] even:bg-gray-50/30 dark:even:bg-gray-800/30">
                            <td class="px-6 py-4">
                                <span class="text-sm font-mono font-semibold text-gray-900 dark:text-white bg-gray-100/50 dark:bg-gray-700/50 px-2 py-0.5 rounded">{{ $payment->invoice_number }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $payment->agreement->hiring->campaign->title ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $payment->agreement->hiring->kolProfile->display_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-900 dark:text-white">Rp. {{ number_format($payment->total_amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold rounded-full border
                                    @if(in_array($payment->status->value, ['paid', 'released'])) bg-emerald-50 text-emerald-600 border-emerald-200/50 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800/50
                                    @elseif($payment->status->value === 'held') bg-blue-50 text-blue-600 border-blue-200/50 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-800/50
                                    @elseif($payment->status->value === 'refunded') bg-gray-50 text-gray-500 border-gray-200/50 dark:bg-gray-700/50 dark:text-gray-300 dark:border-gray-600/50
                                    @elseif(in_array($payment->status->value, ['expired', 'failed'])) bg-red-50 text-red-600 border-red-200/50 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800/50
                                    @else bg-amber-50 text-amber-600 border-amber-200/50 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800/50
                                    @endif">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                        @if(in_array($payment->status->value, ['paid', 'released'])) bg-emerald-500
                                        @elseif($payment->status->value === 'held') bg-blue-500
                                        @elseif($payment->status->value === 'refunded') bg-gray-400
                                        @elseif(in_array($payment->status->value, ['expired', 'failed'])) bg-red-500
                                        @else bg-amber-500
                                        @endif"></span>
                                    {{ ucfirst($payment->status->value) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $payment->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                @if($payment->status->value === 'pending' && $payment->agreement->status === 'signed')
                                    <button wire:click="pay({{ $payment->agreement_id }})"
                                            class="px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-primary to-primary-dark rounded-xl hover:shadow-lg hover:shadow-primary/25 transition-all duration-300">
                                        Bayar
                                    </button>
                                @elseif($payment->gateway_invoice_url && $payment->status->value === 'pending')
                                    <a href="{{ $payment->gateway_invoice_url }}" target="_blank"
                                       class="inline-flex items-center px-4 py-2 text-sm font-semibold text-primary dark:text-primary-400 bg-primary/5 dark:bg-primary/10 rounded-xl hover:bg-primary/10 dark:hover:bg-primary/20 transition-all duration-200 border border-primary/10 dark:border-primary/20">
                                        Lanjutkan
                                        <svg class="w-3.5 h-3.5 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                @else
                                    <span class="text-sm text-gray-300 dark:text-gray-600">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada pembayaran.</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Payments will appear once agreements are made.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8">{{ $payments->links() }}</div>
</div>
