@props([
    'variant' => 'text',
    'count' => 1,
    'class' => '',
])

@php
    $variants = [
        'text' => 'h-4 rounded-lg w-full',
        'title' => 'h-6 rounded-lg w-3/4',
        'avatar' => 'w-10 h-10 rounded-full shrink-0',
        'avatar-lg' => 'w-16 h-16 rounded-full shrink-0',
        'button' => 'h-10 rounded-xl w-24',
        'card' => 'h-48 rounded-2xl w-full',
        'table-row' => 'h-12 rounded-lg w-full',
        'badge' => 'h-6 rounded-full w-20',
    ];

    $classes = $variants[$variant] ?? $variants['text'];
@endphp

@if ($count > 1)
    <div class="space-y-3 {{ $class }}">
        @for ($i = 0; $i < $count; $i++)
            <div class="relative overflow-hidden bg-gray-200/70 dark:bg-gray-700/50 {{ $classes }}">
                <div class="absolute inset-0 -translate-x-full animate-[shimmer_2s_infinite] bg-gradient-to-r from-transparent via-white/40 dark:via-gray-600/40 to-transparent"></div>
            </div>
        @endfor
    </div>
@else
    <div class="relative overflow-hidden bg-gray-200/70 dark:bg-gray-700/50 {{ $classes }} {{ $class }}">
        <div class="absolute inset-0 -translate-x-full animate-[shimmer_2s_infinite] bg-gradient-to-r from-transparent via-white/40 dark:via-gray-600/40 to-transparent"></div>
    </div>
@endif

<style>
@keyframes shimmer {
    100% { transform: translateX(100%); }
}
</style>
