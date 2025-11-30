<div class="grid grid-cols-3 gap-[0.83vw] flex-grow">
    @forelse($atletas as $atleta)
        <x-athlete-card :athlete="$atleta" /> 

        @include('clube.partials.save-to-list-modal', ['atleta' => $atleta])
    @empty
        <div class="col-span-3 text-center py-10 text-gray-500">
            Nenhum atleta encontrado com os filtros selecionados.
        </div>
    @endforelse
</div>