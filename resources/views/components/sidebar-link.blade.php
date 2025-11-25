@php
    $classes = $active
        ? "w-full flex items-center p-3 rounded-md group {$activeClass}"
        : "w-full flex items-center p-3 rounded-md group transition-colors {$inactiveClass}";
@endphp

<li class="list-none">
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        <div class="flex items-center w-6 h-6 transition duration-75 {{ $active ? 'text-white' : 'text-inative group-hover:text-white' }}">
            {{ $slot }}
        </div>
        
        <span class="flex-1 ms-3 whitespace-nowrap font-medium text-xl {{ $active ? 'text-white' : 'text-inative group-hover:text-white' }}">
            {{ $label }}
        </span> 
    </a>
</li>