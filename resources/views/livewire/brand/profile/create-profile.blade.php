<div class="max-w-2xl mx-auto pb-12">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="p-2.5 bg-gradient-to-br from-primary/20 to-primary/5 dark:from-primary/30 dark:to-primary/10 rounded-xl">
                <svg class="w-6 h-6 text-primary dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">Lengkapi Profil Brand</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Isi informasi brand Anda untuk memulai kolaborasi</p>
            </div>
        </div>
    </div>

    <form wire:submit="save" class="space-y-6">
        <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 p-6 md:p-8 space-y-6">
            <div>
                <label for="brand_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nama Brand <span class="text-red-500">*</span></label>
                <input wire:model="brand_name" id="brand_name" type="text" class="mt-1 block w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-200 shadow-sm focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300 placeholder-gray-400" placeholder="Masukkan nama brand Anda">
                @error('brand_name') <span class="mt-1.5 text-sm text-red-600 dark:text-red-400 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Deskripsi</label>
                <textarea wire:model="description" id="description" rows="4" class="mt-1 block w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-200 shadow-sm focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300 placeholder-gray-400" placeholder="Ceritakan tentang brand Anda..."></textarea>
                @error('description') <span class="mt-1.5 text-sm text-red-600 dark:text-red-400 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="industry" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Industri</label>
                    <input wire:model="industry" id="industry" type="text" class="mt-1 block w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-200 shadow-sm focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300 placeholder-gray-400" placeholder="Contoh: Fashion, F&B">
                    @error('industry') <span class="mt-1.5 text-sm text-red-600 dark:text-red-400 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="website" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Website</label>
                    <input wire:model="website" id="website" type="url" class="mt-1 block w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-200 shadow-sm focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300 placeholder-gray-400" placeholder="https://example.com">
                    @error('website') <span class="mt-1.5 text-sm text-red-600 dark:text-red-400 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label for="location" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Lokasi</label>
                <input wire:model="location" id="location" type="text" class="mt-1 block w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-200 shadow-sm focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300 placeholder-gray-400" placeholder="Contoh: Jakarta, Indonesia">
                @error('location') <span class="mt-1.5 text-sm text-red-600 dark:text-red-400 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Media Upload Section -->
        <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 p-6 md:p-8 space-y-6">
            <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-primary dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Media Brand
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="logo" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Logo</label>
                    <div class="relative">
                        <input wire:model="logo" id="logo" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 dark:file:bg-primary-900/30 file:text-primary-dark dark:file:text-primary-300 hover:file:bg-primary-100 dark:hover:file:bg-primary-900/50 file:transition-all file:duration-300 file:cursor-pointer">
                        @error('logo') <span class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                        <div wire:loading wire:target="logo" class="mt-2 text-sm text-primary dark:text-primary-400 flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Uploading...
                        </div>
                        @if ($logo)
                            <img src="{{ $logo->temporaryUrl() }}" class="mt-3 h-20 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                        @endif
                    </div>
                </div>

                <div>
                    <label for="banner" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Banner</label>
                    <div class="relative">
                        <input wire:model="banner" id="banner" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 dark:file:bg-primary-900/30 file:text-primary-dark dark:file:text-primary-300 hover:file:bg-primary-100 dark:hover:file:bg-primary-900/50 file:transition-all file:duration-300 file:cursor-pointer">
                        @error('banner') <span class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                        <div wire:loading wire:target="banner" class="mt-2 text-sm text-primary dark:text-primary-400 flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Uploading...
                        </div>
                        @if ($banner)
                            <img src="{{ $banner->temporaryUrl() }}" class="mt-3 h-20 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 pt-2">
            <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 text-white bg-gradient-to-r from-primary to-primary-dark rounded-xl font-bold shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary/20" wire:loading.attr="disabled">
                <span wire:loading.remove>Simpan Profil</span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Menyimpan...
                </span>
            </button>
        </div>
    </form>
</div>
