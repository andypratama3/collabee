<div class="max-w-2xl mx-auto space-y-6">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Lengkapi Profil Brand</h2>

    <form wire:submit="save" class="space-y-6">
        <div>
            <label for="brand_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Brand <span class="text-red-500">*</span></label>
            <input wire:model="brand_name" id="brand_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('brand_name') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
            <textarea wire:model="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            @error('description') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="industry" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Industri</label>
            <input wire:model="industry" id="industry" type="text" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('industry') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Website</label>
            <input wire:model="website" id="website" type="url" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('website') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi</label>
            <input wire:model="location" id="location" type="text" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('location') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Logo</label>
            <input wire:model="logo" id="logo" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-900/30 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-900/50">
            @error('logo') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
            <div wire:loading wire:target="logo" class="mt-2 text-sm text-indigo-600 dark:text-indigo-400">Uploading...</div>
            @if ($logo)
                <img src="{{ $logo->temporaryUrl() }}" class="mt-2 h-20 rounded">
            @endif
        </div>

        <div>
            <label for="banner" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Banner</label>
            <input wire:model="banner" id="banner" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-900/30 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-900/50">
            @error('banner') <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
            <div wire:loading wire:target="banner" class="mt-2 text-sm text-indigo-600 dark:text-indigo-400">Uploading...</div>
            @if ($banner)
                <img src="{{ $banner->temporaryUrl() }}" class="mt-2 h-20 rounded">
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-6 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900" wire:loading.attr="disabled">
                <span wire:loading.remove>Simpan Profil</span>
                <span wire:loading>Menyimpan...</span>
            </button>
        </div>
    </form>
</div>
