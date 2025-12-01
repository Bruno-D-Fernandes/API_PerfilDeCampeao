@php
    use Carbon\Carbon;

    $title = $item->titulo;
    $location = $item->endereco_formatado; 
    $hexColor = $item->color;
    
    $rawDate = $item->data_hora_inicio;
    $date = $rawDate instanceof Carbon ? $rawDate : Carbon::parse($rawDate);

    $month = $date->translatedFormat('M');
    $day = $date->format('d');
    
    $timeLabel = $date->isToday() 
        ? 'Hoje, ' . $date->format('H:i') 
        : $date->format('d/m • H:i');
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center justify-between group cursor-pointer hover:bg-gray-50 p-[0.21vw] -mx-[0.42vw] rounded-[0.31vw] transition-colors']) }}>
    <div class="flex gap-[0.42vw] items-center flex-1 min-w-0 mr-[0.5vw]" onclick="showEventDetails({{ $item->id }})" >
        <div class="flex flex-col items-center justify-center gap-[0.1vw] w-[2vw] aspect-square rounded-[0.42vw] shrink-0"
             style="background-color: {{ $hexColor }}1A;">
            
            <span class="text-[0.55vw] font-bold uppercase leading-none mt-[0.1vw]" 
                  style="color: {{ $hexColor }}">
                {{ $month }}
            </span>
            
            <span class="text-[0.675vw] font-bold leading-none" 
                  style="color: {{ $hexColor }}">
                {{ $day }}
            </span>
        </div>

        <div class="flex flex-col justify-center min-w-0 flex-1"> 
            <span class="text-[0.675vw] font-semibold text-gray-800 transition-colors truncate block" 
                  title="{{ $title }}">
                {{ $title }}
            </span>

            <span class="text-[0.53vw] text-gray-500 truncate block" 
                  title="{{ $location }} - {{ $timeLabel }}">
                {{ $location }} - {{ $timeLabel }}
            </span>
        </div>
    </div>

    <div class="flex items-center gap-[0.1vw] shrink-0">
        <x-icon-button color="blue" class="!p-[0.32vw]" onclick="openEditModal({{ $item->id }})">
            <svg class="h-[0.73vw] w-[0.73vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
        </x-icon-button>

        <x-icon-button color="red" class="!p-[0.32vw]">
            <svg class="h-[0.73vw] w-[0.73vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-icon"><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
        </x-icon-button>
    </div>
</div>