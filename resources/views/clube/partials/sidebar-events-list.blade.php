@forelse($eventos as $evento)
    <x-event-item :item="$evento" />
@empty
    <div class="p-[0.83vw] text-center text-gray-400 text-[0.63vw] italic">
        {{ $emptyMessage ?? 'Nenhum evento encontrado.' }}
    </div>
@endforelse