<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-900">Dashboard Admin</h2>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="p-6 bg-white rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total User</p>
                    <p class="text-2xl font-bold">{{ $stats['totalUsers'] }}</p>
                </div>
                <div class="p-3 bg-indigo-100 rounded-full">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex gap-4 text-xs text-gray-500">
                <span>Brand: <strong>{{ $stats['brandCount'] }}</strong></span>
                <span>KOL: <strong>{{ $stats['kolCount'] }}</strong></span>
            </div>
        </div>

        <div class="p-6 bg-white rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Campaign</p>
                    <p class="text-2xl font-bold">{{ $stats['totalCampaigns'] }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Revenue</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($stats['totalRevenue'], 0, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pending / Dispute</p>
                    <p class="text-2xl font-bold">{{ $stats['pendingWithdrawals'] + $stats['openDisputes'] }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex gap-4 text-xs text-gray-500">
                <span>Withdrawal: <strong>{{ $stats['pendingWithdrawals'] }}</strong></span>
                <span>Dispute: <strong>{{ $stats['openDisputes'] }}</strong></span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="p-6 bg-white rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Revenue (6 Bulan)</h3>
            <div id="revenueChart" class="h-72"></div>
        </div>

        <div class="p-6 bg-white rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Registrasi User (6 Bulan)</h3>
            <div id="registrationChart" class="h-72"></div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('livewire:init', function () {
        var revenueOptions = {
            chart: { type: 'area', height: 288, fontFamily: 'Inter, sans-serif', toolbar: { show: false } },
            series: [{ name: 'Revenue', data: @json($revenueChart['data']) }],
            xaxis: { categories: @json($revenueChart['categories']), labels: { style: { colors: '#9ca3af' } } },
            yaxis: { labels: { formatter: function (v) { return 'Rp' + v.toLocaleString(); }, style: { colors: '#9ca3af' } } },
            stroke: { curve: 'smooth' },
            colors: ['#6366f1'],
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.2 } },
            tooltip: { y: { formatter: function (v) { return 'Rp ' + v.toLocaleString(); } } }
        };
        var revenueChart = new ApexCharts(document.querySelector("#revenueChart"), revenueOptions);
        revenueChart.render();

        var registrationOptions = {
            chart: { type: 'bar', height: 288, fontFamily: 'Inter, sans-serif', toolbar: { show: false } },
            series: [{ name: 'Registrasi', data: @json($registrationChart['data']) }],
            xaxis: { categories: @json($registrationChart['categories']), labels: { style: { colors: '#9ca3af' } } },
            yaxis: { labels: { style: { colors: '#9ca3af' } } },
            colors: ['#a5b4fc'],
            plotOptions: { bar: { borderRadius: 4, columnWidth: '60%' } },
            tooltip: { y: { formatter: function (v) { return v + ' user'; } } }
        };
        var registrationChart = new ApexCharts(document.querySelector("#registrationChart"), registrationOptions);
        registrationChart.render();
    });
</script>
@endpush
