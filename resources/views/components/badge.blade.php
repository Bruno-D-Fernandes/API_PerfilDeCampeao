@php
    $style = match($color) {
        'red' => [
            'textColor'   => 'text-red-400',
            'bgColor'     => 'bg-red-50',
            'borderColor' => 'border-red-200',
            'dotColor'    => 'bg-red-400',
        ],
        'blue' => [
            'textColor'   => 'text-blue-400',
            'bgColor'     => 'bg-blue-50',
            'borderColor' => 'border-blue-200',
            'dotColor'    => 'bg-blue-400',
        ],
        'green' => [
            'textColor'   => 'text-emerald-400',
            'bgColor'     => 'bg-emerald-50',
            'borderColor' => 'border-emerald-200',
            'dotColor'    => 'bg-emerald-400',
        ],
        default => [
            'textColor'   => 'text-gray-400',
            'bgColor'     => 'bg-gray-50',
            'borderColor' => 'border-gray-200',
            'dotColor'    => 'bg-gray-400',
        ]
    };

    $hasIcon = isset($icon);
@endphp

<span {{ $attributes->class([
    'inline-flex items-center rounded-2xl py-1.5 px-' . ($hasIcon ? '2' : '3.5') . ' text-xs font-medium',
    $style['bgColor'],
    $style['textColor'],
    $style['borderColor'] . ' ring-1 ring-inset' => $border, 
]) }}>
    @if($hasIcon)
        <span class="mr-1 flex h-4 w-4 shrink-0 items-center justify-center">
            {{ $icon }}
        </span>
    @else
        <span class="mr-1 h-1 w-1 rounded-full {{ $style['dotColor'] }}"></span>
    @endif

    {{ $slot }}

    @if($dismissable)
        <span class="ml-0.75 h-4 w-4 shrink-0 {{ $style['textColor'] }}">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x-icon lucide-circle-x"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
        </span>
    @endif
</span>