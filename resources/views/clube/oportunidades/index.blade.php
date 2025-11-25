<x-layouts.clube title="Minhas Oportunidades" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Minhas Oportunidades' => null
]">
    <x-slot:action>
        <x-button onclick="openModal('create-opportunity')" color="clube">
            <x-slot:icon>
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            </x-slot:icon>

            Criar Oportunidade
        </x-button>
    </x-slot:action>

    <x-modal maxWidth="xl" name="create-opportunity" title="Criar oportunidade" titleSize="2xl" titleColor="green">
        <div class="flex flex-col gap-2">
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
        </div>

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
        <x-button onclick="openModal('create-opportunity')" color="clube">
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
        @endforeach
        </button>
    </div>
</x-layouts.clube>