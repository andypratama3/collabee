@extends('layouts.guest')
@section('title', 'Login - ' . config('app.name'))

@section('content')
<div class="w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-gray-900">Masuk ke Akun</h2>
    <p class="mt-2 text-sm text-center text-gray-600">
        Belum punya akun?
        <a href="{{ route('register.brand') }}" class="text-indigo-600 hover:text-indigo-500">Daftar sebagai Brand</a>
        atau
        <a href="{{ route('register.kol') }}" class="text-indigo-600 hover:text-indigo-500">Daftar sebagai KOL</a>
    </p>

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="block w-full mt-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="block w-full mt-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
            </label>
            <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-500">Lupa password?</a>
        </div>

        <button type="submit" class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Masuk
        </button>
    </form>
</div>
@endsection
