<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-900">Dashboard Brand</h2>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="p-6 bg-white rounded-lg shadow">
            <p class="text-sm text-gray-500">Total Campaign</p>
            <p class="text-2xl font-bold">{{ $totalCampaigns }}</p>
        </div>
        <div class="p-6 bg-white rounded-lg shadow">
            <p class="text-sm text-gray-500">Total Spending</p>
            <p class="text-2xl font-bold">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
        </div>
        <div class="p-6 bg-white rounded-lg shadow">
            <p class="text-sm text-gray-500">Rating</p>
            <p class="text-2xl font-bold">{{ number_format($ratingAvg, 1) }}</p>
        </div>
        <div class="p-6 bg-white rounded-lg shadow">
            <p class="text-sm text-gray-500">Active Hirings</p>
            <p class="text-2xl font-bold">{{ $activeHirings }}</p>
        </div>
    </div>

    <div class="p-6 bg-white rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Campaign Terbaru</h3>
        @if ($recentCampaigns->isEmpty())
            <p class="text-sm text-gray-500">Belum ada campaign. Buat campaign pertama Anda!</p>
        @else
            <div class="space-y-3">
                @foreach ($recentCampaigns as $campaign)
                    <div class="flex items-center justify-between py-2 border-b last:border-0">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $campaign->title }}</p>
                            <p class="text-xs text-gray-500">{{ $campaign->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-{{ $campaign->status === 'published' ? 'green' : ($campaign->status === 'draft' ? 'yellow' : 'gray') }}-100 text-{{ $campaign->status === 'published' ? 'green' : ($campaign->status === 'draft' ? 'yellow' : 'gray') }}-800">
                            {{ ucfirst($campaign->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="p-6 bg-white rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Spending Overview</h3>
        <div id="spendingChart" class="h-64"></div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('livewire:init', function () {
        var options = {
            chart: { type: 'area', height: 256, fontFamily: 'Inter, sans-serif', toolbar: { show: false } },
            series: [{ name: 'Spending', data: [0, 0, 0, 0, 0, 0] }],
            xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'], labels: { style: { colors: '#9ca3af' } } },
            yaxis: { labels: { formatter: function (v) { return 'Rp' + v.toLocaleString(); }, style: { colors: '#9ca3af' } } },
            stroke: { curve: 'smooth' },
            colors: ['#6366f1'],
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.2 } },
            tooltip: { y: { formatter: function (v) { return 'Rp ' + v.toLocaleString(); } } }
        };
        var chart = new ApexCharts(document.querySelector("#spendingChart"), options);
        chart.render();
    });
</script>
@endpush
