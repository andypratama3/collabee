<div>
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-0">
        <!-- Back Navigation -->
        <a href="{{ route('campaigns.explore') }}" wire:navigate class="inline-flex items-center gap-1.5 text-sm text-primary dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 font-medium mb-6 group transition-colors duration-200">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Explore
        </a>

        <!-- Campaign Card -->
        <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Featured Banner -->
            @if($campaign->is_featured)
                <div class="px-6 py-2.5 bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-yellow-900/20 border-b border-amber-100/50 dark:border-amber-800/20 flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <span class="text-sm font-semibold text-amber-700 dark:text-amber-400">Featured Campaign</span>
                </div>
            @endif

            <div class="p-6 sm:p-8">
                <!-- Title & Budget -->
                <div class="flex items-start justify-between mb-8 gap-6">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-gray-900 via-gray-800 to-gray-600 dark:from-white dark:via-gray-100 dark:to-gray-300 bg-clip-text text-transparent">{{ $campaign->title }}</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            by {{ $brand->brand_name ?? 'Unknown Brand' }}
                        </p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-xs text-gray-400 dark:text-gray-500 uppercase tracking-wider font-medium mb-1">Total Budget</p>
                        <span class="text-2xl font-bold bg-gradient-to-r from-primary to-primary-dark bg-clip-text text-transparent whitespace-nowrap">Rp. {{ number_format($campaign->budget_total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8 p-5 bg-gray-50/80 dark:bg-gray-700/30 rounded-2xl border border-gray-100/50 dark:border-gray-600/30">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider mb-2">Platforms</p>
                        <div class="flex gap-1.5 flex-wrap">
                            @foreach($campaign->platforms ?? [] as $p)
                                <span class="px-2.5 py-1 text-xs font-medium bg-white dark:bg-gray-700/80 border border-gray-200/50 dark:border-gray-600/50 rounded-lg dark:text-gray-300 shadow-sm">{{ ucfirst($p) }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider mb-2">Content Types</p>
                        <div class="flex gap-1.5 flex-wrap">
                            @foreach($campaign->content_types ?? [] as $t)
                                <span class="px-2.5 py-1 text-xs font-medium bg-white dark:bg-gray-700/80 border border-gray-200/50 dark:border-gray-600/50 rounded-lg dark:text-gray-300 shadow-sm">{{ ucfirst(str_replace('_', ' ', $t)) }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider mb-2">Budget / KOL</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                            {{ $campaign->budget_per_kol ? 'Rp ' . number_format($campaign->budget_per_kol, 0, ',', '.') : 'Negotiable' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider mb-2">Slots</p>
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $campaign->kol_filled }} / {{ $campaign->kol_slots }}</p>
                            <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-600 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-primary to-primary-dark rounded-full transition-all duration-500" style="width: {{ $campaign->kol_slots > 0 ? ($campaign->kol_filled / $campaign->kol_slots * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        Description
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">{{ $campaign->description }}</p>
                </div>

                <!-- Objectives -->
                @if($campaign->objectives)
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Objectives
                        </h2>
                        <ul class="space-y-2">
                            @foreach($campaign->objectives as $objective)
                                <li class="flex items-start gap-2.5 text-gray-600 dark:text-gray-400">
                                    <svg class="w-5 h-5 text-primary/60 dark:text-primary-400/60 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    {{ $objective }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Creative Brief -->
                @if($campaign->brief)
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Creative Brief
                        </h2>
                        <div class="p-5 bg-gray-50/80 dark:bg-gray-700/30 rounded-2xl text-gray-600 dark:text-gray-400 whitespace-pre-wrap leading-relaxed border border-gray-100/50 dark:border-gray-600/30">{{ $campaign->brief }}</div>
                    </div>
                @endif

                <!-- Campaign Info Footer -->
                <div class="grid grid-cols-3 gap-4 p-5 bg-gray-50/80 dark:bg-gray-700/30 rounded-2xl mb-8 border border-gray-100/50 dark:border-gray-600/30">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider mb-1">Category</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $campaign->kol_category ? ucfirst($campaign->kol_category) : 'Any' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider mb-1">Period</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $campaign->start_date->format('d M') }} - {{ $campaign->end_date->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider mb-1">Apply By</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $campaign->deadline_apply->format('d M Y') }}</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                @auth
                    @if(auth()->user()->isKol() && $campaign->status->value === 'open' && !$hasApplied)
                        <button wire:click="openApplyModal"
                                class="w-full px-6 py-3.5 text-sm font-semibold text-white bg-gradient-to-r from-primary to-primary-dark rounded-xl hover:shadow-xl hover:shadow-primary/25 hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            Apply Now
                        </button>
                    @elseif($hasApplied)
                        <x-alert type="success">
                            <p class="font-semibold">You have applied to this campaign</p>
                        </x-alert>
                    @elseif($campaign->status->value !== 'open')
                        <x-alert type="info">
                            <p class="font-semibold">This campaign is {{ $campaign->status->value }}</p>
                        </x-alert>
                    @endif
                @endauth

                @guest
                    <a href="{{ route('register.kol') }}"
                       class="block w-full text-center px-6 py-3.5 text-sm font-semibold text-white bg-gradient-to-r from-primary to-primary-dark rounded-xl hover:shadow-xl hover:shadow-primary/25 hover:-translate-y-0.5 transition-all duration-300">
                        Register as KOL to Apply
                    </a>
                @endguest
            </div>
        </div>
    </div>

    <!-- Apply Modal -->
    @if($showApplyModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 dark:bg-black/60 backdrop-blur-sm" wire:click.self="$set('showApplyModal', false)"
             x-data x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-xl rounded-2xl shadow-2xl shadow-gray-900/20 dark:shadow-black/40 border border-gray-200 dark:border-gray-700 p-6 w-full max-w-lg mx-4"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary/20 to-primary/10 dark:from-primary/30 dark:to-primary/15 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Apply to Campaign</h3>
                </div>
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Proposed Budget (Rp)</label>
                        <input type="number" wire:model="proposedBudget" placeholder="Your proposed fee"
                               class="w-full px-4 py-2.5 border border-gray-200/80 dark:border-gray-600/80 rounded-xl text-sm bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200">
                        @error('proposedBudget') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Message to Brand</label>
                        <textarea wire:model="applyMessage" rows="4"
                                  class="w-full px-4 py-2.5 border border-gray-200/80 dark:border-gray-600/80 rounded-xl text-sm bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200"
                                  placeholder="Tell the brand why you're the perfect fit..."></textarea>
                        @error('applyMessage') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button wire:click="$set('showApplyModal', false)"
                            class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100/80 dark:bg-gray-700/80 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-300">Cancel</button>
                    <button wire:click="apply"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-primary to-primary-dark rounded-xl hover:shadow-lg hover:shadow-primary/20 hover:-translate-y-0.5 transition-all duration-300">Submit Application</button>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.hook('component.init', ({ component }) => {
                if (component.name === 'kol.campaign.detail') {
                    component.call('incrementViews');
                }
            });
        });
    </script>
@endpush
