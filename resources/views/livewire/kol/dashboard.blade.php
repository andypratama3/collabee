<div class="space-y-8 pb-10">
    <!-- Header Section with Greeting -->
    <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-r from-indigo-600 via-indigo-500 to-purple-600 p-8 sm:p-10 text-white shadow-2xl shadow-indigo-500/20">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-10 w-48 h-48 bg-purple-400/20 rounded-full blur-2xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight mb-2">
                    Welcome back, {{ auth()->user()->name }}! 👋
                </h2>
                <p class="text-indigo-100 max-w-xl text-lg font-medium">
                    Here's what's happening with your campaigns and earnings today. Let's make something great!
                </p>
            </div>
            <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-md px-5 py-3 rounded-2xl border border-white/20 shadow-sm">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </span>
                <span class="font-bold text-white tracking-wide text-sm">Available for Work</span>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Available Balance -->
        <div class="group relative overflow-hidden p-6 bg-white dark:bg-gray-800/70 backdrop-blur-xl rounded-[2rem] shadow-sm border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-green-500/10">
            <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3.5 bg-green-100/80 dark:bg-green-500/20 rounded-2xl text-green-600 dark:text-green-400 backdrop-blur-md ring-1 ring-green-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m.599-1.1c-.519.598-1.49 1-2.599 1-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Available Balance</p>
                    <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-1.5">Rp. {{ number_format($walletBalance, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Balance -->
        <div class="group relative overflow-hidden p-6 bg-white dark:bg-gray-800/70 backdrop-blur-xl rounded-[2rem] shadow-sm border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-yellow-500/10">
            <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3.5 bg-yellow-100/80 dark:bg-yellow-500/20 rounded-2xl text-yellow-600 dark:text-yellow-400 backdrop-blur-md ring-1 ring-yellow-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pending Balance</p>
                    <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-1.5">Rp. {{ number_format($pendingBalance, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Campaigns Completed -->
        <div class="group relative overflow-hidden p-6 bg-white dark:bg-gray-800/70 backdrop-blur-xl rounded-[2rem] shadow-sm border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-500/10">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3.5 bg-blue-100/80 dark:bg-blue-500/20 rounded-2xl text-blue-600 dark:text-blue-400 backdrop-blur-md ring-1 ring-blue-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Campaigns Done</p>
                    <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-1.5">{{ $totalCampaignsDone }}</p>
                </div>
            </div>
        </div>

        <!-- Rating Avg -->
        <div class="group relative overflow-hidden p-6 bg-white dark:bg-gray-800/70 backdrop-blur-xl rounded-[2rem] shadow-sm border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-purple-500/10">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3.5 bg-purple-100/80 dark:bg-purple-500/20 rounded-2xl text-purple-600 dark:text-purple-400 backdrop-blur-md ring-1 ring-purple-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.783.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Average Rating</p>
                    <div class="flex items-end mt-1.5 space-x-2">
                        <p class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ number_format($ratingAvg, 1) }}</p>
                        <span class="flex items-center text-yellow-400 mb-1">
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 gap-8 xl:grid-cols-3">
        <!-- Main Content Column (2/3) -->
        <div class="xl:col-span-2 space-y-8">
            
            <!-- Earnings Chart -->
            <section class="bg-white dark:bg-gray-800/70 backdrop-blur-xl rounded-[2rem] shadow-sm border border-gray-200 dark:border-gray-700 p-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Earnings Overview</h3>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-1">Your monthly revenue from completed campaigns</p>
                    </div>
                    <div class="p-1.5 bg-gray-100/80 dark:bg-gray-900/50 backdrop-blur-md rounded-xl flex space-x-1 border border-gray-200 dark:border-gray-700">
                        <button class="px-4 py-2 text-sm font-bold bg-white dark:bg-gray-800 rounded-lg shadow-sm text-gray-900 dark:text-white border border-gray-200 dark:border-gray-700 transition-colors">Monthly</button>
                    </div>
                </div>
                <div id="earningsChart" class="h-80 w-full relative z-10"></div>
            </section>

            <!-- Active Agreements -->
            <section class="bg-white dark:bg-gray-800/70 backdrop-blur-xl rounded-[2rem] shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-gray-50/50 dark:bg-gray-800/30">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Active Agreements</h3>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-1">Campaigns currently in progress</p>
                    </div>
                    <a href="{{ route('kol.agreement.index') }}" class="text-sm font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors bg-indigo-50 dark:bg-indigo-500/10 px-4 py-2 rounded-xl ring-1 ring-indigo-500/20">View All</a>
                </div>
                <div class="p-0">
                    @if ($activeAgreements->isEmpty())
                        <div class="p-12 text-center">
                            <div class="mx-auto w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center text-gray-400 mb-4 shadow-inner">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white">No active agreements</h4>
                            <p class="text-gray-500 dark:text-gray-400 mt-1 font-medium">You don't have any active campaigns right now.</p>
                        </div>
                    @else
                        <div class="divide-y divide-gray-100 dark:divide-gray-700/50">
                            @foreach ($activeAgreements as $hiring)
                                <a href="{{ route('kol.agreement.show', $hiring->agreement->id) }}" class="flex items-center p-6 hover:bg-gray-50/80 dark:hover:bg-gray-700/30 transition-all duration-200 group">
                                    <div class="flex-shrink-0 mr-5">
                                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/40 dark:to-purple-900/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-xl shadow-sm ring-1 ring-indigo-500/20">
                                            {{ substr($hiring->campaign->title, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-3 mb-1">
                                            <span class="text-base font-bold text-gray-900 dark:text-white truncate group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $hiring->campaign->title }}</span>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100/80 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300 capitalize ring-1 ring-blue-500/20">
                                                {{ $hiring->agreement->status }}
                                            </span>
                                        </div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            #{{ $hiring->agreement->agreement_number }} 
                                            <span class="mx-2 text-gray-300 dark:text-gray-600">•</span>
                                            <span class="font-bold text-gray-700 dark:text-gray-300">Rp. {{ number_format($hiring->agreement->total_amount, 0, ',', '.') }}</span>
                                        </p>
                                    </div>
                                    <div class="ml-4 flex-shrink-0 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-300">
                                        <div class="p-2 rounded-full bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700">
                                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        </div>

        <!-- Sidebar Column (1/3) -->
        <div class="space-y-8 xl:col-span-1">
            
            <!-- Profile Completion Widget -->
            <section class="bg-white dark:bg-gray-800/70 backdrop-blur-xl rounded-[2rem] shadow-sm border border-gray-200 dark:border-gray-700 p-6 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity duration-500 group-hover:rotate-12 transform">
                    <svg class="w-32 h-32 text-indigo-600 dark:text-indigo-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white relative z-10">Profile Strength</h3>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-1 mb-6 relative z-10">Complete your profile to stand out to brands.</p>
                
                <div class="relative pt-1 z-10">
                    <div class="flex mb-3 items-center justify-between">
                        <div>
                            <span class="text-xs font-bold inline-block py-1.5 px-3 uppercase tracking-wider rounded-full text-indigo-700 bg-indigo-100/80 dark:text-indigo-300 dark:bg-indigo-900/50 ring-1 ring-indigo-500/20 shadow-sm">
                            Progress
                            </span>
                        </div>
                        <div class="text-right">
                            <span class="text-lg font-extrabold inline-block text-indigo-600 dark:text-indigo-400">
                            {{ $profileCompletion }}%
                            </span>
                        </div>
                    </div>
                    <div class="overflow-hidden h-3.5 mb-5 text-xs flex rounded-full bg-gray-100 dark:bg-gray-700/50 border border-gray-200/50 dark:border-gray-600/50 shadow-inner">
                        <div style="width: {{ $profileCompletion }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-1000 ease-out relative">
                            <div class="absolute top-0 left-0 right-0 bottom-0 bg-white/20 animate-pulse"></div>
                        </div>
                    </div>
                </div>
                
                @if($profileCompletion < 100 && auth()->user()->kolProfile)
                <div class="mt-4 z-10 relative">
                    <a href="{{ route('kol.profile.edit', auth()->user()->kolProfile) }}" class="block w-full py-3 px-4 bg-indigo-50/80 dark:bg-indigo-500/10 hover:bg-indigo-100 dark:hover:bg-indigo-500/20 text-indigo-700 dark:text-indigo-400 text-sm font-bold text-center rounded-xl transition-all duration-200 border border-indigo-200/50 dark:border-indigo-500/20 shadow-sm hover:shadow">
                        Complete Profile
                    </a>
                </div>
                @endif
            </section>

            <!-- Recent Invitations -->
            <section class="bg-white dark:bg-gray-800/70 backdrop-blur-xl rounded-[2rem] shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-gray-50/50 dark:bg-gray-800/30">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Invitations</h3>
                    <a href="{{ route('kol.hiring.index') }}" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 hover:underline transition-colors">View All</a>
                </div>
                <div class="p-0">
                    @if ($recentHirings->isEmpty())
                        <div class="p-8 text-center">
                            <div class="mx-auto w-12 h-12 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center text-gray-400 mb-3 shadow-inner">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">No new invitations.</p>
                        </div>
                    @else
                        <div class="divide-y divide-gray-100 dark:divide-gray-700/50">
                            @foreach ($recentHirings as $hiring)
                                <div class="p-5 hover:bg-gray-50/80 dark:hover:bg-gray-700/30 transition-colors cursor-pointer group">
                                    <div class="flex items-start justify-between">
                                        <div class="pr-3">
                                            <p class="text-sm font-bold text-gray-900 dark:text-white line-clamp-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $hiring->campaign?->title ?? 'Campaign Invitation' }}</p>
                                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mt-1.5 flex items-center">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ $hiring->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <span class="px-2.5 py-1 text-[10px] font-bold rounded-lg
                                            @if($hiring->status->value === 'accepted') bg-green-100/80 text-green-700 dark:bg-green-500/20 dark:text-green-400 border border-green-200 dark:border-green-500/30
                                            @elseif($hiring->status->value === 'pending') bg-yellow-100/80 text-yellow-700 dark:bg-yellow-500/20 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-500/30
                                            @elseif($hiring->status->value === 'negotiating') bg-blue-100/80 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400 border border-blue-200 dark:border-blue-500/30
                                            @else bg-gray-100/80 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 border border-gray-200 dark:border-gray-600
                                            @endif uppercase tracking-wider shrink-0 shadow-sm">
                                            {{ $hiring->status->value }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            <!-- Notifications -->
            <section class="bg-white dark:bg-gray-800/70 backdrop-blur-xl rounded-[2rem] shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-gray-50/50 dark:bg-gray-800/30">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Notifications</h3>
                    @if ($recentNotifications->isNotEmpty())
                    <a href="#" class="text-xs font-bold text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Mark read</a>
                    @endif
                </div>
                <div class="p-0">
                    @if ($recentNotifications->isEmpty())
                        <div class="p-8 text-center">
                            <div class="mx-auto w-12 h-12 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center text-gray-400 mb-3 shadow-inner">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">You're all caught up!</p>
                        </div>
                    @else
                        <div class="divide-y divide-gray-100 dark:divide-gray-700/50">
                            @foreach ($recentNotifications as $notification)
                                <div class="p-5 {{ !$notification->is_read ? 'bg-indigo-50/50 dark:bg-indigo-900/10' : 'hover:bg-gray-50/50 dark:hover:bg-gray-700/20' }} transition-colors relative group">
                                    @if(!$notification->is_read)
                                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-indigo-500 rounded-r-md"></div>
                                    @endif
                                    <p class="text-sm font-bold text-gray-900 dark:text-white pr-4 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $notification->title }}</p>
                                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400 mt-1.5 line-clamp-2 leading-relaxed">{{ $notification->body }}</p>
                                    <p class="text-[10px] font-bold text-gray-400 mt-2.5 uppercase tracking-wider">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('livewire:init', function () {
        var isDark = document.documentElement.classList.contains('dark');
        var earnings = @json($earnings);
        var months = Object.keys(earnings);
        var values = Object.values(earnings);

        var options = {
            chart: {
                type: 'area',
                height: 320,
                fontFamily: 'Inter, sans-serif',
                toolbar: { show: false },
                foreColor: isDark ? '#9ca3af' : '#64748b',
                sparkline: { enabled: false },
                background: 'transparent',
                parentHeightOffset: 0,
            },
            stroke: { 
                curve: 'smooth', 
                width: 3,
                colors: ['#8b5cf6'] 
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.05,
                    stops: [0, 90, 100],
                    colorStops: [
                        { offset: 0, color: '#8b5cf6', opacity: 0.4 },
                        { offset: 100, color: '#6366f1', opacity: 0.05 }
                    ]
                }
            },
            series: [{ name: 'Earnings', data: values }],
            xaxis: {
                categories: months.length ? months : ['No Data'],
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: { colors: isDark ? '#9ca3af' : '#64748b', fontWeight: 600 }
                }
            },
            yaxis: {
                labels: {
                    formatter: function (v) { return 'Rp. ' + (v/1000).toLocaleString() + 'k'; },
                    style: { colors: isDark ? '#9ca3af' : '#64748b', fontWeight: 600 }
                }
            },
            grid: {
                borderColor: isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)',
                strokeDashArray: 5,
                xaxis: { lines: { show: true } },
                yaxis: { lines: { show: true } },
                padding: { top: 0, right: 0, bottom: 0, left: 10 }
            },
            colors: ['#8b5cf6'],
            dataLabels: { enabled: false },
            theme: { mode: isDark ? 'dark' : 'light' },
            tooltip: {
                y: { formatter: function (v) { return 'Rp. ' + v.toLocaleString(); } },
                theme: isDark ? 'dark' : 'light',
                style: { fontSize: '14px', fontFamily: 'Inter, sans-serif' },
                marker: { show: false }
            },
            markers: {
                size: 5,
                colors: ['#ffffff'],
                strokeColors: '#8b5cf6',
                strokeWidth: 3,
                hover: { size: 7 }
            }
        };
        var chart = new ApexCharts(document.querySelector("#earningsChart"), options);
        chart.render();

        window.addEventListener('darkModeChanged', function() {
            var newIsDark = document.documentElement.classList.contains('dark');
            chart.updateOptions({
                theme: { mode: newIsDark ? 'dark' : 'light' },
                grid: { borderColor: newIsDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)' },
                foreColor: newIsDark ? '#9ca3af' : '#64748b',
                xaxis: { labels: { style: { colors: newIsDark ? '#9ca3af' : '#64748b' } } },
                yaxis: { labels: { style: { colors: newIsDark ? '#9ca3af' : '#64748b' } } }
            });
        });
    });
</script>
@endpush
