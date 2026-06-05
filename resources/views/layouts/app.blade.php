<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
        <div x-show="sidebarOpen" @@click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black/50 lg:hidden"></div>

        <aside x-show="sidebarOpen" x-cloak
               class="fixed inset-y-0 left-0 z-30 w-64 bg-white border-r shadow-lg lg:static lg:block lg:shadow-none"
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in duration-200"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full">
            <div class="flex items-center h-16 px-6 border-b">
                <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">{{ config('app.name') }}</a>
            </div>
            <nav class="p-4 space-y-1">
                <a href="{{ route('campaigns.explore') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100">
                    Explore Campaigns
                </a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="pt-3 pb-1">
                            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Admin</p>
                        </div>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100">Dashboard</a>
                        <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100">Users</a>
                        <a href="{{ route('admin.campaigns') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100">Campaigns</a>
                        <a href="{{ route('admin.payments') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100">Payments</a>
                        <a href="{{ route('admin.withdrawals') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100">Withdrawals</a>
                        <a href="{{ route('admin.disputes') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100">Disputes</a>
                        <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100">Settings</a>
                    @endif
                    @if(auth()->user()->isBrand())
                        <div class="pt-3 pb-1">
                            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Brand</p>
                        </div>
                        <a href="{{ route('brand.dashboard') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100">Dashboard</a>
                        @if(auth()->user()->brandProfile)
                            <a href="{{ route('brand.campaign.index') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100">My Campaigns</a>
                            <a href="{{ route('brand.campaign.create') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100">Create Campaign</a>
                            <a href="{{ route('brand.browse-kol') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100">Browse KOL</a>
                            <a href="{{ route('brand.hiring.index') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100">Hirings</a>
                            <a href="{{ route('brand.chat.index') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100">Messages</a>
                            <a href="{{ route('brand.profile.edit', auth()->user()->brandProfile) }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100">Brand Profile</a>
                        @endif
                    @endif
                    @if(auth()->user()->isKol())
                        <div class="pt-3 pb-1">
                            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">KOL</p>
                        </div>
                        <a href="{{ route('kol.dashboard') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100">Dashboard</a>
                        <a href="{{ route('kol.hiring.index') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100">Hiring Invitations</a>
                            <a href="{{ route('kol.chat.index') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100">Messages</a>
                        @if(auth()->user()->kolProfile)
                            <a href="{{ route('kol.profile.edit', auth()->user()->kolProfile) }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-gray-100">KOL Profile</a>
                        @endif
                    @endif
                @endauth
            </nav>
        </aside>

        <div class="flex flex-col flex-1 w-0 overflow-hidden">
            <header class="flex items-center justify-between h-16 px-6 bg-white border-b">
                <button @@click="sidebarOpen = !sidebarOpen" class="text-gray-500 lg:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div class="flex items-center gap-4 ml-auto">
                    @auth
                        <livewire:shared.notification.bell :key="'notification-bell-' . auth()->id()" />
                        <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-700">Login</a>
                        <a href="{{ route('register.brand') }}" class="text-sm text-indigo-600 hover:text-indigo-800">Register</a>
                    @endauth
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                @if (session('success'))
                    <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg">{{ session('error') }}</div>
                @endif
                @if (session('warning'))
                    <div class="mb-4 p-4 text-sm text-yellow-700 bg-yellow-100 rounded-lg">{{ session('warning') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
