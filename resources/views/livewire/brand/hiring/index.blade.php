<div class="space-y-8">
    {{-- Page Header --}}
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-900 via-gray-800 to-gray-600 dark:from-white dark:via-gray-200 dark:to-gray-400">Hiring Management</h1>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Kelola undangan hiring dan lamaran dari KOL</p>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="flex gap-1 p-1 bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700 w-fit shadow-sm">
        <button wire:click="switchTab('outbound')"
                class="px-5 py-2.5 text-sm font-semibold rounded-xl transition-all duration-300 {{ $activeTab === 'outbound' ? 'bg-gradient-to-r from-primary to-primary-dark text-white shadow-md shadow-primary/25' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' }}">
            Outbound Hiring
            @if($hirings->total() > 0)
                <span class="ml-1.5 inline-flex items-center justify-center w-5 h-5 text-xs rounded-full {{ $activeTab === 'outbound' ? 'bg-white/30 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400' }}">{{ $hirings->total() }}</span>
            @endif
        </button>
        <button wire:click="switchTab('applications')"
                class="px-5 py-2.5 text-sm font-semibold rounded-xl transition-all duration-300 {{ $activeTab === 'applications' ? 'bg-gradient-to-r from-primary to-primary-dark text-white shadow-md shadow-primary/25' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' }}">
            Lamaran KOL
            @if($applications->total() > 0)
                <span class="ml-1.5 inline-flex items-center justify-center w-5 h-5 text-xs rounded-full {{ $activeTab === 'applications' ? 'bg-white/30 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400' }}">{{ $applications->total() }}</span>
            @endif
        </button>
    </div>

    @if($activeTab === 'outbound')
        {{-- Filter Pills --}}
        <div class="flex flex-wrap gap-2 p-1.5 bg-white dark:bg-gray-800/60 backdrop-blur-xl rounded-2xl w-fit border border-gray-200 dark:border-gray-700 shadow-sm">
            <button wire:click="$set('filter', '')"
                    class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-300 {{ empty($filter) ? 'bg-gradient-to-r from-primary to-primary-dark text-white shadow-md shadow-primary/25' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100/80 dark:hover:bg-gray-700/50' }}">
                Semua
            </button>
            @foreach($statuses as $status)
                <button wire:click="$set('filter', '{{ $status->value }}')"
                        class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-300 {{ $filter === $status->value ? 'bg-gradient-to-r from-primary to-primary-dark text-white shadow-md shadow-primary/25' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100/80 dark:hover:bg-gray-700/50' }}">
                    {{ ucfirst($status->value) }}
                </button>
            @endforeach
        </div>

        {{-- Outbound Hirings Table --}}
        <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200/50 dark:divide-gray-700/50">
                    <thead>
                        <tr class="bg-gray-50/80 dark:bg-gray-900/50">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">KOL</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Campaign</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Budget</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                        @forelse($hirings as $hiring)
                            <tr class="transition-colors duration-200 hover:bg-primary/[0.02] dark:hover:bg-primary/[0.05] even:bg-gray-50/30 dark:even:bg-gray-800/30">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary/20 to-primary/5 dark:from-primary/30 dark:to-primary/10 flex items-center justify-center text-primary dark:text-primary-400 font-bold text-xs ring-2 ring-primary/10 dark:ring-primary/20">
                                            {{ strtoupper(substr($hiring->kolProfile->display_name ?? '??', 0, 2)) }}
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $hiring->kolProfile->display_name ?? 'Unknown' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $hiring->campaign?->title ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white">
                                    @if($hiring->agreed_budget && $hiring->agreed_budget != $hiring->proposed_budget)
                                        <span class="text-gray-400 line-through text-xs">Rp. {{ number_format($hiring->proposed_budget ?? 0, 0, ',', '.') }}</span>
                                        <br>
                                        <span class="text-emerald-600 dark:text-emerald-400">Rp. {{ number_format($hiring->agreed_budget, 0, ',', '.') }}</span>
                                    @else
                                        Rp. {{ number_format($hiring->proposed_budget ?? 0, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold rounded-full border
                                        @if($hiring->status->value === 'pending') bg-amber-50 text-amber-600 border-amber-200/50 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800/50
                                        @elseif($hiring->status->value === 'accepted') bg-emerald-50 text-emerald-600 border-emerald-200/50 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800/50
                                        @elseif($hiring->status->value === 'rejected') bg-red-50 text-red-600 border-red-200/50 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800/50
                                        @elseif($hiring->status->value === 'cancelled') bg-gray-50 text-gray-500 border-gray-200/50 dark:bg-gray-700/50 dark:text-gray-300 dark:border-gray-600/50
                                        @else bg-blue-50 text-blue-600 border-blue-200/50 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-800/50
                                        @endif">
                                        <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                            @if($hiring->status->value === 'pending') bg-amber-500
                                            @elseif($hiring->status->value === 'accepted') bg-emerald-500
                                            @elseif($hiring->status->value === 'rejected') bg-red-500
                                            @elseif($hiring->status->value === 'cancelled') bg-gray-400
                                            @else bg-blue-500
                                            @endif"></span>
                                        {{ ucfirst($hiring->status->value) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $hiring->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if($hiring->agreement)
                                            <a href="{{ route('brand.agreement.show', $hiring->agreement) }}" wire:navigate
                                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-violet-600 dark:text-violet-400 bg-violet-50/50 dark:bg-violet-900/10 hover:bg-violet-100 dark:hover:bg-violet-900/20 rounded-lg transition-all duration-200 border border-violet-200/30 dark:border-violet-800/30">Agreement</a>
                                        @endif
                                        @if(in_array($hiring->status->value, ['pending', 'negotiating']))
                                            <button wire:click="confirmCancel({{ $hiring->id }})"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 dark:text-red-400 bg-red-50/50 dark:bg-red-900/10 hover:bg-red-100 dark:hover:bg-red-900/20 rounded-lg transition-all duration-200 border border-red-200/30 dark:border-red-800/30">Batal</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        </div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada outbound hiring.</p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Cari KOL dan kirim tawaran.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">{{ $hirings->links() }}</div>
    @endif

    @if($activeTab === 'applications')
        {{-- Inbound Applications from KOLs --}}
        <div class="bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200/50 dark:divide-gray-700/50">
                    <thead>
                        <tr class="bg-gray-50/80 dark:bg-gray-900/50">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">KOL</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Campaign</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Budget Diajukan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pesan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                        @forelse($applications as $application)
                            <tr class="transition-colors duration-200 hover:bg-primary/[0.02] dark:hover:bg-primary/[0.05] even:bg-gray-50/30 dark:even:bg-gray-800/30">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-violet-500/20 to-violet-500/5 dark:from-violet-500/30 dark:to-violet-500/10 flex items-center justify-center text-violet-600 dark:text-violet-400 font-bold text-xs ring-2 ring-violet-500/10">
                                            {{ strtoupper(substr($application->kolProfile->display_name ?? '??', 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $application->kolProfile->display_name ?? 'Unknown' }}</span>
                                            @if($application->kolProfile?->rating_avg > 0)
                                                <p class="text-xs text-amber-500">★ {{ number_format($application->kolProfile->rating_avg, 1) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 max-w-xs truncate">{{ $application->campaign?->title ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $application->proposed_budget ? 'Rp. ' . number_format($application->proposed_budget, 0, ',', '.') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 max-w-xs">
                                    @if($application->message)
                                        <span class="truncate block" title="{{ $application->message }}">{{ Str::limit($application->message, 60) }}</span>
                                    @else
                                        <span class="text-gray-300 dark:text-gray-600">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold rounded-full border
                                        @if($application->status === 'pending') bg-amber-50 text-amber-600 border-amber-200/50 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800/50
                                        @elseif($application->status === 'accepted') bg-emerald-50 text-emerald-600 border-emerald-200/50 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800/50
                                        @elseif($application->status === 'rejected') bg-red-50 text-red-600 border-red-200/50 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800/50
                                        @else bg-gray-50 text-gray-500 border-gray-200/50 dark:bg-gray-700/50 dark:text-gray-300 dark:border-gray-600/50
                                        @endif">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $application->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-right">
                                    @if($application->status === 'pending')
                                        <div class="flex items-center justify-end gap-2">
                                            <button wire:click="openApplicationModal({{ $application->id }}, 'accept')"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-white bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-lg hover:from-emerald-600 hover:to-emerald-700 shadow-sm shadow-emerald-500/20 transition-all duration-200">Terima</button>
                                            <button wire:click="openApplicationModal({{ $application->id }}, 'reject')"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50/50 dark:bg-red-900/10 hover:bg-red-100 dark:hover:bg-red-900/20 rounded-lg transition-all duration-200 border border-red-200/30 dark:border-red-800/30">Tolak</button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        </div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada lamaran dari KOL.</p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Publish campaign untuk mulai menerima lamaran.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">{{ $applications->links() }}</div>
    @endif

    {{-- Cancel Confirmation Modal --}}
    @if($showCancelConfirm)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 dark:bg-black/60 backdrop-blur-sm" wire:click.self="$set('showCancelConfirm', false)">
            <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-xl rounded-2xl shadow-2xl shadow-gray-900/20 dark:shadow-black/40 p-6 w-full max-w-md mx-4 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Batalkan Hiring?</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Alasan (opsional)</label>
                    <textarea wire:model="cancelReason" rows="2"
                              class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 placeholder-gray-400"
                              placeholder="Mengapa Anda membatalkan?"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button wire:click="$set('showCancelConfirm', false)"
                            class="px-5 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200">Tutup</button>
                    <button wire:click="cancel"
                            class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-red-500 to-red-600 rounded-xl hover:from-red-600 hover:to-red-700 shadow-lg shadow-red-500/25 transition-all duration-200">Ya, Batalkan</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Application Review Modal --}}
    @if($showApplicationModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 dark:bg-black/60 backdrop-blur-sm" wire:click.self="$set('showApplicationModal', false)">
            <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-xl rounded-2xl shadow-2xl shadow-gray-900/20 dark:shadow-black/40 p-6 w-full max-w-md mx-4 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $applicationAction === 'accept' ? 'bg-emerald-100 dark:bg-emerald-900/30' : 'bg-red-100 dark:bg-red-900/30' }}">
                        @if($applicationAction === 'accept')
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @else
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $applicationAction === 'accept' ? 'Terima Lamaran?' : 'Tolak Lamaran?' }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $applicationAction === 'accept' ? 'Agreement akan dibuat secara otomatis.' : 'Tindakan ini tidak dapat dibatalkan.' }}
                        </p>
                    </div>
                </div>
                @if($applicationAction === 'reject')
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Alasan penolakan (opsional)</label>
                        <textarea wire:model="applicationRejectReason" rows="2"
                                  class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 placeholder-gray-400"
                                  placeholder="Beri tahu KOL alasan penolakan..."></textarea>
                    </div>
                @endif
                <div class="flex justify-end gap-3">
                    <button wire:click="$set('showApplicationModal', false)"
                            class="px-5 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200">Batal</button>
                    <button wire:click="processApplication"
                            class="px-5 py-2.5 text-sm font-semibold text-white rounded-xl shadow-lg transition-all duration-200 {{ $applicationAction === 'accept' ? 'bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 shadow-emerald-500/25' : 'bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 shadow-red-500/25' }}">
                        {{ $applicationAction === 'accept' ? 'Ya, Terima' : 'Ya, Tolak' }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
