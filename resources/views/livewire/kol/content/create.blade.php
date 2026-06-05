<div>
    <div class="mb-4">
        <a href="{{ route('kol.content.index') }}" wire:navigate class="text-sm text-indigo-600 hover:text-indigo-800">&larr; Kembali</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Upload Konten Baru</h2>
        </div>

        <form wire:submit="save" class="px-6 py-6 space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Agreement</label>
                <select wire:model="agreement_id"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">-- Pilih Agreement --</option>
                    @foreach($agreements as $agreement)
                        <option value="{{ $agreement->id }}">
                            {{ $agreement->agreement_number }} - {{ $agreement->hiring?->campaign?->title ?? 'N/A' }}
                        </option>
                    @endforeach
                </select>
                @error('agreement_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Konten</label>
                <input type="text" wire:model="title"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                       placeholder="Masukkan judul konten">
                @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Caption</label>
                <textarea wire:model="caption" rows="4"
                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                          placeholder="Tulis caption untuk konten ini"></textarea>
                @error('caption') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload File</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                <span>Upload file</span>
                                <input type="file" wire:model="files" multiple class="sr-only" accept="image/*,video/*,.pdf,.doc,.docx">
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">JPG, PNG, GIF, WebP, MP4, MOV, PDF, DOC hingga 50MB</p>
                    </div>
                </div>
                @error('files.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

                @if($files)
                    <div class="mt-4 grid grid-cols-4 gap-3">
                        @foreach($files as $file)
                            <div class="relative group">
                                <div class="aspect-square rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden">
                                    @if(str_starts_with($file->getMimeType(), 'image/'))
                                        <img src="{{ $file->temporaryUrl() }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    @endif
                                </div>
                                <p class="mt-1 text-xs text-gray-500 truncate">{{ $file->getClientOriginalName() }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-3 pt-4 border-t">
                <button type="submit"
                        class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                    Simpan Konten
                </button>
                <a href="{{ route('kol.content.index') }}" wire:navigate
                   class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
