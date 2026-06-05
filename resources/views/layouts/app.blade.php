<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-100 dark:text-gray-100 dark:bg-gray-950"
      data-flash-success="{{ session('success') }}"
      data-flash-error="{{ session('error') }}"
      data-flash-warning="{{ session('warning') }}">
    @if(isset($isImpersonating) && $isImpersonating)
        <div class="fixed top-0 left-0 right-0 z-50 flex items-center justify-center gap-4 px-4 py-2 text-sm text-white bg-orange-600">
            <span>Anda sedang login sebagai <strong>{{ auth()->user()->name }}</strong> — diimpersonasi oleh {{ $impersonatedBy?->name ?? 'Admin' }}</span>
            <form method="POST" action="{{ route('admin.users.stop-impersonate') }}" class="inline">
                @csrf
                <button type="submit" class="px-3 py-1 text-xs font-medium text-orange-800 bg-orange-200 rounded-lg hover:bg-orange-300">Stop Impersonating</button>
            </form>
        </div>
    @endif
    <div x-data="{ sidebarOpen: false }" class="{{ isset($isImpersonating) && $isImpersonating ? 'pt-10' : '' }} flex h-screen overflow-hidden">
        <div x-show="sidebarOpen" @@click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black/50 lg:hidden"></div>

        <aside x-show="sidebarOpen" x-cloak
               class="fixed inset-y-0 left-0 z-30 w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 shadow-lg lg:static lg:block lg:shadow-none"
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in duration-200"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full">
            <div class="flex items-center h-16 px-6 border-b border-gray-200 dark:border-gray-800">
                <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600 dark:text-indigo-400">{{ config('app.name') }}</a>
            </div>
            <nav class="p-4 space-y-1 overflow-y-auto max-h-[calc(100vh-4rem)]">
                <a href="{{ route('campaigns.explore') }}" wire:navigate
                   class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Explore Campaigns
                </a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="pt-3 pb-1">
                            <p class="px-4 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Admin</p>
                        </div>
                        <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">Dashboard</a>
                        <a href="{{ route('admin.users') }}" wire:navigate class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">Users</a>
                        <a href="{{ route('admin.campaigns') }}" wire:navigate class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">Campaigns</a>
                        <a href="{{ route('admin.payments') }}" wire:navigate class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">Payments</a>
                        <a href="{{ route('admin.withdrawals') }}" wire:navigate class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">Withdrawals</a>
                        <a href="{{ route('admin.disputes') }}" wire:navigate class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">Disputes</a>
                        <a href="{{ route('admin.activity-log') }}" wire:navigate class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">Activity Log</a>
                        <a href="{{ route('admin.settings') }}" wire:navigate class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">Settings</a>
                    @endif
                    @if(auth()->user()->isBrand())
                        <div class="pt-3 pb-1">
                            <p class="px-4 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Brand</p>
                        </div>
                        <a href="{{ route('brand.dashboard') }}" wire:navigate class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Dashboard
                        </a>
                        @if(auth()->user()->brandProfile)
                            <a href="{{ route('brand.campaign.index') }}" wire:navigate class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                My Campaigns
                            </a>
                            <a href="{{ route('brand.campaign.create') }}" wire:navigate class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Create Campaign
                            </a>
                            <a href="{{ route('brand.browse-kol') }}" wire:navigate class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Browse KOL
                            </a>
                            <a href="{{ route('brand.hiring.index') }}" wire:navigate class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                Hirings
                            </a>
                            <a href="{{ route('brand.chat.index') }}" wire:navigate class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                Messages
                            </a>
                            <a href="{{ route('brand.profile.edit', auth()->user()->brandProfile) }}" wire:navigate class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Brand Profile
                            </a>
                        @endif
                    @endif
                    @if(auth()->user()->isKol())
                        <div class="pt-3 pb-1">
                            <p class="px-4 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">KOL</p>
                        </div>
                        <a href="{{ route('kol.dashboard') }}" wire:navigate class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Dashboard
                        </a>
                        <a href="{{ route('kol.hiring.index') }}" wire:navigate class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Hiring Invitations
                        </a>
                        <a href="{{ route('kol.chat.index') }}" wire:navigate class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            Messages
                        </a>
                        @if(auth()->user()->kolProfile)
                            <a href="{{ route('kol.profile.edit', auth()->user()->kolProfile) }}" wire:navigate class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                KOL Profile
                            </a>
                        @endif
                    @endif
                @endauth
            </nav>
        </aside>

        <div class="flex flex-col flex-1 w-0 overflow-hidden">
            <header class="flex items-center justify-between h-16 px-4 sm:px-6 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 shrink-0">
                <div class="flex items-center gap-3">
                    <button @@click="sidebarOpen = !sidebarOpen" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 lg:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400 lg:hidden">{{ config('app.name') }}</span>
                </div>

                <div class="flex items-center gap-3 ml-auto">
                    <button onclick="toggleDarkMode()"
                            class="p-2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg"
                            title="Toggle dark mode">
                        <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg class="w-5 h-5 hidden dark:block" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>

                    @auth
                        <livewire:shared.notification.bell :key="'notification-bell-' . auth()->id()" />
                        <div class="hidden sm:flex items-center gap-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ auth()->user()->name }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">Login</a>
                        <a href="{{ route('register.brand') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">Register</a>
                    @endauth
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 sm:p-6">
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
