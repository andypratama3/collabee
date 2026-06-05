<div>
    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Create Campaign</h1>
            <p class="mt-1 text-sm text-gray-500">Fill in the details to create your campaign</p>
        </div>

        <div class="mb-8">
            <div class="flex items-center justify-between">
                @foreach(['Campaign Info', 'Specifications', 'Brief', 'Budget & Schedule'] as $i => $label)
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full text-sm font-medium
                            {{ $step > $i + 1 ? 'bg-indigo-600 text-white' : ($step === $i + 1 ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-500') }}">
                            {{ $step > $i + 1 ? '✓' : $i + 1 }}
                        </div>
                        <span class="ml-2 text-sm {{ $step === $i + 1 ? 'text-indigo-600 font-medium' : 'text-gray-500' }} hidden sm:inline">{{ $label }}</span>
                        @if($i < 3)
                            <div class="w-12 h-0.5 mx-2 {{ $step > $i + 1 ? 'bg-indigo-600' : 'bg-gray-200' }}"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-50 text-red-700 text-sm rounded-lg">{{ session('error') }}</div>
            @endif

            @if($step === 1)
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Campaign Information</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Campaign Title *</label>
                            <input type="text" wire:model="title"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="e.g., Summer Fashion Campaign 2026">
                            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                            <textarea wire:model="description" rows="5"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                      placeholder="Describe your campaign in detail..."></textarea>
                            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Objectives (one per line)</label>
                            <textarea wire:model="objectives" rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                      placeholder="Increase brand awareness&#10;Drive website traffic&#10;Generate leads"></textarea>
                        </div>
                    </div>
                </div>

            @elseif($step === 2)
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Specifications</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Platforms *</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach(['instagram', 'tiktok', 'youtube', 'twitter', 'linkedin', 'facebook', 'podcast', 'blog'] as $platform)
                                    <button type="button" wire:click="togglePlatform('{{ $platform }}')"
                                            class="px-3 py-1.5 text-sm rounded-full border
                                            {{ in_array($platform, $platforms) ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-300 hover:border-indigo-300' }}">
                                        {{ ucfirst($platform) }}
                                    </button>
                                @endforeach
                            </div>
                            @error('platforms') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Content Types *</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach(['photo', 'video', 'reels', 'story', 'carousel', 'blog_post', 'live_streaming', 'podcast_episode'] as $type)
                                    <button type="button" wire:click="toggleContentType('{{ $type }}')"
                                            class="px-3 py-1.5 text-sm rounded-full border
                                            {{ in_array($type, $content_types) ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-300 hover:border-indigo-300' }}">
                                        {{ ucfirst(str_replace('_', ' ', $type)) }}
                                    </button>
                                @endforeach
                            </div>
                            @error('content_types') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">KOL Category</label>
                                <select wire:model="kol_category"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">All Categories</option>
                                    @foreach(['fashion', 'beauty', 'tech', 'gaming', 'food', 'travel', 'fitness', 'music', 'education', 'lifestyle', 'finance', 'parenting'] as $cat)
                                        <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Target Gender</label>
                                <select wire:model="target_gender"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="all">All</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Min Followers</label>
                                <input type="number" wire:model="min_followers" placeholder="e.g., 10000"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Max Followers</label>
                                <input type="number" wire:model="max_followers" placeholder="e.g., 100000"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Min Engagement Rate (%)</label>
                                <input type="number" step="0.01" wire:model="min_engagement" placeholder="e.g., 3.5"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                <input type="text" wire:model="location" placeholder="e.g., Jakarta, Indonesia"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>

            @elseif($step === 3)
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Campaign Brief</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Creative Brief</label>
                            <textarea wire:model="brief" rows="12"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                      placeholder="Provide detailed creative direction, brand guidelines, key messages, dos and don'ts, reference links, etc."></textarea>
                            @error('brief') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

            @elseif($step === 4)
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Budget & Schedule</h2>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Total Budget (Rp) *</label>
                                <input type="number" wire:model="budget_total" placeholder="e.g., 50000000"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('budget_total') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Budget per KOL (Rp)</label>
                                <input type="number" step="0.01" wire:model="budget_per_kol"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">KOL Slots *</label>
                                <input type="number" wire:model="kol_slots" min="1" max="100"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('kol_slots') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date *</label>
                                <input type="date" wire:model="start_date"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('start_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">End Date *</label>
                                <input type="date" wire:model="end_date"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('end_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Application Deadline *</label>
                                <input type="date" wire:model="deadline_apply"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('deadline_apply') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-6 flex items-center justify-between">
            <div>
                @if($step > 1)
                    <button wire:click="previousStep" type="button"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Previous
                    </button>
                @endif
            </div>
            <div class="flex items-center gap-3">
                @if($step === 4)
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" wire:model="saveAsDraft" class="rounded border-gray-300 text-indigo-600">
                        Save as draft
                    </label>
                    <button wire:click="save" type="button"
                            class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        {{ $saveAsDraft ? 'Save Draft' : 'Publish Campaign' }}
                    </button>
                @else
                    <button wire:click="nextStep" type="button"
                            class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        Next Step
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
