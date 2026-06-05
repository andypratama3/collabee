@extends('layouts.guest')
@section('title', 'Lupa Password - ' . config('app.name'))

@section('content')
<div class="w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-gray-900">Lupa Password</h2>
    <p class="mt-2 text-sm text-center text-gray-600">
        Masukkan email Anda dan kami akan mengirimkan link reset password.
    </p>

    @if (session('status'))
        <div class="mt-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="mt-8 space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="block w-full mt-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Kirim Link Reset Password
        </button>
    </form>
</div>
@endsection
