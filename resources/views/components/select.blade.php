<select 
    id="{{ $id }}" 
    name="{{ $name }}"
    {{ $attributes->merge(['class' => 'block w-full p-2 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:border-emerald-500 transition-colors focus:outline-none']) }}
>
    {{ $slot }}
</select>