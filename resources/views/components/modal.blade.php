@php
    $maxWidthClass = match ($maxWidth) {
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        default => 'sm:max-w-2xl',
    };
@endphp

{{-- 1. WRAPPER GERAL (Escondido por padrão) --}}
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

        <div class="relative inline-block transform overflow-hidden rounded-xl bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:align-middle {{ $maxWidthClass }}">
            <div class="flex items-center justify-between p-4 border-b border-gray-300 bg-gray-50/50">
                <h3 class="text-2xl font-semibold text-gray-900 tracking-tight" id="modal-title">
                    {{ $title }}
                </h3>

                <button type="button" onclick="closeModal('{{ $name }}')" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="px-6 py-6">
                {{ $slot }}
            </div>

            @if(isset($footer))
                <div class="bg-gray-50 px-6 py-4 flex gap-2 justify-end border-t border-gray-300">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>