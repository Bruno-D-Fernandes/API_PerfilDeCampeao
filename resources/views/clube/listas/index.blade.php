<x-layouts.clube title="Minhas Listas" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Minhas Listas' => null
]">
    <x-slot:action>
        <x-button onclick="openModal('create-list')" color="clube">
            <x-slot:icon>
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            </x-slot:icon>

            Criar Lista
        </x-button>
    </x-slot:action>

    <x-modal maxWidth="xl" name="create-list" title="Criar lista" titleSize="2xl" titleColor="green">
        <div class="flex flex-col gap-2">
            <x-form-group label="Nome" name="nome" id="lista-nome" labelColor="green" textSize="xl">
                <x-slot:icon>
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-type-icon lucide-type"><path d="M12 4v16"/><path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"/><path d="M9 20h6"/></svg>
                </x-slot:icon>
            </x-form-group>

            <x-form-group label="Descrição" name="descricao" id="lista-descricao" labelColor="green" textSize="xl">
                <x-slot:icon>
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-text-align-center-icon lucide-text-align-center"><path d="M21 5H3"/><path d="M17 12H7"/><path d="M19 19H5"/></svg>
                </x-slot:icon>
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
        $listas = [
            (object) [
                'id' => 1, 
                'nome' => 'Zagueiros - Futebol', 
                'descricao' => 'Meus preferidinhos',
                'data' => '2025-11-20',
                'atletas' => 28,
            ],
            (object) [
                'id' => 2, 
                'nome' => 'Pivôs - Basquete', 
                'descricao' => 'Tanto faz',
                'data' => '2025-11-20',
                'atletas' => 12,
            ],
            (object) [
                'id' => 1, 
                'nome' => 'Zagueiros - Futebol', 
                'descricao' => 'Meus preferidinhos',
                'data' => '2025-11-20',
                'atletas' => 28,
            ],
        ];
    @endphp

    <x-slot:action>
        <x-button onclick="openModal('create-list')" color="clube">
            <x-slot:icon>
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            </x-slot:icon>

            Criar Lista
        </x-button>
    </x-slot:action>

    <div class="grid grid-cols-3 gap-4">
        <button class="group break-inside-avoid w-full h-48 rounded-lg border-2 border-dashed border-emerald-500 hover:border-emerald-600 bg-white flex flex-col items-center justify-center gap-4 cursor-pointer hover:-translate-y-0.5 transition-transform hover:-translate-y-0.5 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" onclick="openModal('create-list')">
            <svg class="h-16 w-16 text-emerald-500 group-hover:text-emerald-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>

            <h3 class="text-lg font-semibold text-emerald-500 group-hover:text-emerald-600">
                Criar nova lista
            </h3>
        </button>

        @foreach($listas as $item)
            <x-list-item :list="$item" class="break-inside-avoid w-full" />

            <x-modal maxWidth="xl" name="edit-list-{{ $item->id }}" title="Editar lista" titleSize="2xl" titleColor="blue">
                <div class="flex flex-col gap-2">
                    <x-form-group label="Nome" name="nome" id="lista-nome" labelColor="blue" textSize="xl">
                        <x-slot:icon>
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-type-icon lucide-type"><path d="M12 4v16"/><path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"/><path d="M9 20h6"/></svg>
                        </x-slot:icon>
                    </x-form-group>

                    <x-form-group label="Descrição" name="descricao" id="lista-descricao" labelColor="blue" textSize="xl">
                        <x-slot:icon>
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-text-align-center-icon lucide-text-align-center"><path d="M21 5H3"/><path d="M17 12H7"/><path d="M19 19H5"/></svg>
                        </x-slot:icon>
                    </x-form-group>
                </div>

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

            <x-modal maxWidth="lg" name="delete-list-{{ $item->id }}" title="Excluir lista" titleSize="xl" titleColor="red">
                <div class="p-4 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Tem certeza absoluta?</h3>
                    <p class="text-sm text-gray-500 mt-2">
                        Você está prestes a excluir <strong>"{{ $item->nome }}"</strong>. Essa ação é irreversível.
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