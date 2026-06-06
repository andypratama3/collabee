@extends('layouts.guest')
@section('title', 'Login - ' . config('app.name'))

@section('content')
<div class="w-full">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Selamat Datang Kembali</h2>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            Belum punya akun? <br class="sm:hidden" />
            <a href="{{ route('register.brand') }}" class="font-semibold text-primary hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 transition-colors">Daftar sebagai Brand</a> atau 
            <a href="{{ route('register.kol') }}" class="font-semibold text-primary hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 transition-colors">Daftar sebagai KOL</a>
        </p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div class="space-y-1">
            <x-form.input id="email" type="email" placeholder="name@company.com">Alamat Email</x-form.input>
        </div>

        <div class="space-y-1">
            <div class="flex items-center justify-between">
                <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Password</label>
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 transition-colors">Lupa password?</a>
            </div>
            <div class="relative">
                <input id="password" name="password" type="password" required
                       class="block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 py-2.5 px-4 text-sm leading-5 text-gray-900 dark:text-gray-100 placeholder-gray-400 shadow-sm transition-all duration-200 focus:border-primary focus:ring-4 focus:ring-primary/10 focus:outline-none"
                       placeholder="••••••••">
                @error('password')
                    <p class="mt-1.5 text-xs font-medium text-red-600 dark:text-red-400 transition-all duration-200">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center">
            <label class="flex items-center gap-3 cursor-pointer group">
                <div class="relative flex items-center justify-center">
                    <input type="checkbox" name="remember" class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 checked:border-primary checked:bg-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all">
                    <svg class="absolute w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-200 transition-colors">Ingat saya</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-primary hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary dark:focus:ring-offset-gray-900 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0">
                Masuk ke Dashboard
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>
    </form>
    
    <div class="mt-8 relative">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-4 bg-white dark:bg-gray-900 text-gray-500 dark:text-gray-400">Platform kolaborasi terpercaya</span>
        </div>
    </div>
</div>
@endsection
