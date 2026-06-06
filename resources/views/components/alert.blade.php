@props(['type' => 'info'])
@php
  $variants = [
    'info' => [
        'bg' => 'bg-blue-50/80 dark:bg-blue-900/20',
        'border' => 'border-blue-200/60 dark:border-blue-700/40',
        'text' => 'text-blue-800 dark:text-blue-300',
        'iconBg' => 'bg-blue-100 dark:bg-blue-800/40',
        'iconColor' => 'text-blue-600 dark:text-blue-400',
        'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
    ],
    'success' => [
        'bg' => 'bg-emerald-50/80 dark:bg-emerald-900/20',
        'border' => 'border-emerald-200/60 dark:border-emerald-700/40',
        'text' => 'text-emerald-800 dark:text-emerald-300',
        'iconBg' => 'bg-emerald-100 dark:bg-emerald-800/40',
        'iconColor' => 'text-emerald-600 dark:text-emerald-400',
        'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
    ],
    'error' => [
        'bg' => 'bg-red-50/80 dark:bg-red-900/20',
        'border' => 'border-red-200/60 dark:border-red-700/40',
        'text' => 'text-red-800 dark:text-red-300',
        'iconBg' => 'bg-red-100 dark:bg-red-800/40',
        'iconColor' => 'text-red-600 dark:text-red-400',
        'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
    ],
    'warning' => [
        'bg' => 'bg-amber-50/80 dark:bg-amber-900/20',
        'border' => 'border-amber-200/60 dark:border-amber-700/40',
        'text' => 'text-amber-800 dark:text-amber-300',
        'iconBg' => 'bg-amber-100 dark:bg-amber-800/40',
        'iconColor' => 'text-amber-600 dark:text-amber-400',
        'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'
    ],
  ];
  $variant = $variants[$type] ?? $variants['info'];
@endphp
<div {{ $attributes->merge(['class' => "flex items-start gap-3.5 p-4 rounded-2xl border backdrop-blur-sm {$variant['bg']} {$variant['border']} {$variant['text']} transition-all duration-300 shadow-sm"]) }} role="alert">
    <div class="shrink-0 mt-0.5 w-8 h-8 rounded-xl {{ $variant['iconBg'] }} flex items-center justify-center">
        <svg class="w-4.5 h-4.5 {{ $variant['iconColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $variant['icon'] }}"></path>
        </svg>
    </div>
    <div class="flex-1 text-sm font-medium leading-relaxed pt-1">
        {{ $slot }}
    </div>
</div>
