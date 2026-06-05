<div>
    <div class="mb-4">
        <a href="{{ route('kol.content.index') }}" wire:navigate class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800">&larr; Kembali</a>
    </div>

    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $content->title }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Campaign: {{ $content->agreement?->hiring?->campaign?->title ?? 'N/A' }}
                    </p>
                </div>
                <span class="px-3 py-1 text-sm font-medium rounded-full self-start
                    @if($content->status->value === 'approved') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400
                    @elseif($content->status->value === 'revision_requested') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400
                    @elseif($content->status->value === 'rejected') bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400
                    @elseif($content->status->value === 'submitted') bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400
                    @elseif($content->status->value === 'posted') bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400
                    @else bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $content->status->value)) }}
                </span>
            </div>

            @if($content->caption)
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Caption</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $content->caption }}</p>
                </div>
            @endif

            @php
                $mediaItems = $content->getMedia('content_files');
            @endphp

            @if($mediaItems->isNotEmpty())
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Media</p>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($mediaItems as $media)
                            <div class="aspect-square rounded-lg bg-gray-100 dark:bg-gray-700 overflow-hidden">
                                @if(str_starts_with($media->mime_type, 'image/'))
                                    <img src="{{ $media->getUrl() }}"
                                         alt="{{ $media->name }}"
                                         class="w-full h-full object-cover">
                                @elseif(str_starts_with($media->mime_type, 'video/'))
                                    <video src="{{ $media->getUrl() }}"
                                           class="w-full h-full object-cover"
                                           controls></video>
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <a href="{{ $media->getUrl() }}" target="_blank"
                                           class="text-indigo-600 dark:text-indigo-400 text-sm hover:underline">
                                            {{ $media->file_name }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($content->revisions->isNotEmpty())
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Riwayat Revisi</p>
                    <div class="space-y-3">
                        @foreach($content->revisions as $revision)
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-3">
                                <div class="flex items-start justify-between">
                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $revision->note }}</p>
                                    <span class="text-xs text-gray-400 dark:text-gray-500 flex-shrink-0 ml-2">{{ $revision->created_at->format('d M Y H:i') }}</span>
                                </div>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                    Oleh: {{ $revision->requester?->name ?? 'N/A' }}
                                    @if($revision->status === 'pending')
                                        <span class="text-yellow-600 dark:text-yellow-400 ml-2">(Menunggu revisi)</span>
                                    @endif
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="px-6 py-4 flex flex-wrap items-center gap-3">
                @if($content->status->value === 'draft' || $content->status->value === 'revision_requested')
                    <button wire:click="submit" wire:confirm="Kirim konten untuk review?"
                            class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        Kirim untuk Review
                    </button>
                @endif

                @if($content->submitted_at)
                    <span class="text-xs text-gray-400 dark:text-gray-500">
                        Dikirim: {{ $content->submitted_at->format('d M Y H:i') }}
                    </span>
                @endif

                @if($content->approved_at)
                    <span class="text-xs text-green-600 dark:text-green-400">
                        Disetujui: {{ $content->approved_at->format('d M Y H:i') }}
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
