<div {{ $attributes->merge(['class' => 'cursor-pointer bg-white min-h-[140px] p-2 border border-gray-100 relative group hover:bg-gray-50 transition flex flex-col gap-1']) }}>
    <div class="flex justify-between items-start">
        <span class="{{ $isToday 
            ? 'bg-sky-500 text-white w-7 h-7 rounded-full flex items-center justify-center font-bold text-sm shadow-sm' 
            : 'text-gray-700 font-medium text-sm w-7 h-7 flex items-center justify-center' 
        }}">
            {{ $day }}
        </span>
    </div>

    <div class="flex-1 flex flex-col gap-1 mt-1 overflow-hidden">
        {{ $slot }}
    </div>
</div>