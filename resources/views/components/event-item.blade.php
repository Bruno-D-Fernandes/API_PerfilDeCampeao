@php
    use Carbon\Carbon;

    $data = (object) $item;

    $title = $data->titulo ?? $data->title ?? 'Sem título';
    $location = $data->local ?? $data->location ?? 'Local não definido';
    $colorName = $data->cor ?? $data->color ?? 'emerald';
    
    $rawDate = $data->data ?? $data->date ?? now();
    $date = $rawDate instanceof Carbon ? $rawDate : Carbon::parse($rawDate);

    $month = $date->translatedFormat('M');
    $day = $date->format('d');
    
    $timeLabel = $date->isToday() 
        ? 'Hoje, ' . $date->format('H:i') 
        : $date->format('d/m • H:i');

    $themes = [
        'red'     => ['box' => 'bg-red-50 text-red-600 border-red-100',       'hover' => 'group-hover:text-red-500'],
        'sky'     => ['box' => 'bg-sky-50 text-sky-600 border-sky-100',       'hover' => 'group-hover:text-sky-500'],
        'blue'    => ['box' => 'bg-blue-50 text-blue-600 border-blue-100',     'hover' => 'group-hover:text-blue-500'],
        'yellow'  => ['box' => 'bg-yellow-50 text-yellow-600 border-yellow-100', 'hover' => 'group-hover:text-yellow-500'],
        'emerald' => ['box' => 'bg-emerald-50 text-emerald-600 border-emerald-100','hover' => 'group-hover:text-emerald-500'],
    ];

    $theme = $themes[$colorName] ?? $themes['emerald'];
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center justify-between group cursor-pointer hover:bg-gray-50 p-2 md:p-1 -mx-2 rounded-lg md:rounded-md transition-colors']) }}>
    <div class="flex gap-3 md:gap-2 items-center">
        <div class="flex flex-col items-center justify-center gap-1 md:gap-0.5 w-[3rem] md:w-[2rem] aspect-square rounded-lg border {{ $theme['box'] }}">
            <span class="text-xs md:text-[8px] font-bold uppercase leading-none mt-0.5">
                {{ $month }}
            </span>
            
            <span class="text-sm md:text-xs font-bold leading-none">
                {{ $day }}
            </span>
        </div>

        <div class="flex flex-col justify-center py-0.5 md:py-0"> 
            <span class="text-sm md:text-xs font-bold text-gray-800 {{ $theme['hover'] }} transition-colors truncate">
                {{ $title }}
            </span>

            <span class="text-xs md:text-[8px] text-gray-500 truncate">
                {{ $location }} - {{ $timeLabel }}
            </span>
        </div>
    </div>

    <div class="flex items-center gap-1.5 md:gap-0.5">
        <x-icon-button color="blue" class="!p-1">
            <svg class="h-4 w-4 md:h-3 md:w-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
        </x-icon-button>

        <x-icon-button color="red" class="!p-1">
            <svg class="h-4 w-4 md:h-3 md:w-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-icon lucide-trash"><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
        </x-icon-button>
    </div>
</div>