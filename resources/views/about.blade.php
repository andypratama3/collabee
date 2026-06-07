@extends('layouts.marketing')

@section('title', 'Tentang Collabee — Hubungkan Brand dengan Nano Influencer')

@section('content')
{{-- Hero Section --}}
<section class="relative pt-36 pb-24 lg:pt-52 lg:pb-36 overflow-hidden">
    {{-- Background Elements --}}
    <div class="absolute inset-0 bg-gradient-to-br from-gray-50 via-white to-primary-50/30 dark:from-[#09090b] dark:via-[#09090b] dark:to-primary-950/20"></div>
    <div class="absolute top-20 right-1/4 w-[600px] h-[600px] bg-primary-500/5 dark:bg-primary-500/5 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-1/4 w-[400px] h-[400px] bg-indigo-500/5 dark:bg-indigo-500/5 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-50 dark:bg-primary-900/30 border border-primary-200/50 dark:border-primary-700/30 mb-8">
                <span class="w-2 h-2 rounded-full bg-primary-500 animate-pulse"></span>
                <span class="text-sm font-bold text-primary-700 dark:text-primary-300">Tentang Collabee</span>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tight text-gray-900 dark:text-white leading-[1.1] mb-8">
                Misi Kami:
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 via-indigo-600 to-purple-600 dark:from-primary-400 dark:via-indigo-400 dark:to-purple-400">Demokratisasi</span>
                Pemasaran Influencer
            </h1>
            <p class="text-lg md:text-xl text-gray-500 dark:text-gray-400 leading-relaxed mx-auto">
                Platform ini membantu mempertemukan brand dengan nano influencer yang punya sekitar 1.000–10.000 followers. Biasanya mereka punya audiens yang lebih dekat dan engagement yang cukup bagus. Jadi brand bisa lebih mudah cari KOL yang cocok untuk promosi, dan content creator (KOL) juga bisa dapat kesempatan kerja sama untuk menambah pengalaman dan portofolio. Semua dilakukan secara peer to peer, jadi brand dan KOL bisa langsung terhubung dengan lebih praktis.
            </p>
        </div>
    </div>
</section>

