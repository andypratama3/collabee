@extends('layouts.marketing')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-gray-50 dark:bg-gray-950 transition-colors duration-500">
    <!-- Premium Background Decor -->
    <div class="absolute inset-0 w-full h-full -z-10 pointer-events-none overflow-hidden">
        <!-- Light Mode Gradients -->
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-primary-200/40 dark:bg-primary-900/20 blur-[120px] rounded-full mix-blend-multiply dark:mix-blend-screen animate-blob"></div>
        <div class="absolute top-[20%] right-[-10%] w-[40%] h-[40%] bg-indigo-200/40 dark:bg-indigo-900/20 blur-[100px] rounded-full mix-blend-multiply dark:mix-blend-screen animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-[-20%] left-[20%] w-[60%] h-[60%] bg-purple-200/40 dark:bg-purple-900/20 blur-[130px] rounded-full mix-blend-multiply dark:mix-blend-screen animate-blob animation-delay-4000"></div>
        
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjEiIGZpbGw9InJnYmEoMTU2LCAxNjMsIDE3NSLCAwLjEpIi8+PC9zdmc+')] [mask-image:linear-gradient(to_bottom,white,transparent)]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <!-- Badge -->
        <div class="inline-flex items-center gap-3 px-5 py-2 rounded-full bg-white/60 dark:bg-gray-900/60 backdrop-blur-md border border-gray-200/50 dark:border-gray-700 text-gray-800 dark:text-gray-200 text-xs font-black uppercase tracking-[0.2em] mb-12 shadow-xl shadow-primary-500/5 hover:scale-105 transition-transform duration-300">
            <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-primary-600 dark:bg-primary-500"></span>
            </span>
            Platform Kolaborasi #1 di Indonesia
        </div>
        
        <!-- Headline -->
        <h1 class="text-6xl md:text-8xl lg:text-[7.5rem] font-black tracking-tighter leading-[1.1] mb-10 text-gray-900 dark:text-white drop-shadow-sm">
            Hubungkan Brand dengan <br class="hidden md:block">
            <span class="relative inline-block mt-2">
                <span class="absolute -inset-2 bg-gradient-to-r from-primary via-indigo-500 to-purple-600 blur-2xl opacity-20 dark:opacity-40"></span>
                <span class="relative text-transparent bg-clip-text bg-gradient-to-r from-primary-600 via-indigo-600 to-purple-600 dark:from-primary-400 dark:via-indigo-400 dark:to-purple-400">
                    KOL Terbaik
                </span>
            </span>
        </h1>
        
        <!-- Subheadline -->
        <p class="max-w-3xl mx-auto text-xl md:text-2xl text-gray-600 dark:text-gray-400 leading-relaxed mb-16 font-medium">
            Platform peer-to-peer yang membantu brand terhubung langsung dengan nano influencer (1.000–10.000 followers) untuk kolaborasi yang lebih praktis, dekat, dan autentik.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-6 mb-24">
            @auth
                <a href="{{ route('dashboard') }}" class="group relative w-full sm:w-auto px-10 py-5 text-lg font-black text-white bg-gray-900 dark:bg-white dark:text-gray-900 rounded-2xl hover:scale-105 transition-all duration-300 shadow-2xl shadow-gray-900/20 dark:shadow-white/10 overflow-hidden">
                    <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 dark:via-gray-900/10 to-transparent -translate-x-full group-hover:animate-shimmer"></span>
                    <span class="relative">Kembali ke Dashboard</span>
                </a>
            @else
                <a href="{{ route('register.brand') }}" class="group relative w-full sm:w-auto px-10 py-5 text-lg font-black text-white bg-gradient-to-r from-primary-600 to-indigo-600 rounded-2xl hover:scale-105 transition-all duration-300 shadow-2xl shadow-primary-500/30 overflow-hidden border border-primary-500/50">
                    <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-shimmer"></span>
                    <span class="relative flex items-center justify-center gap-3">
                        Mulai Sebagai Brand
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </span>
                </a>
                <a href="{{ route('register.kol') }}" class="w-full sm:w-auto px-10 py-5 text-lg font-black text-gray-900 dark:text-white bg-white/50 dark:bg-gray-900/50 backdrop-blur-sm border-2 border-gray-200 dark:border-gray-700 rounded-2xl hover:border-primary-500 dark:hover:border-primary-400 hover:bg-white dark:hover:bg-gray-800 transition-all duration-300 shadow-xl">
                    Gabung Sebagai KOL
                </a>
            @endauth
        </div>

        <!-- Dynamic Brands Section -->
        @if($brands->isNotEmpty())
        <div class="pt-12 border-t border-gray-200/60 dark:border-gray-800/60">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-gray-400 dark:text-gray-500 mb-10">Brand Terkemuka Di Ekosistem Kami</p>
            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-70 dark:opacity-60 hover:opacity-100 transition-all duration-500">
                @foreach($brands as $brand)
                    <div class="group flex flex-col items-center gap-2">
                        <div class="w-16 h-16 rounded-2xl bg-white/50 dark:bg-gray-800/50 backdrop-blur-md border border-gray-200/50 dark:border-gray-700 flex items-center justify-center text-primary-600 dark:text-primary-400 font-black text-2xl shadow-lg group-hover:scale-110 group-hover:-translate-y-1 transition-all duration-300">
                            {{ strtoupper(substr($brand->company_name ?? $brand->user->name, 0, 1)) }}
                        </div>
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest group-hover:text-gray-900 dark:group-hover:text-white transition-colors">{{ $brand->company_name ?? $brand->user->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Stats Grid - Premium Glassmorphism -->
<section class="py-24 relative -mt-10 z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/70 dark:bg-gray-900/70 backdrop-blur-2xl border border-white/50 dark:border-gray-700 rounded-[3rem] p-12 md:p-20 text-center relative overflow-hidden shadow-2xl shadow-gray-200/50 dark:shadow-black/50">
             
             <!-- Inner Abstract Decor -->
             <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-primary-400/30 to-indigo-500/30 rounded-full blur-3xl pointer-events-none"></div>
             <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-tr from-purple-400/30 to-pink-500/30 rounded-full blur-3xl pointer-events-none"></div>

             <div class="relative z-10 grid grid-cols-2 md:grid-cols-4 gap-12 md:gap-16">
                <div class="space-y-3 transform hover:scale-105 transition-transform">
                    <div class="text-5xl md:text-7xl font-black text-transparent bg-clip-text bg-gradient-to-b from-gray-900 to-gray-500 dark:from-white dark:to-gray-400">
                        {{ $stats['brands'] > 100 ? '100+' : $stats['brands'] }}
                    </div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm font-bold uppercase tracking-widest">Brand Terdaftar</div>
                </div>
                <div class="space-y-3 transform hover:scale-105 transition-transform">
                    <div class="text-5xl md:text-7xl font-black text-transparent bg-clip-text bg-gradient-to-b from-primary-600 to-primary-400 dark:from-primary-400 dark:to-primary-600">
                        {{ $stats['kols'] > 500 ? '500+' : $stats['kols'] }}
                    </div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm font-bold uppercase tracking-widest">KOL Aktif</div>
                </div>
                <div class="space-y-3 transform hover:scale-105 transition-transform">
                    <div class="text-5xl md:text-7xl font-black text-transparent bg-clip-text bg-gradient-to-b from-gray-900 to-gray-500 dark:from-white dark:to-gray-400">
                        {{ $stats['campaigns'] > 1000 ? '1K+' : $stats['campaigns'] }}
                    </div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm font-bold uppercase tracking-widest">Campaign Selesai</div>
                </div>
                <div class="space-y-3 transform hover:scale-105 transition-transform">
                    <div class="text-5xl md:text-7xl font-black text-transparent bg-clip-text bg-gradient-to-b from-primary-600 to-primary-400 dark:from-primary-400 dark:to-primary-600">
                        {{ number_format($stats['transactions'] / 1000000, 0) }}<span class="text-3xl md:text-5xl">jt+</span>
                    </div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm font-bold uppercase tracking-widest">Total Transaksi</div>
                </div>
             </div>
        </div>
    </div>
