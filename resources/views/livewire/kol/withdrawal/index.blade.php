<div>
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Penarikan Saldo</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Tarik saldo wallet ke rekening bank Anda</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6">
        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Saldo Wallet</p>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400">Rp {{ number_format($walletBalance, 0, ',', '.') }}</p>
        </div>
        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Pending Balance</p>
            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">Rp {{ number_format($pendingBalance, 0, ',', '.') }}</p>
        </div>
        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Minimum Penarikan</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp 100.000</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ajukan Penarikan</h2>

                <form wire:submit="requestWithdrawal" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah (Rp)</label>
                        <input type="number" wire:model="amount" min="100000" step="1000"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="Minimum Rp 100.000">
                        @error('amount') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rekening Tujuan</label>
                        @if($bankAccounts->isNotEmpty())
                            <select wire:model="bankAccountId"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Pilih Rekening</option>
                                @foreach($bankAccounts as $account)
                                    <option value="{{ $account->id }}">
                                        {{ $account->bank_name }} - {{ $account->account_number }} ({{ $account->account_name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('bankAccountId') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada rekening bank. Tambahkan di profil Anda.</p>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan (opsional)</label>
                        <textarea wire:model="notes" rows="2"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500"
                                  placeholder="Catatan untuk admin"></textarea>
                        @error('notes') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" @if($bankAccounts->isEmpty()) disabled @endif
                            class="w-full px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 disabled:bg-gray-300 disabled:cursor-not-allowed">
                        Ajukan Penarikan
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-3">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Riwayat Penarikan</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Bank</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($withdrawals as $withdrawal)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $withdrawal->bank_name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-0.5 text-xs font-medium rounded-full
                                            @if($withdrawal->status === 'completed') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                            @elseif($withdrawal->status === 'rejected') bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400
                                            @else bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400
                                            @endif">
                                            {{ ucfirst($withdrawal->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $withdrawal->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">Belum ada riwayat penarikan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if(method_exists($withdrawals, 'links'))
                <div class="mt-6">{{ $withdrawals->links() }}</div>
            @endif
        </div>
    </div>
</div>
