<div>
    <!-- Page Header -->
    <div class="relative mb-8">
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-emerald-500/5 dark:bg-emerald-500/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-primary/5 dark:bg-primary/10 rounded-full blur-3xl"></div>
        </div>
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 via-gray-800 to-gray-600 dark:from-white dark:via-gray-100 dark:to-gray-300 bg-clip-text text-transparent">Penarikan Saldo</h1>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Tarik saldo wallet ke rekening bank Anda</p>
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-8">
        <div class="group p-6 bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-2xl">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500/20 to-emerald-600/10 dark:from-emerald-500/30 dark:to-emerald-600/15 flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Saldo Wallet</p>
                    <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-0.5">Rp. {{ number_format($walletBalance, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="group p-6 bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-2xl">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500/20 to-amber-600/10 dark:from-amber-500/30 dark:to-amber-600/15 flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Pending Balance</p>
                    <p class="text-2xl font-bold text-amber-600 dark:text-amber-400 mt-0.5">Rp. {{ number_format($pendingBalance, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="group p-6 bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-2xl">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-400/20 to-gray-500/10 dark:from-gray-400/30 dark:to-gray-500/15 flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Minimum Penarikan</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-0.5">Rp 100.000</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">
        <!-- Withdrawal Form -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary/20 to-primary/10 dark:from-primary/30 dark:to-primary/15 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Ajukan Penarikan</h2>
                </div>

                <form wire:submit="requestWithdrawal" class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Jumlah (Rp)</label>
                        <input type="number" wire:model="amount" min="100000" step="1000"
                               class="w-full px-4 py-2.5 border border-gray-200/80 dark:border-gray-600/80 rounded-xl text-sm bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200"
                               placeholder="Minimum Rp 100.000">
                        @error('amount') <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Rekening Tujuan</label>
                        @if($bankAccounts->isNotEmpty())
                            <select wire:model="bankAccountId"
                                    class="w-full px-4 py-2.5 border border-gray-200/80 dark:border-gray-600/80 rounded-xl text-sm bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200">
                                <option value="">Pilih Rekening</option>
                                @foreach($bankAccounts as $account)
                                    <option value="{{ $account->id }}">
                                        {{ $account->bank_name }} - {{ $account->account_number }} ({{ $account->account_name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('bankAccountId') <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        @else
                            <div class="px-4 py-3 bg-amber-50/50 dark:bg-amber-900/10 rounded-xl border border-amber-100/50 dark:border-amber-800/20">
                                <p class="text-sm text-amber-700 dark:text-amber-400">Belum ada rekening bank. Tambahkan di profil Anda.</p>
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Catatan (opsional)</label>
                        <textarea wire:model="notes" rows="2"
                                  class="w-full px-4 py-2.5 border border-gray-200/80 dark:border-gray-600/80 rounded-xl text-sm bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200"
                                  placeholder="Catatan untuk admin"></textarea>
                        @error('notes') <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" @if($bankAccounts->isEmpty()) disabled @endif
                            class="w-full px-5 py-3 text-sm font-medium text-white bg-gradient-to-r from-primary to-primary-dark rounded-xl hover:shadow-lg hover:shadow-primary/25 hover:-translate-y-0.5 transition-all duration-300 disabled:from-gray-300 disabled:to-gray-400 disabled:cursor-not-allowed disabled:shadow-none disabled:translate-y-0">
                        Ajukan Penarikan
                    </button>
                </form>
            </div>
        </div>

        <!-- Withdrawal History -->
        <div class="lg:col-span-3">
            <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-white/80 to-gray-50/80 dark:from-gray-800/80 dark:to-gray-750/80">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-400/20 to-gray-500/10 dark:from-gray-400/30 dark:to-gray-500/15 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Riwayat Penarikan</h2>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200/50 dark:divide-gray-700/50">
                        <thead class="bg-gray-50/80 dark:bg-gray-900/50">
                            <tr>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Bank</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100/80 dark:divide-gray-700/50">
                            @forelse($withdrawals as $withdrawal)
                                <tr class="group hover:bg-gray-50/80 dark:hover:bg-gray-700/30 transition-colors duration-200">
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white">Rp. {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $withdrawal->bank_name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-lg
                                            @if($withdrawal->status === 'completed') bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400 ring-1 ring-emerald-200/50 dark:ring-emerald-700/30
                                            @elseif($withdrawal->status === 'rejected') bg-rose-50 text-rose-700 dark:bg-rose-900/20 dark:text-rose-400 ring-1 ring-rose-200/50 dark:ring-rose-700/30
                                            @else bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400 ring-1 ring-amber-200/50 dark:ring-amber-700/30
                                            @endif">
                                            {{ ucfirst($withdrawal->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $withdrawal->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 mb-4 rounded-2xl bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                            </div>
                                            <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada riwayat penarikan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if(method_exists($withdrawals, 'links'))
                <div class="mt-8">{{ $withdrawals->links() }}</div>
            @endif
        </div>
    </div>
</div>