</section>

<!-- Dynamic Campaigns Section -->
@if($campaigns->isNotEmpty())
<section class="py-24 bg-white dark:bg-gray-950 transition-colors duration-500 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
            <div>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white mb-4 tracking-tight">Campaign <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-indigo-600 dark:from-primary-400 dark:to-indigo-400">Terbaru</span></h2>
                <p class="text-gray-500 dark:text-gray-400 text-lg">Temukan peluang kolaborasi terbaru dari brand terkemuka.</p>
            </div>
            <a href="{{ route('campaigns.explore') }}" class="inline-flex items-center gap-2 font-bold text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 transition-colors group">
                Lihat Semua Campaign
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($campaigns as $campaign)
            <a href="{{ route('campaigns.detail', $campaign) }}" class="group relative bg-gray-50/50 dark:bg-gray-900/50 backdrop-blur-xl rounded-[2rem] p-8 border border-gray-200/50 dark:border-gray-800/50 hover:border-primary-500/50 dark:hover:border-primary-500/50 hover:shadow-2xl hover:shadow-primary-500/10 hover:-translate-y-2 transition-all duration-500 flex flex-col h-full">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-white dark:bg-gray-800 shadow-lg flex items-center justify-center text-xl font-black text-primary-600 dark:text-primary-400 group-hover:scale-110 transition-transform duration-300">
                            {{ strtoupper(substr($campaign->brandProfile->company_name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">{{ $campaign->brandProfile->company_name ?? 'Brand' }}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 flex items-center gap-1 mt-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $campaign->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    <div class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-xs font-bold rounded-lg whitespace-nowrap">
                        Terbuka
                    </div>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">{{ $campaign->title }}</h3>
                
                <div class="mt-auto pt-6 border-t border-gray-200/50 dark:border-gray-800/50 flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Budget Total</p>
                        <p class="text-lg font-black text-gray-900 dark:text-white">Rp. {{ number_format($campaign->budget_total, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400 group-hover:bg-primary-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Dynamic Top KOL Section -->
@if($kols->isNotEmpty())
<section class="py-24 bg-gray-50 dark:bg-gray-900 relative transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white mb-4 tracking-tight">KOL <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-purple-600 dark:from-pink-400 dark:to-purple-400">Paling Bersinar</span></h2>
            <p class="text-gray-500 dark:text-gray-400 text-lg max-w-2xl mx-auto">Kreator dengan performa tertinggi siap mensukseskan kampanye Anda.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($kols as $kol)
            <div class="group bg-white dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl p-6 text-center shadow-lg shadow-gray-200/20 dark:shadow-none border border-gray-100 dark:border-gray-700 hover:-translate-y-2 hover:shadow-2xl transition-all duration-500">
                <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-pink-100 to-purple-100 dark:from-pink-900/30 dark:to-purple-900/30 p-1 mb-4 group-hover:scale-110 transition-transform duration-300">
                    <div class="w-full h-full rounded-full bg-white dark:bg-gray-800 flex items-center justify-center text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-purple-600">
                        {{ strtoupper(substr($kol->display_name ?? $kol->user->name, 0, 2)) }}
                    </div>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-white truncate mb-1">{{ $kol->display_name ?? $kol->user->name }}</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">{{ $kol->category ?? 'Lifestyle' }}</p>
                <div class="flex items-center justify-center gap-4 text-sm font-bold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-900/50 py-2 rounded-xl">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        {{ $kol->rating_avg ? number_format($kol->rating_avg, 1) : '5.0' }}
                    </span>
                    <span class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-600"></span>
                    <span>{{ number_format($kol->total_followers / 1000, 1) }}K+</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Features Section -->
<section class="py-32 bg-white dark:bg-gray-950 transition-colors duration-500 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-24">
            <h2 class="text-4xl md:text-6xl font-black text-gray-900 dark:text-white mb-6 tracking-tight">MENGAPA COLLABEE?</h2>
            <div class="w-24 h-1.5 bg-gradient-to-r from-primary to-indigo-500 mx-auto rounded-full mb-8"></div>
            <p class="text-gray-500 dark:text-gray-400 text-xl max-w-2xl mx-auto font-medium">Kami membangun ekosistem di mana keamanan, efisiensi, dan kepercayaan adalah prioritas utama kami.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Feature 1 -->
            <div class="group p-10 bg-gray-50 dark:bg-gray-900/80 rounded-[2.5rem] shadow-xl shadow-gray-200/40 dark:shadow-none border border-transparent dark:border-gray-800 hover:border-primary-500/50 dark:hover:border-primary-500/50 hover:bg-white dark:hover:bg-gray-900 transition-all duration-500 hover:-translate-y-2">
                <div class="w-20 h-20 bg-gradient-to-br from-primary-100 to-primary-50 dark:from-primary-900/50 dark:to-primary-950 rounded-[1.5rem] flex items-center justify-center text-primary-600 dark:text-primary-400 mb-10 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-5 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">Escrow Otomatis</h3>
                <p class="text-gray-500 dark:text-gray-400 text-lg leading-relaxed">Dana aman di sistem escrow kami dan hanya dirilis ke KOL setelah konten disetujui sepenuhnya oleh Brand. 100% Bebas penipuan.</p>
            </div>
            <!-- Feature 2 -->
            <div class="group p-10 bg-gray-50 dark:bg-gray-900/80 rounded-[2.5rem] shadow-xl shadow-gray-200/40 dark:shadow-none border border-transparent dark:border-gray-800 hover:border-indigo-500/50 dark:hover:border-indigo-500/50 hover:bg-white dark:hover:bg-gray-900 transition-all duration-500 hover:-translate-y-2">
                <div class="w-20 h-20 bg-gradient-to-br from-indigo-100 to-indigo-50 dark:from-indigo-900/50 dark:to-indigo-950 rounded-[1.5rem] flex items-center justify-center text-indigo-600 dark:text-indigo-400 mb-10 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-500">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-5 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">Direct Messaging</h3>
                <p class="text-gray-500 dark:text-gray-400 text-lg leading-relaxed">Komunikasi langsung antara Brand dan KOL. Diskusikan brief, ide, dan revisi secara instan tanpa perantara yang memperlambat.</p>
            </div>
            <!-- Feature 3 -->
            <div class="group p-10 bg-gray-50 dark:bg-gray-900/80 rounded-[2.5rem] shadow-xl shadow-gray-200/40 dark:shadow-none border border-transparent dark:border-gray-800 hover:border-purple-500/50 dark:hover:border-purple-500/50 hover:bg-white dark:hover:bg-gray-900 transition-all duration-500 hover:-translate-y-2">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-100 to-purple-50 dark:from-purple-900/50 dark:to-purple-950 rounded-[1.5rem] flex items-center justify-center text-purple-600 dark:text-purple-400 mb-10 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-5 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">Manajemen Konten</h3>
                <p class="text-gray-500 dark:text-gray-400 text-lg leading-relaxed">Kelola workflow persetujuan draft dengan mudah. Berikan feedback revisi secara terpusat hingga hasil akhir siap dipublikasikan.</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-32 bg-gray-50 dark:bg-gray-900 transition-colors duration-500 relative overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-primary-500/5 dark:bg-primary-500/10 rounded-full blur-[150px] pointer-events-none"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-24">
            <h2 class="text-4xl md:text-6xl font-black text-gray-900 dark:text-white mb-6 tracking-tight">BAGAIMANA CARA KERJANYA?</h2>
            <div class="w-24 h-1.5 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto rounded-full mb-8"></div>
            <p class="text-gray-500 dark:text-gray-400 text-xl max-w-2xl mx-auto font-medium">Hanya 4 langkah mudah untuk memulai kolaborasi yang sukses bersama Collabee.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 relative">
            <!-- Connecting Line (Desktop) -->
            <div class="hidden lg:block absolute top-24 left-[12%] right-[12%] h-0.5 bg-gradient-to-r from-primary-300 via-indigo-300 to-purple-300 dark:from-primary-700 dark:via-indigo-700 dark:to-purple-700"></div>
            
            <!-- Step 1 -->
            <div class="relative text-center group">
                <div class="relative z-10 w-20 h-20 mx-auto mb-8 bg-white dark:bg-gray-800 rounded-full border-4 border-primary-200 dark:border-primary-800 flex items-center justify-center shadow-xl shadow-primary-500/10 group-hover:scale-110 group-hover:border-primary-400 dark:group-hover:border-primary-600 transition-all duration-500">
                    <span class="text-3xl font-black text-primary-600 dark:text-primary-400">1</span>
                </div>
                <div class="p-6 bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl border border-gray-200/50 dark:border-gray-700 shadow-lg group-hover:shadow-xl group-hover:-translate-y-1 transition-all duration-500">
                    <div class="w-14 h-14 mx-auto mb-4 bg-primary-50 dark:bg-primary-900/30 rounded-2xl flex items-center justify-center text-primary-600 dark:text-primary-400">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Daftar & Buat Profil</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Buat akun gratis sebagai Brand atau KOL dan lengkapi profil Anda.</p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="relative text-center group">
                <div class="relative z-10 w-20 h-20 mx-auto mb-8 bg-white dark:bg-gray-800 rounded-full border-4 border-indigo-200 dark:border-indigo-800 flex items-center justify-center shadow-xl shadow-indigo-500/10 group-hover:scale-110 group-hover:border-indigo-400 dark:group-hover:border-indigo-600 transition-all duration-500">
                    <span class="text-3xl font-black text-indigo-600 dark:text-indigo-400">2</span>
                </div>
                <div class="p-6 bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl border border-gray-200/50 dark:border-gray-700 shadow-lg group-hover:shadow-xl group-hover:-translate-y-1 transition-all duration-500">
                    <div class="w-14 h-14 mx-auto mb-4 bg-indigo-50 dark:bg-indigo-900/30 rounded-2xl flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Temukan & Koneksi</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Brand menemukan KOL yang cocok, atau KOL melamar ke campaign yang tersedia.</p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="relative text-center group">
                <div class="relative z-10 w-20 h-20 mx-auto mb-8 bg-white dark:bg-gray-800 rounded-full border-4 border-violet-200 dark:border-violet-800 flex items-center justify-center shadow-xl shadow-violet-500/10 group-hover:scale-110 group-hover:border-violet-400 dark:group-hover:border-violet-600 transition-all duration-500">
                    <span class="text-3xl font-black text-violet-600 dark:text-violet-400">3</span>
                </div>
                <div class="p-6 bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl border border-gray-200/50 dark:border-gray-700 shadow-lg group-hover:shadow-xl group-hover:-translate-y-1 transition-all duration-500">
                    <div class="w-14 h-14 mx-auto mb-4 bg-violet-50 dark:bg-violet-900/30 rounded-2xl flex items-center justify-center text-violet-600 dark:text-violet-400">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Buat Agreement</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Sepakati syarat, budget, dan deadline. Dana masuk ke escrow otomatis.</p>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="relative text-center group">
                <div class="relative z-10 w-20 h-20 mx-auto mb-8 bg-white dark:bg-gray-800 rounded-full border-4 border-purple-200 dark:border-purple-800 flex items-center justify-center shadow-xl shadow-purple-500/10 group-hover:scale-110 group-hover:border-purple-400 dark:group-hover:border-purple-600 transition-all duration-500">
                    <span class="text-3xl font-black text-purple-600 dark:text-purple-400">4</span>
                </div>
                <div class="p-6 bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl border border-gray-200/50 dark:border-gray-700 shadow-lg group-hover:shadow-xl group-hover:-translate-y-1 transition-all duration-500">
                    <div class="w-14 h-14 mx-auto mb-4 bg-purple-50 dark:bg-purple-900/30 rounded-2xl flex items-center justify-center text-purple-600 dark:text-purple-400">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Selesai & Bayar</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Brand approve konten, dana otomatis rilis ke KOL. Semua aman & transparan.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-32 bg-white dark:bg-gray-950 transition-colors duration-500 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20">
            <h2 class="text-4xl md:text-6xl font-black text-gray-900 dark:text-white mb-6 tracking-tight">KATA MEREKA</h2>
            <div class="w-24 h-1.5 bg-gradient-to-r from-pink-500 to-purple-500 mx-auto rounded-full mb-8"></div>
            <p class="text-gray-500 dark:text-gray-400 text-xl max-w-2xl mx-auto font-medium">Brand dan KOL yang sudah merasakan dampak positif kolaborasi di Collabee.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Testimonial 1 -->
            <div class="group p-8 bg-gray-50/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-[2rem] border border-gray-200/50 dark:border-gray-800/50 hover:border-primary-300 dark:hover:border-primary-700 hover:shadow-2xl hover:shadow-primary-500/5 hover:-translate-y-1 transition-all duration-500">
                <div class="flex items-center gap-1 mb-6">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed mb-8 font-medium italic">"Platform yang sangat memudahkan kami menemukan KOL berkualitas. Sistem escrow membuat kami merasa aman dalam setiap transaksi."</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center text-white font-bold text-lg">A</div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">Andi Pratama</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Marketing Director, TechVenture</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="group p-8 bg-gray-50/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-[2rem] border border-gray-200/50 dark:border-gray-800/50 hover:border-pink-300 dark:hover:border-pink-700 hover:shadow-2xl hover:shadow-pink-500/5 hover:-translate-y-1 transition-all duration-500">
                <div class="flex items-center gap-1 mb-6">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed mb-8 font-medium italic">"Sebagai content creator, saya sangat terbantu. Pembayaran selalu tepat waktu dan prosesnya sangat transparan. Highly recommended!"</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">S</div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">Sarah Kirana</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Content Creator, 250K Followers</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="group p-8 bg-gray-50/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-[2rem] border border-gray-200/50 dark:border-gray-800/50 hover:border-indigo-300 dark:hover:border-indigo-700 hover:shadow-2xl hover:shadow-indigo-500/5 hover:-translate-y-1 transition-all duration-500">
                <div class="flex items-center gap-1 mb-6">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed mb-8 font-medium italic">"Collabee mengubah cara kami berkolaborasi. Tidak perlu lagi ribet dengan invoice manual. Semuanya otomatis dan profesional."</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white font-bold text-lg">R</div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">Rizki Fadillah</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">CEO, BrandGrowth Indonesia</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-32 bg-gray-50 dark:bg-gray-900 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-primary-900/10 to-indigo-900/10 dark:from-primary-900/30 dark:to-indigo-900/30 pointer-events-none"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-5xl md:text-7xl font-black text-gray-900 dark:text-white mb-10 leading-tight tracking-tight">Siap Memulai <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-indigo-600 dark:from-primary-400 dark:to-indigo-400">Revolusi Digital Anda?</span></h2>
        <p class="text-xl text-gray-600 dark:text-gray-400 mb-14 max-w-2xl mx-auto leading-relaxed font-medium">
            Ribuan Brand dan KOL telah sukses meningkatkan ROI mereka bersama Collabee. Jangan tertinggal, bergabung sekarang secara gratis.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
            <a href="{{ route('register.brand') }}" class="w-full sm:w-auto px-12 py-5 text-xl font-black text-white bg-gradient-to-r from-primary-600 to-indigo-600 rounded-2xl hover:scale-105 transition-all duration-300 shadow-2xl shadow-primary-500/30">
                Daftar Gratis Sekarang
            </a>
            <a href="{{ route('campaigns.explore') }}" class="w-full sm:w-auto px-12 py-5 text-xl font-black text-gray-900 dark:text-white bg-white dark:bg-gray-800 rounded-2xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300 shadow-xl border border-transparent dark:border-gray-700">
                Jelajahi Campaign
            </a>
        </div>
    </div>
</section>
@endsection
