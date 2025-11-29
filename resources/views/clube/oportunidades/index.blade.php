<x-layouts.clube title="Minhas Oportunidades" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Minhas Oportunidades' => null
]">
    @php
        $clube = auth()->guard('club')->user();
        $oportunidades = $clube->oportunidades;
    @endphp

    <x-slot:action>
        <x-button onclick="openModal('create-opportunity')" size="md" color="clube">
            <x-slot:icon>
                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            </x-slot:icon>

            Criar Oportunidade
        </x-button>
    </x-slot:action>

    <x-modal maxWidth="xl" name="create-opportunity" title="Criar oportunidade" titleSize="2xl" titleColor="green">
        <form class="flex flex-col gap-[0.42vw]">
            <x-form-group label="Título" name="nomeOportunidade" id="oportunidade-nome" labelColor="green" textSize="xl">
                <x-slot:icon>
                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-type-icon lucide-type"><path d="M12 4v16"/><path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"/><path d="M9 20h6"/></svg>
                </x-slot:icon>
            </x-form-group>

            <x-form-group label="Descrição" name="descricaoOportunidade" id="oportunidade-descricao" labelColor="green" textSize="xl">
                <x-slot:icon>
                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-text-align-center-icon lucide-text-align-center"><path d="M21 5H3"/><path d="M17 12H7"/><path d="M19 19H5"/></svg>
                </x-slot:icon>
            </x-form-group>

            <x-form-group label="Esporte" type="select" name="esportes" id="oportunidade-esportes" labelColor="green" textSize="xl" size="1" multiple>
                <x-slot:icon>
                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trophy-icon lucide-trophy"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg>
                </x-slot:icon>

                <option>
                    Futebol
                </option>
            </x-form-group>

            <x-form-group label="Posições" type="select" name="posicoes" id="oportunidade-posicoes" labelColor="green" textSize="xl" size="1" multiple>
                <x-slot:icon>
                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-target-icon lucide-target"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                </x-slot:icon>

                <option>
                    Atacante
                </option>
            </x-form-group>
        </form>

        <x-slot:footer>
            <div class="w-full flex gap-x-[0.42vw] justify-end">
                <x-button color="gray" size="md">
                    Cancelar
                </x-button>

                <x-button color="clube" size="md">
                    Salvar
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>

    <x-slot:action>
        <x-button onclick="openModal('create-opportunity')" size="sm" color="clube">
            <x-slot:icon>
                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            </x-slot:icon>

            Criar oportunidade
        </x-button>
    </x-slot:action>

    <div class="grid grid-cols-3 gap-[0.83vw] auto-rows-auto">
        <button class="group break-inside-avoid w-full h-[9vw] rounded-[0.42vw] border-[0.15vw] border-dashed border-emerald-500 hover:border-emerald-600 bg-white flex flex-col items-center justify-center cursor-pointer hover:-translate-y-0.5 transition-transform hover:-translate-y-0.5 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" onclick="openModal('create-opportunity')">
            <svg class="h-[2.5vw] w-[2.5vw] text-emerald-500 group-hover:text-emerald-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>

            <h3 class="text-[0.94vw] font-semibold text-emerald-500 group-hover:text-emerald-600">
                Criar nova oportunidade
            </h3>
        </button>

        @foreach($oportunidades as $item)
            <x-opportunity-item :opportunity="$item" />

            <x-modal maxWidth="xl" name="edit-opportunity-{{ $item->id }}" title="Editar oportunidade" titleSize="2xl" titleColor="blue">
                <form class="flex flex-col gap-[0.42vw]">
                    <x-form-group label="Título" name="nomeOportunidade" id="oportunidade-nome" labelColor="blue" textSize="xl" value="{{ $item->titulo }}">
                        <x-slot:icon>
                            <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-type-icon lucide-type"><path d="M12 4v16"/><path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"/><path d="M9 20h6"/></svg>
                        </x-slot:icon>
                    </x-form-group>

                    <x-form-group label="Descrição" name="descricaoOportunidade" id="oportunidade-descricao" labelColor="blue" textSize="xl">
                        <x-slot:icon>
                            <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-text-align-center-icon lucide-text-align-center"><path d="M21 5H3"/><path d="M17 12H7"/><path d="M19 19H5"/></svg>
                        </x-slot:icon>
                    </x-form-group>

                    <x-form-group label="Esporte" type="select" name="esportes" id="oportunidade-esportes" labelColor="blue" textSize="xl" size="1" multiple>
                        <x-slot:icon>
                            <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trophy-icon lucide-trophy"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg>
                        </x-slot:icon>

                        <option>
                            Futebol
                        </option>
                    </x-form-group>

                    <x-form-group label="Posições" type="select" name="posicoes" id="oportunidade-posicoes" labelColor="blue" textSize="xl" size="1" multiple>
                        <x-slot:icon>
                            <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-target-icon lucide-target"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                        </x-slot:icon>

                        <option>
                            Atacante
                        </option>
                    </x-form-group>
                </form>

                <x-slot:footer>
                    <div class="w-full flex gap-x-[0.42vw] justify-end">
                        <x-button color="gray" size="md">
                            Cancelar
                        </x-button>

                        <x-button color="none" size="md" class="bg-sky-300 text-white hover:bg-sky-600">
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
                        Você está prestes a excluir <strong>"{{ $item->titulo }}"</strong>. Essa ação é irreversível.
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
</x-layouts.clube>