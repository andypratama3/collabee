<div>
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-0">
        <a href="{{ route('campaigns.explore') }}" wire:navigate class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 mb-4 inline-block">
            &larr; Back to Explore
        </a>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            @if($campaign->is_featured)
                <div class="px-6 py-2 bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-sm font-medium">Featured Campaign</div>
            @endif

            <div class="p-6 sm:p-8">
                <div class="flex items-start justify-between mb-6 gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $campaign->title }}</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">by {{ $brand->brand_name ?? 'Unknown Brand' }}</p>
                    </div>
                    <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 whitespace-nowrap">Rp {{ number_format($campaign->budget_total, 0, ',', '.') }}</span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Platforms</p>
                        <div class="flex gap-1 mt-1 flex-wrap">
                            @foreach($campaign->platforms ?? [] as $p)
                                <span class="px-2 py-0.5 text-xs bg-white dark:bg-gray-700 border dark:border-gray-600 rounded-full dark:text-gray-300">{{ ucfirst($p) }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Content Types</p>
                        <div class="flex gap-1 mt-1 flex-wrap">
                            @foreach($campaign->content_types ?? [] as $t)
                                <span class="px-2 py-0.5 text-xs bg-white dark:bg-gray-700 border dark:border-gray-600 rounded-full dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $t)) }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Budget / KOL</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100 mt-1">
                            {{ $campaign->budget_per_kol ? 'Rp ' . number_format($campaign->budget_per_kol, 0, ',', '.') : 'Negotiable' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Slots</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $campaign->kol_filled }} / {{ $campaign->kol_slots }} filled</p>
                    </div>
                </div>

                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Description</h2>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">{{ $campaign->description }}</p>
                </div>

                @if($campaign->objectives)
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Objectives</h2>
                        <ul class="list-disc list-inside space-y-1 text-gray-600 dark:text-gray-400">
                            @foreach($campaign->objectives as $objective)
                                <li>{{ $objective }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($campaign->brief)
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Creative Brief</h2>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $campaign->brief }}</div>
                    </div>
                @endif

                <div class="grid grid-cols-3 gap-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg mb-6">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Category</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $campaign->kol_category ? ucfirst($campaign->kol_category) : 'Any' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Period</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $campaign->start_date->format('d M') }} - {{ $campaign->end_date->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Apply By</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $campaign->deadline_apply->format('d M Y') }}</p>
                    </div>
                </div>

                @auth
                    @if(auth()->user()->isKol() && $campaign->status->value === 'open' && !$hasApplied)
                        <button wire:click="openApplyModal"
                                class="w-full px-6 py-3 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                            Apply Now
                        </button>
                    @elseif($hasApplied)
                        <div class="w-full px-6 py-3 text-sm font-medium text-center text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-900/30 rounded-lg">
                            You have applied to this campaign
                        </div>
                    @elseif($campaign->status->value !== 'open')
                        <div class="w-full px-6 py-3 text-sm font-medium text-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            This campaign is {{ $campaign->status->value }}
                        </div>
                    @endif
                @endauth

                @guest
                    <a href="{{ route('register.kol') }}"
                       class="block w-full text-center px-6 py-3 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        Register as KOL to Apply
                    </a>
                @endguest
            </div>
        </div>
    </div>

    @if($showApplyModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 dark:bg-black/70" wire:click.self="$set('showApplyModal', false)">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 w-full max-w-lg mx-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Apply to Campaign</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Proposed Budget (Rp)</label>
                        <input type="number" wire:model="proposedBudget" placeholder="Your proposed fee"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-gray-200">
                        @error('proposedBudget') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Message to Brand</label>
                        <textarea wire:model="applyMessage" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-gray-200"
                                  placeholder="Tell the brand why you're the perfect fit..."></textarea>
                        @error('applyMessage') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button wire:click="$set('showApplyModal', false)"
                            class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">Cancel</button>
                    <button wire:click="apply"
                            class="px-4 py-2 text-sm text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">Submit Application</button>
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
