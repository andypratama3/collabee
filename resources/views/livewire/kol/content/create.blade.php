<div>
    <!-- Back Navigation -->
    <div class="mb-5">
        <a href="{{ route('kol.content.index') }}" wire:navigate class="inline-flex items-center gap-1.5 text-sm text-primary dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 font-medium transition-colors duration-200 group">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
        <!-- Card Header -->
        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-white/80 to-gray-50/80 dark:from-gray-800/80 dark:to-gray-750/80">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary/20 to-primary/10 dark:from-primary/30 dark:to-primary/15 flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Upload Konten Baru</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Lengkapi detail konten di bawah ini</p>
                </div>
            </div>
        </div>

        <form wire:submit="save" class="px-6 py-6 space-y-6">
            <!-- Agreement Select -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Pilih Agreement</label>
                <select wire:model="agreement_id"
                        class="w-full rounded-xl border-gray-200/80 dark:border-gray-600/80 shadow-sm focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm dark:bg-gray-700/50 dark:text-gray-200 transition-all duration-200 py-2.5">
                    <option value="">-- Pilih Agreement --</option>
                    @foreach($agreements as $agreement)
                        <option value="{{ $agreement->id }}">
                            {{ $agreement->agreement_number }} - {{ $agreement->hiring?->campaign?->title ?? 'N/A' }}
                        </option>
                    @endforeach
                </select>
                @error('agreement_id') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
            </div>

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

            <!-- File Upload -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Upload File</label>
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
                    Simpan Konten
                </button>
                <a href="{{ route('kol.content.index') }}" wire:navigate
                   class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100/80 dark:bg-gray-700/80 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-300">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
