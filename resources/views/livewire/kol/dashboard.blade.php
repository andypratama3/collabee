<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard KOL</h2>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Saldo Wallet</p>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400">Rp {{ number_format($walletBalance, 0, ',', '.') }}</p>
        </div>
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Pending Balance</p>
            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">Rp {{ number_format($pendingBalance, 0, ',', '.') }}</p>
        </div>
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Campaign Done</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalCampaignsDone }}</p>
        </div>
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Rating</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($ratingAvg, 1) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Undangan Hiring</h3>
            @if ($recentHirings->isEmpty())
                <x-empty-state icon="message" title="Belum ada undangan hiring" description="Apply to campaigns to get hired!" actionLabel="Explore Campaigns" actionUrl="{{ route('campaigns.explore') }}" />
            @else
                <div class="space-y-3">
                    @foreach ($recentHirings as $hiring)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $hiring->campaign?->title ?? 'Campaign' }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $hiring->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                @if($hiring->status === 'accepted') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                @elseif($hiring->status === 'pending') bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400
                                @elseif($hiring->status === 'negotiating') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                @else bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300
                                @endif">
                                {{ ucfirst($hiring->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Riwayat Earnings</h3>
            <div id="earningsChart" class="h-64"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', function () {
        var isDark = document.documentElement.classList.contains('dark');
        var earnings = @json($earnings);
        var months = Object.keys(earnings);
        var values = Object.values(earnings);

        var options = {
            chart: { type: 'bar', height: 256, fontFamily: 'Inter, sans-serif', toolbar: { show: false }, foreColor: isDark ? '#9ca3af' : '#9ca3af' },
            series: [{ name: 'Earnings', data: values }],
            xaxis: { categories: months.length ? months : ['Belum ada data'] },
            yaxis: { labels: { formatter: function (v) { return 'Rp' + v.toLocaleString(); } } },
            colors: ['#6366f1'],
            theme: { mode: isDark ? 'dark' : 'light' },
            tooltip: { y: { formatter: function (v) { return 'Rp ' + v.toLocaleString(); } } }
        };
        var chart = new ApexCharts(document.querySelector("#earningsChart"), options);
        chart.render();
    });
</script>
@endpush
