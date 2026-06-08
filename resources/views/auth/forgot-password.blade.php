@extends('layouts.guest')
@section('title', 'Lupa Password - ' . config('app.name'))

@section('content')
<div class="w-full">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-500/20 to-orange-500/20 dark:from-amber-500/10 dark:to-orange-500/10 mb-4">
            <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Lupa Password?</h2>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            Tidak masalah. Masukkan email Anda dan kami akan mengirimkan link untuk reset password.
        </p>
    </div>

    @if (session('status'))
        <script>document.addEventListener('DOMContentLoaded', () => window.Swal && window.Swal.mixin({toast:true,position:'top-end',showConfirmButton:false,timer:5000,timerProgressBar:true}).fire({icon:'success',title:@json(session('status'))}));</script>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="block w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 dark:focus:border-primary-400 transition-all duration-200 text-sm"
                   placeholder="nama@email.com">
            @error('email') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="flex items-center justify-center gap-2 w-full px-4 py-3.5 text-sm font-bold text-white bg-gradient-to-r from-primary-600 to-indigo-600 rounded-xl hover:from-primary-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-900 transition-all duration-200 shadow-lg shadow-primary-500/25">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            Kirim Link Reset Password
        </button>

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors">
                ← Kembali ke halaman login
            </a>
        </div>
    </form>
</div>
@endsection
