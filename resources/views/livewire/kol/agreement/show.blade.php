<div>
    <div class="mb-4">
        <a href="{{ route('kol.agreement.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800">&larr; Kembali ke Perjanjian</a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Perjanjian {{ $agreement->agreement_number }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Kampanye: {{ $agreement->hiring->campaign->title }} &mdash;
                    Brand: {{ $agreement->hiring->brandProfile->user->name }}
                </p>
            </div>
            <span class="px-3 py-1 text-sm font-medium rounded-full self-start
                @if($agreement->status === 'signed') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400
                @else bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400
                @endif">{{ $agreement->status === 'signed' ? 'Ditandatangani' : 'Draft' }}</span>
        </div>

        <div class="px-6 py-6 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jumlah Total</p>
                    <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">Rp {{ number_format($agreement->total_amount, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Biaya Platform</p>
                    <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $agreement->platform_fee_percent }}%</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanda Tangan Brand</p>
                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                        @if($agreement->brand_signed_at)
                            Ditandatangani {{ $agreement->brand_signed_at->format('d M Y H:i') }}
                            <span class="text-xs text-gray-500 dark:text-gray-400">(IP: {{ $agreement->brand_signed_ip }})</span>
                        @else
                            <span class="text-yellow-600 dark:text-yellow-400">Menunggu tanda tangan</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanda Tangan KOL</p>
                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                        @if($agreement->kol_signed_at)
                            Ditandatangani {{ $agreement->kol_signed_at->format('d M Y H:i') }}
                            <span class="text-xs text-gray-500 dark:text-gray-400">(IP: {{ $agreement->kol_signed_ip }})</span>
                        @else
                            <span class="text-yellow-600 dark:text-yellow-400">Menunggu tanda tangan</span>
                        @endif
                    </p>
                </div>
            </div>

            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Syarat & Ketentuan</p>
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed">
                    {{ $agreement->terms }}
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t dark:border-gray-700">
                @if(!$agreement->kol_signed_at)
                    <button wire:click="sign"
                            class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700"
                            wire:confirm="Dengan menandatangani, Anda menyetujui syarat dan ketentuan di atas.">
                        Tanda Tangan sebagai KOL
                    </button>
                @else
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-900/30 rounded-lg">
                        Ditandatangani oleh Anda
                    </span>
                @endif

                @if($agreement->status === 'signed' && $agreement->pdf_path)
                    <a href="{{ asset('storage/' . $agreement->pdf_path) }}" target="_blank"
                       class="px-4 py-2.5 text-sm font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/50">
                        Unduh PDF
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
