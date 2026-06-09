<div>
    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create Campaign</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Fill in the details to create your campaign</p>
        </div>

        <div class="mb-8">
            <div class="flex items-center justify-between overflow-x-auto pb-2">
                @foreach(['Campaign Info', 'Specifications', 'Brief', 'Budget & Schedule'] as $i => $label)
                    <div class="flex items-center shrink-0">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full text-sm font-medium
                            {{ $step > $i + 1 ? 'bg-primary text-white' : ($step === $i + 1 ? 'bg-primary text-white' : 'bg-gray-200 dark:bg-gray-600 text-gray-500 dark:text-gray-400') }}">
                            {{ $step > $i + 1 ? '✓' : $i + 1 }}
                        </div>
                        <span class="ml-2 text-sm {{ $step === $i + 1 ? 'text-primary font-medium' : 'text-gray-500 dark:text-gray-400' }} hidden sm:inline">{{ $label }}</span>
                        @if($i < 3)
                            <div class="w-12 h-0.5 mx-2 {{ $step > $i + 1 ? 'bg-primary' : 'bg-gray-200 dark:bg-gray-600' }}"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 p-8">
            @if(session('error'))
                <script>document.addEventListener('DOMContentLoaded', () => window.Swal && window.Swal.mixin({toast:true,position:'top-end',showConfirmButton:false,timer:4000,timerProgressBar:true}).fire({icon:'error',title:@json(session('error'))}));</script>
            @endif

            @if($step === 1)
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Campaign Information</h2>
                    <div class="space-y-4">
                        <div>
                            <x-form.input id="campaign_title" name="title" :value="$title">Campaign Title *</x-form.input>
                        </div>
                        <div>
                            <x-form.textarea id="description" name="description" :value="$description" rows="5">Description *</x-form.textarea>
                        </div>
                        <div>
                            <x-form.textarea id="objectives" name="objectives" :value="$objectives" rows="4">Objectives (one per line)</x-form.textarea>
                        </div>
                    </div>
                </div>

            @elseif($step === 2)
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Specifications</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Platforms *</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach(['instagram', 'tiktok', 'youtube', 'twitter', 'linkedin', 'facebook', 'podcast', 'blog'] as $platform)
                                    <button type="button" wire:click="togglePlatform('{{ $platform }}')"
                                            class="px-3 py-1.5 text-sm rounded-full border
                                            {{ in_array($platform, $platforms) ? 'bg-primary text-white border-primary' : 'bg-white dark:bg-gray-700 text-gray-600 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:border-primary-300 dark:hover:border-primary-500' }}">
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
                                            {{ in_array($type, $content_types) ? 'bg-primary text-white border-primary' : 'bg-white dark:bg-gray-700 text-gray-600 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:border-primary-300 dark:hover:border-primary-500' }}">
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
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary">
                                    <option value="">All Categories</option>
                                    @foreach(['fashion', 'beauty', 'tech', 'gaming', 'food', 'travel', 'fitness', 'music', 'education', 'lifestyle', 'finance', 'parenting'] as $cat)
                                        <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Target Gender</label>
                                <select wire:model="target_gender"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary">
                                    <option value="all">All</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Min Followers</label>
                                <input type="number" wire:model="min_followers" placeholder="e.g., 10000"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max Followers</label>
                                <input type="number" wire:model="max_followers" placeholder="e.g., 100000"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Min Engagement Rate (%)</label>
                                <input type="number" step="0.01" wire:model="min_engagement" placeholder="e.g., 3.5"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location</label>
                                <input type="text" wire:model="location" placeholder="e.g., Jakarta, Indonesia"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary">
                            </div>
                        </div>
                    </div>
                </div>

            @elseif($step === 3)
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Campaign Brief</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Creative Brief</label>
                            <textarea wire:model="brief" rows="12"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary"
                                      placeholder="Provide detailed creative direction, brand guidelines, key messages, dos and don'ts, reference links, etc."></textarea>
                            @error('brief') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

            @elseif($step === 4)
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Budget & Schedule</h2>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Total Budget (Rp) *</label>
                                <input type="number" wire:model="budget_total" placeholder="e.g., 50000000"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary">
                                @error('budget_total') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Budget per KOL (Rp)</label>
                                <input type="number" step="0.01" wire:model="budget_per_kol"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">KOL Slots *</label>
                                <input type="number" wire:model="kol_slots" min="1" max="100"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary">
                                @error('kol_slots') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date *</label>
                                <input type="date" wire:model="start_date"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary">
                                @error('start_date') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date *</label>
                                <input type="date" wire:model="end_date"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary">
                                @error('end_date') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Application Deadline *</label>
                                <input type="date" wire:model="deadline_apply"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary">
                                @error('deadline_apply') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
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
                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600">
                        Previous
                    </button>
                @endif
            </div>
            <div class="flex items-center gap-3">
                @if($step === 4)
                    <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <input type="checkbox" wire:model="saveAsDraft" class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-primary">
                        Save as draft
                    </label>
                    <button wire:click="save" type="button"
                            class="px-6 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary-dark">
                        {{ $saveAsDraft ? 'Save Draft' : 'Publish Campaign' }}
                    </button>
                @else
                    <button wire:click="nextStep" type="button"
                            class="px-6 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary-dark">
                        Next Step
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
