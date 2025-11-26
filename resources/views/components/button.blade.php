@php
    $colors = [
        'blue'   => 'bg-sky-300 text-white hover:bg-sky-500 focus:ring-sky-500',
        'red' => 'bg-red-300 text-white hover:bg-red-500 focus:ring-red-500',
        'green' => 'bg-emerald-300 text-white hover:bg-emerald-500',
        'gray' => 'bg-gray-50 border-1 border-gray-300 text-gray-700 hover:bg-gray-200 focus:border-gray-400 focus:ring-0 focus:ring-offset-0',
        'admin' => 'bg-sky-500 text-white hover:bg-sky-600',
        'clube' => 'bg-emerald-500 text-white hover:bg-emerald-600',
        'none' => '',
    ];

    $sizes = [
        'xs' => 'px-2 py-0.5 text-[8px]',
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-6 py-3.5 text-base',
        'xl' => 'px-8 py-4.5 text-md'
    ];

    $baseClasses = 'cursor-pointer inline-flex items-center justify-center font-medium rounded-lg ' . ($color == 'none' ? ' ' : 'shadow-xs ') . 'focus:outline-none transition-transform hover:-translate-y-0.5 transition-colors disabled:opacity-50 disabled:cursor-not-allowed';
    
    $classes = $baseClasses . ' ' . 
               ($colors[$color] ?? $variants['primary']) . ' ' . 
               ($sizes[$size]) . ' ' . 
               ($full ? 'w-full' : '');
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if(isset($icon))
        <span class="mr-2 -ml-1">
            {{ $icon }}
        </span>
    @endif

    {{ $slot }}
</button>