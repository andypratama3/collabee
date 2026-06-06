@props(['variant' => 'primary'])

@php
    $variants = [
        'primary' => 'bg-primary-50/80 text-primary-700 ring-primary-200/50 dark:bg-primary-900/30 dark:text-primary-400 dark:ring-primary-700/30',
        'success' => 'bg-emerald-50/80 text-emerald-700 ring-emerald-200/50 dark:bg-emerald-900/30 dark:text-emerald-400 dark:ring-emerald-700/30',
        'warning' => 'bg-amber-50/80 text-amber-700 ring-amber-200/50 dark:bg-amber-900/30 dark:text-amber-400 dark:ring-amber-700/30',
        'danger' => 'bg-rose-50/80 text-rose-700 ring-rose-200/50 dark:bg-rose-900/30 dark:text-rose-400 dark:ring-rose-700/30',
        'info' => 'bg-sky-50/80 text-sky-700 ring-sky-200/50 dark:bg-sky-900/30 dark:text-sky-400 dark:ring-sky-700/30',
        'gray' => 'bg-slate-50/80 text-slate-700 ring-slate-200/50 dark:bg-slate-800 dark:text-slate-400 dark:ring-slate-600/30',
    ];

    $classes = $variants[$variant] ?? $variants['primary'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold ring-1 ring-inset backdrop-blur-sm $classes"]) }}>
    {{ $slot }}
</span>
