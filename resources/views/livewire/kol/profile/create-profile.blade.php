<div class="max-w-3xl mx-auto space-y-8">
    <h2 class="text-2xl font-bold text-gray-900">Lengkapi Profil KOL</h2>

    <form wire:submit="save" class="space-y-8">
        <div class="space-y-6">
            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Dasar</h3>

            <div>
                <label for="display_name" class="block text-sm font-medium text-gray-700">Nama Tampilan <span class="text-red-500">*</span></label>
                <input wire:model="display_name" id="display_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('display_name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                <textarea wire:model="bio" id="bio" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                @error('bio') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select wire:model="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->value }}">{{ ucfirst($cat->value) }}</option>
                        @endforeach
                    </select>
                    @error('category') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Lokasi</label>
                    <input wire:model="location" id="location" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('location') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                    <select wire:model="gender" id="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Pilih</option>
                        <option value="male">Laki-laki</option>
                        <option value="female">Perempuan</option>
                    </select>
                    @error('gender') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input wire:model="date_of_birth" id="date_of_birth" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('date_of_birth') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label for="avatar" class="block text-sm font-medium text-gray-700">Foto Profil</label>
                <input wire:model="avatar" id="avatar" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                @error('avatar') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                <div wire:loading wire:target="avatar" class="mt-2 text-sm text-indigo-600">Uploading...</div>
                @if ($avatar)
                    <img src="{{ $avatar->temporaryUrl() }}" class="mt-2 h-20 rounded-full">
                @endif
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="is_open_for_work" class="flex items-center gap-2 text-sm font-medium text-gray-700">
                        <input wire:model="is_open_for_work" id="is_open_for_work" type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        Terbuka untuk Kerja Sama
                    </label>
                </div>

                <div>
                    <label for="min_budget" class="block text-sm font-medium text-gray-700">Budget Minimal (Rp)</label>
                    <input wire:model="min_budget" id="min_budget" type="number" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('min_budget') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Akun Sosial Media</h3>

            @foreach($social_accounts as $index => $account)
                <div class="p-4 border rounded-lg bg-gray-50 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Akun #{{ $index + 1 }}</span>
                        <button type="button" wire:click="removeSocialAccount({{ $index }})" class="text-sm text-red-600 hover:text-red-800">Hapus</button>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <select wire:model="social_accounts.{{ $index }}.platform" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">Platform</option>
                                @foreach($platforms as $platform)
                                    <option value="{{ $platform->value }}">{{ ucfirst($platform->value) }}</option>
                                @endforeach
                            </select>
                            @error("social_accounts.{$index}.platform") <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <input wire:model="social_accounts.{{ $index }}.username" type="text" placeholder="Username" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            @error("social_accounts.{$index}.username") <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <input wire:model="social_accounts.{{ $index }}.followers_count" type="number" placeholder="Followers" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                        <div>
                            <input wire:model="social_accounts.{{ $index }}.engagement_rate" type="number" step="0.01" placeholder="Engagement Rate" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                    </div>
                </div>
            @endforeach

            @if (empty($social_accounts))
                <p class="text-sm text-gray-500">Belum ada akun sosial media. Tambahkan setidaknya satu akun.</p>
            @endif

            <button type="button" wire:click="addSocialAccount" class="text-sm text-indigo-600 hover:text-indigo-800">
                + Tambah Akun Sosial Media
            </button>
        </div>

        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Portfolio</h3>

            @foreach($portfolios as $index => $portfolio)
                <div class="p-4 border rounded-lg bg-gray-50 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Portfolio #{{ $index + 1 }}</span>
                        <button type="button" wire:click="removePortfolio({{ $index }})" class="text-sm text-red-600 hover:text-red-800">Hapus</button>
                    </div>
                    <div>
                        <input wire:model="portfolios.{{ $index }}.title" type="text" placeholder="Judul" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @error("portfolios.{$index}.title") <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <textarea wire:model="portfolios.{{ $index }}.description" rows="2" placeholder="Deskripsi" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                    </div>
                    <div>
                        <input wire:model="portfolios.{{ $index }}.external_link" type="url" placeholder="Link Eksternal" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @error("portfolios.{$index}.external_link") <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>
            @endforeach

            <button type="button" wire:click="addPortfolio" class="text-sm text-indigo-600 hover:text-indigo-800">
                + Tambah Portfolio
            </button>
        </div>

        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Rate Card</h3>

            @foreach($rate_cards as $index => $rateCard)
                <div class="p-4 border rounded-lg bg-gray-50 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Rate #{{ $index + 1 }}</span>
                        <button type="button" wire:click="removeRateCard({{ $index }})" class="text-sm text-red-600 hover:text-red-800">Hapus</button>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <select wire:model="rate_cards.{{ $index }}.platform" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">Platform</option>
                                @foreach($platforms as $platform)
                                    <option value="{{ $platform->value }}">{{ ucfirst($platform->value) }}</option>
                                @endforeach
                            </select>
                            @error("rate_cards.{$index}.platform") <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <input wire:model="rate_cards.{{ $index }}.content_type" type="text" placeholder="Tipe Konten" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            @error("rate_cards.{$index}.content_type") <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <input wire:model="rate_cards.{{ $index }}.price" type="number" step="0.01" placeholder="Harga (Rp)" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            @error("rate_cards.{$index}.price") <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <input wire:model="rate_cards.{{ $index }}.description" type="text" placeholder="Deskripsi" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                    </div>
                </div>
            @endforeach

            <button type="button" wire:click="addRateCard" class="text-sm text-indigo-600 hover:text-indigo-800">
                + Tambah Rate Card
            </button>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="px-6 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" wire:loading.attr="disabled">
                <span wire:loading.remove>Simpan Profil</span>
                <span wire:loading>Menyimpan...</span>
            </button>
        </div>
    </form>
</div>
