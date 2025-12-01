<button 
    type="button" 
    {{ $attributes->merge(['class' => 'cursor-pointer p-[0.42vw] rounded-[0.42vw] hover:bg-gray-100 focus:outline-none transition-colors duration-200 ' . $colorClasses()]) }}
>
    {{ $slot }}
</button>