<!DOCTYPE html>
<html lang="id" x-data="{
    darkMode: document.documentElement.classList.contains('dark')
}" x-init="darkMode = document.documentElement.classList.contains('dark')">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
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
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html.dark { color-scheme: dark; }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-white dark:bg-gray-950 dark:text-gray-100 selection:bg-primary selection:text-white flex min-h-screen">

    <!-- Left Side: Gorgeous Image & Gradient -->
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gray-900 items-center justify-center">
        <!-- Abstract background image with a tech/modern vibe -->
        <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=2564&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-overlay" alt="Abstract modern background">
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/90 via-purple-900/90 to-primary-900/90 dark:from-indigo-950/95 dark:via-purple-950/95 dark:to-primary-950/95 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent"></div>

        <!-- Glowing Orbs for extra premium feel -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary-500 rounded-full mix-blend-screen filter blur-[100px] opacity-40 animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-pink-500 rounded-full mix-blend-screen filter blur-[100px] opacity-30"></div>

        <!-- Content overlay -->
        <div class="relative z-10 w-full max-w-lg px-8 lg:px-12 text-white">
            <a href="{{ route('home') }}" class="flex items-center gap-3 mb-12 transform hover:scale-105 transition-transform duration-300">
                <div class="w-12 h-12 bg-white/10 backdrop-blur-xl rounded-2xl flex items-center justify-center border border-white/20 shadow-[0_0_15px_rgba(255,255,255,0.1)]">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="text-3xl font-bold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-white to-white/70">{{ config('app.name') }}</span>
            </a>
            
            <h2 class="text-5xl font-extrabold mb-6 leading-[1.1] tracking-tight">
                Hubungkan <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-300 to-pink-300">Brand</span> & <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-300 to-orange-300">KOL</span> <br/> dalam Satu Platform
            </h2>
            <p class="text-lg text-white/80 font-medium mb-12 max-w-md leading-relaxed">
                Tingkatkan campaign Anda dengan kolaborasi yang tepat. Mulai perjalanan sukses Anda bersama ribuan kreator dan brand terkemuka di seluruh Indonesia.
            </p>
            
            <div class="flex items-center gap-5 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-5 shadow-2xl">
                <div class="flex -space-x-3">
                    <img class="w-12 h-12 rounded-full border-2 border-primary-900" src="https://ui-avatars.com/api/?name=B&background=random" alt="User avatar">
                    <img class="w-12 h-12 rounded-full border-2 border-primary-900" src="https://ui-avatars.com/api/?name=A&background=random" alt="User avatar">
                    <img class="w-12 h-12 rounded-full border-2 border-primary-900" src="https://ui-avatars.com/api/?name=C&background=random" alt="User avatar">
                    <img class="w-12 h-12 rounded-full border-2 border-primary-900" src="https://ui-avatars.com/api/?name=D&background=random" alt="User avatar">
                    <div class="w-12 h-12 rounded-full border-2 border-primary-900 bg-white/10 backdrop-blur-sm flex items-center justify-center text-xs font-bold text-white">+10k</div>
                </div>
                <div class="text-sm">
                    <p class="font-bold text-white text-base">Dipercaya oleh ribuan kreator</p>
                    <p class="text-white/60">Bergabunglah dengan mereka hari ini.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side: Form -->
    <div class="flex-1 flex flex-col justify-center relative bg-gray-50 dark:bg-gray-950 px-4 sm:px-6 lg:px-12 xl:px-24">
        
        <!-- Mobile Logo -->
        <div class="absolute top-6 left-6 lg:hidden">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-10 h-10 bg-primary-600 rounded-xl flex items-center justify-center shadow-lg shadow-primary-600/30">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ config('app.name') }}</span>
            </a>
        </div>

        <div class="w-full max-w-md mx-auto mt-16 lg:mt-0">
            @if (session('success'))
                <x-alert type="success" class="mb-6 rounded-2xl shadow-sm">{{ session('success') }}</x-alert>
            @endif

            @if (session('error'))
                <x-alert type="error" class="mb-6 rounded-2xl shadow-sm">{{ session('error') }}</x-alert>
            @endif

            <div class="bg-white dark:bg-gray-900/80 shadow-2xl shadow-gray-300/40 dark:shadow-black/50 rounded-[2rem] border border-gray-200 dark:border-gray-800/60 p-8 sm:p-10 backdrop-blur-xl relative overflow-hidden z-10">
                <!-- Subtle decorative background element inside the card -->
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-primary-500/10 dark:bg-primary-500/5 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-pink-500/10 dark:bg-pink-500/5 rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="relative z-10">
                    @yield('content')
                </div>
            </div>
            
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} <span class="font-semibold">{{ config('app.name') }}</span>. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
