@props(['type' => 'button', 'variant' => 'primary', 'loading' => false, 'size' => 'md', 'href' => null])
@php
  $base = 'inline-flex items-center justify-center font-semibold transition-all duration-300 rounded-xl focus:outline-none focus:ring-4 disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none active:scale-[0.97] hover:-translate-y-0.5';

  $sizes = [
    'sm' => 'px-3.5 py-1.5 text-xs gap-1.5',
    'md' => 'px-5 py-2.5 text-sm gap-2',
    'lg' => 'px-7 py-3 text-base gap-2.5',
  ];

  $variants = [
    'primary' => 'text-white bg-gradient-to-b from-primary to-primary-dark hover:from-primary-dark hover:to-primary-dark focus:ring-primary/20 shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30',
    'secondary' => 'text-primary bg-primary-50 dark:bg-primary-900/20 hover:bg-primary-100 dark:hover:bg-primary-900/30 focus:ring-primary/20 ring-1 ring-primary-200/50 dark:ring-primary-700/30',
    'ghost' => 'text-gray-700 dark:text-gray-300 bg-transparent hover:bg-gray-100 dark:hover:bg-gray-800 focus:ring-gray-200 dark:focus:ring-gray-700',
    'danger' => 'text-white bg-gradient-to-b from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 focus:ring-red-500/20 shadow-lg shadow-red-500/20 hover:shadow-xl hover:shadow-red-500/25',
    'white' => 'text-gray-700 bg-white/90 backdrop-blur-sm border border-gray-200/60 hover:bg-white dark:bg-gray-800/90 dark:border-gray-700/60 dark:text-gray-300 dark:hover:bg-gray-800 focus:ring-gray-200 dark:focus:ring-gray-700 shadow-sm hover:shadow-md',
  ];

  $classes = ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "$base $classes"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "$base $classes"]) }} @if($loading) disabled @endif>
        @if($loading)
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>{{ $attributes->get('loading-text', 'Processing...') }}</span>
        @else
            {{ $slot }}
        @endif
    </button>
@endif
