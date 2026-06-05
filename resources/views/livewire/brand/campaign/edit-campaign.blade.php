<div>
    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Campaign</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Update your campaign details</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-8">
            <div class="space-y-6">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Campaign Information</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Campaign Title *</label>
                            <input type="text" wire:model="title"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('title') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description *</label>
                            <textarea wire:model="description" rows="5"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                            @error('description') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Objectives (one per line)</label>
                            <textarea wire:model="objectives" rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-200 dark:border-gray-700">

                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Specifications</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Platforms *</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach(['instagram', 'tiktok', 'youtube', 'twitter', 'linkedin', 'facebook', 'podcast', 'blog'] as $platform)
                                    <button type="button" wire:click="togglePlatform('{{ $platform }}')"
                                            class="px-3 py-1.5 text-sm rounded-full border
                                            {{ in_array($platform, $platforms) ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white dark:bg-gray-700 text-gray-600 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:border-indigo-300 dark:hover:border-indigo-500' }}">
                                        {{ ucfirst($platform) }}
                                    </button>
                                @endforeach
                            </div>
                            @error('platforms') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content Types *</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach(['photo', 'video', 'reels', 'story', 'carousel', 'blog_post', 'live_streaming', 'podcast_episode'] as $type)
                                    <button type="button" wire:click="toggleContentType('{{ $type }}')"
                                            class="px-3 py-1.5 text-sm rounded-full border
                                            {{ in_array($type, $content_types) ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white dark:bg-gray-700 text-gray-600 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:border-indigo-300 dark:hover:border-indigo-500' }}">
                                        {{ ucfirst(str_replace('_', ' ', $type)) }}
                                    </button>
                                @endforeach
                            </div>
                            @error('content_types') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">KOL Category</label>
                                <select wire:model="kol_category"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">All Categories</option>
                                    @foreach(['fashion', 'beauty', 'tech', 'gaming', 'food', 'travel', 'fitness', 'music', 'education', 'lifestyle', 'finance', 'parenting'] as $cat)
                                        <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Target Gender</label>
                                <select wire:model="target_gender"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="all">All</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Min Followers</label>
                                <input type="number" wire:model="min_followers"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max Followers</label>
                                <input type="number" wire:model="max_followers"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Min Engagement Rate (%)</label>
                                <input type="number" step="0.01" wire:model="min_engagement"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location</label>
                                <input type="text" wire:model="location"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-200 dark:border-gray-700">

                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Campaign Brief</h2>
                    <textarea wire:model="brief" rows="10"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    @error('brief') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <hr class="border-gray-200 dark:border-gray-700">

                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Budget & Schedule</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Total Budget (Rp) *</label>
                            <input type="number" wire:model="budget_total"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('budget_total') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Budget per KOL (Rp)</label>
                            <input type="number" step="0.01" wire:model="budget_per_kol"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">KOL Slots *</label>
                            <input type="number" wire:model="kol_slots" min="1" max="100"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('kol_slots') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date *</label>
                            <input type="date" wire:model="start_date"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('start_date') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date *</label>
                            <input type="date" wire:model="end_date"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('end_date') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Application Deadline *</label>
                            <input type="date" wire:model="deadline_apply"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('deadline_apply') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-3">
            <a href="{{ route('brand.campaign.index') }}" wire:navigate
               class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600">
                Cancel
            </a>
            <button wire:click="save" type="button"
                    class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                Update Campaign
            </button>
        </div>
    </div>
</div>
