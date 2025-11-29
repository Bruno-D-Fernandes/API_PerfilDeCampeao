<x-layouts.clube title="Minhas Listas" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Minhas Listas' => null
]">
    @php
        $clube = auth()->guard('club')->user();
        $listas = $clube->listas;
    @endphp

    <x-slot:action>
        <x-button onclick="openModal('create-list')" color="clube" size="sm">
            <x-slot:icon>
                <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            </x-slot:icon>

            Criar Lista
        </x-button>
    </x-slot:action>

    <x-modal maxWidth="[30vw]" name="create-list" title="Criar lista" titleSize="[1.25vw]" titleColor="green">
        <div class="flex flex-col gap-[0.42vw]">
            <x-form-group label="Nome" name="nome" id="lista-nome" labelColor="green" textSize="[1.04vw]">
                <x-slot:icon>
                    <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M12 4v16"/><path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"/><path d="M9 20h6"/></svg>
                </x-slot:icon>
            </x-form-group>

            <x-form-group label="Descrição" name="descricao" id="lista-descricao" labelColor="green" textSize="[1.04vw]">
                <x-slot:icon>
                    <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M21 5H3"/><path d="M17 12H7"/><path d="M19 19H5"/></svg>
                </x-slot:icon>
            </x-form-group>
        </div>

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

    <div class="grid grid-cols-3 gap-[0.83vw]">
        <button class="group break-inside-avoid w-full h-[9vw] rounded-[0.42vw] border-[0.15vw] border-dashed border-emerald-500 hover:border-emerald-600 bg-white flex flex-col items-center justify-center gap-[0.83vw] cursor-pointer hover:-translate-y-[0.1vw] transition-transform transition-colors disabled:opacity-50 disabled:cursor-not-allowed" onclick="openModal('create-list')">
            <svg class="h-[3.33vw] w-[3.33vw] text-emerald-500 group-hover:text-emerald-600 stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>

            <h3 class="text-[0.94vw] font-semibold text-emerald-500 group-hover:text-emerald-600">
                Criar nova lista
            </h3>
        </button>

        @foreach($listas as $item)
            <x-list-item :list="$item" class="break-inside-avoid w-full" />

            <x-modal maxWidth="[30vw]" name="edit-list-{{ $item->id }}" title="Editar lista" titleSize="[1.25vw]" titleColor="blue">
                <div class="flex flex-col gap-[0.42vw]">
                    <x-form-group label="Nome" name="nome" id="lista-nome" labelColor="blue" textSize="[1.04vw]">
                        <x-slot:icon>
                            <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 4v16"/><path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"/><path d="M9 20h6"/></svg>
                        </x-slot:icon>
                    </x-form-group>

                    <x-form-group label="Descrição" name="descricao" id="lista-descricao" labelColor="blue" textSize="[1.04vw]">
                        <x-slot:icon>
                            <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 5H3"/><path d="M17 12H7"/><path d="M19 19H5"/></svg>
                        </x-slot:icon>
                    </x-form-group>
                </div>

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

            <x-modal maxWidth="[26.67vw]" name="delete-list-{{ $item->id }}" title="Excluir lista" titleSize="[1.04vw]" titleColor="red">
                <div class="p-[0.83vw] text-center">
                    <div class="mx-auto flex items-center justify-center h-[2.5vw] w-[2.5vw] rounded-full bg-red-100 mb-[0.83vw]">
                        <svg class="h-[1.25vw] w-[1.25vw] text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-[0.94vw] leading-6 font-medium text-gray-900">Tem certeza absoluta?</h3>
                    <p class="text-[0.73vw] text-gray-500 mt-[0.42vw]">
                        Você está prestes a excluir <strong>"{{ $item->nome }}"</strong>. Essa ação é irreversível.
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