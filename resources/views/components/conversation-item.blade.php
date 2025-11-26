<div class="flex items-center justify-between bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer p-2">
    <div class="flex items-center gap-x-2 w-full">
        <div class="h-12 md:h-10 w-12 md:w-10 aspect-square rounded-full bg-gray-200">
            @if(false)
                <img src="{{ $chat->user->avatar }}" class="w-full h-full object-cover">
            @endif
        </div>

        <div class="w-full h-full flex flex-col justify-between">
            <h2 class="text-md md:text-sm font-medium tracking-tight text-gray-800 truncate">
                João Pedro Insano
            </h2>

            <h3 class="text-sm md:text-xs font-normal text-gray-500 truncate">
                Vai corinthians
            </h3>
        </div>
    </div>

    <div class="h-full flex flex-col items-end justify-center gap-y-1.5">
        <span class="text-xs font-normal text-gray-700 pl-4 md:pl-3">
            12:45
        </span>

        <div class="h-5 md:h-4 w-5 md:w-4 bg-emerald-500 flex items-center justify-center rounded-full">
            <span class="text-xs md:text-[9px] font-semibold text-white">
                3
            </span>
        </div>
    </div>
</div>