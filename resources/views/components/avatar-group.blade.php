@php
    $items = collect($items);

    $sizeClasses = match($size) {
        'sm' => 'w-[1.67vw] h-[1.67vw] text-[0.63vw]',
        'md' => 'w-[2.08vw] h-[2.08vw] text-[0.63vw]',
        'lg' => 'w-[2.92vw] h-[2.92vw] text-[0.73vw]',
        default => 'w-[2.08vw] h-[2.08vw] text-[0.63vw]',
    };
@endphp

<div class="flex -space-x-[0.63vw] rtl:space-x-reverse">
    @foreach(collect($items)->take($max) as $item)
        <x-avatar 
            :src="data_get($item, 'foto')" 
            :alt="data_get($item, 'nome') ?? 'User'" 
            :size="$size"
            class="border-[0.1vw] border-white" 
        />
    @endforeach

    @if($items->count() > $max)    
        <a href="#" class="flex items-center justify-center {{ $sizeClasses }} font-medium text-white bg-gray-600 border-[0.1vw] border-white rounded-full hover:bg-gray-800 z-10 transition-colors">
            +{{ $items->count() - $max }}
        </a>
    @endif
</div>