<div>
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Penarikan Saldo</h1>
            <p class="mt-1 text-sm text-gray-500">Tarik saldo wallet ke rekening bank Anda</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6">
        <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-200">
            <p class="text-sm text-gray-500">Saldo Wallet</p>
            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($walletBalance, 0, ',', '.') }}</p>
        </div>
        <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-200">
            <p class="text-sm text-gray-500">Pending Balance</p>
            <p class="text-2xl font-bold text-yellow-600">Rp {{ number_format($pendingBalance, 0, ',', '.') }}</p>
        </div>
        <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-200">
            <p class="text-sm text-gray-500">Minimum Penarikan</p>
            <p class="text-2xl font-bold text-gray-900">Rp 100.000</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Ajukan Penarikan</h2>

                <form wire:submit="requestWithdrawal" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Rp)</label>
                        <input type="number" wire:model="amount" min="100000" step="1000"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="Minimum Rp 100.000">
                        @error('amount') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rekening Tujuan</label>
                        @if($bankAccounts->isNotEmpty())
                            <select wire:model="bankAccountId"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Pilih Rekening</option>
                                @foreach($bankAccounts as $account)
                                    <option value="{{ $account->id }}">
                                        {{ $account->bank_name }} - {{ $account->account_number }} ({{ $account->account_name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('bankAccountId') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        @else
                            <p class="text-sm text-gray-500">Belum ada rekening bank. Tambahkan di profil Anda.</p>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (opsional)</label>
                        <textarea wire:model="notes" rows="2"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                  placeholder="Catatan untuk admin"></textarea>
                        @error('notes') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" @if($bankAccounts->isEmpty()) disabled @endif
                            class="w-full px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 disabled:bg-gray-300 disabled:cursor-not-allowed">
                        Ajukan Penarikan
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-3">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Riwayat Penarikan</h2>
                </div>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bank</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($withdrawals as $withdrawal)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $withdrawal->bank_name }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-full
                                        @if($withdrawal->status === 'completed') bg-green-100 text-green-700
                                        @elseif($withdrawal->status === 'rejected') bg-red-100 text-red-700
                                        @else bg-yellow-100 text-yellow-700
                                        @endif">
                                        {{ ucfirst($withdrawal->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $withdrawal->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">Belum ada riwayat penarikan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($withdrawals, 'links'))
                <div class="mt-6">{{ $withdrawals->links() }}</div>
            @endif
        </div>
    </div>
</div>
