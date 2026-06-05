@extends('layouts.app')
@section('title', 'Dashboard Brand')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-900">Dashboard Brand</h2>
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="p-6 bg-white rounded-lg shadow">
            <p class="text-sm text-gray-500">Total Campaign</p>
            <p class="text-2xl font-bold">{{ auth()->user()->brandProfile?->total_campaigns ?? 0 }}</p>
        </div>
        <div class="p-6 bg-white rounded-lg shadow">
            <p class="text-sm text-gray-500">Total Spending</p>
            <p class="text-2xl font-bold">Rp {{ number_format(auth()->user()->brandProfile?->total_spent ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="p-6 bg-white rounded-lg shadow">
            <p class="text-sm text-gray-500">Rating</p>
            <p class="text-2xl font-bold">{{ auth()->user()->brandProfile?->rating_avg ?? 0 }}</p>
        </div>
        <div class="p-6 bg-white rounded-lg shadow">
            <p class="text-sm text-gray-500">Active Hirings</p>
            <p class="text-2xl font-bold">{{ auth()->user()->brandProfile?->hirings?->where('status', 'accepted')->count() ?? 0 }}</p>
        </div>
    </div>
</div>
@endsection
