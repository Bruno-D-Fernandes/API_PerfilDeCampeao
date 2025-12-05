<div class="grid grid-cols-3 gap-[0.83vw] auto-rows-[1fr] h-full">
    @forelse($atletas as $atleta)
        <x-athlete-card :athlete="$atleta" class="!max-h-[11.3vw]" /> 

        @include('clube.partials.save-to-list-modal', ['atleta' => $atleta])
    @empty
        <div class="col-span-3 text-center py-[2.1vw] text-gray-500">
            Nenhum atleta encontrado com os filtros selecionados.
        </div>
    @endforelse
</div>