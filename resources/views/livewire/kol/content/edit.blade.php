<div>
    <!-- Back Navigation -->
    <div class="mb-5">
        <a href="{{ route('kol.content.show', $content) }}" wire:navigate class="inline-flex items-center gap-1.5 text-sm text-primary dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 font-medium transition-colors duration-200 group">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <div class="space-y-6">
        <!-- Revision Request Banner -->
        @if($content->status->value === 'revision_requested')
            <x-alert type="warning">
                <p class="font-bold mb-0.5">Revisi Diminta</p>
                <p class="text-sm">Silakan perbarui konten Anda berdasarkan catatan revisi dari brand, lalu kirim ulang untuk review.</p>
            </x-alert>
        @endif

        @if($content->status->value === 'draft')
            <x-alert type="info">
                <p class="font-bold mb-0.5">Mode Draft</p>
                <p class="text-sm">Konten ini masih dalam mode draft. Edit caption atau file, lalu kirim untuk review dari halaman detail konten.</p>
            </x-alert>
        @endif

        <!-- Edit Form -->
        <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Card Header -->
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-white/80 to-gray-50/80 dark:from-gray-800/80 dark:to-gray-750/80">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary/20 to-primary/10 dark:from-primary/30 dark:to-primary/15 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Edit Konten</h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $content->title }}</p>
                    </div>
                </div>
            </div>

            <form wire:submit="save" class="px-6 py-6 space-y-6">
                <!-- Title Input -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Judul Konten</label>
                    <input type="text" wire:model="title"
                           class="w-full rounded-xl border-gray-200/80 dark:border-gray-600/80 shadow-sm focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm dark:bg-gray-700/50 dark:text-gray-200 transition-all duration-200 py-2.5"
                           placeholder="Masukkan judul konten">
                    @error('title') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Caption Textarea -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Caption</label>
                    <textarea wire:model="caption" rows="4"
                              class="w-full rounded-xl border-gray-200/80 dark:border-gray-600/80 shadow-sm focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm dark:bg-gray-700/50 dark:text-gray-200 transition-all duration-200"
                              placeholder="Tulis caption untuk konten ini"></textarea>
                    @error('caption') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Current Media -->
                @if($mediaItems->isNotEmpty())
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Media Saat Ini</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($mediaItems as $media)
                                <div class="relative group">
                                    @if(in_array($media->id, $deletedMediaIds))
                                        <div class="aspect-square rounded-xl bg-red-50 dark:bg-red-900/20 border-2 border-red-300 dark:border-red-700 flex items-center justify-center">
                                            <p class="text-sm font-medium text-red-600 dark:text-red-400">Akan dihapus</p>
                                        </div>
                                    @else
                                        <div class="aspect-square rounded-xl bg-gray-100 dark:bg-gray-700/50 overflow-hidden ring-1 ring-gray-200/50 dark:ring-gray-600/30">
                                            @if(str_starts_with($media->mime_type, 'image/'))
                                                <img src="{{ $media->getUrl() }}" alt="{{ $media->name }}" class="w-full h-full object-cover">
                                            @elseif(str_starts_with($media->mime_type, 'video/'))
                                                <video src="{{ $media->getUrl() }}" class="w-full h-full object-cover"></video>
                                            @else
                                                <div class="w-full h-full flex items-center justify-center p-4">
                                                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button" wire:click="removeMedia({{ $media->id }})"
                                                class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 shadow-lg hover:bg-red-600">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    @endif
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 truncate">{{ $media->file_name }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Upload New Files -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tambah File Baru</label>
                    <div class="mt-1 flex justify-center px-6 pt-8 pb-8 border-2 border-gray-200/80 dark:border-gray-600/80 border-dashed rounded-2xl hover:border-primary/40 dark:hover:border-primary/40 hover:bg-primary-50/10 dark:hover:bg-primary-900/10 transition-all duration-300 group">
                        <div class="space-y-2 text-center">
                            <div class="w-14 h-14 mx-auto rounded-2xl bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center group-hover:bg-primary-50 dark:group-hover:bg-primary-900/20 transition-colors duration-300">
                                <svg class="h-7 w-7 text-gray-400 dark:text-gray-500 group-hover:text-primary dark:group-hover:text-primary-400 transition-colors duration-300" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                <label class="relative cursor-pointer rounded-lg font-semibold text-primary dark:text-primary-400 hover:text-primary-500 transition-colors">
                                    <span>Upload file</span>
                                    <input type="file" wire:model="files" multiple class="sr-only" accept="image/*,video/*,.pdf,.doc,.docx">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-500">JPG, PNG, GIF, WebP, MP4, MOV, PDF, DOC hingga 50MB</p>
                        </div>
                    </div>
                    @error('files.*') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror

                    @if($files)
                        <div class="mt-4 grid grid-cols-4 gap-3">
                            @foreach($files as $file)
                                <div class="relative group">
                                    <div class="aspect-square rounded-xl bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center overflow-hidden ring-1 ring-gray-200/50 dark:ring-gray-600/30 group-hover:ring-primary/30 transition-all duration-200">
                                        @if(str_starts_with($file->getMimeType(), 'image/'))
                                            <img src="{{ $file->temporaryUrl() }}" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400 truncate font-medium">{{ $file->getClientOriginalName() }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-3 pt-5 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit"
                            class="px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-primary to-primary-dark rounded-xl hover:shadow-lg hover:shadow-primary/25 hover:-translate-y-0.5 transition-all duration-300">
                        {{ $content->status->value === 'revision_requested' ? 'Simpan & Kirim Ulang' : 'Simpan Perubahan' }}
                    </button>
                    <a href="{{ route('kol.content.show', $content) }}" wire:navigate
                       class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100/80 dark:bg-gray-700/80 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-300">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
