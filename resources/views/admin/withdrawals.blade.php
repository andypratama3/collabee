<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Manajemen Withdrawal</h2>
    </div>

    <div class="flex flex-wrap gap-4">
        <select wire:model.live="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">Semua Status</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="completed">Completed</option>
            <option value="rejected">Rejected</option>
        </select>
    </div>

    <div class="overflow-hidden bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">KOL</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Amount</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Admin Fee</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Net</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Bank</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Status</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Tanggal</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-end">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($withdrawals as $withdrawal)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium text-gray-900">{{ $withdrawal->kolProfile?->display_name ?? 'KOL #'.$withdrawal->kol_profile_id }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">Rp {{ number_format($withdrawal->admin_fee, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">Rp {{ number_format($withdrawal->net_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <p>{{ $withdrawal->bank_name }}</p>
                            <p class="text-xs">{{ $withdrawal->bank_account_number }} / {{ $withdrawal->bank_account_name }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                {{ $withdrawal->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $withdrawal->status === 'approved' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $withdrawal->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $withdrawal->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($withdrawal->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $withdrawal->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-end">
                            @if ($withdrawal->status === 'pending')
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="approve({{ $withdrawal->id }})" class="px-3 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-lg hover:bg-green-200">Setujui</button>
                                    <button wire:click="confirmReject({{ $withdrawal->id }})" class="px-3 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-lg hover:bg-red-200">Tolak</button>
                                </div>
                            @elseif ($withdrawal->status === 'approved')
                                <button wire:click="showProofUpload({{ $withdrawal->id }})" class="px-3 py-1 text-xs font-medium text-indigo-700 bg-indigo-100 rounded-lg hover:bg-indigo-200">Upload Bukti</button>
                            @elseif ($withdrawal->status === 'rejected' && $withdrawal->admin_note)
                                <span class="text-xs text-gray-500" title="{{ $withdrawal->admin_note }}">{{ \Illuminate\Support\Str::limit($withdrawal->admin_note, 30) }}</span>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">Tidak ada withdrawal ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $withdrawals->links() }}
    </div>

    {{-- Reject Modal --}}
    @if ($showRejectModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="w-full max-w-md p-6 mx-4 bg-white rounded-lg shadow-xl" @@click.away="$wire.showRejectModal = false">
                <h3 class="text-lg font-semibold text-gray-900">Tolak Withdrawal</h3>
                <form wire:submit="reject" class="mt-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                        <textarea wire:model="rejectReason" rows="3" class="w-full mt-1 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        @error('rejectReason') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" wire:click="$set('showRejectModal', false)" class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm text-white bg-red-600 rounded-lg hover:bg-red-700">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Upload Proof Modal --}}
    @if ($showProofModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="w-full max-w-md p-6 mx-4 bg-white rounded-lg shadow-xl" @@click.away="$wire.showProofModal = false">
                <h3 class="text-lg font-semibold text-gray-900">Upload Bukti Transfer</h3>
                <form wire:submit="uploadProof" class="mt-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">File Bukti (JPG/PNG/PDF, Max 2MB)</label>
                        <input type="file" wire:model="proofFile" class="w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @error('proofFile') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div wire:loading wire:target="proofFile" class="text-sm text-indigo-600">Uploading...</div>
                    <div class="flex justify-end gap-3">
                        <button type="button" wire:click="$set('showProofModal', false)" class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
