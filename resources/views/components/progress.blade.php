@php
    $barColor = match($color) {
        'green' => 'bg-emerald-500',
        'blue'  => 'bg-blue-500',
        'red'   => 'bg-red-500',
        'yellow'=> 'bg-yellow-400',
        default => 'bg-gray-500',
    };
@endphp

<div {{ $attributes->merge(['class' => 'w-full']) }}>
    @if($label || $showValue)
        <div class="flex justify-between mb-1 md:mb-0.5">
            @if($label)
                <span class="text-sm md:text-xs font-medium text-gray-700">{{ $label }}</span>
            @endif

            @if($showValue)
                <span class="text-sm md:text-xs font-medium text-gray-700">{{ $percentage }}%</span>
            @endif
        </div>
    @endif

    <div class="w-full bg-gray-100 rounded-full h-2.5 md:h-1.5 border border-gray-100">
        <div 
            class="h-2.5 md:h-1.5 rounded-full transition-all duration-500 {{ $barColor }}" 
            style="width: {{ $percentage }}%"
        ></div>
    </div>
</div>