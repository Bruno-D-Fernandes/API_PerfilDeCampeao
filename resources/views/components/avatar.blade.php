@php
    $sizeClasses = match($size) {
        'sm' => 'w-[1.67vw] h-[1.67vw] text-[0.63vw]',
        'md' => 'w-[2.08vw] h-[2.08vw] text-[0.73vw]',
        'lg' => 'w-[2.92vw] h-[2.92vw] text-[0.83vw]',
        'xl' => 'w-[4.17vw] h-[4.17vw] text-[1.04vw]',
        default => 'w-[2.08vw] h-[2.08vw] text-[0.73vw]',
    };

    $initials = '';
    
    if (empty($src)) {
        $names = explode(' ', trim($alt));
        
        $first = $names[0][0] ?? '';
        
        $second = $names[1][0] ?? '';
        
        $initials = strtoupper($first . $second);
    }
@endphp

<div {{ $attributes->merge(['class' => "relative inline-flex items-center justify-center rounded-full object-cover ring-[0.1vw] ring-white " . $sizeClasses . ($src ? '' : ' bg-gray-200 text-gray-600')]) }}>
    
    @if($src)
        <img class="w-full h-full rounded-full object-cover" src="{{ $src }}" alt="{{ $alt }}">
    @else
        <span class="font-medium leading-none">{{ $initials }}</span>
    @endif

    {{ $slot }}
</div>