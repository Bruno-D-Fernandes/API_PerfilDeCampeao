@php
    $colors = [
        'blue'    => 'bg-sky-300 text-white hover:bg-sky-500 focus:ring-sky-500',
        'red'     => 'bg-red-300 text-white hover:bg-red-500 focus:ring-red-500',
        'green'   => 'bg-emerald-300 text-white hover:bg-emerald-500',
        'gray'    => 'bg-gray-50 border-[0.052vw] border-gray-300 text-gray-700 hover:bg-gray-200 focus:border-gray-400 focus:ring-0 focus:ring-offset-0',
        'admin'   => 'bg-sky-500 text-white hover:bg-sky-600',
        'clube'   => 'bg-emerald-500 text-white hover:bg-emerald-600',
        'none'    => '',
    ];

    $sizes = [
        'sq' => 'p-[0.42vw] text-[0.42vw]',
        'xs' => 'px-[0.42vw] py-[0.1vw] text-[0.42vw]',
        'sm' => 'px-[0.63vw] py-[0.31vw] text-[0.63vw]',
        'md' => 'px-[0.83vw] py-[0.52vw] text-[0.73vw]',
        'lg' => 'px-[1.25vw] py-[0.73vw] text-[0.83vw]',
        'xl' => 'px-[1.67vw] py-[0.94vw] text-[0.94vw]'
    ];

    $baseClasses = 'cursor-pointer inline-flex items-center justify-center font-medium rounded-[0.42vw] ' . ($color == 'none' ? ' ' : 'shadow-xs ]') . 'focus:outline-none transition-transform hover:-translate-y-[0.1vw] transition-colors disabled:opacity-50 disabled:cursor-not-allowed';
    
    $classes = $baseClasses . ' ' . 
               ($colors[$color] ?? $variants['primary']) . ' ' . 
               ($sizes[$size]) . ' ' . 
               ($full ? 'w-full' : '');
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if(isset($icon))
        <span class="mr-[0.42vw] -ml-[0.21vw]">
            {{ $icon }}
        </span>
    @endif

    {{ $slot }}
</button>