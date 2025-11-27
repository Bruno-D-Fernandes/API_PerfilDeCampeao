@if(count($eventos) > 0)
    @foreach($eventos as $evento)
        <x-event-item 
            :item="$evento"
        />
    @endforeach
@else
    <div class="text-center py-[0.52vw] text-gray-400 text-[0.63vw]">
        Nenhum evento para este dia.
    </div>
@endif