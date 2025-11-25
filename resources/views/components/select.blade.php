<select 
    id="{{ $id }}" 
    name="{{ $name }}"
    {{ $attributes->merge(['class' => 'block w-full p-2 text-sm text-gray-900 bg-gray-50 rounded-lg']) }}
>
    {{ $slot }}
</select>