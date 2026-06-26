@extends('layouts.guest')
@section('title', 'Daftar Brand - ' . config('app.name'))

@section('content')
<div class="w-full">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Daftar sebagai Brand</h2>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-primary hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 transition-colors">Masuk ke akun Anda</a>
        </p>
    </div>

    <form method="POST" action="{{ route('register.brand') }}" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form.input id="name" placeholder="Budi Santoso">Nama Lengkap</x-form.input>
            <x-form.input id="brand_name" placeholder="PT Kreatif Maju">Nama Brand / Perusahaan</x-form.input>
        </div>

        <x-form.input id="email" type="email" placeholder="budi@perusahaan.com">Alamat Email</x-form.input>

        <x-form.select id="industry" name="industry" label="Industri / Bidang Usaha">
            <option value="">Pilih industri</option>
            <option value="Fashion">Fashion & Apparel</option>
            <option value="Food & Beverage">Food & Beverage</option>
            <option value="Technology">Technology & Gadgets</option>
            <option value="Beauty">Beauty & Cosmetics</option>
            <option value="Travel">Travel & Hospitality</option>
            <option value="Lifestyle">Lifestyle</option>
            <option value="Education">Education</option>
            <option value="Finance">Finance & Banking</option>
            <option value="Health">Health & Wellness</option>
            <option value="Entertainment">Entertainment</option>
            <option value="Other">Lainnya</option>
        </x-form.select>

        <x-form.input id="phone" type="tel" placeholder="0812-3456-7890">No. Telepon (Opsional)</x-form.input>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form.input id="location" placeholder="Jakarta, Indonesia">Lokasi (Opsional)</x-form.input>
            <x-form.input id="website" type="url" placeholder="https://perusahaan.com">Website (Opsional)</x-form.input>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form.input id="password" type="password" placeholder="••••••••">Password</x-form.input>
            <x-form.input id="password_confirmation" type="password" placeholder="••••••••">Konfirmasi Password</x-form.input>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-primary hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary dark:focus:ring-offset-gray-900 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0">
                Buat Akun Brand
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>
        
        <p class="mt-4 text-xs text-center text-gray-500 dark:text-gray-400">
            Dengan mendaftar, Anda menyetujui <a href="#" class="text-primary hover:underline">Syarat & Ketentuan</a> dan <a href="#" class="text-primary hover:underline">Kebijakan Privasi</a> kami.
        </p>
    </form>
</div>
@endsection
