<button 
    type="button" 
    {{ $attributes->merge(['class' => 'cursor-pointer p-2 rounded-lg hover:bg-gray-100 focus:outline-none transition-colors duration-200 ' . $colorClasses()]) }}
>
    {{ $slot }}
</button>