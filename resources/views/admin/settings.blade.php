<div class="max-w-3xl mx-auto space-y-6">
    <h2 class="text-2xl font-bold text-gray-900">Pengaturan Aplikasi</h2>

    <form wire:submit="save" class="space-y-6">
        <div class="p-6 bg-white rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan Pembayaran</h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Fee Platform (%)</label>
                    <input type="number" wire:model="platformFeePercent" step="0.1" min="0" max="100"
                           class="w-full mt-1 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    @error('platformFeePercent') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Min. Withdrawal</label>
                    <input type="number" wire:model="minWithdrawal" min="0"
                           class="w-full mt-1 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    @error('minWithdrawal') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Max. Withdrawal</label>
                    <input type="number" wire:model="maxWithdrawal" min="0"
                           class="w-full mt-1 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    @error('maxWithdrawal') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="p-6 bg-white rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Kontak & Informasi</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email Kontak</label>
                    <input type="email" wire:model="contactEmail"
                           class="w-full mt-1 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    @error('contactEmail') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tentang</label>
                    <textarea wire:model="aboutText" rows="4"
                              class="w-full mt-1 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Syarat & Ketentuan</label>
                    <textarea wire:model="termsText" rows="4"
                              class="w-full mt-1 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kebijakan Privasi</label>
                    <textarea wire:model="privacyText" rows="4"
                              class="w-full mt-1 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Lainnya</h3>
            <div class="flex items-center gap-3">
                <input type="checkbox" wire:model="maintenanceMode" id="maintenanceMode"
                       class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                <label for="maintenanceMode" class="text-sm font-medium text-gray-700">Mode Maintenance</label>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
