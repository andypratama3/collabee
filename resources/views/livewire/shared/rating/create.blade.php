<div>
    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Header -->
            <div class="px-6 md:px-8 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50/80 to-white/80 dark:from-gray-800/80 dark:to-gray-800/50">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                        Beri Rating {{ $type === 'kol' ? 'KOL' : 'Brand' }}
                    </h2>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Campaign: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $hiring->campaign?->title ?? 'N/A' }}</span>
                    &mdash;
                    <span class="text-gray-500">
                        @if($type === 'kol')
                            KOL: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $hiring->kolProfile?->display_name ?? 'N/A' }}</span>
                        @else
                            Brand: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $hiring->brandProfile?->brand_name ?? 'N/A' }}</span>
                        @endif
                    </span>
                </p>
            </div>

            <!-- Rating Form -->
            <div class="px-6 md:px-8 py-6 md:py-8 space-y-7">

                {{-- Communication --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Komunikasi</label>
                    <div class="flex items-center gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button"
                                    wire:click="$set('communication', {{ $i }})"
                                    class="w-11 h-11 rounded-xl flex items-center justify-center text-xl font-bold transition-all duration-200 hover:-translate-y-0.5
                                    {{ $communication >= $i ? 'bg-gradient-to-br from-yellow-400 to-amber-500 text-white shadow-md shadow-yellow-400/30' : 'bg-gray-100 dark:bg-gray-700/50 text-gray-300 dark:text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                                ★
                            </button>
                        @endfor
                        <span class="ml-2 text-sm font-bold {{ $communication > 0 ? 'text-amber-500' : 'text-gray-300 dark:text-gray-600' }}">
                            {{ $communication > 0 ? $communication . '/5' : '' }}
                        </span>
                    </div>
                    @error('communication') <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Professionalism --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Profesionalisme</label>
                    <div class="flex items-center gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button"
                                    wire:click="$set('professionalism', {{ $i }})"
                                    class="w-11 h-11 rounded-xl flex items-center justify-center text-xl font-bold transition-all duration-200 hover:-translate-y-0.5
                                    {{ $professionalism >= $i ? 'bg-gradient-to-br from-yellow-400 to-amber-500 text-white shadow-md shadow-yellow-400/30' : 'bg-gray-100 dark:bg-gray-700/50 text-gray-300 dark:text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                                ★
                            </button>
                        @endfor
                        <span class="ml-2 text-sm font-bold {{ $professionalism > 0 ? 'text-amber-500' : 'text-gray-300 dark:text-gray-600' }}">
                            {{ $professionalism > 0 ? $professionalism . '/5' : '' }}
                        </span>
                    </div>
                    @error('professionalism') <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Quality --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Kualitas Konten</label>
                    <div class="flex items-center gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button"
                                    wire:click="$set('quality', {{ $i }})"
                                    class="w-11 h-11 rounded-xl flex items-center justify-center text-xl font-bold transition-all duration-200 hover:-translate-y-0.5
                                    {{ $quality >= $i ? 'bg-gradient-to-br from-yellow-400 to-amber-500 text-white shadow-md shadow-yellow-400/30' : 'bg-gray-100 dark:bg-gray-700/50 text-gray-300 dark:text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                                ★
                            </button>
                        @endfor
                        <span class="ml-2 text-sm font-bold {{ $quality > 0 ? 'text-amber-500' : 'text-gray-300 dark:text-gray-600' }}">
                            {{ $quality > 0 ? $quality . '/5' : '' }}
                        </span>
                    </div>
                    @error('quality') <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Timeliness --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Ketepatan Waktu</label>
                    <div class="flex items-center gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button"
                                    wire:click="$set('timeliness', {{ $i }})"
                                    class="w-11 h-11 rounded-xl flex items-center justify-center text-xl font-bold transition-all duration-200 hover:-translate-y-0.5
                                    {{ $timeliness >= $i ? 'bg-gradient-to-br from-yellow-400 to-amber-500 text-white shadow-md shadow-yellow-400/30' : 'bg-gray-100 dark:bg-gray-700/50 text-gray-300 dark:text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                                ★
                            </button>
                        @endfor
                        <span class="ml-2 text-sm font-bold {{ $timeliness > 0 ? 'text-amber-500' : 'text-gray-300 dark:text-gray-600' }}">
                            {{ $timeliness > 0 ? $timeliness . '/5' : '' }}
                        </span>
                    </div>
                    @error('timeliness') <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Review text --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Review (opsional)</label>
                    <textarea wire:model="review" rows="3"
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm focus:ring-2 focus:ring-primary/20 focus:border-primary text-sm bg-white dark:bg-gray-900/50 dark:text-gray-200 transition-all duration-200"
                              placeholder="Ceritakan pengalaman Anda bekerja sama..."></textarea>
                    @error('review') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Submit --}}
                <div class="flex items-center gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    @if($type === 'kol')
                        <button wire:click="submitBrandRating" wire:loading.attr="disabled"
                                class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-primary to-primary-dark rounded-xl shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-0.5 transition-all duration-300 disabled:opacity-70 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="submitBrandRating">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </span>
                            <span wire:loading wire:target="submitBrandRating">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            </span>
                            Kirim Rating
                        </button>
                    @else
                        <button wire:click="submitKolRating" wire:loading.attr="disabled"
                                class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-primary to-primary-dark rounded-xl shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-0.5 transition-all duration-300 disabled:opacity-70 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="submitKolRating">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </span>
                            <span wire:loading wire:target="submitKolRating">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            </span>
                            Kirim Rating
                        </button>
                    @endif

                    <a href="{{ auth()->user()->isBrand() ? route('brand.hiring.index') : route('kol.hiring.index') }}" wire:navigate
                       class="px-5 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200">
                        Lewati
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
