<div>
    <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
        <!-- Header -->
        <div class="px-6 md:px-8 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50/80 to-white/80 dark:from-gray-800/80 dark:to-gray-800/50">
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                Rating & Review
            </h2>
        </div>

        <div class="px-6 md:px-8 py-6 md:py-8 space-y-6">
            @if($stats['count'] > 0)
                <!-- Overall Rating -->
                <div class="flex items-center gap-5 p-5 rounded-xl bg-gradient-to-r from-amber-50/80 to-yellow-50/50 dark:from-amber-900/10 dark:to-yellow-900/5 border border-amber-100/50 dark:border-amber-800/30">
                    <div class="text-center">
                        <div class="text-4xl font-extrabold bg-gradient-to-br from-yellow-500 to-amber-600 bg-clip-text text-transparent">{{ number_format($stats['average'], 1) }}</div>
                        <p class="text-xs text-gray-400 dark:text-gray-500 font-medium mt-1">dari 5.0</p>
                    </div>
                    <div class="border-l border-amber-200/50 dark:border-amber-800/30 pl-5">
                        <div class="flex gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="text-xl {{ $i <= round($stats['average']) ? 'text-yellow-400 drop-shadow-sm' : 'text-gray-200 dark:text-gray-600' }}">★</span>
                            @endfor
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            {{ $stats['count'] }} review
                        </p>
                    </div>
                </div>

                <!-- Dimension Breakdown -->
                <div class="space-y-4">
                    @foreach([
                        'communication' => 'Komunikasi',
                        'professionalism' => 'Profesionalisme',
                        'quality' => 'Kualitas',
                        'timeliness' => 'Ketepatan Waktu',
                    ] as $key => $label)
                        <div class="group">
                            <div class="flex items-center justify-between text-sm mb-2">
                                <span class="font-medium text-gray-600 dark:text-gray-400">{{ $label }}</span>
                                <span class="font-bold text-gray-900 dark:text-gray-100">{{ number_format($stats['dimensions'][$key], 1) }}</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-700/50 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-yellow-400 to-amber-500 h-2.5 rounded-full transition-all duration-700 ease-out"
                                     style="width: {{ ($stats['dimensions'][$key] / 5) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-50 to-amber-50 dark:from-yellow-900/10 dark:to-amber-900/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-yellow-300 dark:text-yellow-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-base font-semibold text-gray-500 dark:text-gray-400">Belum ada rating</p>
                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Rating akan muncul setelah kolaborasi selesai.</p>
                </div>
            @endif
        </div>
    </div>
</div>
