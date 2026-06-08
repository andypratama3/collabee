<div class="space-y-8">
    {{-- Page Header --}}
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-900 via-gray-800 to-gray-600 dark:from-white dark:via-gray-200 dark:to-gray-400">My Campaigns</h1>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Track and manage all your brand marketing campaigns.</p>
        </div>
        <a href="{{ route('brand.campaign.create') }}" wire:navigate
           class="mt-4 sm:mt-0 inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-primary to-primary-dark text-white text-sm font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create Campaign
        </a>
    </div>

    {{-- Filters --}}
    <div class="flex flex-wrap gap-2 p-1.5 bg-white dark:bg-gray-800/60 backdrop-blur-xl rounded-2xl w-fit border border-gray-200 dark:border-gray-700 shadow-sm">
        <button wire:click="$set('filter', '')"
                class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-300 {{ empty($filter) ? 'bg-gradient-to-r from-primary to-primary-dark text-white shadow-md shadow-primary/25' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100/80 dark:hover:bg-gray-700/50' }}">
            All Campaigns
        </button>
        @foreach($statuses as $status)
            <button wire:click="$set('filter', '{{ $status->value }}')"
                    class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-300 {{ $filter === $status->value ? 'bg-gradient-to-r from-primary to-primary-dark text-white shadow-md shadow-primary/25' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100/80 dark:hover:bg-gray-700/50' }}">
                {{ ucfirst(str_replace('_', ' ', $status->value)) }}
            </button>
        @endforeach
    </div>

    {{-- Campaign List --}}
    <div class="grid grid-cols-1 gap-5">
        @forelse($campaigns as $campaign)
            <div class="group bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/40 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 p-6 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-2xl hover:shadow-gray-300/30 dark:hover:shadow-gray-900/50 hover:border-primary/20">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 mb-2 flex-wrap">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-primary transition-colors duration-300 truncate">{{ $campaign->title }}</h3>
                            <span class="px-3 py-1 text-xs font-bold rounded-full tracking-wide border
                                @if($campaign->status->value === 'open') bg-emerald-50 text-emerald-600 border-emerald-200/50 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800/50
                                @elseif($campaign->status->value === 'draft') bg-gray-50 text-gray-500 border-gray-200/50 dark:bg-gray-700/50 dark:text-gray-300 dark:border-gray-600/50
                                @elseif($campaign->status->value === 'in_progress') bg-blue-50 text-blue-600 border-blue-200/50 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-800/50
                                @elseif($campaign->status->value === 'completed') bg-indigo-50 text-indigo-600 border-indigo-200/50 dark:bg-indigo-900/20 dark:text-indigo-400 dark:border-indigo-800/50
                                @elseif($campaign->status->value === 'cancelled') bg-red-50 text-red-600 border-red-200/50 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800/50
                                @else bg-amber-50 text-amber-600 border-amber-200/50 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800/50
                                @endif">
                                {{ strtoupper(str_replace('_', ' ', $campaign->status->value)) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-4 max-w-2xl leading-relaxed">{{ $campaign->description }}</p>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 py-4 border-t border-gray-100 dark:border-gray-700">
                            <div class="group/stat p-3 rounded-xl bg-gray-100/80 dark:bg-gray-700/30 transition-colors duration-200 hover:bg-primary/5 dark:hover:bg-primary/10">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-500 uppercase tracking-wider">Budget</p>
                                </div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">Rp. {{ number_format($campaign->budget_total, 0, ',', '.') }}</p>
                            </div>
                            <div class="group/stat p-3 rounded-xl bg-gray-100/80 dark:bg-gray-700/30 transition-colors duration-200 hover:bg-primary/5 dark:hover:bg-primary/10">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-500 uppercase tracking-wider">Slots</p>
                                </div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $campaign->kol_filled }}/{{ $campaign->kol_slots }}</p>
                            </div>
                            <div class="group/stat p-3 rounded-xl bg-gray-100/80 dark:bg-gray-700/30 transition-colors duration-200 hover:bg-primary/5 dark:hover:bg-primary/10">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-500 uppercase tracking-wider">Applications</p>
                                </div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $campaign->applications_count }}</p>
                            </div>
                            <div class="group/stat p-3 rounded-xl bg-gray-100/80 dark:bg-gray-700/30 transition-colors duration-200 hover:bg-primary/5 dark:hover:bg-primary/10">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-500 uppercase tracking-wider">Active Hirings</p>
                                </div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $campaign->hirings_count }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2 lg:flex-col lg:items-stretch lg:w-32 shrink-0">
                        <a href="{{ route('brand.campaign.edit', $campaign) }}" wire:navigate
                           class="flex-1 text-center px-3 py-2.5 text-sm font-semibold text-primary bg-primary/5 hover:bg-primary/10 rounded-xl transition-all duration-300 border border-primary/10 hover:border-primary/20">Edit</a>
                        
                        @if($campaign->status->value === 'draft')
                            <button wire:click="publish({{ $campaign->id }})"
                                    class="flex-1 px-3 py-2.5 text-sm font-semibold text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 rounded-xl transition-all duration-300 border border-emerald-200/50 dark:border-emerald-800/50">Publish</button>
                        @endif
                        
                        <div class="relative" x-data="{ open: false }">
                            <button @@click="open = !open" 
                                    class="p-2.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                            </button>
                            <div x-show="open" @@click.away="open = false" x-cloak
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 bottom-full mb-2 lg:bottom-auto lg:top-0 lg:right-full lg:mr-2 w-48 bg-white/90 dark:bg-gray-800/90 backdrop-blur-xl rounded-xl shadow-xl shadow-gray-200/30 dark:shadow-gray-900/50 border border-gray-200 dark:border-gray-700 py-1.5 z-10">
                                @if($campaign->status->value === 'open')
                                    <button wire:click="pause({{ $campaign->id }})"
                                            class="w-full text-left px-4 py-2.5 text-sm text-amber-600 hover:bg-amber-50/80 dark:hover:bg-amber-900/20 transition-colors duration-200">Pause Campaign</button>
                                @endif
                                @if($campaign->status->value === 'paused')
                                    <button wire:click="resume({{ $campaign->id }})"
                                            class="w-full text-left px-4 py-2.5 text-sm text-emerald-600 hover:bg-emerald-50/80 dark:hover:bg-emerald-900/20 transition-colors duration-200">Resume Campaign</button>
                                @endif
                                @if(in_array($campaign->status->value, ['draft', 'open', 'paused']))
                                    <button wire:click="cancel({{ $campaign->id }})" wire:confirm="Batalkan campaign ini?"
                                            class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50/80 dark:hover:bg-red-900/20 transition-colors duration-200">Cancel Campaign</button>
                                @endif
                                <div class="my-1 border-t border-gray-100 dark:border-gray-700"></div>
                                <button wire:click="confirmDelete({{ $campaign->id }})"
                                        class="w-full text-left px-4 py-2.5 text-sm text-red-600 font-bold hover:bg-red-50/80 dark:hover:bg-red-900/20 transition-colors duration-200">Delete Forever</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-16 bg-white dark:bg-gray-800/60 backdrop-blur-xl rounded-2xl border border-dashed border-gray-300/50 dark:border-gray-700 shadow-xl shadow-gray-200/10 dark:shadow-gray-900/20">
                <x-empty-state icon="campaign" title="No campaigns found" description="Create your first campaign to start working with KOLs." actionLabel="Create Campaign" actionUrl="{{ route('brand.campaign.create') }}" />
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $campaigns->links() }}
    </div>
</div>
