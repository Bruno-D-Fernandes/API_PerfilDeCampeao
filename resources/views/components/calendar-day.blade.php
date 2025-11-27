<div {{ $attributes->merge(['class' => 'cursor-pointer bg-white p-[0.21vw] border-[0.052vw] border-gray-100 relative group hover:bg-gray-50 transition flex flex-col gap-[0.1vw]']) }}>
    <div class="flex justify-between items-start">
        <span class="{{ $isToday 
            ? 'bg-emerald-500 text-white w-[1.04vw] h-[1.04vw] rounded-[0.25vw] flex items-center justify-center font-bold text-[0.63vw]' 
            : 'text-gray-700 font-medium text-[0.63vw] w-[0.83vw] h-[0.83vw] flex items-center justify-center' 
        }}">
            {{ $day }}
        </span>
    </div>

    <div class="flex-1 flex flex-col gap-[0.1vw] overflow-hidden">
        {{ $slot }}
    </div>
</div>