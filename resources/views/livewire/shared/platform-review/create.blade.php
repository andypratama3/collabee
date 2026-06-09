<div>
    <div class="max-w-xl mx-auto">
        {{-- Success confetti header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-primary/20 to-violet-500/20 dark:from-primary/30 dark:to-violet-500/30 mb-4 ring-4 ring-primary/10 dark:ring-primary/20">
                <svg class="w-10 h-10 text-primary dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Campaign Selesai! 🎉</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Bagaimana pengalaman Anda menggunakan Collabee? Bantu kami berkembang dengan review Anda.</p>
        </div>

        <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Header -->
            <div class="px-6 md:px-8 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-primary/5 to-violet-500/5 dark:from-primary/10 dark:to-violet-500/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary/20 to-violet-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.482-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Review Platform Collabee</h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Berikan penilaian jujur Anda</p>
                    </div>
                </div>
            </div>

            <div class="px-6 md:px-8 py-6 md:py-8 space-y-7">

                {{-- Star Rating --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Seberapa puas Anda dengan Collabee?</label>

                    {{-- Big star selector --}}
                    <div class="flex items-center gap-3 justify-center py-4">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button"
                                    wire:click="$set('rating', {{ $i }})"
                                    class="group relative transition-all duration-200 hover:-translate-y-1 focus:outline-none">
                                <svg class="w-12 h-12 transition-all duration-200
                                    {{ $rating >= $i
                                        ? 'text-amber-400 drop-shadow-[0_0_8px_rgba(251,191,36,0.6)] scale-110'
                                        : 'text-gray-200 dark:text-gray-600 group-hover:text-amber-300 group-hover:scale-105' }}"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </button>
                        @endfor
                    </div>

                    {{-- Label under stars --}}
                    <div class="text-center mt-1">
                        @if($rating === 0)
                            <span class="text-sm text-gray-400 dark:text-gray-500">Klik bintang untuk memberi penilaian</span>
                        @elseif($rating === 1)
                            <span class="text-sm font-semibold text-red-500">😞 Sangat Buruk</span>
                        @elseif($rating === 2)
                            <span class="text-sm font-semibold text-orange-500">😕 Buruk</span>
                        @elseif($rating === 3)
                            <span class="text-sm font-semibold text-yellow-500">😐 Cukup</span>
                        @elseif($rating === 4)
                            <span class="text-sm font-semibold text-lime-500">😊 Bagus</span>
                        @elseif($rating === 5)
                            <span class="text-sm font-semibold text-emerald-500">🤩 Luar Biasa!</span>
                        @endif
                    </div>

                    @error('rating') <p class="mt-2 text-xs text-red-600 dark:text-red-400 text-center">{{ $message }}</p> @enderror
                </div>

                {{-- Review text --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                        Ceritakan pengalaman Anda
                        <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <textarea wire:model="review" rows="4"
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm focus:ring-2 focus:ring-primary/20 focus:border-primary text-sm bg-white dark:bg-gray-900/50 dark:text-gray-200 transition-all duration-200 resize-none"
                              placeholder="Apa yang Anda suka? Apa yang perlu kami tingkatkan? Saran Anda sangat berarti..."></textarea>
                    <p class="mt-1 text-xs text-gray-400 dark:text-gray-500 text-right">{{ strlen($review) }}/2000</p>
                    @error('review') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button wire:click="submit" wire:loading.attr="disabled"
                            class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-primary to-primary-dark rounded-xl shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-0.5 transition-all duration-300 disabled:opacity-70 disabled:cursor-not-allowed disabled:translate-y-0">
                        <span wire:loading.remove wire:target="submit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </span>
                        <span wire:loading wire:target="submit">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        </span>
                        Kirim Review
                    </button>

                    <button wire:click="skip"
                            class="px-5 py-2.5 text-sm font-semibold text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200">
                        Lewati →
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
