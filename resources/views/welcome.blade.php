<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} — Platform Kolaborasi Brand & KOL</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <meta name="description" content="Collabee adalah platform peer-to-peer yang menghubungkan brand secara langsung dengan KOL untuk kampanye pemasaran yang efektif, transparan, dan terpercaya.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100">
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-gray-950/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600 dark:text-indigo-400">{{ config('app.name') }}</a>
                <nav class="hidden sm:flex items-center gap-6">
                    <a href="{{ route('campaigns.explore') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Jelajahi Campaign</a>
                    <a href="{{ route('about') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Tentang</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Masuk</a>
                        <a href="{{ route('register.brand') }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors">Daftar Sekarang</a>
                    @endauth
                </nav>
                <div class="sm:hidden flex items-center gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-indigo-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 mr-2">Masuk</a>
                        <a href="{{ route('register.brand') }}" class="px-3 py-1.5 text-sm font-medium text-white bg-indigo-600 rounded-lg">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main>
        <section class="relative pt-24 pb-16 sm:pt-32 sm:pb-24 overflow-hidden">
            <div class="absolute inset-0 -z-10">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[800px] bg-indigo-100 dark:bg-indigo-950/30 rounded-full blur-3xl opacity-50"></div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight">
                    Hubungkan Brand dengan
                    <span class="text-indigo-600 dark:text-indigo-400">KOL Terbaik</span>
                </h1>
                <p class="mt-6 max-w-2xl mx-auto text-lg sm:text-xl text-gray-500 dark:text-gray-400 leading-relaxed">
                    Platform peer-to-peer yang menghubungkan brand secara langsung dengan Key Opinion Leader.
                    Transparan, aman, dan tanpa perantara.
                </p>
                <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-8 py-3 text-base font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-600/25">
                            Dashboard Saya
                        </a>
                    @else
                        <a href="{{ route('register.brand') }}" class="px-8 py-3 text-base font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-600/25">
                            Mulai Sebagai Brand
                        </a>
                        <a href="{{ route('register.kol') }}" class="px-8 py-3 text-base font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50 rounded-xl hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors">
                            Daftar Sebagai KOL
                        </a>
                    @endauth
                </div>
                <div class="mt-8">
                    <a href="{{ route('campaigns.explore') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                        <span>Jelajahi Campaign Tersedia</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                    </a>
                </div>
            </div>
        </section>

        <section class="py-16 sm:py-24 bg-gray-50 dark:bg-gray-900/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl font-bold">Kenapa Collabee?</h2>
                    <p class="mt-4 text-gray-500 dark:text-gray-400">Platform yang dirancang untuk kolaborasi yang lebih baik</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/50 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Koneksi Langsung</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Brand dan KOL terhubung langsung tanpa perantara, negosiasi lebih efisien.</p>
                    </div>
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/50 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Pembayaran Aman</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Sistem escrow otomatis menjamin pembayaran aman untuk kedua belah pihak.</p>
                    </div>
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/50 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Komunikasi Real-time</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Chat langsung dengan notifikasi real-time untuk respons cepat.</p>
                    </div>
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-rose-100 dark:bg-rose-900/50 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Manajemen Konten</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Upload, review, dan approval konten terpusat dalam satu dashboard.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 sm:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl font-bold">Bagaimana Cara Kerjanya?</h2>
                    <p class="mt-4 text-gray-500 dark:text-gray-400">Tiga langkah mudah untuk memulai kolaborasi</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900/50 rounded-2xl flex items-center justify-center mb-4">
                            <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">1</span>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Buat Campaign</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Brand membuat campaign dengan detail lengkap — budget, platform, dan target KOL.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900/50 rounded-2xl flex items-center justify-center mb-4">
                            <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">2</span>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">KOL Melamar</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">KOL menemukan campaign yang cocok dan melamar dengan penawaran budget.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900/50 rounded-2xl flex items-center justify-center mb-4">
                            <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">3</span>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Kolaborasi & Dibayar</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Konten dikirim, disetujui, dan pembayaran otomatis dirilis dari escrow.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 bg-indigo-600 dark:bg-indigo-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-3xl sm:text-4xl font-bold text-white">100+</div>
                        <div class="mt-1 text-sm text-indigo-200">Brand Terdaftar</div>
                    </div>
                    <div>
                        <div class="text-3xl sm:text-4xl font-bold text-white">500+</div>
                        <div class="mt-1 text-sm text-indigo-200">KOL Aktif</div>
                    </div>
                    <div>
                        <div class="text-3xl sm:text-4xl font-bold text-white">1000+</div>
                        <div class="mt-1 text-sm text-indigo-200">Campaign Selesai</div>
                    </div>
                    <div>
                        <div class="text-3xl sm:text-4xl font-bold text-white">Rp 2M+</div>
                        <div class="mt-1 text-sm text-indigo-200">Total Transaksi</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 sm:py-24">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl sm:text-4xl font-bold mb-4">Siap Memulai Kolaborasi?</h2>
                <p class="text-lg text-gray-500 dark:text-gray-400 mb-8">Bergabunglah dengan ribuan brand dan KOL yang sudah menggunakan Collabee.</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-8 py-3 text-base font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-600/25">
                            Ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('register.brand') }}" class="px-8 py-3 text-base font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-600/25">
                            Daftar Sekarang
                        </a>
                        <a href="{{ route('campaigns.explore') }}" class="px-8 py-3 text-base font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50 rounded-xl hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors">
                            Jelajahi Campaign
                        </a>
                    @endauth
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-bold text-indigo-600 dark:text-indigo-400 mb-3">{{ config('app.name') }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Platform kolaborasi brand & KOL terpercaya di Indonesia.</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-3">Fitur</h3>
                    <ul class="space-y-2 text-sm text-gray-500 dark:text-gray-400">
                        <li><a href="{{ route('campaigns.explore') }}" class="hover:text-gray-700 dark:hover:text-gray-200">Jelajahi Campaign</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-gray-700 dark:hover:text-gray-200">Tentang Kami</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold mb-3">Akun</h3>
                    <ul class="space-y-2 text-sm text-gray-500 dark:text-gray-400">
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="hover:text-gray-700 dark:hover:text-gray-200">Dashboard</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="hover:text-gray-700 dark:hover:text-gray-200">Masuk</a></li>
                            <li><a href="{{ route('register.brand') }}" class="hover:text-gray-700 dark:hover:text-gray-200">Daftar Brand</a></li>
                            <li><a href="{{ route('register.kol') }}" class="hover:text-gray-700 dark:hover:text-gray-200">Daftar KOL</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-800 text-center text-sm text-gray-400 dark:text-gray-500">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
