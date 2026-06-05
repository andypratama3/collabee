@extends('layouts.app')
@section('title', 'Dashboard KOL')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-900">Dashboard KOL</h2>
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="p-6 bg-white rounded-lg shadow">
            <p class="text-sm text-gray-500">Saldo Wallet</p>
            <p class="text-2xl font-bold">Rp {{ number_format(auth()->user()->kolProfile?->wallet_balance ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="p-6 bg-white rounded-lg shadow">
            <p class="text-sm text-gray-500">Pending Balance</p>
            <p class="text-2xl font-bold">Rp {{ number_format(auth()->user()->kolProfile?->pending_balance ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="p-6 bg-white rounded-lg shadow">
            <p class="text-sm text-gray-500">Campaign Done</p>
            <p class="text-2xl font-bold">{{ auth()->user()->kolProfile?->total_campaigns_done ?? 0 }}</p>
        </div>
        <div class="p-6 bg-white rounded-lg shadow">
            <p class="text-sm text-gray-500">Rating</p>
            <p class="text-2xl font-bold">{{ auth()->user()->kolProfile?->rating_avg ?? 0 }}</p>
        </div>
    </div>
</div>
@endsection
