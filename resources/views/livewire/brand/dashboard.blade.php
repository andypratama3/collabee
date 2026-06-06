<div class="space-y-8 relative">
    <!-- Background glow effects -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-primary/20 blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-indigo-500/20 blur-[120px]"></div>
    </div>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 backdrop-blur-md bg-white dark:bg-gray-900/30 p-6 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-sm">
        <div>
            <h2 class="text-3xl font-black bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-300">
                Brand Dashboard
            </h2>
            <p class="text-gray-600 dark:text-gray-400 mt-1 font-medium">Overview of your campaign performance and activities.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('brand.campaign.create') }}" wire:navigate class="group relative inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white transition-all duration-200 bg-primary font-pj rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary hover:bg-primary-dark shadow-[0_0_20px_rgba(99,102,241,0.4)] hover:shadow-[0_0_25px_rgba(99,102,241,0.6)]">
                <svg class="w-5 h-5 mr-2 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Create Campaign
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Card 1 -->
        <div class="group relative p-6 bg-white dark:bg-gray-800/60 backdrop-blur-xl rounded-3xl border border-gray-200 dark:border-gray-700 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.1)] transition-all duration-300 hover:-translate-y-1 hover:shadow-xl overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-primary/20 rounded-full blur-2xl group-hover:bg-primary/30 transition-colors duration-300"></div>
            
            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Total Campaigns</p>
                    <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">{{ $totalCampaigns }}</p>
                </div>
                <div class="p-3 bg-white dark:bg-gray-700 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-600 text-primary group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="group relative p-6 bg-white dark:bg-gray-800/60 backdrop-blur-xl rounded-3xl border border-gray-200 dark:border-gray-700 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.1)] transition-all duration-300 hover:-translate-y-1 hover:shadow-xl overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-500/20 rounded-full blur-2xl group-hover:bg-green-500/30 transition-colors duration-300"></div>
            
            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Total Spent</p>
                    <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">Rp. {{ number_format($totalSpent, 0, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-white dark:bg-gray-700 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-600 text-green-500 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="group relative p-6 bg-white dark:bg-gray-800/60 backdrop-blur-xl rounded-3xl border border-gray-200 dark:border-gray-700 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.1)] transition-all duration-300 hover:-translate-y-1 hover:shadow-xl overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-500/20 rounded-full blur-2xl group-hover:bg-amber-500/30 transition-colors duration-300"></div>
            
            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Brand Rating</p>
                    <div class="flex items-center gap-2">
                        <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">{{ number_format($ratingAvg, 1) }}</p>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                </div>
                <div class="p-3 bg-white dark:bg-gray-700 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-600 text-amber-500 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.482-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="group relative p-6 bg-white dark:bg-gray-800/60 backdrop-blur-xl rounded-3xl border border-gray-200 dark:border-gray-700 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.1)] transition-all duration-300 hover:-translate-y-1 hover:shadow-xl overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-500/20 rounded-full blur-2xl group-hover:bg-indigo-500/30 transition-colors duration-300"></div>
            
            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Active Hirings</p>
                    <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">{{ $activeHirings }}</p>
                </div>
                <div class="p-3 bg-white dark:bg-gray-700 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-600 text-indigo-500 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Spending Chart -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800/60 backdrop-blur-xl rounded-3xl border border-gray-200 dark:border-gray-700 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.1)] overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                    Spending Overview (Last 7 Days)
                </h3>
            </div>
            <div class="p-6">
                <div id="spendingChart" class="h-80 w-full" wire:ignore></div>
            </div>
        </div>

        <!-- Recent Campaigns -->
        <div class="bg-white dark:bg-gray-800/60 backdrop-blur-xl rounded-3xl border border-gray-200 dark:border-gray-700 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.1)] overflow-hidden flex flex-col">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-gray-50/80 dark:bg-gray-800/40">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Recent Campaigns</h3>
                <a href="{{ route('brand.campaign.index') }}" wire:navigate class="text-sm font-bold text-primary hover:text-primary-dark transition-colors flex items-center gap-1 group">
                    View All 
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="p-0 flex-1">
                @if ($recentCampaigns->isEmpty())
                    <div class="p-12 flex items-center justify-center h-full">
                        <x-empty-state icon="campaign" title="No campaigns yet" description="Start your first campaign today." actionLabel="Create Campaign" actionUrl="{{ route('brand.campaign.create') }}" />
                    </div>
                @else
                    <div class="divide-y divide-gray-100 dark:divide-gray-700/50">
                        @foreach ($recentCampaigns as $campaign)
                            <div class="p-6 flex items-center justify-between hover:bg-white/80 dark:hover:bg-gray-700/80 transition-all duration-200 group">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary/10 to-primary/5 border border-primary/10 flex items-center justify-center text-primary group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-base font-bold text-gray-900 dark:text-white group-hover:text-primary transition-colors">{{ $campaign->title }}</p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ $campaign->created_at->format('d M Y') }}</span>
                                            <span class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-600"></span>
                                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ $campaign->kol_filled }}/{{ $campaign->kol_slots }} Slots</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="px-3 py-1 text-xs font-bold rounded-full border shadow-sm
                                    @if($campaign->status->value === 'open') bg-green-50 border-green-200 text-green-700 dark:bg-green-900/20 dark:border-green-800 dark:text-green-400
                                    @elseif($campaign->status->value === 'draft') bg-gray-50 border-gray-200 text-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300
                                    @elseif($campaign->status->value === 'in_progress') bg-blue-50 border-blue-200 text-blue-700 dark:bg-blue-900/20 dark:border-blue-800 dark:text-blue-400
                                    @else bg-yellow-50 border-yellow-200 text-yellow-700 dark:bg-yellow-900/20 dark:border-yellow-800 dark:text-yellow-400
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $campaign->status->value)) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Hirings -->
        <div class="bg-white dark:bg-gray-800/60 backdrop-blur-xl rounded-3xl border border-gray-200 dark:border-gray-700 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.1)] overflow-hidden flex flex-col">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-gray-50/80 dark:bg-gray-800/40">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Recent Hirings</h3>
                <a href="{{ route('brand.hiring.index') }}" wire:navigate class="text-sm font-bold text-primary hover:text-primary-dark transition-colors flex items-center gap-1 group">
                    View All 
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="p-0 flex-1">
                @if ($recentHirings->isEmpty())
                    <div class="p-12 flex items-center justify-center h-full">
                        <x-empty-state icon="hiring" title="No hirings yet" description="Start hiring KOLs for your campaigns." actionLabel="Browse KOL" actionUrl="{{ route('brand.browse-kol') }}" />
                    </div>
                @else
                    <div class="divide-y divide-gray-100 dark:divide-gray-700/50">
                        @foreach ($recentHirings as $hiring)
                            <div class="p-6 flex items-center justify-between hover:bg-white/80 dark:hover:bg-gray-700/80 transition-all duration-200 group">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-100 to-indigo-50 border border-indigo-200 dark:from-indigo-900/40 dark:to-indigo-800/20 dark:border-indigo-700 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-black text-lg shadow-sm group-hover:scale-110 transition-transform duration-300">
                                        {{ strtoupper(substr($hiring->kolProfile->display_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-base font-bold text-gray-900 dark:text-white group-hover:text-indigo-500 transition-colors">{{ $hiring->kolProfile->display_name }}</p>
                                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 line-clamp-1 mt-1">{{ $hiring->campaign->title }}</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 text-xs font-bold rounded-full border shadow-sm
                                    @if($hiring->status->value === 'accepted') bg-green-50 border-green-200 text-green-700 dark:bg-green-900/20 dark:border-green-800 dark:text-green-400
                                    @elseif($hiring->status->value === 'pending') bg-yellow-50 border-yellow-200 text-yellow-700 dark:bg-yellow-900/20 dark:border-yellow-800 dark:text-yellow-400
                                    @elseif($hiring->status->value === 'negotiating') bg-blue-50 border-blue-200 text-blue-700 dark:bg-blue-900/20 dark:border-blue-800 dark:text-blue-400
                                    @elseif($hiring->status->value === 'rejected' || $hiring->status->value === 'cancelled') bg-red-50 border-red-200 text-red-700 dark:bg-red-900/20 dark:border-red-800 dark:text-red-400
                                    @else bg-gray-50 border-gray-200 text-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300
                                    @endif">
                                    {{ ucfirst($hiring->status->value) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('livewire:init', function () {
        var isDark = document.documentElement.classList.contains('dark');
        var textColor = isDark ? '#9ca3af' : '#64748b';
        var gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';
        
        var spendingData = @json($spendingData);
        var spendingLabels = @json($spendingLabels);

        var options = {
            chart: {
                type: 'area',
                height: 350,
                fontFamily: 'Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif',
                toolbar: { show: false },
                background: 'transparent',
                dropShadow: {
                    enabled: true,
                    top: 10,
                    left: 0,
                    blur: 10,
                    color: '#6366f1',
                    opacity: 0.1
                }
            },
            series: [{
                name: 'Spending (Rp)',
                data: spendingData
            }],
            xaxis: {
                categories: spendingLabels,
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: { 
                    style: { 
                        colors: textColor, 
                        fontWeight: 600,
                        cssClass: 'text-xs font-semibold'
                    },
                    offsetY: 5
                },
                crosshairs: {
                    show: true,
                    stroke: {
                        color: '#6366f1',
                        width: 1,
                        dashArray: 4
                    }
                }
            },
            yaxis: {
                labels: {
                    style: { 
                        colors: textColor, 
                        fontWeight: 600 
                    },
                    formatter: function (v) { 
                        if (v >= 1000000) {
                            return 'Rp. ' + (v / 1000000).toFixed(1) + 'M';
                        } else if (v >= 1000) {
                            return 'Rp. ' + (v / 1000).toFixed(0) + 'K';
                        }
                        return 'Rp. ' + v;
                    }
                }
            },
            grid: {
                borderColor: gridColor,
                strokeDashArray: 4,
                padding: { top: 0, right: 0, bottom: 0, left: 10 },
                xaxis: { lines: { show: true } },
                yaxis: { lines: { show: true } }
            },
            stroke: { 
                curve: 'smooth', 
                width: 4,
                lineCap: 'round'
            },
            colors: ['#6366f1'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.5,
                    opacityTo: 0.05,
                    stops: [0, 90, 100],
                    colorStops: [
                        { offset: 0, color: '#6366f1', opacity: 0.5 },
                        { offset: 100, color: '#6366f1', opacity: 0.05 }
                    ]
                }
            },
            dataLabels: { enabled: false },
            tooltip: {
                theme: isDark ? 'dark' : 'light',
                y: { formatter: function (v) { return 'Rp. ' + v.toLocaleString(); } },
                style: {
                    fontSize: '14px',
                    fontFamily: 'Inter, sans-serif',
                },
                marker: { show: true }
            },
            markers: {
                size: 0,
                colors: ['#fff'],
                strokeColors: '#6366f1',
                strokeWidth: 3,
                strokeOpacity: 0.9,
                strokeDashArray: 0,
                fillOpacity: 1,
                discrete: [],
                shape: "circle",
                radius: 2,
                offsetX: 0,
                offsetY: 0,
                onClick: undefined,
                onDblClick: undefined,
                showNullDataPoints: true,
                hover: {
                    size: 8,
                    sizeOffset: 3
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#spendingChart"), options);
        chart.render();

        window.addEventListener('darkModeChanged', function() {
            var newIsDark = document.documentElement.classList.contains('dark');
            var newTextColor = newIsDark ? '#9ca3af' : '#64748b';
            var newGridColor = newIsDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';
            
            chart.updateOptions({
                theme: { mode: newIsDark ? 'dark' : 'light' },
                xaxis: { labels: { style: { colors: newTextColor } } },
                yaxis: { labels: { style: { colors: newTextColor } } },
                grid: { borderColor: newGridColor }
            });
        });
    });
</script>
@endpush
