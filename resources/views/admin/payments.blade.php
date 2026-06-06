<div class="space-y-8">
    {{-- Page Header --}}
    <div class="relative">
        <div class="absolute -top-4 -left-4 w-72 h-72 bg-gradient-to-br from-emerald-400/20 to-teal-400/20 rounded-full blur-3xl opacity-50 dark:opacity-30"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-extrabold tracking-tight">
                    <span class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 dark:from-white dark:via-gray-100 dark:to-gray-300 bg-clip-text text-transparent">Manajemen Pembayaran</span>
                </h2>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Pantau semua transaksi pembayaran di platform.</p>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200/80 dark:divide-gray-700/80">
                <thead>
                    <tr class="bg-gray-50/80 dark:bg-gray-900/40">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">ID</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">Brand</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">Kampanye</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-end">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800/80">
                    @forelse ($payments as $payment)
                        <tr class="hover:bg-primary-50/40 dark:hover:bg-primary-900/10 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 bg-gray-100 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300 text-sm font-mono font-medium rounded-lg">#{{ $payment->id }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $payment->agreement?->hiring?->campaign?->brandProfile?->brand_name ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $payment->agreement?->hiring?->campaign?->title ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full
                                    @switch($payment->status->value ?? $payment->status)
                                        @case('pending') bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 @break
                                        @case('paid') bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 @break
                                        @case('failed') bg-rose-50 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400 @break
                                        @default bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300
                                    @endswitch">
                                    @php $statusVal = $payment->status->value ?? $payment->status; @endphp
                                    @if($statusVal === 'paid')
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    @elseif($statusVal === 'pending')
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    @endif
                                    {{ ucfirst($statusVal) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-end">
                                <span class="text-sm font-bold text-gray-900 dark:text-gray-100">Rp. {{ number_format($payment->total_amount ?? 0, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-100 to-teal-100 dark:from-emerald-900/30 dark:to-teal-900/30 rounded-2xl flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-emerald-400 dark:text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400 font-semibold">Tidak ada pembayaran ditemukan</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Transaksi pembayaran akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $payments->links() }}</div>
</div>
