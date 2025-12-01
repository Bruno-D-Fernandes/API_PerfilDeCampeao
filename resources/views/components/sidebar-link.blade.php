@php
    $classes = $active
        ? "w-full flex items-center p-[0.75vw] rounded-[0.31vw] group {$activeClass}"
        : "w-full flex items-center p-[0.75vw] rounded-[0.31vw] group transition-colors {$inactiveClass}";
@endphp

<li class="list-none">
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        <div class="flex items-center w-[1.04vw] h-[1.04vw] transition duration-75 {{ $active ? 'text-white' : 'text-inative group-hover:text-white' }}">
            {{ $slot }}
        </div>
        
        <span class="flex-1 ms-[0.63vw] whitespace-nowrap font-medium text-[0.73vw] {{ $active ? 'text-white' : 'text-inative group-hover:text-white' }}">
            {{ $label }}
        </span> 
    </a>
</li>