@props([
    'variant' => 'text',
    'count' => 1,
    'class' => '',
])

@php
    $variants = [
        'text' => 'h-4 rounded w-full',
        'title' => 'h-6 rounded w-3/4',
        'avatar' => 'w-10 h-10 rounded-full shrink-0',
        'avatar-lg' => 'w-16 h-16 rounded-full shrink-0',
        'button' => 'h-10 rounded-lg w-24',
        'card' => 'h-48 rounded-xl w-full',
        'table-row' => 'h-12 rounded w-full',
        'badge' => 'h-6 rounded-full w-20',
    ];

    $classes = $variants[$variant] ?? $variants['text'];
@endphp

@if ($count > 1)
    <div class="space-y-3 {{ $class }}">
        @for ($i = 0; $i < $count; $i++)
            <div class="animate-pulse bg-gray-200 dark:bg-gray-700 {{ $classes }}"></div>
        @endfor
    </div>
@else
    <div class="animate-pulse bg-gray-200 dark:bg-gray-700 {{ $classes }} {{ $class }}"></div>
@endif
