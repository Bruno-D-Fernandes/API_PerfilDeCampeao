<div {{ $attributes->merge(['class' => 'cursor-pointer bg-white p-2 border border-gray-100 relative group hover:bg-gray-50 transition flex flex-col gap-0.5']) }}>
    <div class="flex justify-between items-start">
        <span class="{{ $isToday 
            ? 'bg-emerald-500 text-white w-5 h-5 rounded-sm flex items-center justify-center font-bold text-sm' 
            : 'text-gray-700 font-medium text-sm w-5 h-5 flex items-center justify-center' 
        }}">
            {{ $day }}
        </span>
    </div>

    <div class="flex-1 flex flex-col gap-1 overflow-hidden">
        {{ $slot }}
    </div>
</div>