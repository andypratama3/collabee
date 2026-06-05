<div>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Explore Campaigns</h1>
            <p class="mt-2 text-gray-500">Find the perfect campaign that matches your expertise</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search campaigns..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
                <div>
                    <select wire:model.live="kol_category" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="">All Categories</option>
                        @foreach($categoryOptions as $cat)
                            <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <input type="number" wire:model.live.debounce.300ms="budget_min" placeholder="Min budget..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
                <div>
                    <input type="number" wire:model.live.debounce.300ms="budget_max" placeholder="Max budget..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
            </div>
            <div class="mt-3">
                <label class="block text-sm font-medium text-gray-700 mb-2">Platforms</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($platformOptions as $platform)
                        <button wire:click="togglePlatform('{{ $platform }}')"
                                class="px-3 py-1 text-sm rounded-full border
                                {{ in_array($platform, $platforms) ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-300 hover:border-indigo-300' }}">
                            {{ ucfirst($platform) }}
                        </button>
                    @endforeach
                    @if($search || $kol_category || $budget_min || $budget_max || $platforms)
                        <button wire:click="resetFilters" class="px-3 py-1 text-sm text-red-600 hover:bg-red-50 rounded-full">Reset</button>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($campaigns as $campaign)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-6">
                        @if($campaign->is_featured)
                            <span class="px-2 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-700 rounded-full mb-2 inline-block">Featured</span>
                        @endif
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $campaign->title }}</h3>
                        <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ $campaign->description }}</p>
                        <div class="flex items-center gap-2 mb-3 flex-wrap">
                            @foreach($campaign->platforms ?? [] as $platform)
                                <span class="px-2 py-0.5 text-xs bg-gray-100 text-gray-600 rounded-full">{{ ucfirst($platform) }}</span>
                            @endforeach
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">{{ $campaign->brandProfile->brand_name ?? 'Unknown Brand' }}</span>
                            <span class="font-semibold text-indigo-600">Rp {{ number_format($campaign->budget_total, 0, ',', '.') }}</span>
                        </div>
                        <div class="mt-3 flex items-center gap-4 text-xs text-gray-400">
                            <span>Slots: {{ $campaign->kol_filled }}/{{ $campaign->kol_slots }}</span>
                            <span>Applications: {{ $campaign->applications_count }}</span>
                            <span>Deadline: {{ $campaign->deadline_apply->format('d M') }}</span>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('campaigns.detail', $campaign) }}" wire:navigate
                               class="block w-full text-center px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <p class="mt-2 text-gray-500">No campaigns found. Try adjusting your filters.</p>
                    <button wire:click="resetFilters" class="mt-2 text-sm text-indigo-600 hover:text-indigo-800">Reset all filters</button>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $campaigns->links() }}
        </div>
    </div>
</div>
