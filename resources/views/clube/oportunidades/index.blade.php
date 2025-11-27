<x-layouts.clube title="Minhas Oportunidades" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Minhas Oportunidades' => null
]">
    <x-slot:action>
        <x-button onclick="openModal('create-opportunity')" size="md" color="clube">
            <x-slot:icon>
                <svg class="h-4 w-4 md:h-3 md:w-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            </x-slot:icon>

            Criar Oportunidade
        </x-button>
    </x-slot:action>

    <x-modal maxWidth="xl" name="create-opportunity" title="Criar oportunidade" titleSize="2xl" titleColor="green">
        <form class="flex flex-col gap-2">
            <x-form-group label="Título" name="nomeOportunidade" id="oportunidade-nome" labelColor="green" textSize="xl">
                <x-slot:icon>
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-type-icon lucide-type"><path d="M12 4v16"/><path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"/><path d="M9 20h6"/></svg>
                </x-slot:icon>
            </x-form-group>

            <x-form-group label="Descrição" name="descricaoOportunidade" id="oportunidade-descricao" labelColor="green" textSize="xl">
                <x-slot:icon>
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-text-align-center-icon lucide-text-align-center"><path d="M21 5H3"/><path d="M17 12H7"/><path d="M19 19H5"/></svg>
                </x-slot:icon>
            </x-form-group>

            <x-form-group label="Esporte" type="select" name="esportes" id="oportunidade-esportes" labelColor="green" textSize="xl" size="1" multiple>
                <x-slot:icon>
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trophy-icon lucide-trophy"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg>
                </x-slot:icon>

                <option>
                    Futebol
                </option>
            </x-form-group>

            <x-form-group label="Posições" type="select" name="posicoes" id="oportunidade-posicoes" labelColor="green" textSize="xl" size="1" multiple>
                <x-slot:icon>
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-target-icon lucide-target"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                </x-slot:icon>

                <option>
                    Atacante
                </option>
            </x-form-group>
        </form>

        <x-slot:footer>
            <div class="w-full flex gap-x-2 justify-end">
                <x-button color="gray" size="md">
                    Cancelar
                </x-button>

                <x-button color="clube" size="md">
                    Salvar
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>

    @php
        $oportunidades = [
            (object) [
                'id' => 1, 
                'titulo' => 'Seletiva Sub-20 - Goleiros e Zagueiros', 
                'data' => '2025-11-20',
                'inscritos' => 28,
                'vagas' => 30,
                'status' => 'ativa',
            ],
            (object) [
                'id' => 3, 
                'titulo' => 'Peneira Regional 2024', 
                'data' => '2024-10-10',
                'inscritos' => 50,
                'vagas' => 50,
                'status' => 'ativa',
            ],
        ];
    @endphp

    <x-slot:action>
        <x-button onclick="openModal('create-opportunity')" size="sm" color="clube">
            <x-slot:icon>
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            </x-slot:icon>

            Criar oportunidade
        </x-button>
    </x-slot:action>

    <div class="grid grid-cols-3 gap-4 auto-rows-auto">
        <button class="group break-inside-avoid w-full h-48 rounded-lg border-2 border-dashed border-emerald-500 hover:border-emerald-600 bg-white flex flex-col items-center justify-center gap-4 cursor-pointer hover:-translate-y-0.5 transition-transform hover:-translate-y-0.5 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" onclick="openModal('create-opportunity')">
            <svg class="h-16 w-16 text-emerald-500 group-hover:text-emerald-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>

            <h3 class="text-lg font-semibold text-emerald-500 group-hover:text-emerald-600">
                Criar nova oportunidade
            </h3>
        </button>

        @foreach($oportunidades as $item)
            <x-opportunity-item :opportunity="$item" />

            <x-modal maxWidth="xl" name="edit-opportunity-{{ $item->id }}" title="Editar oportunidade" titleSize="2xl" titleColor="blue">
                <form class="flex flex-col gap-2">
                    <x-form-group label="Título" name="nomeOportunidade" id="oportunidade-nome" labelColor="blue" textSize="xl" value="{{ $item->titulo }}">
                        <x-slot:icon>
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-type-icon lucide-type"><path d="M12 4v16"/><path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"/><path d="M9 20h6"/></svg>
                        </x-slot:icon>
                    </x-form-group>

                    <x-form-group label="Descrição" name="descricaoOportunidade" id="oportunidade-descricao" labelColor="blue" textSize="xl">
                        <x-slot:icon>
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-text-align-center-icon lucide-text-align-center"><path d="M21 5H3"/><path d="M17 12H7"/><path d="M19 19H5"/></svg>
                        </x-slot:icon>
                    </x-form-group>

                    <x-form-group label="Esporte" type="select" name="esportes" id="oportunidade-esportes" labelColor="blue" textSize="xl" size="1" multiple>
                        <x-slot:icon>
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trophy-icon lucide-trophy"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg>
                        </x-slot:icon>

                        <option>
                            Futebol
                        </option>
                    </x-form-group>

                    <x-form-group label="Posições" type="select" name="posicoes" id="oportunidade-posicoes" labelColor="blue" textSize="xl" size="1" multiple>
                        <x-slot:icon>
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-target-icon lucide-target"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                        </x-slot:icon>

                        <option>
                            Atacante
                        </option>
                    </x-form-group>
                </form>

                <x-slot:footer>
                    <div class="w-full flex gap-x-2 justify-end">
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
                <div class="p-4 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Tem certeza absoluta?</h3>
                    <p class="text-sm text-gray-500 mt-2">
                        Você está prestes a excluir <strong>"{{ $item->titulo }}"</strong>. Essa ação é irreversível.
                    </p>
                </div>

                <x-slot:footer>
                    <div class="w-full flex gap-x-2 justify-end">
                        <x-button color="gray" size="md" onclick="closeModal('delete-opportunity-{{ $item->id }}')">Cancelar</x-button>
                        <x-button color="red" size="md">Sim, excluir</x-button>
                    </div>
                </x-slot:footer>
            </x-modal>
        @endforeach
    </div>
</x-layouts.clube>