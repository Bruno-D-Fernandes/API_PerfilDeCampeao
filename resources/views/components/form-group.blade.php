@php
    $theme = match($labelColor) {
        'red'   => ['label' => 'text-red-600',      'input' => 'focus:ring-red-500 focus:border-red-500'],
        'blue'  => ['label' => 'text-sky-600',      'input' => 'focus:ring-sky-500 focus:border-sky-500'],
        'green' => ['label' => 'text-emerald-500',  'input' => 'focus:ring-emerald-500 focus:border-emerald-500'],
        'white' => ['label' => 'text-white',        'input' => 'focus:ring-0 focus:ring-offset-0'], 
        default => ['label' => 'text-gray-900',     'input' => 'focus:ring-gray-500 focus:border-gray-500'],
    };

    $sizeClass = match($textSize) {
        'xs'      => 'text-[0.63vw]',
        'sm'      => 'text-[0.73vw]',
        'md'      => 'text-[0.83vw]', 
        'lg'      => 'text-[0.94vw]',
        'xl'      => 'text-[1.04vw]',
        '2xl'     => 'text-[1.25vw]',
        'default' => $textSize,
        default   => 'text-[0.83vw]',
    };

    $isPassword = ($type === 'password');
    $isSelect   = ($type === 'select');
    $isDate     = ($type === 'date');
    $isTime     = ($type === 'time');
    $isFile     = ($type === 'file');

    $hasSlotIcon = isset($icon);

    $showIconColumn = ($hasSlotIcon || $isDate || $isTime || $isPassword || (!$isSelect && !$hasSlotIcon && !$isFile)) && !$isFile;
@endphp

<div class="w-full flex flex-col gap-[0.42vw]">
    @if($label)
        <label for="{{ $id }}" class="block {{ $sizeClass }} font-medium {{ $theme['label'] }}">
            {{ $label }}      
        </label>
    @endif

    <div class="relative w-full">
        @if(!$isFile)
            <div class="absolute inset-y-0 start-0 flex items-center ps-[0.73vw] pointer-events-none text-gray-500 z-10">
                @if($hasSlotIcon)
                    <div class="w-[1.04vw] h-[1.04vw] flex items-center justify-center">
                        {{ $icon }}
                    </div>
                @elseif($isDate)
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="w-[1.04vw] h-[1.04vw] lucide lucide-calendar-days stroke-[0.1vw]"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                @elseif($isTime)
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="w-[1.04vw] h-[1.04vw] lucide lucide-clock stroke-[0.1vw]"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg>
                @elseif($isPassword)
                    <svg class="w-[1.04vw] h-[1.04vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                @elseif(!$isSelect) 
                    <svg class="w-[1.04vw] h-[1.04vw] stroke-[0.1vw]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m3.5 5.5 7.893 6.036a1 1 0 0 0 1.214 0L20.5 5.5M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z"/></svg>
                @endif
            </div>
        @endif

        @if($isSelect)
            <x-select 
                {{ $attributes->merge([
                    'id' => $id, 
                    'name' => $name,
                    'class' => $theme['input'] . ' ' . ($hasSlotIcon ? 'ps-[2.08vw]' : ''),
                ]) }}
            >
                {{ $slot }}
            </x-select>
        @else
            <input 
                type="{{ $type }}" 
                id="{{ $id }}" 
                name="{{ $name }}"
                @if($isDate || $isTime) onclick="try { this.showPicker() } catch(e){}" @endif
                {{ $attributes->merge([
                    'class' => $isFile 
                        ? 'block w-full text-[0.73vw] text-gray-900 border-[0.052vw] border-gray-300 rounded-[0.42vw] cursor-pointer bg-gray-50 focus:outline-none focus:border-gray-500 focus:ring-[0.052vw] focus:ring-gray-500 placeholder:text-gray-400 file:mr-[0.83vw] file:py-[0.42vw] file:px-[0.83vw] file:rounded-l-[0.42vw] file:border-0 file:text-[0.73vw] file:font-semibold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300'
                        : 'block w-full p-[0.52vw] text-[0.73vw] text-gray-900 bg-gray-50 border-[0.052vw] border-gray-300 rounded-[0.42vw] focus:border-[0.052vw] ' . 
                          $theme['input'] . 
                          ($showIconColumn ? ' ps-[2.08vw]' : '') . 
                          ($isPassword ? ' pe-[2.08vw]' : '')
                ]) }}
            >
        @endif

        @if($isPassword)
            <button 
                type="button" 
                onclick="togglePasswordVisibility('{{ $id }}')"
                class="absolute inset-y-0 end-0 flex items-center pe-[0.73vw] cursor-pointer text-gray-500 hover:text-gray-700 focus:outline-none z-20"
            >
                <svg id="{{ $id }}-eye-open" class="w-[1.04vw] h-[1.04vw] stroke-[0.1vw]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                <svg id="{{ $id }}-eye-closed" class="w-[1.04vw] h-[1.04vw] hidden stroke-[0.1vw]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
            </button>
        @endif
    </div>

    <p id="{{ $id }}-error" class="text-[0.73vw] text-red-600 hidden"></p>
</div>

@once
<script>
    function togglePasswordVisibility(id) {
        const input = document.getElementById(id);
        const eyeOpen = document.getElementById(id + "-eye-open");
        const eyeClosed = document.getElementById(id + "-eye-closed");

        if (!input) return;

        if (input.type === "password") {
            input.type = "text";
            eyeOpen.classList.add("hidden");
            eyeClosed.classList.remove("hidden");
        } else {
            input.type = "password";
            eyeClosed.classList.add("hidden");
            eyeOpen.classList.remove("hidden");
        }
    }
</script>
@endonce