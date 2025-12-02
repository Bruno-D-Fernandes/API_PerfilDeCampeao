<x-modal maxWidth="xl" name="save-to-list-{{ $atleta->id }}" title="Salvar em..." titleSize="[1.04vw]" titleColor="emerald">
    <div class="flex flex-col gap-[0.42vw]">
        <div class="max-h-[15.6vw] overflow-y-auto custom-scrollbar pr-[0.42vw]">
            <x-form id="save-list-form-{{ $atleta->id }}" class="save-list-form-container flex flex-col gap-[0.21vw]">
                @php
                    $listas = auth()->guard('club')->user()->listas ?? []; 
                @endphp

                @forelse($listas as $lista)
                    @include('clube.partials.save-to-list-item', ['lista' => $lista, 'atletaId' => $atleta->id])
                @empty
                    <div class="no-lists-message text-center py-[1vw] text-gray-500 text-[0.73vw]">
                        Nenhuma lista encontrada. Crie uma abaixo!
                    </div>
                @endforelse

            </x-form>
        </div>
    </div>
</x-modal>