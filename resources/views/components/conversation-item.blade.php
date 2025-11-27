<div class="flex items-center justify-between bg-gray-50 rounded-[0.42vw] hover:bg-gray-100 transition-colors cursor-pointer p-[0.42vw]">
    <div class="flex items-center gap-x-[0.42vw] w-full">
        <div class="h-[2.08vw] w-[2.08vw] aspect-square rounded-full bg-gray-200">
            @if(false)
                <img src="{{ $chat->user->avatar }}" class="w-full h-full object-cover">
            @endif
        </div>

        <div class="w-full h-full flex flex-col justify-between">
            <h2 class="text-[0.73vw] font-medium tracking-tight text-gray-800 truncate">
                João Pedro Insano
            </h2>

            <h3 class="text-[0.63vw] font-normal text-gray-500 truncate">
                Vai corinthians
            </h3>
        </div>
    </div>

    <div class="h-full flex flex-col items-end justify-center gap-y-[0.31vw]">
        <span class="text-[0.63vw] font-normal text-gray-700 pl-[0.63vw]">
            12:45
        </span>

        <div class="h-[0.83vw] w-[0.83vw] bg-emerald-500 flex items-center justify-center rounded-full">
            <span class="text-[0.47vw] font-semibold text-white">
                3
            </span>
        </div>
    </div>
</div>