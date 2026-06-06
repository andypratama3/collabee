@props(['title' => null, 'subtitle' => null, 'footer' => null, 'noPadding' => false])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-900/80 backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg shadow-gray-200/50 dark:shadow-gray-900/30 overflow-hidden transition-all duration-300 hover:-translate-y-0.5 hover:shadow-2xl hover:shadow-gray-200/30 dark:hover:shadow-gray-900/40']) }}>
    @if($title || $subtitle)
        <div class="px-6 py-4 border-b border-gray-100/80 dark:border-gray-800/80">
            @if($title)
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $title }}</h3>
            @endif
            @if($subtitle)
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $subtitle }}</p>
            @endif
        </div>
    @endif

    <div class="{{ $noPadding ? '' : 'p-6' }}">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="px-6 py-4 bg-gray-50/50 dark:bg-gray-800/30 border-t border-gray-100/80 dark:border-gray-800/80">
            {{ $footer }}
        </div>
    @endif
</div>
