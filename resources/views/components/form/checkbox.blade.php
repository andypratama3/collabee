@props(['id', 'name' => null, 'checked' => false])
<label class="relative inline-flex items-center group cursor-pointer select-none">
    <input id="{{ $id }}" name="{{ $name ?? $id }}" type="checkbox" {{ $checked ? 'checked' : '' }}
           {{ $attributes->merge(['class' => 'peer w-5 h-5 rounded-lg border-gray-300 dark:border-gray-600 text-primary shadow-sm focus:ring-4 focus:ring-primary/10 focus:ring-offset-0 transition-all duration-300 dark:bg-gray-800 hover:border-primary/50 dark:hover:border-primary/50 checked:shadow-primary/20']) }}>
    <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-gray-100 peer-checked:text-primary transition-colors duration-200">
        {{ $slot }}
    </span>
</label>
