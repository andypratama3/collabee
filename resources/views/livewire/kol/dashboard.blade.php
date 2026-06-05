<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-900">Dashboard KOL</h2>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="p-6 bg-white rounded-lg shadow">
            <p class="text-sm text-gray-500">Saldo Wallet</p>
            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($walletBalance, 0, ',', '.') }}</p>
        </div>
        <div class="p-6 bg-white rounded-lg shadow">
            <p class="text-sm text-gray-500">Pending Balance</p>
            <p class="text-2xl font-bold text-yellow-600">Rp {{ number_format($pendingBalance, 0, ',', '.') }}</p>
        </div>
        <div class="p-6 bg-white rounded-lg shadow">
            <p class="text-sm text-gray-500">Campaign Done</p>
            <p class="text-2xl font-bold">{{ $totalCampaignsDone }}</p>
        </div>
        <div class="p-6 bg-white rounded-lg shadow">
            <p class="text-sm text-gray-500">Rating</p>
            <p class="text-2xl font-bold">{{ number_format($ratingAvg, 1) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="p-6 bg-white rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Undangan Hiring</h3>
            @if ($recentHirings->isEmpty())
                <p class="text-sm text-gray-500">Belum ada undangan hiring.</p>
            @else
                <div class="space-y-3">
                    @foreach ($recentHirings as $hiring)
                        <div class="flex items-center justify-between py-2 border-b last:border-0">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $hiring->campaign?->title ?? 'Campaign' }}</p>
                                <p class="text-xs text-gray-500">{{ $hiring->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-{{ $hiring->status === 'accepted' ? 'green' : ($hiring->status === 'pending' ? 'yellow' : ($hiring->status === 'negotiating' ? 'blue' : 'gray')) }}-100 text-{{ $hiring->status === 'accepted' ? 'green' : ($hiring->status === 'pending' ? 'yellow' : ($hiring->status === 'negotiating' ? 'blue' : 'gray')) }}-800">
                                {{ ucfirst($hiring->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="p-6 bg-white rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Earnings</h3>
            <div id="earningsChart" class="h-64"></div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('livewire:init', function () {
        var earnings = @json($earnings);
        var months = Object.keys(earnings);
        var values = Object.values(earnings);

        var options = {
            chart: { type: 'bar', height: 256, fontFamily: 'Inter, sans-serif', toolbar: { show: false } },
            series: [{ name: 'Earnings', data: values }],
            xaxis: { categories: months.length ? months : ['Belum ada data'], labels: { style: { colors: '#9ca3af' } } },
            yaxis: { labels: { formatter: function (v) { return 'Rp' + v.toLocaleString(); }, style: { colors: '#9ca3af' } } },
            colors: ['#6366f1'],
            tooltip: { y: { formatter: function (v) { return 'Rp ' + v.toLocaleString(); } } }
        };
        var chart = new ApexCharts(document.querySelector("#earningsChart"), options);
        chart.render();
    });
</script>
@endpush
