<div class="max-w-5xl mx-auto pb-12">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="p-2.5 bg-gradient-to-br from-primary/20 to-primary/5 dark:from-primary/30 dark:to-primary/10 rounded-xl">
                <svg class="w-6 h-6 text-primary dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </div>
            <div>
                <h2 class="text-3xl font-extrabold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent tracking-tight">Edit Profil KOL</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Perbarui informasi profil Anda untuk menarik lebih banyak brand.</p>
            </div>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="mb-6 p-4 bg-emerald-50/80 dark:bg-emerald-900/20 border border-emerald-200/50 dark:border-emerald-800/50 rounded-xl flex items-center gap-3 text-emerald-700 dark:text-emerald-400 backdrop-blur-sm">
            <div class="p-1 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <form wire:submit="update" class="space-y-8">
        <!-- Informasi Dasar -->
        <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50/80 to-white/80 dark:from-gray-800/80 dark:to-gray-800/50">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Informasi Dasar
                </h3>
            </div>
            <div class="p-6 md:p-8 space-y-6">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="flex-shrink-0">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Foto Profil</label>
                        <div class="relative group">
                            <div class="w-32 h-32 rounded-2xl overflow-hidden bg-gradient-to-br from-gray-100 to-gray-50 dark:from-gray-700 dark:to-gray-800 border-2 border-dashed border-gray-300 dark:border-gray-600 flex items-center justify-center relative shadow-inner">
                                @if ($avatar)
                                    <img src="{{ $avatar->temporaryUrl() }}" class="w-full h-full object-cover">
                                @elseif ($existing_avatar_url)
                                    <img src="{{ $existing_avatar_url }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                @endif
                                
                                <label class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-all duration-300 cursor-pointer rounded-2xl backdrop-blur-sm">
                                    <svg class="w-8 h-8 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <input wire:model="avatar" type="file" class="sr-only" accept="image/*">
                                </label>
                            </div>
                            <div wire:loading wire:target="avatar" class="absolute inset-0 flex items-center justify-center bg-white dark:bg-gray-800/80 rounded-2xl backdrop-blur-sm">
                                <svg class="animate-spin h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </div>
                        </div>
                        @error('avatar') <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex-1 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="display_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nama Tampilan <span class="text-red-500">*</span></label>
                                <input wire:model="display_name" id="display_name" type="text" class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-100 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300">
                                @error('display_name') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Kategori Utama</label>
                                <select wire:model="category" id="category" class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-100 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->value }}">{{ ucfirst($cat->value) }}</option>
                                    @endforeach
                                </select>
                                @error('category') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="bio" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Bio / Deskripsi Diri</label>
                            <textarea wire:model="bio" id="bio" rows="4" class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-100 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300" placeholder="Ceritakan tentang diri Anda dan apa yang Anda tawarkan ke brand..."></textarea>
                            @error('bio') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="location" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Lokasi</label>
                                <input wire:model="location" id="location" type="text" class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-100 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300" placeholder="Contoh: Jakarta, Indonesia">
                                @error('location') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="min_budget" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Budget Minimal (Rp)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-gray-400 dark:text-gray-500 text-sm font-medium">Rp</span>
                                    </div>
                                    <input wire:model="min_budget" id="min_budget" type="number" step="1" class="w-full pl-11 rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-100 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300">
                                </div>
                                @error('min_budget') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="gender" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Jenis Kelamin</label>
                                <div class="flex gap-3">
                                    <label class="flex-1 flex items-center justify-center p-3 rounded-xl border cursor-pointer transition-all duration-300 {{ $gender === 'male' ? 'ring-2 ring-primary border-primary/30 bg-primary/5 dark:bg-primary/10 shadow-sm' : 'border-gray-200 dark:border-gray-700 dark:bg-gray-900/50 hover:bg-gray-50 dark:hover:bg-gray-800 hover:-translate-y-0.5' }}">
                                        <input type="radio" wire:model="gender" value="male" class="sr-only">
                                        <span class="text-sm font-medium {{ $gender === 'male' ? 'text-primary dark:text-primary-400' : 'text-gray-700 dark:text-gray-300' }}">Laki-laki</span>
                                    </label>
                                    <label class="flex-1 flex items-center justify-center p-3 rounded-xl border cursor-pointer transition-all duration-300 {{ $gender === 'female' ? 'ring-2 ring-primary border-primary/30 bg-primary/5 dark:bg-primary/10 shadow-sm' : 'border-gray-200 dark:border-gray-700 dark:bg-gray-900/50 hover:bg-gray-50 dark:hover:bg-gray-800 hover:-translate-y-0.5' }}">
                                        <input type="radio" wire:model="gender" value="female" class="sr-only">
                                        <span class="text-sm font-medium {{ $gender === 'female' ? 'text-primary dark:text-primary-400' : 'text-gray-700 dark:text-gray-300' }}">Perempuan</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label for="date_of_birth" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal Lahir</label>
                                <input wire:model="date_of_birth" id="date_of_birth" type="date" class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-100 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300">
                                @error('date_of_birth') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="pt-2">
                            <label class="relative inline-flex items-center cursor-pointer group">
                                <input type="checkbox" wire:model="is_open_for_work" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 dark:peer-focus:ring-primary/10 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary shadow-inner"></div>
                                <span class="ml-3 text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-gray-100 transition-colors">Terbuka untuk Kerja Sama</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Akun Sosial Media -->
        <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50/80 to-white/80 dark:from-gray-800/80 dark:to-gray-800/50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    Akun Sosial Media
                </h3>
                <button type="button" wire:click="addSocialAccount" class="inline-flex items-center px-3.5 py-2 text-xs font-bold text-primary dark:text-primary-400 hover:bg-primary/10 rounded-xl transition-all duration-300 hover:-translate-y-0.5">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    TAMBAH AKUN
                </button>
            </div>
            <div class="p-6 md:p-8 space-y-4">
                @if (empty($social_accounts))
                    <div class="py-10 text-center border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-2xl bg-gray-50/30 dark:bg-gray-900/10">
                        <div class="w-12 h-12 bg-gradient-to-br from-gray-100 to-gray-50 dark:from-gray-700 dark:to-gray-800 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada akun sosial media yang ditambahkan.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($social_accounts as $index => $account)
                            <div class="relative p-5 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/30 group hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300">
                                <button type="button" wire:click="removeSocialAccount({{ $index }})" class="absolute top-4 right-4 p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m4-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                                <div class="grid grid-cols-2 gap-4 mt-2">
                                    <div class="col-span-2">
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Platform</label>
                                        <select wire:model="social_accounts.{{ $index }}.platform" class="w-full px-0 bg-transparent border-0 border-b border-gray-200 dark:border-gray-700 focus:ring-0 focus:border-primary text-sm font-semibold dark:text-gray-200">
                                            <option value="">Pilih Platform</option>
                                            @foreach($platforms as $platform)
                                                <option value="{{ $platform->value }}">{{ ucfirst($platform->value) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Username</label>
                                        <input wire:model="social_accounts.{{ $index }}.username" type="text" class="w-full px-0 bg-transparent border-0 border-b border-gray-200 dark:border-gray-700 focus:ring-0 focus:border-primary text-sm font-semibold dark:text-gray-200" placeholder="@username">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Followers</label>
                                        <input wire:model="social_accounts.{{ $index }}.followers_count" type="number" class="w-full px-0 bg-transparent border-0 border-b border-gray-200 dark:border-gray-700 focus:ring-0 focus:border-primary text-sm font-semibold dark:text-gray-200" placeholder="0">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Portfolio -->
        <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50/80 to-white/80 dark:from-gray-800/80 dark:to-gray-800/50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Portfolio
                </h3>
                <button type="button" wire:click="addPortfolio" class="inline-flex items-center px-3.5 py-2 text-xs font-bold text-primary dark:text-primary-400 hover:bg-primary/10 rounded-xl transition-all duration-300 hover:-translate-y-0.5">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    TAMBAH ITEM
                </button>
            </div>
            <div class="p-6 md:p-8 space-y-6">
                @if (empty($portfolios))
                    <div class="py-10 text-center border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-2xl bg-gray-50/30 dark:bg-gray-900/10">
                        <div class="w-12 h-12 bg-gradient-to-br from-gray-100 to-gray-50 dark:from-gray-700 dark:to-gray-800 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada item portfolio yang ditambahkan.</p>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($portfolios as $index => $portfolio)
                            <div class="relative p-6 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50/30 dark:bg-gray-900/20 group hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300">
                                <button type="button" wire:click="removePortfolio({{ $index }})" class="absolute top-5 right-5 p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m4-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Judul Project</label>
                                            <input wire:model="portfolios.{{ $index }}.title" type="text" class="w-full px-0 bg-transparent border-0 border-b border-gray-200 dark:border-gray-700 focus:ring-0 focus:border-primary text-sm font-semibold dark:text-gray-200" placeholder="Masukkan judul project">
                                            @error("portfolios.{$index}.title") <p class="mt-1 text-[10px] text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Deskripsi Singkat</label>
                                            <textarea wire:model="portfolios.{{ $index }}.description" rows="2" class="w-full px-0 bg-transparent border-0 border-b border-gray-200 dark:border-gray-700 focus:ring-0 focus:border-primary text-sm font-medium dark:text-gray-300" placeholder="Jelaskan peran Anda dalam project ini..."></textarea>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Link Eksternal (Opsional)</label>
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                            <input wire:model="portfolios.{{ $index }}.external_link" type="url" class="flex-1 px-0 bg-transparent border-0 border-b border-gray-200 dark:border-gray-700 focus:ring-0 focus:border-primary text-sm font-medium dark:text-gray-300" placeholder="https://example.com/project">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Rate Card -->
        <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50/80 to-white/80 dark:from-gray-800/80 dark:to-gray-800/50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Rate Card
                </h3>
                <button type="button" wire:click="addRateCard" class="inline-flex items-center px-3.5 py-2 text-xs font-bold text-primary dark:text-primary-400 hover:bg-primary/10 rounded-xl transition-all duration-300 hover:-translate-y-0.5">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    TAMBAH RATE
                </button>
            </div>
            <div class="p-6 md:p-8">
                @if (empty($rate_cards))
                    <div class="py-10 text-center border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-2xl bg-gray-50/30 dark:bg-gray-900/10">
                        <div class="w-12 h-12 bg-gradient-to-br from-gray-100 to-gray-50 dark:from-gray-700 dark:to-gray-800 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada data harga yang ditambahkan.</p>
                    </div>
                @else
                    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/80 dark:bg-gray-900/50 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                    <th class="px-6 py-4">Platform</th>
                                    <th class="px-6 py-4">Tipe Konten</th>
                                    <th class="px-6 py-4">Harga (Rp)</th>
                                    <th class="px-6 py-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100/50 dark:divide-gray-700/50">
                                @foreach($rate_cards as $index => $rateCard)
                                    <tr class="text-sm font-medium dark:text-gray-200 hover:bg-gray-50/80 dark:hover:bg-gray-700/30 transition-colors duration-200">
                                        <td class="px-6 py-4">
                                            <select wire:model="rate_cards.{{ $index }}.platform" class="bg-transparent border-0 p-0 focus:ring-0 text-sm font-bold dark:text-gray-200">
                                                <option value="">Platform</option>
                                                @foreach($platforms as $platform)
                                                    <option value="{{ $platform->value }}">{{ ucfirst($platform->value) }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-6 py-4">
                                            <input wire:model="rate_cards.{{ $index }}.content_type" type="text" class="w-full bg-transparent border-0 p-0 focus:ring-0 text-sm dark:text-gray-300" placeholder="Misal: Instagram Feed">
                                        </td>
                                        <td class="px-6 py-4">
                                            <input wire:model="rate_cards.{{ $index }}.price" type="number" class="w-full bg-transparent border-0 p-0 focus:ring-0 text-sm font-bold dark:text-gray-200" placeholder="0">
                                        </td>
                                        <td class="px-6 py-4">
                                            <button type="button" wire:click="removeRateCard({{ $index }})" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m4-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Rekening Bank -->
        <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50/80 to-white/80 dark:from-gray-800/80 dark:to-gray-800/50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Rekening Bank
                </h3>
            </div>
            <div class="p-6 md:p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="bank_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nama Bank</label>
                        <input wire:model="bank_name" id="bank_name" type="text" class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-100 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300" placeholder="Contoh: BCA, Mandiri, BNI">
                        @error('bank_name') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="account_number" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nomor Rekening</label>
                        <input wire:model="account_number" id="account_number" type="text" class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-100 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300" placeholder="0000000000">
                        @error('account_number') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="account_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nama Pemilik Rekening</label>
                        <input wire:model="account_name" id="account_name" type="text" class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-100 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300" placeholder="Nama sesuai di buku tabungan">
                        @error('account_name') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4 pt-4">
            <a href="{{ route('kol.dashboard') }}" wire:navigate class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors duration-200">BATAL</a>
            <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-primary to-primary-dark text-white rounded-xl font-bold shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-0.5 transition-all duration-300 focus:ring-4 focus:ring-primary/20" wire:loading.attr="disabled">
                <span wire:loading.remove>SIMPAN PERUBAHAN</span>
                <span wire:loading class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    MENYIMPAN...
                </span>
            </button>
        </div>
    </form>
</div>
