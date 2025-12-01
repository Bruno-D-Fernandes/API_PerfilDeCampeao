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

        <div class="w-full border-t border-gray-100"></div>

        <button type="button" onclick="closeModal('save-to-list-{{ $atleta->id }}'); openModal('create-list');" class="cursor-pointer group flex items-center gap-x-[0.83vw] px-[0.63vw] py-[0.42vw] rounded-[0.42vw] text-[0.73vw] font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 w-full outline-none">
            <div class="w-[1.56vw] h-[1.56vw] flex items-center justify-center rounded-full bg-gray-200 text-gray-500 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300 shadow-sm shrink-0">
                <svg class="w-[0.83vw] h-[0.83vw] stroke-[0.15vw]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
            </div>
            <span class="group-hover:translate-x-[0.1vw] transition-transform duration-200 text-[0.73vw]">Criar nova lista</span>
        </button>
    </div>
</x-modal>