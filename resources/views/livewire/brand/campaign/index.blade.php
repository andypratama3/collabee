<div>
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">My Campaigns</h1>
            <p class="mt-1 text-sm text-gray-500">Manage your brand campaigns</p>
        </div>
        <a href="{{ route('brand.campaign.create') }}" wire:navigate
           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create Campaign
        </a>
    </div>

    <div class="flex gap-2 mb-6 flex-wrap">
        <button wire:click="$set('filter', '')"
                class="px-3 py-1.5 text-sm rounded-full {{ empty($filter) ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            All
        </button>
        @foreach($statuses as $status)
            <button wire:click="$set('filter', '{{ $status->value }}')"
                    class="px-3 py-1.5 text-sm rounded-full {{ $filter === $status->value ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                {{ ucfirst(str_replace('_', ' ', $status->value)) }}
            </button>
        @endforeach
    </div>

    <div class="space-y-4">
        @forelse($campaigns as $campaign)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $campaign->title }}</h3>
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full
                                @if($campaign->status->value === 'open') bg-green-100 text-green-700
                                @elseif($campaign->status->value === 'draft') bg-gray-100 text-gray-600
                                @elseif($campaign->status->value === 'in_progress') bg-blue-100 text-blue-700
                                @elseif($campaign->status->value === 'completed') bg-indigo-100 text-indigo-700
                                @elseif($campaign->status->value === 'cancelled') bg-red-100 text-red-700
                                @else bg-yellow-100 text-yellow-700
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $campaign->status->value)) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 line-clamp-2 mb-3">{{ $campaign->description }}</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span>Budget: Rp {{ number_format($campaign->budget_total, 0, ',', '.') }}</span>
                            <span>Slots: {{ $campaign->kol_filled }}/{{ $campaign->kol_slots }}</span>
                            <span>Applications: {{ $campaign->applications_count }}</span>
                            <span>Hirings: {{ $campaign->hirings_count }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 ml-4">
                        <a href="{{ route('brand.campaign.edit', $campaign) }}" wire:navigate
                           class="px-3 py-1.5 text-sm text-indigo-600 hover:bg-indigo-50 rounded-lg">Edit</a>
                        @if($campaign->status->value === 'draft')
                            <button wire:click="publish({{ $campaign->id }})"
                                    class="px-3 py-1.5 text-sm text-green-600 hover:bg-green-50 rounded-lg">Publish</button>
                        @endif
                        @if($campaign->status->value === 'open')
                            <button wire:click="pause({{ $campaign->id }})"
                                    class="px-3 py-1.5 text-sm text-yellow-600 hover:bg-yellow-50 rounded-lg">Pause</button>
                        @endif
                        @if($campaign->status->value === 'paused')
                            <button wire:click="resume({{ $campaign->id }})"
                                    class="px-3 py-1.5 text-sm text-green-600 hover:bg-green-50 rounded-lg">Resume</button>
                        @endif
                        @if(in_array($campaign->status->value, ['draft', 'open', 'paused']))
                            <button wire:click="confirmCancel({{ $campaign->id }})"
                                    class="px-3 py-1.5 text-sm text-red-600 hover:bg-red-50 rounded-lg">Cancel</button>
                        @endif
                        <button wire:click="confirmDelete({{ $campaign->id }})"
                                class="px-3 py-1.5 text-sm text-red-600 hover:bg-red-50 rounded-lg"
                                onclick="return confirm('Delete this campaign permanently?')">Delete</button>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white rounded-xl border border-gray-200">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">No campaigns yet</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating your first campaign.</p>
                <a href="{{ route('brand.campaign.create') }}" wire:navigate
                   class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
                    Create Campaign
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $campaigns->links() }}
    </div>
</div>
