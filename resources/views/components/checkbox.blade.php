@php
    $style = match($color) {
        'red' => [
            'borderColor'  => 'border-red-500/80',
            'checkedColor' => 'text-red-600',
            'focusBorder'  => 'focus:border-red-500',
            'labelColor'   => 'text-red-600/80',
        ],
        'blue' => [
            'borderColor'  => 'border-sky-500/80',
            'checkedColor' => 'text-sky-600',
            'focusBorder'  => 'focus:border-sky-500',
            'labelColor'   => 'text-sky-600/80',
        ],
        'green' => [
            'borderColor'  => 'border-emerald-500/80',
            'checkedColor' => 'text-emerald-600',
            'focusBorder'  => 'focus:border-emerald-500',
            'labelColor'   => 'text-emerald-600/80',
        ],
        default => [
            'borderColor'  => 'border-gray-500/80',
            'checkedColor' => 'text-gray-600',
            'focusBorder'  => 'focus:border-gray-500',
            'labelColor'   => 'text-gray-600/80',
        ]
    };
@endphp

<div class="flex items-center">
    <input 
        id="checkbox" 
        type="checkbox" 
        value="" 
        class="w-4 h-4 rounded border border-[1px] {{ $style['borderColor'] }} {{ $style['checkedColor'] }} {{ $style['focusBorder'] }} focus:ring-0 focus:ring-offset-0"
    >
    
    <label for="checkbox" class="select-none ms-2 text-md font-medium {{ $style['labelColor'] }}">
        @if($label)
            {{ $label }}
        @elseif(isset($link))
            {{ $link }}
        @endif
    </label>
</div>