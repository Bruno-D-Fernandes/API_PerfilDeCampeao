@php
    $colors = match ($type) {
        'success' => [
            'bg'      => 'bg-emerald-50',
            'border'  => 'border-emerald-400',
            'icon'    => 'text-emerald-600',
            'title'   => 'text-emerald-800',
            'message' => 'text-emerald-700',
            'close'   => 'text-emerald-500 hover:bg-emerald-100',
        ],
        'error' => [
            'bg'      => 'bg-red-50',
            'border'  => 'border-red-400',
            'icon'    => 'text-red-600',
            'title'   => 'text-red-800',
            'message' => 'text-red-700',
            'close'   => 'text-red-500 hover:bg-red-100',
        ],
        'warning' => [
            'bg'      => 'bg-amber-50',
            'border'  => 'border-amber-400',
            'icon'    => 'text-amber-600',
            'title'   => 'text-amber-800',
            'message' => 'text-amber-700',
            'close'   => 'text-amber-500 hover:bg-amber-100',
        ],
        default => [
            'bg'      => 'bg-sky-50',
            'border'  => 'border-sky-400',
            'icon'    => 'text-sky-600',
            'title'   => 'text-sky-800',
            'message' => 'text-sky-700',
            'close'   => 'text-sky-500 hover:bg-sky-100',
        ],
    };
@endphp

<div 
    class="toast-alert w-full max-w-[23.33vw] flex items-start p-[0.63vw] mb-[0.63vw] rounded-[0.42vw] border-[0.1vw] transition-opacity duration-300 ease-out 
        {{ $colors['bg'] }} {{ $colors['border'] }}"
    role="alert"
>
    <div class="inline-flex items-center justify-center flex-shrink-0 w-[1.25vw] h-[1.25vw] mt-[0.1vw] {{ $colors['icon'] }}">
        {{-- Ícone --}}
        @switch($type)
            @case('success')
                <svg class="w-[1.25vw] h-[1.25vw]" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" 
                        clip-rule="evenodd"/>
                </svg>
                @break

            @case('error')
                <svg class="w-[1.25vw] h-[1.25vw]" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" 
                        clip-rule="evenodd"/>
                </svg>
                @break

            @case('warning')
                <svg class="w-[1.25vw] h-[1.25vw]" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" 
                        clip-rule="evenodd"/>
                </svg>
                @break

            @default
                <svg class="w-[1.25vw] h-[1.25vw]" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd"/>
                </svg>
        @endswitch
    </div>

    <div class="ml-[0.63vw] text-[0.73vw] font-medium flex-1">
        @if($title)
            <div class="font-semibold mb-[0.21vw] {{ $colors['title'] }}">
                {{ $title }}
            </div>
        @endif

        <div class="{{ $colors['message'] }}">
            {{ $message ?? $slot }}
        </div>
    </div>

    @if($dismissible)
        <button 
            type="button" 
            onclick="dismissToast(this)"
            class="cursor-pointer ml-auto -mx-[0.21vw] -my-[0.21vw] p-[0.21vw] rounded-[0.42vw] focus:outline-none h-[1.46vw] w-[1.46vw] flex items-center justify-center {{ $colors['close'] }} pointer-events-auto transition-all duration-300 ease-out opacity-100 translate-y-0"
        >
            <svg class="w-[0.63vw] h-[0.63vw]" viewBox="0 0 14 14" fill="none">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    @endif
</div>

@once
<script>
    function dismissToast(button) {
        const toast = button.closest('.toast-alert');

        if (!toast) return;

        toast.classList.add("opacity-0", "translate-y-[0.42vw]");
        setTimeout(() => toast.remove(), 300);
    }
</script>
@endonce