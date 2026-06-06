<div class="space-y-8">
    {{-- Page Header --}}
    <div class="relative">
        <div class="absolute -top-4 -left-4 w-72 h-72 bg-gradient-to-br from-violet-400/20 to-purple-400/20 rounded-full blur-3xl opacity-50 dark:opacity-30"></div>
        <div class="relative">
            <h2 class="text-3xl font-extrabold tracking-tight">
                <span class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 dark:from-white dark:via-gray-100 dark:to-gray-300 bg-clip-text text-transparent">Pengaturan</span>
            </h2>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Konfigurasi pengaturan platform dan parameter sistem.</p>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-emerald-50/80 dark:bg-emerald-900/20 backdrop-blur-xl border border-emerald-200/50 dark:border-emerald-800/50 rounded-2xl">
            <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <span class="text-sm font-medium text-emerald-800 dark:text-emerald-300">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Settings Form --}}
    <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 overflow-hidden">
        <form wire:submit="save">
            {{-- Financial Settings Section --}}
            <div class="p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-9 h-9 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 uppercase tracking-wider">Pengaturan Keuangan</h3>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Atur fee platform dan batas penarikan</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                    <div class="space-y-1.5">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Platform Fee (%)</label>
                        <input type="number" wire:model="platformFeePercent" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/80 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-200 dark:text-gray-200 placeholder-gray-400">
                        @error('platformFeePercent') <span class="text-xs text-rose-600 dark:text-rose-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Min Withdrawal</label>
                        <input type="number" wire:model="minWithdrawal" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/80 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-200 dark:text-gray-200 placeholder-gray-400">
                        @error('minWithdrawal') <span class="text-xs text-rose-600 dark:text-rose-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Max Withdrawal</label>
                        <input type="number" wire:model="maxWithdrawal" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/80 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-200 dark:text-gray-200 placeholder-gray-400">
                        @error('maxWithdrawal') <span class="text-xs text-rose-600 dark:text-rose-400">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 dark:border-gray-700"></div>

            {{-- General Settings Section --}}
            <div class="p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 uppercase tracking-wider">Pengaturan Umum</h3>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Informasi kontak dan deskripsi platform</p>
                    </div>
                </div>
                <div class="space-y-5">
                    <div class="space-y-1.5">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Contact Email</label>
                        <input type="email" wire:model="contactEmail" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/80 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-200 dark:text-gray-200 placeholder-gray-400">
                        @error('contactEmail') <span class="text-xs text-rose-600 dark:text-rose-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">About Text</label>
                        <textarea wire:model="aboutText" rows="3" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/80 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-200 dark:text-gray-200 placeholder-gray-400 resize-none"></textarea>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 dark:border-gray-700"></div>

            {{-- System Settings Section --}}
            <div class="p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-9 h-9 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 uppercase tracking-wider">Pengaturan Sistem</h3>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Kontrol mode maintenance dan sistem</p>
                    </div>
                </div>
                <label class="relative inline-flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" wire:model="maintenanceMode" class="w-5 h-5 rounded-lg border-gray-300 dark:border-gray-600 text-primary-600 focus:ring-2 focus:ring-primary-500/20 transition-all duration-200">
                    <div>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Maintenance Mode</span>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Aktifkan untuk menonaktifkan akses publik sementara</p>
                    </div>
                </label>
            </div>

            <div class="border-t border-gray-100 dark:border-gray-700"></div>

            {{-- Submit --}}
            <div class="p-6 sm:p-8 bg-gray-50/50 dark:bg-gray-900/20">
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl hover:from-primary-600 hover:to-primary-700 shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/30 hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Pengaturan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
