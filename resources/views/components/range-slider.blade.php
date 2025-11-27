@php
    $theme = match($color) {
        'white' => [
            'text'        => 'text-white',     
            'track_bg'    => 'bg-white/30',      
            'track_active'=> 'bg-white',              
            'thumb_bg'    => 'bg-gray-100',         
            'thumb_border'=> 'border-transparent', 
        ],
        default => [
            'text'        => 'text-gray-700',    
            'track_bg'    => 'bg-gray-200',     
            'track_active'=> 'bg-emerald-500',     
            'thumb_bg'    => 'bg-white',           
            'thumb_border'=> 'border-emerald-500',    
        ],
    };
@endphp

<div 
    id="{{ $id }}" 
    class="w-full group range-slider-container flex flex-col gap-y-[0.83vw]"
    data-min="{{ $min }}"
    data-max="{{ $max }}"
    data-step="{{ $step }}"
>
    <label class="text-[0.73vw] font-medium {{ $theme['text'] }}">
        {{ $label }} 

        @if($unit) <span class="opacity-80 text-[0.63vw] font-normal">({{ $unit }})</span> @endif
    </label>

    <div class="relative w-full h-[0.42vw]">
        <div class="absolute w-full h-[0.42vw] rounded-full top-0 z-0 {{ $theme['track_bg'] }}"></div>

        <div class="range-track absolute h-[0.42vw] rounded-full top-0 z-10 {{ $theme['track_active'] }}"></div>

        <div class="thumb-min absolute h-[1.04vw] w-[1.04vw] rounded-full shadow top-1/2 -translate-y-1/2 -ml-[0.52vw] z-20 pointer-events-none border-[0.1vw] {{ $theme['thumb_bg'] }} {{ $theme['thumb_border'] }}"></div>
        <div class="thumb-max absolute h-[1.04vw] w-[1.04vw] rounded-full shadow top-1/2 -translate-y-1/2 -ml-[0.52vw] z-20 pointer-events-none border-[0.1vw] {{ $theme['thumb_bg'] }} {{ $theme['thumb_border'] }}"></div>

        <input 
            type="range" 
            name="{{ $nameMin }}" 
            min="{{ $min }}" 
            max="{{ $max }}" 
            step="{{ $step }}" 
            value="{{ $min }}"
            oninput="updateRange('{{ $id }}')"
            class="input-min absolute w-full h-[0.42vw] top-0 z-30 opacity-0 cursor-pointer pointer-events-none [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:w-[1.04vw] [&::-webkit-slider-thumb]:h-[1.04vw] [&::-webkit-slider-thumb]:appearance-none"
        >

        <input 
            type="range" 
            name="{{ $nameMax }}" 
            min="{{ $min }}" 
            max="{{ $max }}" 
            step="{{ $step }}" 
            value="{{ $max }}"
            oninput="updateRange('{{ $id }}')"
            class="input-max absolute w-full h-[0.42vw] top-0 z-30 opacity-0 cursor-pointer pointer-events-none [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:w-[1.04vw] [&::-webkit-slider-thumb]:h-[1.04vw] [&::-webkit-slider-thumb]:appearance-none"
        >
    </div>

    <div class="flex justify-between items-center text-[0.63vw] font-medium {{ $theme['text'] }}">
        <span class="display-min">{{ $min }}</span>
        <span class="display-max">{{ $max }}</span>
    </div>
</div>

@once
<script>
    function updateRange(containerId) {
        const root = document.getElementById(containerId);

        const minInput = root.querySelector('.input-min');
        const maxInput = root.querySelector('.input-max');

        const thumbMin = root.querySelector('.thumb-min');
        const thumbMax = root.querySelector('.thumb-max');

        const track = root.querySelector('.range-track');

        const displayMin = root.querySelector('.display-min');
        const displayMax = root.querySelector('.display-max');

        const minLimit = parseFloat(root.dataset.min);
        const maxLimit = parseFloat(root.dataset.max);
        const step = parseFloat(root.dataset.step);
        const minGap = step;

        let val1 = parseFloat(minInput.value);
        let val2 = parseFloat(maxInput.value);

        if (val2 - val1 < minGap) {
            if (val1 > val2 - minGap) {
                minInput.value = val2 - minGap;
                val1 = parseFloat(minInput.value);
            }
            if (val2 < val1 + minGap) {
                maxInput.value = val1 + minGap;
                val2 = parseFloat(maxInput.value);
            }
        }

        const percent1 = ((val1 - minLimit) / (maxLimit - minLimit)) * 100;
        const percent2 = ((val2 - minLimit) / (maxLimit - minLimit)) * 100;

        thumbMin.style.left = percent1 + "%";
        thumbMax.style.left = percent2 + "%";

        track.style.left = percent1 + "%";
        track.style.width = (percent2 - percent1) + "%";

        displayMin.textContent = step < 1 ? val1.toFixed(2) : val1;
        displayMax.textContent = step < 1 ? val2.toFixed(2) : val2;

        if (val1 > (maxLimit - minLimit) / 2) {
            minInput.style.zIndex = 40;
            maxInput.style.zIndex = 30;
        } else {
            minInput.style.zIndex = 30;
            maxInput.style.zIndex = 40;
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.range-slider-container').forEach(el => {
            updateRange(el.id);
        });
    });
</script>
@endonce