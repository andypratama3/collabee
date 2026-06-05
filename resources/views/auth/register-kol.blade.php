@extends('layouts.guest')
@section('title', 'Daftar KOL - ' . config('app.name'))

@section('content')
<div class="w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-gray-900">Daftar sebagai KOL / Influencer</h2>
    <p class="mt-2 text-sm text-center text-gray-600">
        Sudah punya akun? <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500">Masuk</a>
    </p>

    <form method="POST" action="{{ route('register.kol') }}" class="mt-8 space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="block w-full mt-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="display_name" class="block text-sm font-medium text-gray-700">Nama Panggung / Display Name</label>
            <input id="display_name" type="text" name="display_name" value="{{ old('display_name') }}" required
                   class="block w-full mt-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('display_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                   class="block w-full mt-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
            <select id="category" name="category" required
                    class="block w-full mt-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Pilih kategori</option>
                <option value="beauty">Beauty</option>
                <option value="fashion">Fashion</option>
                <option value="tech">Tech</option>
                <option value="food">Food</option>
                <option value="travel">Travel</option>
                <option value="lifestyle">Lifestyle</option>
                <option value="sports">Sports</option>
                <option value="music">Music</option>
                <option value="gaming">Gaming</option>
                <option value="education">Education</option>
                <option value="business">Business</option>
                <option value="entertainment">Entertainment</option>
                <option value="parenting">Parenting</option>
                <option value="automotive">Automotive</option>
                <option value="photography">Photography</option>
            </select>
            @error('category') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="block w-full mt-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                   class="block w-full mt-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <button type="submit" class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Daftar sebagai KOL
        </button>
    </form>
</div>
@endsection
