@php
    $theme = match($color) {
        'red' => [
            'input' => 'text-red-600 border-gray-300 focus:border-red-500 focus:ring-red-500',
            'label' => 'text-gray-700', // Label neutro é mais elegante, mas se quiser colorido use: text-red-700
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
        {{ $attributes->merge(['class' => "w-4 h-4 rounded-full focus:ring-1 {$theme['input']}"]) }}
    >
    
    <label for="{{ $id }}" class="select-none ms-2 text-md font-medium {{ $theme['label'] }}">
        {{ $label ?? $slot }}
    </label>
</div>