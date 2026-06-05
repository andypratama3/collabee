<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tentang Collabee - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100">
    <header class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600 dark:text-indigo-400">{{ config('app.name') }}</a>
                <nav class="flex items-center gap-4">
                    <a href="{{ route('campaigns.explore') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Jelajahi</a>
                    <a href="{{ route('about') }}" class="text-sm text-indigo-600 dark:text-indigo-400 font-medium">Tentang</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Masuk</a>
                        <a href="{{ route('register.brand') }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">Daftar</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <main>
        <div class="max-w-3xl mx-auto px-4 py-16 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold text-center mb-8">Tentang Collabee</h1>

            <div class="prose dark:prose-invert max-w-none space-y-6">
                <p class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed">
                    Collabee adalah platform <strong>peer-to-peer</strong> yang menghubungkan brand secara langsung dengan KOL (Key Opinion Leader) untuk kampanye pemasaran yang efektif, transparan, dan terpercaya.
                </p>

                <h2 class="text-2xl font-semibold mt-10">Misi Kami</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Memberdayakan brand dan kreator untuk berkolaborasi tanpa perantara — menciptakan kemitraan yang saling menguntungkan dengan sistem escrow yang aman, pembayaran otomatis, dan komunikasi real-time.
                </p>

                <h2 class="text-2xl font-semibold mt-10">Fitur Utama</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                        <h3 class="font-semibold">Eksplorasi Campaign</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Temukan campaign yang sesuai dengan niche dan keahlian Anda.</p>
                    </div>
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                        <h3 class="font-semibold">Sistem Escrow</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pembayaran aman dengan sistem escrow otomatis.</p>
                    </div>
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                        <h3 class="font-semibold">Chat Real-time</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Komunikasi langsung antara brand dan KOL.</p>
                    </div>
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                        <h3 class="font-semibold">Manajemen Konten</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Upload, review, dan approve konten dalam satu platform.</p>
                    </div>
                </div>

                <h2 class="text-2xl font-semibold mt-10">Hubungi Kami</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Punya pertanyaan atau saran? Jangan ragu untuk menghubungi tim kami melalui email di <a href="mailto:hello@collabee.app" class="text-indigo-600 dark:text-indigo-400 hover:underline">hello@collabee.app</a>.
                </p>
            </div>
        </div>
    </main>

    <footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 mt-16">
        <div class="max-w-7xl mx-auto px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </footer>
</body>
</html>