{{-- Values Grid Section --}}
<section class="relative py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">
            {{-- Visual Grid --}}
            <div class="order-2 lg:order-1">
                <div class="grid grid-cols-2 gap-5">
                    @foreach([
                        ['emoji' => '🚀', 'label' => 'Cepat', 'color' => 'primary', 'from' => 'from-primary-100', 'to' => 'to-primary-50', 'darkFrom' => 'dark:from-primary-900/30', 'darkTo' => 'dark:to-primary-800/10', 'text' => 'text-primary-700 dark:text-primary-300', 'border' => 'border-primary-200/50 dark:border-primary-700/30', 'mt' => ''],
                        ['emoji' => '🛡️', 'label' => 'Aman', 'color' => 'indigo', 'from' => 'from-indigo-100', 'to' => 'to-indigo-50', 'darkFrom' => 'dark:from-indigo-900/30', 'darkTo' => 'dark:to-indigo-800/10', 'text' => 'text-indigo-700 dark:text-indigo-300', 'border' => 'border-indigo-200/50 dark:border-indigo-700/30', 'mt' => 'mt-10'],
                        ['emoji' => '💎', 'label' => 'Premium', 'color' => 'emerald', 'from' => 'from-emerald-100', 'to' => 'to-emerald-50', 'darkFrom' => 'dark:from-emerald-900/30', 'darkTo' => 'dark:to-emerald-800/10', 'text' => 'text-emerald-700 dark:text-emerald-300', 'border' => 'border-emerald-200/50 dark:border-emerald-700/30', 'mt' => '-mt-10'],
                        ['emoji' => '🌈', 'label' => 'Inklusif', 'color' => 'amber', 'from' => 'from-amber-100', 'to' => 'to-amber-50', 'darkFrom' => 'dark:from-amber-900/30', 'darkTo' => 'dark:to-amber-800/10', 'text' => 'text-amber-700 dark:text-amber-300', 'border' => 'border-amber-200/50 dark:border-amber-700/30', 'mt' => ''],
                    ] as $item)
                        <div class="aspect-square rounded-3xl bg-gradient-to-br {{ $item['from'] }} {{ $item['to'] }} {{ $item['darkFrom'] }} {{ $item['darkTo'] }} border {{ $item['border'] }} flex items-center justify-center p-8 {{ $item['mt'] }} group hover:scale-105 hover:shadow-xl transition-all duration-500 cursor-default">
                            <div class="text-center">
                                <div class="text-5xl mb-3 group-hover:scale-110 transition-transform duration-300">{{ $item['emoji'] }}</div>
                                <div class="font-black text-lg {{ $item['text'] }}">{{ $item['label'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Story Content --}}
            <div class="order-1 lg:order-2 space-y-8">
                <div>
                    <h2 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white mb-6 leading-tight">Cerita Di Balik Collabee</h2>
                    <div class="space-y-4 text-gray-600 dark:text-gray-400 text-lg leading-relaxed">
                        <p>
                            Collabee hadir untuk membantu brand, terutama UMKM, menemukan nano influencer (1.000–10.000 followers) yang cocok untuk mempromosikan produk mereka. Di sisi lain, content creator juga bisa mendapatkan kesempatan kerja sama untuk menambah pengalaman dan portofolio.
                        </p>
                        <p>
                            Kami bukan agensi. Kami adalah <strong class="text-gray-900 dark:text-white font-bold">platform peer-to-peer</strong>. Semua dilakukan secara langsung tanpa perantara, jadi brand dan KOL bisa terhubung dengan lebih praktis, dekat, dan autentik.
                        </p>
                    </div>
                </div>

                {{-- Values List --}}
                <div class="space-y-5 pt-4">
                    <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest">Mengapa Collabee?</h4>
                    @foreach([
                        ['num' => '01', 'title' => 'Peer to Peer', 'desc' => 'Brand dan KOL terhubung langsung tanpa perantara.'],
                        ['num' => '02', 'title' => 'Nano Influencer Focus', 'desc' => 'Fokus pada kreator 1.000–10.000 followers dengan engagement tinggi.'],
                        ['num' => '03', 'title' => 'Praktis & Autentik', 'desc' => 'Kolaborasi yang lebih dekat, alami, dan terjangkau untuk semua.'],
                    ] as $value)
                        <div class="flex items-start gap-5 p-5 rounded-2xl bg-white/80 dark:bg-gray-900/50 border border-gray-200/50 dark:border-gray-800/50 hover:border-primary-200 dark:hover:border-primary-800 hover:shadow-lg transition-all duration-300 group">
                            <div class="shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center text-white font-black text-sm shadow-lg shadow-primary-500/25 group-hover:scale-110 transition-transform duration-300">
                                {{ $value['num'] }}
                            </div>
                            <div>
                                <span class="font-bold text-gray-900 dark:text-white">{{ $value['title'] }}</span>
                                <span class="text-gray-500 dark:text-gray-400"> — {{ $value['desc'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="relative py-24 lg:py-32 overflow-hidden">
    {{-- Background --}}
    <div class="absolute inset-0 bg-gradient-to-br from-gray-50 via-primary-50/20 to-indigo-50/20 dark:from-gray-900/50 dark:via-primary-950/20 dark:to-indigo-950/20"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-primary-500/5 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white mb-4">Siap Mulai Kolaborasi?</h2>
        <p class="text-lg text-gray-500 dark:text-gray-400 mb-12 max-w-xl mx-auto">Pilih peran Anda dan mulai terhubung dengan nano influencer atau brand di seluruh Indonesia.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 max-w-3xl mx-auto">
            {{-- Brand Card --}}
            <div class="group relative bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl p-8 lg:p-10 rounded-[2rem] border border-gray-200/50 dark:border-gray-800/50 shadow-xl shadow-gray-200/20 dark:shadow-gray-900/30 hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-primary-500 to-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-100 to-indigo-100 dark:from-primary-900/40 dark:to-indigo-900/40 flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <h3 class="text-xl font-black text-gray-900 dark:text-white mb-3">Untuk Brand</h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed mb-6">Temukan nano influencer yang cocok dengan audiens Anda dan ajak kerja sama langsung tanpa perantara.</p>
                <a href="{{ route('register.brand') }}" class="block w-full py-3.5 text-center bg-gradient-to-r from-primary-600 to-indigo-600 text-white font-bold rounded-xl hover:from-primary-700 hover:to-indigo-700 transition-all duration-300 shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/30">Daftar Brand</a>
            </div>

            {{-- KOL Card --}}
            <div class="group relative bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl p-8 lg:p-10 rounded-[2rem] border border-gray-200/50 dark:border-gray-800/50 shadow-xl shadow-gray-200/20 dark:shadow-gray-900/30 hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-pink-500 to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-pink-100 to-purple-100 dark:from-pink-900/40 dark:to-purple-900/40 flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h3 class="text-xl font-black text-gray-900 dark:text-white mb-3">Untuk KOL</h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed mb-6">Dapatkan tawaran kerja sama dari berbagai brand dan bangun portofolio sebagai content creator.</p>
                <a href="{{ route('register.kol') }}" class="block w-full py-3.5 text-center bg-gradient-to-r from-pink-600 to-purple-600 text-white font-bold rounded-xl hover:from-pink-700 hover:to-purple-700 transition-all duration-300 shadow-lg shadow-pink-500/25 hover:shadow-xl hover:shadow-pink-500/30">Daftar KOL</a>
            </div>
        </div>
    </div>
</section>

{{-- Contact Section --}}
<section class="py-24 lg:py-32">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-100 to-indigo-100 dark:from-primary-900/30 dark:to-indigo-900/30 mb-6">
            <svg class="w-8 h-8 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <h2 class="text-2xl md:text-3xl font-black text-gray-900 dark:text-white mb-4">Butuh Bantuan Lebih Lanjut?</h2>
        <p class="text-gray-500 dark:text-gray-400 mb-8 text-lg">Tim kami siap membantu Anda 24/7. Hubungi kami melalui email atau media sosial.</p>
        <a href="mailto:hello@collabee.app" class="inline-flex items-center gap-2 px-6 py-3 text-primary-600 dark:text-primary-400 font-bold bg-primary-50 dark:bg-primary-900/20 rounded-xl border border-primary-200/50 dark:border-primary-700/30 hover:bg-primary-100 dark:hover:bg-primary-900/40 hover:shadow-lg transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            hello@collabee.app
        </a>
    </div>
</section>
@endsection
