<div>
    <!-- Back Navigation -->
    <div class="mb-6">
        <a href="{{ route('brand.agreement.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary-400 transition-colors duration-200 group">
            <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Perjanjian
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
        <!-- Header -->
        <div class="px-6 md:px-8 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50/80 to-white/80 dark:from-gray-800/80 dark:to-gray-800/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5 text-primary dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Perjanjian {{ $agreement->agreement_number }}</h2>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Kampanye: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $agreement->hiring->campaign->title }}</span> &mdash;
                    KOL: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $agreement->hiring->kolProfile->display_name }}</span>
                </p>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-sm font-semibold rounded-xl self-start
                @if($agreement->status === 'signed') bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 ring-1 ring-emerald-200/50 dark:ring-emerald-800/50
                @else bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 ring-1 ring-amber-200/50 dark:ring-amber-800/50
                @endif">
                @if($agreement->status === 'signed')
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                @endif
                {{ $agreement->status === 'signed' ? 'Ditandatangani' : 'Draft' }}
            </span>
        </div>

        <!-- Content -->
        <div class="px-6 md:px-8 py-6 md:py-8 space-y-8">
            <!-- Detail Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="p-4 rounded-xl bg-gray-50/80 dark:bg-gray-900/30 border border-gray-100/50 dark:border-gray-700/30">
                    <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Jumlah Total</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">Rp. {{ number_format($agreement->total_amount, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 rounded-xl bg-gray-50/80 dark:bg-gray-900/30 border border-gray-100/50 dark:border-gray-700/30">
                    <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Biaya Platform</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $agreement->platform_fee_percent }}%</p>
                </div>
            </div>

            <!-- Signature Status -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex items-start gap-3 p-4 rounded-xl border border-gray-100/50 dark:border-gray-700/30 {{ $agreement->brand_signed_at ? 'bg-emerald-50/50 dark:bg-emerald-900/10' : 'bg-amber-50/30 dark:bg-amber-900/10' }}">
                    <div class="p-2 rounded-lg {{ $agreement->brand_signed_at ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400' : 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Tanda Tangan Brand</p>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            @if($agreement->brand_signed_at)
                                Ditandatangani {{ $agreement->brand_signed_at->format('d M Y H:i') }}
                                <span class="block text-xs text-gray-400 dark:text-gray-500 mt-0.5">IP: {{ $agreement->brand_signed_ip }}</span>
                            @else
                                <span class="text-amber-600 dark:text-amber-400 font-medium">Menunggu tanda tangan</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-4 rounded-xl border border-gray-100/50 dark:border-gray-700/30 {{ $agreement->kol_signed_at ? 'bg-emerald-50/50 dark:bg-emerald-900/10' : 'bg-amber-50/30 dark:bg-amber-900/10' }}">
                    <div class="p-2 rounded-lg {{ $agreement->kol_signed_at ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400' : 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Tanda Tangan KOL</p>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            @if($agreement->kol_signed_at)
                                Ditandatangani {{ $agreement->kol_signed_at->format('d M Y H:i') }}
                                <span class="block text-xs text-gray-400 dark:text-gray-500 mt-0.5">IP: {{ $agreement->kol_signed_ip }}</span>
                            @else
                                <span class="text-amber-600 dark:text-amber-400 font-medium">Menunggu tanda tangan</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Terms -->
            <div>
                <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">Syarat & Ketentuan</p>
                <div class="bg-gray-50/80 dark:bg-gray-900/30 rounded-xl p-5 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed border border-gray-100/50 dark:border-gray-700/30">
                    {{ $agreement->terms }}
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-wrap items-center gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                @if(!$agreement->brand_signed_at)
                    <button wire:click="sign"
                            class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-primary to-primary-dark rounded-xl shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-0.5 transition-all duration-300 focus:ring-4 focus:ring-primary/20"
                            wire:confirm="Dengan menandatangani, Anda menyetujui syarat dan ketentuan di atas.">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Tanda Tangan sebagai Brand
                    </button>
                @else
                    <span class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl ring-1 ring-emerald-200/50 dark:ring-emerald-800/50">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Ditandatangani oleh Anda
                    </span>
                @endif

                @if($agreement->status === 'signed' && $agreement->pdf_path)
                    <a href="{{ asset('storage/' . $agreement->pdf_path) }}" target="_blank"
                       class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-primary dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 rounded-xl ring-1 ring-primary-200/50 dark:ring-primary-800/50 hover:bg-primary-100 dark:hover:bg-primary-900/30 hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Unduh PDF
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
