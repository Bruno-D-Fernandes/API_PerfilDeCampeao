@php
    $style = match($color) {
        'red' => [
            'borderColor'  => 'border-red-500/80',
            'checkedColor' => 'text-red-600',
            'focusBorder'  => 'focus:border-red-500',
            'labelColor'   => 'text-red-600/80',
        ],
        'orange' => [
            'borderColor'  => 'border-orange-500/80',
            'checkedColor' => 'text-orange-600',
            'focusBorder'  => 'focus:border-orange-500',
            'labelColor'   => 'text-orange-600/80',
        ],
        'amber' => [
            'borderColor'  => 'border-amber-500/80',
            'checkedColor' => 'text-amber-600',
            'focusBorder'  => 'focus:border-amber-500',
            'labelColor'   => 'text-amber-600/80',
        ],
        'yellow' => [
            'borderColor'  => 'border-yellow-500/80',
            'checkedColor' => 'text-yellow-600',
            'focusBorder'  => 'focus:border-yellow-500',
            'labelColor'   => 'text-yellow-600/80',
        ],
        'teal' => [
            'borderColor'  => 'border-teal-500/80',
            'checkedColor' => 'text-teal-600',
            'focusBorder'  => 'focus:border-teal-500',
            'labelColor'   => 'text-teal-600/80',
        ],
        'cyan' => [
            'borderColor'  => 'border-cyan-500/80',
            'checkedColor' => 'text-cyan-600',
            'focusBorder'  => 'focus:border-cyan-500',
            'labelColor'   => 'text-cyan-600/80',
        ],
        'indigo' => [
            'borderColor'  => 'border-indigo-500/80',
            'checkedColor' => 'text-indigo-600',
            'focusBorder'  => 'focus:border-indigo-500',
            'labelColor'   => 'text-indigo-600/80',
        ],
        'violet' => [
            'borderColor'  => 'border-violet-500/80',
            'checkedColor' => 'text-violet-600',
            'focusBorder'  => 'focus:border-violet-500',
            'labelColor'   => 'text-violet-600/80',
        ],
        'purple' => [
            'borderColor'  => 'border-purple-500/80',
            'checkedColor' => 'text-purple-600',
            'focusBorder'  => 'focus:border-purple-500',
            'labelColor'   => 'text-purple-600/80',
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
        'white' => [
            'borderColor'  => '',
            'checkedColor' => '',
            'focusBorder'  => '',
            'labelColor'   => '',
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