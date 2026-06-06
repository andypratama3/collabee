@props(['id', 'name' => null, 'value' => '', 'rows' => 4, 'placeholder' => '', 'label' => null])
<div class="group">
    @if($label || $slot->isNotEmpty())
        <label for="{{ $id }}" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5 transition-colors duration-200 group-focus-within:text-primary">
            {{ $label ?? $slot }}
        </label>
    @endif
    <div class="relative">
        <textarea id="{{ $id }}" name="{{ $name ?? $id }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}"
                  {{ $attributes->whereDoesntStartWith('class') }}
                  @class([
                      'block w-full rounded-xl border-gray-200 dark:border-gray-700/80 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm py-3 px-4 text-sm leading-relaxed text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 shadow-sm transition-all duration-300 focus:border-primary focus:ring-4 focus:ring-primary/10 focus:shadow-md focus:outline-none resize-y hover:border-gray-300 dark:hover:border-gray-600',
                      'border-red-300 dark:border-red-700/80 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500/10 focus:shadow-red-100/50 dark:focus:shadow-red-900/20' => $errors->has($name ?? $id),
                      $attributes->get('class'),
                  ])>{{ old($name ?? $id, $value) }}</textarea>
    </div>
    @error($name ?? $id)
        <p class="mt-1.5 text-xs font-medium text-red-600 dark:text-red-400 flex items-center gap-1 transition-all duration-200">
            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"/>
            </svg>
            {{ $message }}
        </p>
    @enderror
</div>
