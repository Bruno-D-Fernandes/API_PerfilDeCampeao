@php
    $maxWidthClass = match($maxWidth) {
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        default => 'sm:max-w-2xl',
    };

    $titleSizeClass = match($titleSize) {
        'sm' => 'text-sm',
        'md' => 'text-md',
        'lg' => 'text-lg',
        'xl' => 'text-xl',
        '2xl' => 'text-2xl',
        '3xl' => 'text-3xl',
        '4xl' => 'text-4xl',
        '5xl' => 'text-5xl',
        default => 'sm:text-xl',
    };

    $titleColorClass = match($titleColor) {
        'blue' => 'text-sky-600',
        'gray' => 'text-gray-900',
        default => 'text-emerald-600'
    }
@endphp

<div 
    id="{{ $name }}" 
    class="fixed inset-0 z-50 hidden overflow-y-auto overflow-x-hidden"
    aria-labelledby="modal-title" 
    role="dialog" 
    aria-modal="true"
>
    <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div 
            class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity" 
            aria-hidden="true"
            onclick="closeModal('{{ $name }}')"
        ></div>

        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

        <div class="relative inline-block transform overflow-hidden rounded-xl bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:align-middle {{ $maxWidthClass }} p-4">
            <div class="flex items-center justify-between pb-2 border-b border-gray-300">
                <h3 class="{{ $titleSizeClass }} font-semibold {{ $titleColorClass }} tracking-tight" id="modal-title">
                    {{ $title }}
                </h3>

                <button type="button" onclick="closeModal('{{ $name }}')" class="cursor-pointer text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="pt-2.5 pb-2.5">
                {{ $slot }}
            </div>

            @if(isset($footer))
                <div class="flex pt-3 justify-end border-t border-gray-300">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>