<div>
    <!-- Back Navigation -->
    <div class="mb-5">
        <a href="{{ route('kol.content.index') }}" wire:navigate class="inline-flex items-center gap-1.5 text-sm text-primary dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 font-medium transition-colors duration-200 group">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <div class="space-y-6">
        <!-- Main Content Card -->
        <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-gradient-to-r from-white/80 to-gray-50/80 dark:from-gray-800/80 dark:to-gray-750/80">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $content->title }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        Campaign: {{ $content->agreement?->hiring?->campaign?->title ?? 'N/A' }}
                    </p>
                </div>
                <span class="px-3 py-1.5 text-sm font-semibold rounded-xl self-start
                    @if($content->status->value === 'approved') bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400 ring-1 ring-emerald-200/50 dark:ring-emerald-700/30
                    @elseif($content->status->value === 'revision_requested') bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400 ring-1 ring-amber-200/50 dark:ring-amber-700/30
                    @elseif($content->status->value === 'rejected') bg-rose-50 text-rose-700 dark:bg-rose-900/20 dark:text-rose-400 ring-1 ring-rose-200/50 dark:ring-rose-700/30
                    @elseif($content->status->value === 'submitted') bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 ring-1 ring-blue-200/50 dark:ring-blue-700/30
                    @elseif($content->status->value === 'posted') bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400 ring-1 ring-emerald-200/50 dark:ring-emerald-700/30
                    @else bg-gray-50 text-gray-600 dark:bg-gray-700/50 dark:text-gray-400 ring-1 ring-gray-200/50 dark:ring-gray-600/30
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $content->status->value)) }}
                </span>
            </div>

            <!-- Caption Section -->
            @if($content->caption)
                <div class="px-6 py-5 border-b border-gray-100/80 dark:border-gray-700">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Caption</p>
                    </div>
                    <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed">{{ $content->caption }}</p>
                </div>
            @endif

            <!-- Media Section -->
            @php
                $mediaItems = $content->getMedia('content_files');
            @endphp

            @if($mediaItems->isNotEmpty())
                <div class="px-6 py-5 border-b border-gray-100/80 dark:border-gray-700">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Media</p>
                        <span class="text-xs text-gray-400 dark:text-gray-500 ml-1">({{ $mediaItems->count() }} {{ $mediaItems->count() === 1 ? 'file' : 'files' }})</span>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($mediaItems as $media)
                            <div class="group aspect-square rounded-xl bg-gray-100 dark:bg-gray-700/50 overflow-hidden ring-1 ring-gray-200/50 dark:ring-gray-600/30 hover:ring-primary/30 transition-all duration-300 hover:shadow-lg">
                                @if(str_starts_with($media->mime_type, 'image/'))
                                    <img src="{{ $media->getUrl() }}"
                                         alt="{{ $media->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @elseif(str_starts_with($media->mime_type, 'video/'))
                                    <video src="{{ $media->getUrl() }}"
                                           class="w-full h-full object-cover"
                                           controls></video>
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center gap-2 p-4">
                                        <svg class="w-10 h-10 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        <a href="{{ $media->getUrl() }}" target="_blank"
                                           class="text-primary dark:text-primary-400 text-sm hover:underline font-medium truncate max-w-full">
                                            {{ $media->file_name }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Revision History -->
            @if($content->revisions->isNotEmpty())
                <div class="px-6 py-5 border-b border-gray-100/80 dark:border-gray-700">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Riwayat Revisi</p>
                    </div>
                    <div class="space-y-3">
                        @foreach($content->revisions as $revision)
                            <div class="bg-amber-50/50 dark:bg-amber-900/10 rounded-xl p-4 border border-amber-100/50 dark:border-amber-800/20">
                                <div class="flex items-start justify-between gap-3">
                                    <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">{{ $revision->note }}</p>
                                    <span class="text-xs text-gray-400 dark:text-gray-500 flex-shrink-0 ml-2 whitespace-nowrap">{{ $revision->created_at->format('d M Y H:i') }}</span>
                                </div>
                                <div class="flex items-center gap-2 mt-2">
                                    <p class="text-xs text-gray-400 dark:text-gray-500">
                                        Oleh: <span class="font-medium">{{ $revision->requester?->name ?? 'N/A' }}</span>
                                    </p>
                                    @if($revision->status === 'pending')
                                        <span class="px-2 py-0.5 text-xs font-semibold rounded-md bg-amber-100/80 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 ring-1 ring-amber-200/50 dark:ring-amber-700/30">Menunggu revisi</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Rejection Message -->
            @if($content->status->value === 'rejected' && $content->notes)
                <div class="px-6 py-5 border-t border-gray-100/80 dark:border-gray-700 bg-rose-50/50 dark:bg-rose-900/10">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-rose-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        <div>
                            <p class="text-sm font-bold text-rose-700 dark:text-rose-400 mb-1">Konten Ditolak</p>
                            <p class="text-sm text-rose-600 dark:text-rose-300">{{ $content->notes }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="px-6 py-5 flex flex-wrap items-center gap-3 bg-gray-50/50 dark:bg-gray-900/20">
                @if(in_array($content->status->value, ['draft', 'revision_requested']))
                    <a href="{{ route('kol.content.edit', $content) }}" wire:navigate
                       class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600 transition-all duration-300 inline-flex items-center gap-2 ring-1 ring-gray-200 dark:ring-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Konten
                    </a>
                    <button wire:click="submit" wire:confirm="Kirim konten untuk review?"
                            class="px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-primary to-primary-dark rounded-xl hover:shadow-lg hover:shadow-primary/25 hover:-translate-y-0.5 transition-all duration-300 inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Kirim untuk Review
                    </button>
                @endif

                @if($content->status->value === 'rejected')
                    <a href="{{ route('kol.content.create', $content->agreement_id) }}" wire:navigate
                       class="px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-rose-500 to-rose-600 rounded-xl hover:shadow-lg hover:shadow-rose-500/25 hover:-translate-y-0.5 transition-all duration-300 inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Upload Ulang Konten
                    </a>
                @endif

                @if($content->submitted_at)
                    <span class="inline-flex items-center gap-1.5 text-xs text-gray-400 dark:text-gray-500">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Dikirim: {{ $content->submitted_at->format('d M Y H:i') }}
                    </span>
                @endif

                @if($content->approved_at)
                    <span class="inline-flex items-center gap-1.5 text-xs text-emerald-600 dark:text-emerald-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Disetujui: {{ $content->approved_at->format('d M Y H:i') }}
                    </span>

                    {{-- Rate Brand button — only show if KOL hasn't rated yet --}}
                    @php
                        $hiringId = $content->agreement?->hiring_id;
                        $alreadyRated = $hiringId
                            ? \App\Models\Rating::where('hiring_id', $hiringId)
                                ->where('rater_id', auth()->id())
                                ->exists()
                            : true;
                    @endphp
                    @if($hiringId && !$alreadyRated)
                        <a href="{{ route('shared.rating.create', ['hiring' => $hiringId, 'type' => 'brand']) }}" wire:navigate
                           class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/20 rounded-xl ring-1 ring-amber-200/50 dark:ring-amber-700/30 hover:bg-amber-100 dark:hover:bg-amber-900/40 transition-all duration-200">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            Beri Rating Brand
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
