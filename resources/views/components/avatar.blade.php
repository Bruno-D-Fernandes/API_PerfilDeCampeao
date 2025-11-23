@php
    $sizeClasses = match($size) {
        'sm' => 'w-8 h-8 text-xs',
        'md' => 'w-10 h-10 text-sm',
        'lg' => 'w-14 h-14 text-base',
        'xl' => 'w-20 h-20 text-xl',
        default => 'w-10 h-10 text-sm',
    };

    $initials = '';
    
    if (empty($src)) {
        $names = explode(' ', trim($alt));
        
        $first = $names[0][0] ?? '';
        
        $second = $names[1][0] ?? '';
        
        $initials = strtoupper($first . $second);
    }
@endphp

<div {{ $attributes->merge(['class' => "relative inline-flex items-center justify-center rounded-full object-cover ring-2 ring-white " . $sizeClasses . ($src ? '' : ' bg-gray-200 text-gray-600')]) }}>
    
    @if($src)
        <img class="w-full h-full rounded-full object-cover" src="{{ $src }}" alt="{{ $alt }}">
    @else
        <span class="font-medium leading-none">{{ $initials }}</span>
    @endif

    {{ $slot }}
</div>