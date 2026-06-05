<div>
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Browse KOL</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Find the perfect KOL for your campaign</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search KOL name..."
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-gray-200">
            </div>
            <div>
                <select wire:model.live="category" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-gray-200">
                    <option value="">All Categories</option>
                    @foreach(['fashion', 'beauty', 'tech', 'gaming', 'food', 'travel', 'fitness', 'music', 'education', 'lifestyle', 'finance', 'parenting'] as $cat)
                        <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <input type="number" wire:model.live.debounce.300ms="minFollowers" placeholder="Min followers..."
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-gray-200">
            </div>
            <div>
                <input type="number" step="0.1" wire:model.live.debounce.300ms="minEngagement" placeholder="Min engagement %..."
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-gray-200">
            </div>
        </div>
        <div class="mt-3 flex flex-wrap items-center gap-4">
            <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                <input type="checkbox" wire:model.live="openForWork" class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 dark:bg-gray-700">
                Open for work only
            </label>
            <input type="text" wire:model.live.debounce.300ms="location" placeholder="Location..."
                   class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-gray-200">
            <input type="number" wire:model.live.debounce.300ms="maxBudget" placeholder="Max budget..."
                   class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-gray-200">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($kols as $kol)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-lg flex-shrink-0">
                        {{ strtoupper(substr($kol->display_name, 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $kol->display_name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $kol->category ? ucfirst($kol->category) : 'General' }}</p>
                        <div class="flex items-center gap-3 mt-2 text-sm text-gray-500 dark:text-gray-400">
                            <span>{{ number_format($kol->total_followers) }} followers</span>
                            <span>{{ $kol->avg_engagement_rate }}% eng.</span>
                        </div>
                        <div class="flex items-center gap-3 mt-1 text-sm text-gray-500 dark:text-gray-400">
                            <span>{{ $kol->rating_avg ? number_format($kol->rating_avg, 1) : 'N/A' }} rating</span>
                            @if($kol->min_budget)
                                <span>From Rp {{ number_format($kol->min_budget, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        @if($kol->location)
                            <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">{{ $kol->location }}</p>
                        @endif
                        <button wire:click="openHireModal({{ $kol->id }}, '{{ addslashes($kol->display_name) }}')"
                                class="mt-3 px-4 py-1.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                            Hire
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <x-empty-state icon="search" title="No KOL found" description="Try adjusting your filters." />
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $kols->links() }}
    </div>

    @if($showHireModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 dark:bg-black/70" wire:click.self="$set('showHireModal', false)">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 w-full max-w-lg mx-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Hire {{ $selectedKolName }}</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Campaign *</label>
                        <select wire:model="hireCampaignId" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-gray-200">
                            <option value="">Select a campaign</option>
                            @foreach($campaigns as $c)
                                <option value="{{ $c['id'] }}">{{ $c['title'] }}</option>
                            @endforeach
                        </select>
                        @error('hireCampaignId') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Proposed Budget (Rp)</label>
                        <input type="number" wire:model="proposedBudget" placeholder="Leave empty to use campaign default"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-gray-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Message</label>
                        <textarea wire:model="hireMessage" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-gray-200"
                                  placeholder="Personal message to the KOL..."></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button wire:click="$set('showHireModal', false)"
                            class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">Cancel</button>
                    <button wire:click="hire"
                            class="px-4 py-2 text-sm text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">Send Invitation</button>
                </div>
            </div>
        </div>
    @endif
</div>
