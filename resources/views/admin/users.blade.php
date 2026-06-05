<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Manajemen User</h2>
    </div>

    <div class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau email..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <select wire:model.live="roleFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">Semua Role</option>
            @foreach ($roles as $role)
                <option value="{{ $role->value }}">{{ ucfirst($role->value) }}</option>
            @endforeach
        </select>
        <select wire:model.live="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">Semua Status</option>
            <option value="active">Aktif</option>
            <option value="inactive">Nonaktif</option>
            <option value="verified">Terverifikasi</option>
            <option value="unverified">Belum Verifikasi</option>
        </select>
    </div>

    <div class="overflow-hidden bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">User</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Role</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Status</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Terverifikasi</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Bergabung</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-end">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-sm font-medium text-indigo-600">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                {{ $user->user_type->value === 'brand' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $user->user_type->value === 'kol' ? 'bg-green-100 text-green-800' : '' }}
                                {{ str_starts_with($user->user_type->value, 'admin') ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ str_starts_with($user->user_type->value, 'super_admin') ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($user->user_type->value) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if ($user->is_active)
                                <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Aktif</span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if ($user->is_verified)
                                <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Ya</span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Tidak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-end">
                            <div class="flex items-center justify-end gap-2">
                                @if (!$user->is_active)
                                    <button wire:click="activate({{ $user->id }})" class="px-3 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-lg hover:bg-green-200">Aktifkan</button>
                                @else
                                    <button wire:click="ban({{ $user->id }})" class="px-3 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-lg hover:bg-red-200">Nonaktifkan</button>
                                @endif
                                @if (!$user->is_verified)
                                    <button wire:click="verify({{ $user->id }})" class="px-3 py-1 text-xs font-medium text-indigo-700 bg-indigo-100 rounded-lg hover:bg-indigo-200">Verifikasi</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">Tidak ada user ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
