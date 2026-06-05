<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Brand</h2>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Campaign</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalCampaigns }}</p>
        </div>
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Spending</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
        </div>
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Rating</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($ratingAvg, 1) }}</p>
        </div>
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Active Hirings</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $activeHirings }}</p>
        </div>
    </div>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Campaign Terbaru</h3>
        @if ($recentCampaigns->isEmpty())
            <x-empty-state icon="campaign" title="Belum ada campaign" description="Buat campaign pertama Anda!" actionLabel="Buat Campaign" actionUrl="{{ route('brand.campaign.create') }}" />
        @else
            <div class="space-y-3">
                @foreach ($recentCampaigns as $campaign)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $campaign->title }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $campaign->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium rounded-full
                            @if($campaign->status === 'published') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                            @elseif($campaign->status === 'draft') bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400
                            @else bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300
                            @endif">
                            {{ ucfirst($campaign->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Spending Overview</h3>
        <div id="spendingChart" class="h-64"></div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', function () {
        var isDark = document.documentElement.classList.contains('dark');
        var textColor = isDark ? '#9ca3af' : '#9ca3af';
        var options = {
            chart: { type: 'area', height: 256, fontFamily: 'Inter, sans-serif', toolbar: { show: false }, foreColor: textColor },
            series: [{ name: 'Spending', data: [0, 0, 0, 0, 0, 0] }],
            xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'] },
            yaxis: { labels: { formatter: function (v) { return 'Rp' + v.toLocaleString(); } } },
            stroke: { curve: 'smooth' },
            colors: ['#6366f1'],
            theme: { mode: isDark ? 'dark' : 'light' },
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.2 } },
            tooltip: { y: { formatter: function (v) { return 'Rp ' + v.toLocaleString(); } } }
        };
        var chart = new ApexCharts(document.querySelector("#spendingChart"), options);
        chart.render();
    });
</script>
@endpush
