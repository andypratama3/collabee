<div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Rating & Review</h2>
        </div>

        <div class="px-6 py-6 space-y-6">
            @if($stats['count'] > 0)
                <div class="flex items-center gap-4">
                    <div class="text-4xl font-bold text-yellow-500">{{ number_format($stats['average'], 1) }}</div>
                    <div>
                        <div class="flex gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="text-lg {{ $i <= round($stats['average']) ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                            @endfor
                        </div>
                        <p class="text-sm text-gray-500">{{ $stats['count'] }} review</p>
                    </div>
                </div>

                <div class="space-y-3">
                    @foreach([
                        'communication' => 'Komunikasi',
                        'professionalism' => 'Profesionalisme',
                        'quality' => 'Kualitas',
                        'timeliness' => 'Ketepatan Waktu',
                    ] as $key => $label)
                        <div>
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="text-gray-600">{{ $label }}</span>
                                <span class="font-medium text-gray-900">{{ number_format($stats['dimensions'][$key], 1) }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-yellow-400 h-2 rounded-full transition-all"
                                     style="width: {{ ($stats['dimensions'][$key] / 5) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-400 text-lg mb-1">★</p>
                    <p class="text-sm text-gray-500">Belum ada rating.</p>
                </div>
            @endif
        </div>
    </div>
</div>
