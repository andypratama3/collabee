<!DOCTYPE html>
<html lang="id" x-data="{
    sidebarOpen: false,
    darkMode: document.documentElement.classList.contains('dark'),
    toggleDarkMode() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode ? 'true' : 'false');
        document.documentElement.classList.toggle('dark', this.darkMode);
        window.dispatchEvent(new CustomEvent('darkModeChanged', { detail: { isDark: this.darkMode } }));
    }
}" x-init="
    darkMode = document.documentElement.classList.contains('dark');
    document.addEventListener('livewire:navigated', () => { $nextTick(() => { darkMode = document.documentElement.classList.contains('dark') }) });
">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) — Collabee Dashboard</title>
    <script>
        // Dark mode: bulletproof persistence across wire:navigate
        (function(){
            function isDark(){
                var d=localStorage.getItem('darkMode');
                return d==='true'||(d===null&&window.matchMedia('(prefers-color-scheme:dark)').matches);
            }
            function enforce(){
                if(isDark()){document.documentElement.classList.add('dark')}
                else{document.documentElement.classList.remove('dark')}
            }
            enforce();
            // Re-enforce after Livewire swaps the page
            document.addEventListener('livewire:navigating',enforce);
            document.addEventListener('livewire:navigated',enforce);
            // MutationObserver: catch any external removal of 'dark' class (Livewire morph)
            new MutationObserver(function(mutations){
                mutations.forEach(function(m){
                    if(m.attributeName==='class'){
                        var hasDark=document.documentElement.classList.contains('dark');
                        if(isDark()&&!hasDark){document.documentElement.classList.add('dark')}
                        else if(!isDark()&&hasDark){document.documentElement.classList.remove('dark')}
                    }
                });
            }).observe(document.documentElement,{attributes:true,attributeFilter:['class']});
        })();
    </script>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50 dark:text-gray-100 dark:bg-[#09090b] transition-colors duration-300">
    
    <!-- Impersonation Banner -->
    @if(isset($isImpersonating) && $isImpersonating)
        <div class="fixed top-0 left-0 right-0 z-[60] flex items-center justify-center gap-4 px-4 py-3 text-sm text-white bg-gradient-to-r from-amber-500 to-amber-600 shadow-xl shadow-amber-500/20 animate-slide-down backdrop-blur-md">
            <span class="font-medium flex items-center gap-2">
                <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                Logged in as <strong>{{ auth()->user()->name }}</strong> (Impersonated by {{ $impersonatedBy?->name ?? 'Admin' }})
            </span>
            <form method="POST" action="{{ route('admin.users.stop-impersonate') }}" class="inline">
                @csrf
                <button type="submit" class="px-4 py-1.5 text-xs font-black text-amber-900 bg-white rounded-xl hover:bg-amber-50 hover:scale-105 transition-all shadow-sm">Stop Impersonating</button>
            </form>
        </div>
    @endif

    <div class="flex h-screen overflow-hidden {{ (isset($isImpersonating) && $isImpersonating) ? 'pt-12' : '' }}">
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false" 
             class="fixed inset-0 z-40 bg-gray-900/40 dark:bg-black/60 backdrop-blur-sm lg:hidden"></div>

        <!-- Sidebar -->
        <aside x-ref="sidebar"
               class="fixed inset-y-0 left-0 z-50 w-[280px] bg-white dark:bg-gray-900/80 backdrop-blur-2xl border-r border-gray-200 dark:border-white/5 shadow-2xl lg:shadow-xl lg:static lg:!translate-x-0 transition-transform duration-300 flex flex-col"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between h-20 px-8 border-b border-gray-100 dark:border-white/5 shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-primary-500/30 group-hover:scale-110 transition-transform">
                        <span class="text-white font-black text-lg">C</span>
                    </div>
                    <span class="text-xl font-black tracking-tight text-gray-900 dark:text-white">{{ config('app.name') }}</span>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden p-2 -mr-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-8 overflow-y-auto scrollbar-none">
                
                <!-- Shared -->
                <div class="space-y-1">
                    <p class="px-4 text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3">General</p>
                    <x-nav-link href="{{ route('campaigns.explore') }}" :active="request()->routeIs('campaigns.explore')" icon="search">Explore Campaigns</x-nav-link>
                </div>

                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="space-y-1">
                            <p class="px-4 text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3">Admin Center</p>
                            <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')" icon="dashboard">Dashboard</x-nav-link>
                            <x-nav-link href="{{ route('admin.users') }}" :active="request()->routeIs('admin.users')" icon="users">Users Management</x-nav-link>
                            <x-nav-link href="{{ route('admin.campaigns') }}" :active="request()->routeIs('admin.campaigns')" icon="campaign">All Campaigns</x-nav-link>
                            <x-nav-link href="{{ route('admin.payments') }}" :active="request()->routeIs('admin.payments')" icon="payment">Payments Hub</x-nav-link>
                            <x-nav-link href="{{ route('admin.withdrawals') }}" :active="request()->routeIs('admin.withdrawals')" icon="withdrawal">Withdrawals</x-nav-link>
                            <x-nav-link href="{{ route('admin.disputes') }}" :active="request()->routeIs('admin.disputes')" icon="dispute">Disputes Resolution</x-nav-link>
                            <x-nav-link href="{{ route('admin.activity-log') }}" :active="request()->routeIs('admin.activity-log')" icon="log">System Logs</x-nav-link>
                            <x-nav-link href="{{ route('admin.settings') }}" :active="request()->routeIs('admin.settings')" icon="settings">Platform Settings</x-nav-link>
                        </div>
                    @endif

                    @if(auth()->user()->isBrand())
                        <div class="space-y-1">
                            <p class="px-4 text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3">Brand Center</p>
                            <x-nav-link href="{{ route('brand.dashboard') }}" :active="request()->routeIs('brand.dashboard')" icon="dashboard">Overview</x-nav-link>
                            @if(auth()->user()->brandProfile)
                                <x-nav-link href="{{ route('brand.campaign.index') }}" :active="request()->routeIs('brand.campaign.*')" icon="campaign">My Campaigns</x-nav-link>
                                <x-nav-link href="{{ route('brand.browse-kol') }}" :active="request()->routeIs('brand.browse-kol')" icon="users">Find KOLs</x-nav-link>
                                <x-nav-link href="{{ route('brand.hiring.index') }}" :active="request()->routeIs('brand.hiring.*')" icon="hiring">Hiring Pipeline</x-nav-link>
                                <x-nav-link href="{{ route('brand.chat.index') }}" :active="request()->routeIs('brand.chat.*')" icon="chat">Messages</x-nav-link>
                                <x-nav-link href="{{ route('brand.agreement.index') }}" :active="request()->routeIs('brand.agreement.*')" icon="agreement">Contracts & Escrow</x-nav-link>
                                <x-nav-link href="{{ route('brand.payment.index') }}" :active="request()->routeIs('brand.payment.*')" icon="payment">Billing History</x-nav-link>
                                <x-nav-link href="{{ route('brand.profile.edit', auth()->user()->brandProfile) }}" :active="request()->routeIs('brand.profile.*')" icon="profile">Brand Profile</x-nav-link>
                            @endif
                        </div>
                    @endif

                    @if(auth()->user()->isKol())
                        <div class="space-y-1">
                            <p class="px-4 text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-3">KOL Center</p>
                            <x-nav-link href="{{ route('kol.dashboard') }}" :active="request()->routeIs('kol.dashboard')" icon="dashboard">Performance</x-nav-link>
                            <x-nav-link href="{{ route('kol.hiring.index') }}" :active="request()->routeIs('kol.hiring.*')" icon="hiring">Job Offers</x-nav-link>
                            <x-nav-link href="{{ route('kol.chat.index') }}" :active="request()->routeIs('kol.chat.*')" icon="chat">Messages</x-nav-link>
                            <x-nav-link href="{{ route('kol.agreement.index') }}" :active="request()->routeIs('kol.agreement.*')" icon="agreement">Active Contracts</x-nav-link>
                            <x-nav-link href="{{ route('kol.withdrawal.index') }}" :active="request()->routeIs('kol.withdrawal.*')" icon="withdrawal">Earnings & Payouts</x-nav-link>
                            @if(auth()->user()->kolProfile)
                                <x-nav-link href="{{ route('kol.content.index') }}" :active="request()->routeIs('kol.content.*')" icon="campaign">Content Drafts</x-nav-link>
                                <x-nav-link href="{{ route('kol.profile.edit', auth()->user()->kolProfile) }}" :active="request()->routeIs('kol.profile.*')" icon="profile">My Portfolio</x-nav-link>
                            @endif
                        </div>
                    @endif
                @endauth
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-6 shrink-0 mt-auto border-t border-gray-100 dark:border-white/5">
                <div class="bg-gradient-to-br from-primary-50 to-indigo-50 dark:from-primary-900/20 dark:to-indigo-900/20 rounded-[1.5rem] p-5 border border-primary-100/50 dark:border-primary-800/30">
                    <p class="text-[10px] font-black text-primary-600 dark:text-primary-400 uppercase tracking-widest mb-1.5">Butuh Bantuan?</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4 font-medium">Tim Collabee siap membantu 24/7.</p>
                    <a href="mailto:support@collabee.app" class="block text-center py-2.5 bg-white dark:bg-gray-800 text-primary-600 dark:text-primary-400 text-xs font-black rounded-xl hover:bg-primary-600 hover:text-white dark:hover:bg-primary-500 transition-all shadow-sm border border-gray-100 dark:border-gray-700">Hubungi Support</a>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex flex-col flex-1 min-w-0 overflow-hidden relative">
            
            <!-- App Background Gradients -->
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary-400/5 dark:bg-primary-500/10 rounded-full blur-[120px] pointer-events-none -z-10 translate-x-1/3 -translate-y-1/3"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-indigo-400/5 dark:bg-indigo-500/10 rounded-full blur-[120px] pointer-events-none -z-10 -translate-x-1/3 translate-y-1/3"></div>

            <!-- Top Header -->
            <header class="h-20 flex items-center justify-between px-6 lg:px-10 bg-white/90 dark:bg-[#09090b]/60 backdrop-blur-xl border-b border-gray-200/80 dark:border-white/5 shrink-0 z-30 sticky top-0">
                
                <!-- Left side -->
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-500 hover:text-primary transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h2 class="text-xl font-black text-gray-900 dark:text-white tracking-tight drop-shadow-sm">
                        @yield('page_title', 'Dashboard')
                    </h2>
                </div>

                <!-- Right side -->
                <div class="flex items-center gap-3 sm:gap-5">
                    
                    <!-- Dark Mode Toggle -->
                    <button @click="toggleDarkMode()" 
                            class="p-2.5 rounded-xl bg-white dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700/80 text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 hover:border-primary-200 dark:hover:border-primary-800 transition-all duration-300 shadow-sm"
                            title="Toggle Dark Mode">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" style="display: none;"><path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </button>

                    @auth
                        <!-- Notification Bell -->
                        <livewire:shared.notification.bell :key="'notif-bell-' . auth()->id()" />

                        <div class="h-8 w-px bg-gray-200 dark:bg-gray-800 mx-1 hidden sm:block"></div>

                        <!-- Profile Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 p-1.5 rounded-2xl bg-white dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700/80 hover:border-primary-300 dark:hover:border-primary-700 transition-all duration-300 shadow-sm group">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center text-white font-black shadow-md shadow-primary-500/20 group-hover:scale-105 transition-transform">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div class="hidden sm:block text-left mr-3">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white leading-none mb-1">{{ auth()->user()->name }}</p>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 font-bold uppercase tracking-widest leading-none">{{ auth()->user()->user_type->label() }}</p>
                                </div>
                                <svg class="hidden sm:block w-4 h-4 text-gray-400 mr-2 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                 class="absolute right-0 mt-3 w-64 bg-white/90 dark:bg-gray-900/90 backdrop-blur-xl rounded-[1.5rem] shadow-2xl shadow-black/10 dark:shadow-black/40 border border-gray-100 dark:border-white/10 overflow-hidden z-50"
                                 style="display: none;">
                                
                                <div class="p-5 bg-gray-50/50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-white/5">
                                    <p class="text-[10px] text-gray-400 dark:text-gray-500 font-black uppercase tracking-widest mb-1.5">Akun Aktif</p>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ auth()->user()->email }}</p>
                                </div>

                                <div class="p-2 space-y-1">
                                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-bold text-gray-600 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-500/10 hover:text-primary-600 dark:hover:text-primary-400 rounded-xl transition-all">
                                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        Beranda Publik
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center gap-3 px-4 py-2.5 text-sm font-bold text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-xl transition-all">
                                            <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            Keluar Sesi
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto overflow-x-hidden scrollbar-thin relative z-10">
                <div class="p-6 sm:p-8 lg:p-10 max-w-7xl mx-auto min-h-full">
                    @if (session('success'))
                        <script>document.addEventListener('DOMContentLoaded', () => window.Swal && window.Swal.mixin({toast:true,position:'top-end',showConfirmButton:false,timer:3000,timerProgressBar:true}).fire({icon:'success',title:@json(session('success'))}));</script>
                    @endif

                    @if (session('error'))
                        <script>document.addEventListener('DOMContentLoaded', () => window.Swal && window.Swal.mixin({toast:true,position:'top-end',showConfirmButton:false,timer:4000,timerProgressBar:true}).fire({icon:'error',title:@json(session('error'))}));</script>
                    @endif

                    <!-- Content Transition Wrapper -->
                    <div class="animate-fade-in-up">
                        @yield('content')
                        {{ $slot ?? '' }}
                    </div>
                </div>
            </main>
        </div>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>
