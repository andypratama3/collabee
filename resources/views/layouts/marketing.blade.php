<!DOCTYPE html>
<html lang="id" x-data="{
    mobileMenuOpen: false,
    scrolled: false,
    darkMode: document.documentElement.classList.contains('dark'),
    toggleDarkMode() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode ? 'true' : 'false');
        document.documentElement.classList.toggle('dark', this.darkMode);
        window.dispatchEvent(new CustomEvent('darkModeChanged', { detail: { isDark: this.darkMode } }));
    }
}" x-init="
    darkMode = document.documentElement.classList.contains('dark');
    window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 });
    document.addEventListener('livewire:navigated', () => { $nextTick(() => { darkMode = document.documentElement.classList.contains('dark') }) });
">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name') . ' — Platform Kolaborasi Brand & KOL Premium')</title>
    <script>
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
            document.addEventListener('livewire:navigating',enforce);
            document.addEventListener('livewire:navigated',enforce);
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
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <meta name="description" content="@yield('description', 'Collabee adalah platform peer-to-peer yang menghubungkan brand secara langsung dengan KOL untuk kampanye pemasaran yang efektif, transparan, dan terpercaya.')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-[#09090b] transition-colors duration-500 selection:bg-primary-500/30 selection:text-primary-900 dark:selection:text-primary-100">
    
    <!-- Floating Navbar -->
    <header :class="{ 'py-4': !scrolled, 'py-2 bg-white/80 dark:bg-[#09090b]/80 shadow-2xl shadow-gray-200/20 dark:shadow-black/50 backdrop-blur-xl border-b border-gray-200/50 dark:border-white/5': scrolled }"
            class="fixed top-0 left-0 right-0 z-[100] transition-all duration-500 ease-in-out border-b border-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between transition-all duration-500" :class="{ 'h-14': scrolled, 'h-16': !scrolled }">
                
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-primary-500/30 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                        <span class="text-white font-black text-xl">C</span>
                    </div>
                    <span class="text-2xl font-black tracking-tighter text-gray-900 dark:text-white drop-shadow-sm">{{ config('app.name') }}</span>
                </a>

                <!-- Desktop Nav -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="{{ route('campaigns.explore') }}" class="text-sm font-bold text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Jelajahi Campaign</a>
                    <a href="{{ route('about') }}" class="text-sm font-bold text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Tentang Kami</a>
                    
                    <div class="w-px h-6 bg-gray-200 dark:bg-gray-800"></div>

                    <!-- Theme Toggle -->
                    <button @click="toggleDarkMode()" class="p-2 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-500 hover:text-primary-600 dark:hover:text-primary-400 hover:scale-110 transition-all duration-300">
                        <svg x-show="!darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <svg x-show="darkMode" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" style="display: none;"><path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </button>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="group relative inline-flex items-center justify-center px-6 py-2.5 text-sm font-black text-white bg-gray-900 dark:bg-white dark:text-gray-900 rounded-xl hover:scale-105 transition-all duration-300 shadow-xl shadow-gray-900/20 dark:shadow-white/10 overflow-hidden">
                            <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 dark:via-gray-900/10 to-transparent -translate-x-full group-hover:animate-shimmer"></span>
                            <span class="relative">Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Masuk</a>
                        <a href="{{ route('register.brand') }}" class="group relative inline-flex items-center justify-center px-6 py-2.5 text-sm font-black text-white bg-gradient-to-r from-primary-600 to-indigo-600 rounded-xl hover:scale-105 transition-all duration-300 shadow-xl shadow-primary-500/30 overflow-hidden border border-primary-500/50">
                            <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-shimmer"></span>
                            <span class="relative">Daftar Sekarang</span>
                        </a>
                    @endauth
                </nav>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center gap-3">
                    <button @click="toggleDarkMode()" class="p-2 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-500">
                        <svg x-show="!darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <svg x-show="darkMode" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" style="display: none;"><path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </button>
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:text-primary transition-colors">
                        <svg x-show="!mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-10"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-10"
             class="md:hidden absolute top-[calc(100%+0.5rem)] left-4 right-4 bg-white/95 dark:bg-gray-900/95 backdrop-blur-3xl border border-gray-200 dark:border-gray-800 shadow-2xl rounded-[2rem] overflow-hidden"
             style="display: none;">
            <div class="p-6 space-y-3">
                <a href="{{ route('campaigns.explore') }}" class="block px-4 py-3 text-lg font-bold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition-colors">Jelajahi Campaign</a>
                <a href="{{ route('about') }}" class="block px-4 py-3 text-lg font-bold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition-colors">Tentang Kami</a>
                <hr class="my-4 border-gray-100 dark:border-gray-800">
                @auth
                    <a href="{{ route('dashboard') }}" class="block w-full text-center px-4 py-4 text-lg font-black text-white bg-gray-900 dark:bg-white dark:text-gray-900 rounded-2xl shadow-xl shadow-gray-900/20">Ke Dashboard</a>
                @else
                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <a href="{{ route('login') }}" class="flex items-center justify-center px-4 py-4 text-lg font-bold text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800 rounded-2xl border border-transparent hover:border-gray-300 dark:hover:border-gray-700">Masuk</a>
                        <a href="{{ route('register.brand') }}" class="flex items-center justify-center px-4 py-4 text-lg font-black text-white bg-gradient-to-r from-primary-600 to-indigo-600 rounded-2xl shadow-lg shadow-primary-500/30">Daftar</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <main class="relative z-10">
        @yield('content')
    </main>

    <footer class="bg-white dark:bg-[#09090b] border-t border-gray-200/60 dark:border-white/5 relative overflow-hidden">
        <!-- Abstract Footer Decor -->
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-primary-500/5 dark:bg-primary-900/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 py-20 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-16">
                
                <!-- Brand Column -->
                <div class="md:col-span-5 space-y-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-primary-500/30">
                            <span class="text-white font-black text-xl">C</span>
                        </div>
                        <span class="text-2xl font-black tracking-tight text-gray-900 dark:text-white">{{ config('app.name') }}</span>
                    </a>
                    <p class="text-gray-500 dark:text-gray-400 max-w-sm text-lg leading-relaxed">
                        Platform peer-to-peer revolusioner yang mendemokrasikan kolaborasi antara Brand dan Kreator Konten di seluruh Indonesia.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-800 flex items-center justify-center text-gray-400 hover:text-primary-600 hover:border-primary-500 hover:shadow-lg hover:shadow-primary-500/20 transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-800 flex items-center justify-center text-gray-400 hover:text-indigo-600 hover:border-indigo-500 hover:shadow-lg hover:shadow-indigo-500/20 transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.332 3.608 1.308.975.975 1.245 2.242 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.332 2.633-1.308 3.608-.975-.975-2.242 1.245-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.332-3.608-1.308-.975-.975-1.245-2.242-1.308-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.062-1.366.332-2.633 1.308-3.608.975-.975 2.242-1.245 3.608-1.308 1.266-.058 1.646-.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948s.014 3.667.072 4.947c.2 4.337 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072s3.667-.014 4.947-.072c4.337-.2 6.78-2.618 6.98-6.98.058-1.281.072-1.689.072-4.948s-.014-3.667-.072-4.947c-.2-4.338-2.617-6.78-6.98-6.98-1.28-.058-1.689-.072-4.948-.072zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Links Columns -->
                <div class="md:col-span-3 md:col-start-7">
                    <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest mb-6">Produk</h3>
                    <ul class="space-y-4">
                        <li><a href="{{ route('campaigns.explore') }}" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 font-medium transition-colors">Jelajahi Campaign</a></li>
                        <li><a href="{{ route('register.kol') }}" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 font-medium transition-colors">Untuk KOL</a></li>
                        <li><a href="{{ route('register.brand') }}" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 font-medium transition-colors">Untuk Brand</a></li>
                        <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 font-medium transition-colors">Cara Kerja</a></li>
                    </ul>
                </div>

                <div class="md:col-span-3">
                    <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest mb-6">Perusahaan</h3>
                    <ul class="space-y-4">
                        <li><a href="{{ route('about') }}" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 font-medium transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 font-medium transition-colors">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 font-medium transition-colors">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 font-medium transition-colors">Pusat Bantuan</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-20 pt-8 border-t border-gray-200/60 dark:border-white/5 flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-sm text-gray-400 dark:text-gray-500 font-medium">
                    &copy; {{ date('Y') }} {{ config('app.name') }} Inc. Hak cipta dilindungi undang-undang.
                </p>
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-2 text-sm text-gray-400 dark:text-gray-500 font-medium bg-gray-50 dark:bg-gray-800 px-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-700">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Semua Sistem Berjalan Normal
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
    @stack('scripts')
</body>
</html>
