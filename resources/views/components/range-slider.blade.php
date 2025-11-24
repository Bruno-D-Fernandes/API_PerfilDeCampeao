<div id="{{ $id }}" class="w-full mb-6 group">
    <div class="flex justify-between items-center mb-4">
        <label class="text-sm font-medium text-gray-900">{{ $label }}</label>
        
        <div class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded border border-emerald-100">
            <span class="display-min">{{ $min }}</span>{{ $unit }} - 
            <span class="display-max">{{ $max }}</span>{{ $unit }}
        </div>
    </div>

    <div class="relative w-full h-2 mt-2">
        <div class="absolute w-full h-2 bg-gray-200 rounded-full top-0 z-0"></div>

        <div class="range-track absolute h-2 bg-emerald-500 rounded-full top-0 z-10"></div>

        <input 
            type="range" 
            name="{{ $nameMin }}" 
            min="{{ $min }}" 
            max="{{ $max }}" 
            step="{{ $step }}" 
            value="{{ $min }}"
            class="input-min absolute w-full h-2 top-0 z-20 opacity-0 cursor-pointer pointer-events-none [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:h-5 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:bg-white [&::-webkit-slider-thumb]:border-2 [&::-webkit-slider-thumb]:border-emerald-500 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:shadow-md hover:[&::-webkit-slider-thumb]:scale-110 transition-all"
        >

        <input 
            type="range" 
            name="{{ $nameMax }}" 
            min="{{ $min }}" 
            max="{{ $max }}" 
            step="{{ $step }}" 
            value="{{ $max }}"
            class="input-max absolute w-full h-2 top-0 z-20 opacity-0 cursor-pointer pointer-events-none [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:h-5 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:bg-white [&::-webkit-slider-thumb]:border-2 [&::-webkit-slider-thumb]:border-emerald-500 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:shadow-md hover:[&::-webkit-slider-thumb]:scale-110 transition-all"
        >
    </div>
</div>

<script>
    (function() {
        const root = document.getElementById('{{ $id }}');
        const minInput = root.querySelector('.input-min');
        const maxInput = root.querySelector('.input-max');
        const track = root.querySelector('.range-track');
        const displayMin = root.querySelector('.display-min');
        const displayMax = root.querySelector('.display-max');
        
        const min = {{ $min }};
        const max = {{ $max }};
        const step = {{ $step }};
        
        const minGap = step; 

        function updateSlider() {
            let val1 = parseFloat(minInput.value);
            let val2 = parseFloat(maxInput.value);

            if (val2 - val1 < minGap) {
                if (this === minInput) {
                    minInput.value = val2 - minGap;
                } else {
                    maxInput.value = val1 + minGap;
                }
            }
            
            displayMin.textContent = minInput.value;
            displayMax.textContent = maxInput.value;

            fillColor();
        }

        function fillColor() {
            const val1 = parseFloat(minInput.value);
            const val2 = parseFloat(maxInput.value);
            
            const percent1 = ((val1 - min) / (max - min)) * 100;
            const percent2 = ((val2 - min) / (max - min)) * 100;

            track.style.left = percent1 + "%";
            track.style.width = (percent2 - percent1) + "%";
        }

        minInput.addEventListener('input', updateSlider);
        maxInput.addEventListener('input', updateSlider);

        fillColor();
    })();
</script>