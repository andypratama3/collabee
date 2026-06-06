<div>
    <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
        <!-- Header -->
        <div class="px-6 md:px-8 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50/80 to-white/80 dark:from-gray-800/80 dark:to-gray-800/50">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                    Beri Rating {{ $type === 'kol' ? 'KOL' : 'Brand' }}
                </h2>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Campaign: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $hiring->campaign?->title ?? 'N/A' }}</span>
            </p>
        </div>

        <!-- Rating Form -->
        <div class="px-6 md:px-8 py-6 md:py-8 space-y-8">
            @foreach(['communication' => 'Komunikasi', 'professionalism' => 'Profesionalisme', 'quality' => 'Kualitas', 'timeliness' => 'Ketepatan Waktu'] as $field => $label)
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">{{ $label }}</label>
                    <div class="flex gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button"
                                    wire:click="$set('{{ $field }}', {{ $i }})"
                                    class="w-11 h-11 rounded-xl flex items-center justify-center text-lg transition-all duration-300 hover:-translate-y-0.5
                                    {{ ${$field} >= $i ? 'bg-gradient-to-br from-yellow-400 to-amber-500 text-white shadow-md shadow-yellow-400/30' : 'bg-gray-100 dark:bg-gray-700/50 text-gray-300 dark:text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-600 hover:shadow-sm' }}">
                                ★
                            </button>
                        @endfor
                        <span class="ml-2 flex items-center text-sm font-bold {{ ${$field} > 0 ? 'text-amber-500' : 'text-gray-300 dark:text-gray-600' }}">
                            {{ ${$field} > 0 ? ${$field} . '/5' : '' }}
                        </span>
                    </div>
                    @error($field) <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                </div>
            @endforeach

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Review (opsional)</label>
                <textarea wire:model="review" rows="3"
                          class="w-full rounded-xl border-gray-200 dark:border-gray-700 shadow-sm focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 text-sm dark:bg-gray-900/50 dark:text-gray-200 transition-all duration-300"
                          placeholder="Tulis review Anda..."></textarea>
                @error('review') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                @if($type === 'kol')
                    <button wire:click="submitBrandRating"
                            class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-primary to-primary-dark rounded-xl shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-0.5 transition-all duration-300 focus:ring-4 focus:ring-primary/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Kirim Rating
                    </button>
                @else
                    <button wire:click="submitKolRating"
                            class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-primary to-primary-dark rounded-xl shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-0.5 transition-all duration-300 focus:ring-4 focus:ring-primary/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Kirim Rating
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
