<select 
    id="{{ $id }}" 
    name="{{ $name }}"
    {{ $attributes->merge(['class' => 'block w-full p-[0.42vw] text-[0.73vw] text-gray-900 bg-gray-50 rounded-[0.42vw] border-[0.052vw] border-gray-300 focus:border-emerald-500 transition-colors focus:outline-none']) }}
>
    {{ $slot }}
</select>