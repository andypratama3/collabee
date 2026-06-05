<div>
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Campaigns</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage your brand campaigns</p>
        </div>
        <a href="{{ route('brand.campaign.create') }}" wire:navigate
           class="mt-3 sm:mt-0 inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create Campaign
        </a>
    </div>

    <div class="flex gap-2 mb-6 flex-wrap">
        <button wire:click="$set('filter', '')"
                class="px-3 py-1.5 text-sm rounded-full {{ empty($filter) ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
            All
        </button>
        @foreach($statuses as $status)
            <button wire:click="$set('filter', '{{ $status->value }}')"
                    class="px-3 py-1.5 text-sm rounded-full {{ $filter === $status->value ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                {{ ucfirst(str_replace('_', ' ', $status->value)) }}
            </button>
        @endforeach
    </div>

    <div class="space-y-4">
        @forelse($campaigns as $campaign)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex flex-col sm:flex-row items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1 flex-wrap">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white truncate">{{ $campaign->title }}</h3>
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full
                                @if($campaign->status->value === 'open') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                @elseif($campaign->status->value === 'draft') bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300
                                @elseif($campaign->status->value === 'in_progress') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                @elseif($campaign->status->value === 'completed') bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400
                                @elseif($campaign->status->value === 'cancelled') bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400
                                @else bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $campaign->status->value)) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-3">{{ $campaign->description }}</p>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4 text-sm text-gray-500 dark:text-gray-400">
                            <span>Budget: Rp {{ number_format($campaign->budget_total, 0, ',', '.') }}</span>
                            <span>Slots: {{ $campaign->kol_filled }}/{{ $campaign->kol_slots }}</span>
                            <span>Applications: {{ $campaign->applications_count }}</span>
                            <span>Hirings: {{ $campaign->hirings_count }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap shrink-0">
                        <a href="{{ route('brand.campaign.edit', $campaign) }}" wire:navigate
                           class="px-3 py-1.5 text-sm text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-lg">Edit</a>
                        @if($campaign->status->value === 'draft')
                            <button wire:click="publish({{ $campaign->id }})"
                                    class="px-3 py-1.5 text-sm text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/30 rounded-lg">Publish</button>
                        @endif
                        @if($campaign->status->value === 'open')
                            <button wire:click="pause({{ $campaign->id }})"
                                    class="px-3 py-1.5 text-sm text-yellow-600 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/30 rounded-lg">Pause</button>
                        @endif
                        @if($campaign->status->value === 'paused')
                            <button wire:click="resume({{ $campaign->id }})"
                                    class="px-3 py-1.5 text-sm text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/30 rounded-lg">Resume</button>
                        @endif
                        @if(in_array($campaign->status->value, ['draft', 'open', 'paused']))
                            <button wire:click="confirmCancel({{ $campaign->id }})"
                                    class="px-3 py-1.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg">Cancel</button>
                        @endif
                        <button wire:click="confirmDelete({{ $campaign->id }})"
                                class="px-3 py-1.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg">Delete</button>
                    </div>
                </div>
            </div>
        @empty
            <x-empty-state icon="campaign" title="No campaigns yet" description="Get started by creating your first campaign." actionLabel="Create Campaign" actionUrl="{{ route('brand.campaign.create') }}" />
        @endforelse
    </div>

    <div class="mt-6">
        {{ $campaigns->links() }}
    </div>
</div>
