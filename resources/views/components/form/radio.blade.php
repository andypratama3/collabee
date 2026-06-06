@props(['id', 'name' => null, 'value' => null, 'checked' => false])
<label class="inline-flex items-center group cursor-pointer">
    <input id="{{ $id }}" name="{{ $name ?? $id }}" type="radio" value="{{ $value }}" {{ $checked ? 'checked' : '' }}
           {{ $attributes->merge(['class' => 'w-5 h-5 border-gray-300 dark:border-gray-700 text-primary shadow-sm focus:ring-primary/20 focus:ring-offset-0 transition-all duration-200 dark:bg-gray-900']) }}>
    <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-primary transition-colors">
        {{ $slot }}
    </span>
</label>
