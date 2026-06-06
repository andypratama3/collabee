<div class="space-y-8">
    {{-- Page Header --}}
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-900 via-gray-800 to-gray-600 dark:from-white dark:via-gray-200 dark:to-gray-400">Browse KOL</h1>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Find the perfect KOL for your campaign</p>
        </div>
    </div>

    {{-- Search Filters --}}
    <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 p-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search KOL name..."
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700/50 dark:text-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 placeholder-gray-400">
            </div>
            <div>
                <select wire:model.live="category" class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700/50 dark:text-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%239ca3af%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E')] bg-[length:1.25rem] bg-[right_0.5rem_center] bg-no-repeat">
                    <option value="">All Categories</option>
                    @foreach(['fashion', 'beauty', 'tech', 'gaming', 'food', 'travel', 'fitness', 'music', 'education', 'lifestyle', 'finance', 'parenting'] as $cat)
                        <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <input type="number" wire:model.live.debounce.300ms="minFollowers" placeholder="Min followers..."
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700/50 dark:text-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 placeholder-gray-400">
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
                <input type="number" step="0.1" wire:model.live.debounce.300ms="minEngagement" placeholder="Min engagement %..."
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700/50 dark:text-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 placeholder-gray-400">
            </div>
        </div>
        <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700 flex flex-wrap items-center gap-4">
            <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300 cursor-pointer group">
                <input type="checkbox" wire:model.live="openForWork" class="rounded border-gray-300 dark:border-gray-600 text-primary dark:bg-gray-700 focus:ring-primary/20 transition-all duration-200">
                <span class="group-hover:text-primary transition-colors duration-200">Open for work only</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="location" placeholder="Location..."
                       class="pl-8 pr-3 py-1.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700/50 dark:text-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 placeholder-gray-400">
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <input type="number" wire:model.live.debounce.300ms="maxBudget" placeholder="Max budget..."
                       class="pl-8 pr-3 py-1.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700/50 dark:text-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 placeholder-gray-400">
            </div>
        </div>
    </div>

    {{-- KOL Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($kols as $kol)
            <div class="group bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-gray-300/30 dark:hover:shadow-gray-900/50 hover:border-primary/20">
                <div class="flex items-start gap-4">
                    <div class="relative flex-shrink-0">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-primary/20 via-primary/10 to-purple-500/20 dark:from-primary/30 dark:via-primary/15 dark:to-purple-500/30 flex items-center justify-center text-primary dark:text-primary-400 font-bold text-lg ring-2 ring-primary/20 dark:ring-primary/30 transition-all duration-300 group-hover:ring-primary/40 group-hover:shadow-lg group-hover:shadow-primary/10">
                            {{ strtoupper(substr($kol->display_name, 0, 2)) }}
                        </div>
                        <div class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-emerald-400 rounded-full border-2 border-white dark:border-gray-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-gray-900 dark:text-gray-100 truncate group-hover:text-primary transition-colors duration-300">{{ $kol->display_name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">{{ $kol->category ? ucfirst($kol->category) : 'General' }}</p>
                        
                        <div class="grid grid-cols-2 gap-2 mt-3">
                            <div class="flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span class="font-medium">{{ number_format($kol->total_followers) }}</span>
                            </div>
                            <div class="flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                <span class="font-medium">{{ $kol->avg_engagement_rate }}%</span>
                            </div>
                            <div class="flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400">
                                <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-medium">{{ $kol->rating_avg ? number_format($kol->rating_avg, 1) : 'N/A' }}</span>
                            </div>
                            @if($kol->min_budget)
                                <div class="flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span class="font-medium">Rp. {{ number_format($kol->min_budget, 0, ',', '.') }}</span>
                                </div>
                            @endif
                        </div>
                        
                        @if($kol->location)
                            <div class="flex items-center gap-1.5 mt-2 text-sm text-gray-400 dark:text-gray-500">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $kol->location }}
                            </div>
                        @endif
                        
                        <button wire:click="openHireModal({{ $kol->id }}, '{{ addslashes($kol->display_name) }}')"
                                class="mt-4 w-full px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-primary to-primary-dark rounded-xl hover:shadow-lg hover:shadow-primary/25 transition-all duration-300 hover:-translate-y-0.5">
                            Hire
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="py-16 bg-white dark:bg-gray-800/60 backdrop-blur-xl rounded-2xl border border-dashed border-gray-300/50 dark:border-gray-700 shadow-xl shadow-gray-200/10 dark:shadow-gray-900/20">
                    <x-empty-state icon="search" title="No KOL found" description="Try adjusting your filters." />
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $kols->links() }}
    </div>

    {{-- Hire Modal --}}
    @if($showHireModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 dark:bg-black/60 backdrop-blur-sm" wire:click.self="$set('showHireModal', false)"
             style="animation: fadeIn 0.2s ease-out">
            <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-xl rounded-2xl shadow-2xl shadow-gray-900/20 dark:shadow-black/40 p-6 w-full max-w-lg mx-4 border border-gray-200 dark:border-gray-700"
                 style="animation: slideUp 0.3s ease-out">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary/20 to-primary/5 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Hire {{ $selectedKolName }}</h3>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Campaign <span class="text-red-500">*</span></label>
                        <select wire:model="hireCampaignId" class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700/50 dark:text-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200">
                            <option value="">Select a campaign</option>
                            @foreach($campaigns as $c)
                                <option value="{{ $c['id'] }}">{{ $c['title'] }}</option>
                            @endforeach
                        </select>
                        @error('hireCampaignId') <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Proposed Budget (Rp)</label>
                        <input type="number" wire:model="proposedBudget" placeholder="Leave empty to use campaign default"
                               class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700/50 dark:text-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 placeholder-gray-400">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Message</label>
                        <textarea wire:model="hireMessage" rows="3"
                                  class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700/50 dark:text-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 placeholder-gray-400"
                                  placeholder="Personal message to the KOL..."></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button wire:click="$set('showHireModal', false)"
                            class="px-5 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200">Cancel</button>
                    <button wire:click="hire"
                            class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-primary to-primary-dark rounded-xl hover:shadow-lg hover:shadow-primary/25 transition-all duration-300">Send Invitation</button>
                </div>
            </div>
        </div>
    @endif

    <style>
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(10px) scale(0.98); } to { opacity: 1; transform: translateY(0) scale(1); } }
    </style>
</div>
