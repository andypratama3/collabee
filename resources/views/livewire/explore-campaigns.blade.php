<div class="space-y-8 pb-10">
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-white dark:bg-gray-800 rounded-[2rem] border border-gray-200 dark:border-gray-700 shadow-lg shadow-gray-200/50 dark:shadow-none pt-16 pb-20">
        <!-- Background Decorations -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-primary/20 blur-[120px]"></div>
            <div class="absolute top-[20%] -right-[10%] w-[40%] h-[40%] rounded-full bg-blue-500/10 blur-[100px]"></div>
        </div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary dark:bg-primary/20 dark:text-primary-400 text-sm font-semibold mb-6 ring-1 ring-inset ring-primary/20">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Temukan Peluang Barumu</span>
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-6 text-gray-900 dark:text-white">
                Jelajahi <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-600">Campaign</span>
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto font-medium">
                Temukan peluang kolaborasi terbaik yang sesuai dengan persona dan audiens Anda.
            </p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 backdrop-blur-2xl rounded-[2rem] shadow-lg shadow-gray-200/50 dark:shadow-none border border-gray-200 dark:border-gray-700 p-6 md:p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Pencarian -->
                <div class="relative group">
                    <input type="text" id="search" wire:model.live.debounce.300ms="search" placeholder=" "
                           class="peer w-full px-4 pt-6 pb-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none">
                    <label for="search" class="absolute text-sm font-semibold text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-4 left-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-1 peer-focus:scale-75 peer-focus:-translate-y-3 peer-focus:text-primary">
                        Nama Campaign
                    </label>
                    <div class="absolute right-4 top-4 text-gray-400 peer-focus:text-primary transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>

                <!-- Kategori -->
                <div class="relative group">
                    <select id="kol_category" wire:model.live="kol_category"
                            class="peer w-full px-4 pt-6 pb-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none appearance-none">
                        <option value="">Semua Kategori</option>
                        @foreach($categoryOptions as $cat)
                            <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                        @endforeach
                    </select>
                    <label for="kol_category" class="absolute text-sm font-semibold text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-4 left-4 z-10 origin-[0] peer-focus:text-primary">
                        Kategori
                    </label>
                    <div class="absolute right-4 top-5 pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>

                <!-- Budget Min -->
                <div class="relative group">
                    <input type="number" id="budget_min" wire:model.live.debounce.300ms="budget_min" placeholder=" "
                           class="peer w-full pl-10 pr-4 pt-6 pb-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none">
                    <span class="absolute left-4 top-5 text-gray-400 font-bold peer-focus:text-primary transition-colors">Rp</span>
                    <label for="budget_min" class="absolute text-sm font-semibold text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-4 left-10 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-1 peer-focus:scale-75 peer-focus:-translate-y-3 peer-focus:text-primary">
                        Budget Min
                    </label>
                </div>

                <!-- Budget Max -->
                <div class="relative group">
                    <input type="number" id="budget_max" wire:model.live.debounce.300ms="budget_max" placeholder=" "
                           class="peer w-full pl-10 pr-4 pt-6 pb-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none">
                    <span class="absolute left-4 top-5 text-gray-400 font-bold peer-focus:text-primary transition-colors">Rp</span>
                    <label for="budget_max" class="absolute text-sm font-semibold text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-4 left-10 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-1 peer-focus:scale-75 peer-focus:-translate-y-3 peer-focus:text-primary">
                        Budget Max
                    </label>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Platform</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($platformOptions as $platform)
                                <button wire:click="togglePlatform('{{ $platform }}')"
                                        class="px-4 py-2 text-sm font-semibold rounded-xl border transition-all duration-200
                                        {{ in_array($platform, $platforms) 
                                            ? 'bg-primary border-primary text-white shadow-md shadow-primary/30 transform scale-105' 
                                            : 'bg-white dark:bg-gray-800/50 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-primary/50 hover:bg-primary/5' }}">
                                    {{ ucfirst($platform) }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    @if($search || $kol_category || $budget_min || $budget_max || $platforms)
                        <button wire:click="resetFilters" class="shrink-0 px-5 py-2.5 rounded-xl text-sm font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 dark:text-rose-400 dark:bg-rose-500/10 dark:hover:bg-rose-500/20 transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Reset Filter
                        </button>
                    @endif
                </div>
            </div>
        </div>

    <!-- Campaign Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @forelse($campaigns as $campaign)
                <div class="group relative bg-white dark:bg-gray-900/80 rounded-[2rem] border border-gray-200/60 dark:border-gray-700 hover:border-primary/30 dark:hover:border-primary/30 overflow-hidden transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary/10 flex flex-col h-full">
                    
                    <!-- Decorative Top Gradient -->
                    <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-primary to-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                    <div class="p-8 flex-1 flex flex-col">
                        <!-- Header -->
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary/10 to-blue-500/10 dark:from-primary/20 dark:to-blue-500/20 flex items-center justify-center text-primary dark:text-primary-400 font-bold text-xl ring-1 ring-primary/20 group-hover:scale-110 transition-transform duration-300">
                                {{ substr($campaign->brandProfile->brand_name ?? 'C', 0, 1) }}
                            </div>
                            @if($campaign->is_featured)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold uppercase tracking-wider bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl shadow-sm">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    Featured
                                </span>
                            @endif
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-primary transition-colors line-clamp-2">
                            {{ $campaign->title }}
                        </h3>
                        
                        <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-3 mb-6 flex-1 leading-relaxed">
                            {{ $campaign->description }}
                        </p>
                        
                        <!-- Platforms -->
                        <div class="flex flex-wrap gap-2 mb-8">
                            @foreach($campaign->platforms ?? [] as $platform)
                                <span class="px-3 py-1.5 text-[11px] font-bold bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-lg uppercase tracking-wider border border-gray-200 dark:border-gray-700">
                                    {{ $platform }}
                                </span>
                            @endforeach
                        </div>

                        <!-- Info Grid -->
                        <div class="grid grid-cols-2 gap-4 p-4 rounded-2xl bg-gray-50 dark:bg-gray-800/50 mb-6 border border-gray-100 dark:border-gray-700">
                            <div>
                                <p class="text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1">Budget</p>
                                <p class="text-sm font-black text-primary dark:text-primary-400">Rp. {{ number_format($campaign->budget_total, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1">Slots</p>
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                        @php
                                            $percentage = $campaign->kol_slots > 0 ? min(100, ($campaign->kol_filled / $campaign->kol_slots) * 100) : 0;
                                        @endphp
                                        <div class="h-full bg-primary rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="text-xs font-black text-gray-700 dark:text-gray-300">
                                        {{ $campaign->kol_filled }}/{{ $campaign->kol_slots }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Info & CTA -->
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="text-xs font-semibold">{{ $campaign->deadline_apply->format('d M Y') }}</span>
                            </div>
                            
                            <a href="{{ route('campaigns.detail', $campaign) }}" wire:navigate
                               class="inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white bg-gray-900 dark:bg-white dark:text-gray-900 rounded-xl hover:bg-primary dark:hover:bg-primary dark:hover:text-white transition-all duration-300 hover:shadow-lg hover:shadow-primary/30 focus:ring-2 focus:ring-offset-2 focus:ring-primary dark:focus:ring-offset-gray-900">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-24 text-center">
                    <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800/50 rounded-full flex items-center justify-center mx-auto mb-6 ring-8 ring-gray-50 dark:ring-gray-900/50">
                        <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Campaign Tidak Ditemukan</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">Kami tidak dapat menemukan campaign yang sesuai dengan kriteria pencarian Anda. Coba sesuaikan filter untuk hasil yang lebih baik.</p>
                    <button wire:click="resetFilters" class="inline-flex items-center justify-center px-8 py-4 bg-primary text-white font-bold rounded-2xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-0.5">
                        Hapus Semua Filter
                    </button>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $campaigns->links() }}
        </div>
</div>
