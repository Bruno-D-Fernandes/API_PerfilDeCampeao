@php
    $theme = match($labelColor) {
        'red'   => ['label' => 'text-red-600',     'input' => 'focus:ring-red-500 focus:border-red-500'],
        'blue'  => ['label' => 'text-sky-600',     'input' => 'focus:ring-sky-500 focus:border-sky-500'],
        'green' => ['label' => 'text-emerald-500', 'input' => 'focus:ring-emerald-500 focus:border-emerald-500'],
        'white' => ['label' => 'text-white',       'input' => 'focus:ring-0 focus:ring-offset-0'],
        default => ['label' => 'text-gray-900',    'input' => 'focus:ring-gray-500 focus:border-gray-500'],
    };

    $sizeClass = match($textSize) {
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'md' => 'text-base',
        'lg' => 'text-lg',
        'xl' => 'text-xl',
        '2xl' => 'text-2xl',
        default => $textSize,
    };

    $isPassword = ($type === 'password');
    $isSelect   = ($type === 'select');
    $isDate     = ($type === 'date');
    $isTime     = ($type === 'time');

    $hasSlotIcon = isset($icon);

    $showIconColumn = $hasSlotIcon || $isDate || $isTime || $isPassword || (!$isSelect && !$hasSlotIcon);
@endphp

<div class="w-full flex flex-col gap-2">
    @if($label)
        <label for="{{ $id }}" class="block {{ $sizeClass }} font-medium {{ $theme['label'] }}">
            {{ $label }}      
        </label>
    @endif

    <div class="relative w-full">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-gray-500 z-10">
            @if($hasSlotIcon)
                <div class="w-5 h-5 flex items-center justify-center">
                    {{ $icon }}
                </div>
            @elseif($isDate)
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 lucide lucide-calendar-days-icon lucide-calendar-days"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
            @elseif($isTime)
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 lucide lucide-clock-icon lucide-clock"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg>
            @elseif($isPassword)
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            @elseif(!$isSelect) 
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m3.5 5.5 7.893 6.036a1 1 0 0 0 1.214 0L20.5 5.5M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z"/></svg>
            @endif
        </div>

        @if($isSelect)
            <x-select 
                {{ $attributes->merge([
                    'id' => $id, 
                    'name' => $name,
                    'class' => $theme['input'] . ' ' . ($hasSlotIcon ? 'ps-10' : ''),
                ]) }}
            >
                {{ $slot }}
            </x-select>
        @else
            <input 
                type="{{ $type }}" 
                id="{{ $id }}" 
                name="{{ $name }}"
                {{-- Adiciona onclick para abrir o calendário ao clicar no input inteiro (UX) --}}
                @if($isDate || $isTime) onclick="try { this.showPicker() } catch(e){}" @endif
                {{ $attributes->merge([
                    'class' => 'block w-full p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:border-1 ' . 
                    $theme['input'] . 
                    ($showIconColumn ? ' ps-10' : '') . 
                    ($isPassword ? ' pe-10' : '')
                ]) }}
            >
        @endif

        @if($isPassword)
            <button 
                type="button" 
                onclick="togglePasswordVisibility('{{ $id }}')"
                class="absolute inset-y-0 end-0 flex items-center pe-3.5 cursor-pointer text-gray-500 hover:text-gray-700 focus:outline-none z-20"
            >
                <svg id="{{ $id }}-eye-open" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                <svg id="{{ $id }}-eye-closed" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
            </button>
        @endif
    </div>

    <p id="{{ $id }}-error" class="text-sm text-red-600 hidden"></p>
</div>

@once
    <script>
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const eyeOpen = document.getElementById(inputId + '-eye-open');
            const eyeClosed = document.getElementById(inputId + '-eye-closed');

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>
@endonce