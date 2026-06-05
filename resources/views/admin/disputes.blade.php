<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Pusat Dispute</h2>
    </div>

    <div class="flex flex-wrap gap-4">
        <select wire:model.live="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">Semua Status</option>
            <option value="open">Open</option>
            <option value="investigating">Investigating</option>
            <option value="resolved">Resolved</option>
            <option value="closed">Closed</option>
        </select>
    </div>

    <div class="overflow-hidden bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Subject</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Hiring</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Raised By</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Status</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Tanggal</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-end">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($disputes as $dispute)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-900">{{ $dispute->subject }}</p>
                            <p class="text-xs text-gray-500 truncate max-w-[200px]">{{ $dispute->description }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $dispute->hiring?->campaign?->title ?? 'Hiring #'.$dispute->hiring_id }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $dispute->raisedBy?->name ?? 'User #'.$dispute->raised_by }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                {{ $dispute->status === 'open' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $dispute->status === 'investigating' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $dispute->status === 'resolved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $dispute->status === 'closed' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ ucfirst($dispute->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $dispute->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-end">
                            <div class="flex items-center justify-end gap-2">
                                <button wire:click="confirmAddNote({{ $dispute->id }})" class="px-3 py-1 text-xs font-medium text-indigo-700 bg-indigo-100 rounded-lg hover:bg-indigo-200">Tambah Catatan</button>
                                @if ($dispute->status !== 'resolved' && $dispute->status !== 'closed')
                                    <button wire:click="confirmResolve({{ $dispute->id }})" class="px-3 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-lg hover:bg-green-200">Selesaikan</button>
                                @endif
                            </div>
                            @if ($dispute->admin_notes)
                                <div class="mt-2 text-xs text-gray-500">
                                    @foreach (json_decode($dispute->admin_notes, true) as $note)
                                        <p class="truncate">
                                            <span class="font-medium">{{ $note['type'] === 'resolution' ? 'Resolusi' : 'Catatan' }}:</span>
                                            {{ \Illuminate\Support\Str::limit($note['message'], 50) }}
                                        </p>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">Tidak ada dispute ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $disputes->links() }}
    </div>

    {{-- Note Modal --}}
    @if ($showNoteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="w-full max-w-md p-6 mx-4 bg-white rounded-lg shadow-xl" @@click.away="$wire.showNoteModal = false">
                <h3 class="text-lg font-semibold text-gray-900">Tambah Catatan</h3>
                <form wire:submit="addNote" class="mt-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Catatan</label>
                        <textarea wire:model="note" rows="3" class="w-full mt-1 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        @error('note') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" wire:click="$set('showNoteModal', false)" class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Resolve Modal --}}
    @if ($showResolveModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="w-full max-w-md p-6 mx-4 bg-white rounded-lg shadow-xl" @@click.away="$wire.showResolveModal = false">
                <h3 class="text-lg font-semibold text-gray-900">Selesaikan Dispute</h3>
                <form wire:submit="resolve" class="mt-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Resolusi</label>
                        <textarea wire:model="resolution" rows="3" class="w-full mt-1 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        @error('resolution') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" wire:click="$set('showResolveModal', false)" class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm text-white bg-green-600 rounded-lg hover:bg-green-700">Selesaikan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
