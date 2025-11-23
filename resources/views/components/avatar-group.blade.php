@php
    $items = collect($items);

    $sizeClasses = match($size) {
        'sm' => 'w-8 h-8 text-xs',
        'md' => 'w-10 h-10 text-xs',
        'lg' => 'w-14 h-14 text-sm',
        default => 'w-10 h-10 text-xs',
    };
@endphp

<div class="flex -space-x-3 rtl:space-x-reverse">
    @foreach(collect($items)->take($max) as $item)
        <x-avatar 
            :src="data_get($item, 'foto')" 
            :alt="data_get($item, 'nome') ?? 'User'" 
            :size="$size"
            class="border-2 border-white" 
        />
    @endforeach

    @if($items->count() > $max)    
        <a href="#" class="flex items-center justify-center {{ $sizeClasses }} font-medium text-white bg-gray-600 border-2 border-white rounded-full hover:bg-gray-800 z-10 transition-colors">
            +{{ $items->count() - $max }}
        </a>
    @endif
</div>