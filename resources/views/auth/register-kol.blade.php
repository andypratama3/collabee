@extends('layouts.guest')
@section('title', 'Daftar KOL - ' . config('app.name'))

@section('content')
<div class="w-full">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Daftar sebagai KOL / Influencer</h2>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-primary hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 transition-colors">Masuk ke akun Anda</a>
        </p>
    </div>

    <form method="POST" action="{{ route('register.kol') }}" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form.input id="name" placeholder="Siska Kohl">Nama Lengkap</x-form.input>
            <x-form.input id="display_name" placeholder="@siskakohl">Nama Panggung / Akun</x-form.input>
        </div>

        <x-form.input id="email" type="email" placeholder="siska@contoh.com">Alamat Email</x-form.input>

        <x-form.select id="category" name="category" label="Kategori Utama">
            <option value="">Pilih kategori</option>
            <option value="beauty">Beauty & Makeup</option>
            <option value="fashion">Fashion & Style</option>
            <option value="tech">Tech & Gadget</option>
            <option value="food">Food & Culinary</option>
            <option value="travel">Travel & Adventure</option>
            <option value="lifestyle">Daily Lifestyle</option>
            <option value="sports">Sports & Fitness</option>
            <option value="music">Music & Cover</option>
            <option value="gaming">Gaming & E-Sports</option>
            <option value="education">Education & Tips</option>
            <option value="business">Business & Finance</option>
            <option value="entertainment">Entertainment & Comedy</option>
            <option value="parenting">Parenting</option>
            <option value="automotive">Automotive</option>
            <option value="photography">Photography & Art</option>
        </x-form.select>

        <x-form.input id="phone" type="tel" placeholder="0812-3456-7890">No. Telepon (Opsional)</x-form.input>

        <x-form.input id="location" placeholder="Jakarta, Indonesia">Lokasi (Opsional)</x-form.input>

        <div>
            <label for="bio" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Bio (Opsional)</label>
            <textarea id="bio" name="bio" rows="3" placeholder="Ceritakan tentang diri Anda..."
                      class="block w-full rounded-xl border-gray-200 dark:border-gray-700/80 bg-white dark:bg-gray-900 py-3 px-4 text-sm leading-relaxed text-gray-900 dark:text-gray-100 placeholder-gray-400 shadow-sm transition-all duration-300 focus:border-primary focus:ring-4 focus:ring-primary/10 focus:outline-none resize-y"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form.input id="password" type="password" placeholder="••••••••">Password</x-form.input>
            <x-form.input id="password_confirmation" type="password" placeholder="••••••••">Konfirmasi Password</x-form.input>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-primary hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary dark:focus:ring-offset-gray-900 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0">
                Buat Akun KOL
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>

        <p class="mt-4 text-xs text-center text-gray-500 dark:text-gray-400">
            Dengan mendaftar, Anda menyetujui <a href="#" class="text-primary hover:underline">Syarat & Ketentuan</a> dan <a href="#" class="text-primary hover:underline">Kebijakan Privasi</a> kami.
        </p>
    </form>
</div>
@endsection
