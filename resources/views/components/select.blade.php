<select 
    id="{{ $id }}" 
    name="{{ $name }}"
    {{ $attributes->merge(['class' => 'block w-full p-2.5 text-sm text-gray-900 bg-gray-50 border-none rounded-lg']) }}
>
    {{ $slot }}
</select>