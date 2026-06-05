<div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                Beri Rating {{ $type === 'kol' ? 'KOL' : 'Brand' }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Campaign: {{ $hiring->campaign?->title ?? 'N/A' }}
            </p>
        </div>

        <div class="px-6 py-6 space-y-6">
            @foreach(['communication' => 'Komunikasi', 'professionalism' => 'Profesionalisme', 'quality' => 'Kualitas', 'timeliness' => 'Ketepatan Waktu'] as $field => $label)
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ $label }}</label>
                    <div class="flex gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button"
                                    wire:click="$set('{{ $field }}', {{ $i }})"
                                    class="w-10 h-10 rounded-full flex items-center justify-center text-lg transition-colors
                                    {{ ${$field} >= $i ? 'bg-yellow-400 text-yellow-800' : 'bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                                ★
                            </button>
                        @endfor
                    </div>
                    @error($field) <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            @endforeach

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Review (opsional)</label>
                <textarea wire:model="review" rows="3"
                          class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm dark:bg-gray-700 dark:text-gray-200"
                          placeholder="Tulis review Anda..."></textarea>
                @error('review') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-4 border-t dark:border-gray-700">
                @if($type === 'kol')
                    <button wire:click="submitBrandRating"
                            class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        Kirim Rating
                    </button>
                @else
                    <button wire:click="submitKolRating"
                            class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        Kirim Rating
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
