<div>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Explore Campaigns</h1>
            <p class="mt-2 text-gray-500 dark:text-gray-400">Find the perfect campaign that matches your expertise</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search campaigns..."
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-gray-200">
                </div>
                <div>
                    <select wire:model.live="kol_category" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-gray-200">
                        <option value="">All Categories</option>
                        @foreach($categoryOptions as $cat)
                            <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <input type="number" wire:model.live.debounce.300ms="budget_min" placeholder="Min budget..."
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-gray-200">
                </div>
                <div>
                    <input type="number" wire:model.live.debounce.300ms="budget_max" placeholder="Max budget..."
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-gray-200">
                </div>
            </div>
            <div class="mt-3">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Platforms</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($platformOptions as $platform)
                        <button wire:click="togglePlatform('{{ $platform }}')"
                                class="px-3 py-1 text-sm rounded-full border
                                {{ in_array($platform, $platforms) ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white dark:bg-gray-700 text-gray-600 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:border-indigo-300' }}">
                            {{ ucfirst($platform) }}
                        </button>
                    @endforeach
                    @if($search || $kol_category || $budget_min || $budget_max || $platforms)
                        <button wire:click="resetFilters" class="px-3 py-1 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-full">Reset</button>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($campaigns as $campaign)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-6">
                        @if($campaign->is_featured)
                            <span class="px-2 py-0.5 text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 rounded-full mb-2 inline-block">Featured</span>
                        @endif
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $campaign->title }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-4">{{ $campaign->description }}</p>
                        <div class="flex items-center gap-2 mb-3 flex-wrap">
                            @foreach($campaign->platforms ?? [] as $platform)
                                <span class="px-2 py-0.5 text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full">{{ ucfirst($platform) }}</span>
                            @endforeach
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">{{ $campaign->brandProfile->brand_name ?? 'Unknown Brand' }}</span>
                            <span class="font-semibold text-indigo-600 dark:text-indigo-400">Rp {{ number_format($campaign->budget_total, 0, ',', '.') }}</span>
                        </div>
                        <div class="mt-3 flex items-center gap-4 text-xs text-gray-400 dark:text-gray-500">
                            <span>Slots: {{ $campaign->kol_filled }}/{{ $campaign->kol_slots }}</span>
                            <span>Applications: {{ $campaign->applications_count }}</span>
                            <span>Deadline: {{ $campaign->deadline_apply->format('d M') }}</span>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('campaigns.detail', $campaign) }}" wire:navigate
                               class="block w-full text-center px-4 py-2 text-sm font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/50">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <x-empty-state icon="search" title="No campaigns found" description="Try adjusting your filters.">
                        <button wire:click="resetFilters" class="mt-2 text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800">Reset all filters</button>
                    </x-empty-state>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $campaigns->links() }}
        </div>
    </div>
</div>
