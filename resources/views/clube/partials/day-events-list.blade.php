@if(count($eventos) > 0)
    @foreach($eventos as $evento)
        <x-event-item 
            :item="null"
        />
    @endforeach
@else
    <div class="text-center py-4 md:py-2.5 text-gray-400 text-sm md:text-xs">
        Nenhum evento para este dia.
    </div>
@endif