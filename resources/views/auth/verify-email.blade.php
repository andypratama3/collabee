@extends('layouts.guest')
@section('title', 'Verifikasi Email - ' . config('app.name'))

@section('content')
<div class="w-full max-w-md text-center">
    <h2 class="text-2xl font-bold text-gray-900">Verifikasi Email Anda</h2>
    <p class="mt-4 text-gray-600">
        Kami telah mengirimkan link verifikasi ke <strong>{{ auth()->user()->email }}</strong>.
    </p>
    <p class="mt-2 text-sm text-gray-500">
        Klik link tersebut untuk mengaktifkan akun Anda.
    </p>

    <form method="POST" action="{{ route('verification.resend') }}" class="mt-6">
        @csrf
        <p class="text-sm text-gray-500">Tidak menerima email?
            <button type="submit" class="text-indigo-600 hover:text-indigo-500">Klik untuk kirim ulang</button>
        </p>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="mt-4">
        @csrf
        <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">Logout</button>
    </form>
</div>
@endsection
