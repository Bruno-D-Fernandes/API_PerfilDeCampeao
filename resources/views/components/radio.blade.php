@php
    $theme = match($color) {
        'red' => [
            'input' => 'text-red-600 border-gray-300 focus:border-red-500 focus:ring-red-500',
            'label' => 'text-gray-700', 
        ],
        'blue' => [
            'input' => 'text-sky-600 border-gray-300 focus:border-sky-500 focus:ring-sky-500',
            'label' => 'text-gray-700',
        ],
        'green' => [
            'input' => 'text-emerald-600 border-gray-300 focus:border-emerald-500 focus:ring-emerald-500',
            'label' => 'text-gray-700',
        ],
        'white' => [
            'input' => 'text-white border-white bg-white focus:ring-offset-0 focus:border-white focus:ring-white checked:text-emerald-500',
            'label' => 'text-white',
        ],
        default => [
            'input' => 'text-gray-600 border-gray-300 focus:border-gray-500 focus:ring-gray-500',
            'label' => 'text-gray-700',
        ]
    };
@endphp

<div class="flex items-center">
    <input 
        type="radio" 
        id="{{ $id }}" 
        name="{{ $name }}" 
        value="{{ $value }}"
        {{ $attributes->merge(['class' => "w-[0.83vw] h-[0.83vw] rounded-full focus:ring-[0.052vw] {$theme['input']}"]) }}
    >
    
    <label for="{{ $id }}" class="select-none ms-[0.42vw] text-[0.83vw] font-medium {{ $theme['label'] }}">
        {{ $label ?? $slot }}
    </label>
</div>