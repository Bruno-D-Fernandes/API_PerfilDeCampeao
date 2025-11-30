<div class="grid grid-cols-3 gap-[0.83vw] auto-rows-auto">
    <button class="group break-inside-avoid w-full h-[9vw] rounded-[0.42vw] border-[0.15vw] border-dashed border-emerald-500 hover:border-emerald-600 bg-white flex flex-col items-center justify-center cursor-pointer hover:-translate-y-0.5 transition-transform hover:-translate-y-0.5 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" onclick="openModal('create-opportunity')">
        <svg class="h-[2.5vw] w-[2.5vw] text-emerald-500 group-hover:text-emerald-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>

        <h3 class="text-[0.94vw] font-semibold text-emerald-500 group-hover:text-emerald-600">
            Criar nova oportunidade
        </h3>
    </button>

    @foreach($oportunidades as $item)
        <x-opportunity-item :opportunity="$item" :hasActions="true" />

        <x-modal maxWidth="2xl" name="edit-opportunity-{{ $item->id }}" title="Editar oportunidade" titleSize="2xl" titleColor="blue">
            <x-form id="form-edit-{{ $item->id }}" class="flex flex-col gap-[0.42vw]">
                @csrf
                @method('PUT')
                
                <x-form-group label="Título" name="tituloOportunidades" id="oportunidade-titulo-{{ $item->id }}" labelColor="blue" textSize="xl" value="{{ $item->tituloOportunidades }}" required>
                    <x-slot:icon>
                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-type-icon"><path d="M12 4v16"/><path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"/><path d="M9 20h6"/></svg>
                    </x-slot:icon>
                </x-form-group>

                <div class="grid grid-cols-2 gap-[0.42vw]">
                    <x-form-group label="Esporte" type="select" name="esporte_id" id="oportunidade-esporte-{{ $item->id }}" labelColor="blue" textSize="xl" required onchange="atualizarPosicoes('edit-esporte-{{ $item->id }}', 'oportunidade-posicoes-{{ $item->id }}')">
                        <x-slot:icon>
                            <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trophy-icon"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg>
                        </x-slot:icon>

                        <option value="">Selecione...</option>
                            @foreach($esportes as $esporte)
                                <option value="{{ $esporte->id }}" {{ $item->esporte_id == $esporte->id ? 'selected' : '' }}>
                                    {{ $esporte->nomeEsporte ?? $esporte->nome }}
                                </option>
                            @endforeach
                    </x-form-group>

                    <x-form-group label="Posições (Segure Ctrl)" name="posicoes_ids[]" id="oportunidade-posicoes" type="select" multiple size="1" labelColor="blue" textSize="xl" class="h-[2.5vw]">
                        <x-slot:icon>
                            <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-target-icon"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                        </x-slot:icon>
                        
                        @foreach($item->esporte->posicoes as $pos)
                            <option value="{{ $pos->id }}" {{ $item->posicoes->contains($pos->id) ? 'selected' : '' }}>
                                {{ $pos->nomePosicao ?? $pos->nome }}
                            </option>
                        @endforeach
                    </x-form-group>
                </div>

                <div class="grid grid-cols-3 gap-[0.42vw]">
                    <x-form-group label="Idade Mín." type="number" name="idadeMinima" id="oportunidade-idade-min-{{ $item->id }}" labelColor="blue" textSize="xl" value="{{ $item->idadeMinima }}" required>
                        <x-slot:icon>
                            <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-down-to-line"><path d="M12 17V3"/><path d="m6 11 6 6 6-6"/><path d="M19 21H5"/></svg>
                        </x-slot:icon>
                    </x-form-group>

                    <x-form-group label="Idade Máx." type="number" name="idadeMaxima" id="oportunidade-idade-max-{{ $item->id }}" labelColor="blue" textSize="xl" value="{{ $item->idadeMaxima }}" required>
                        <x-slot:icon>
                            <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-from-line"><path d="m18 9-6-6-6 6"/><path d="M12 3v14"/><path d="M5 21h14"/></svg>
                        </x-slot:icon>
                    </x-form-group>

                    <x-form-group label="Vagas" type="number" name="limite_inscricoes" id="oportunidade-limite-{{ $item->id }}" labelColor="blue" textSize="xl" value="{{ $item->limite_inscricoes }}" required>
                        <x-slot:icon>
                            <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </x-slot:icon>
                    </x-form-group>
                </div>

                <x-form-group label="Descrição" name="descricaoOportunidades" id="oportunidade-descricao-{{ $item->id }}" labelColor="blue" textSize="xl" value="{{ $item->descricaoOportunidades }}" required>
                    <x-slot:icon>
                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-text-align-center-icon"><path d="M21 5H3"/><path d="M17 12H7"/><path d="M19 19H5"/></svg>
                    </x-slot:icon>
                </x-form-group>
            </x-form>

            <x-slot:footer>
                <div class="w-full flex gap-x-[0.42vw] justify-end">
                    <x-button color="gray" size="md" onclick="closeModal('edit-opportunity-{{ $item->id }}')">
                        Cancelar
                    </x-button>

                    <x-button color="none" size="md" class="bg-sky-300 text-white hover:bg-sky-600"  onclick="saveOpportunity('form-edit-{{ $item->id }}', 'edit', {{ $item->id }})">
                        Salvar
                    </x-button>
                </div>
            </x-slot:footer>
        </x-modal>

        <x-modal maxWidth="lg" name="delete-opportunity-{{ $item->id }}" title="Excluir oportunidade" titleSize="xl" titleColor="red">
            <div class="p-[0.83vw] text-center">
                <div class="mx-auto flex items-center justify-center h-[2.5vw] w-[2.5vw] rounded-full bg-red-100 mb-[0.83vw]">
                    <svg class="h-[1.25vw] w-[1.25vw] text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-[0.94vw] leading-6 font-medium text-gray-900">Tem certeza absoluta?</h3>
                <p class="text-[0.73vw] text-gray-500 mt-[0.42vw]">
                    Você está prestes a excluir <strong>"{{ $item->tituloOportunidades }}"</strong>. Essa ação é irreversível.
                </p>
            </div>

            <x-slot:footer>
                <div class="w-full flex gap-x-[0.42vw] justify-end">
                    <x-button color="gray" size="md" onclick="closeModal('delete-opportunity-{{ $item->id }}')">Cancelar</x-button>
                    <x-button color="red" size="md">Sim, excluir</x-button>
                </div>
            </x-slot:footer>
        </x-modal>
    @endforeach
</div>