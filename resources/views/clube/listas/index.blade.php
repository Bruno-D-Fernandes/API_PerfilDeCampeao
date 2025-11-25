<x-layouts.clube title="Minhas Listas" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Minhas Listas' => null
]">
    <x-drawer id="notifications" width="max-w-lg">
        <div class="flex flex-col gap-y-2">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-emerald-700 tracking-tight">
                    Notificações
                </h1>

                <x-icon-button color="green">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </x-icon-button>
            </div>
            
            <div class="w-full h-10 bg-gray-50 rounded-lg flex items-center justify-between">
                <div class="flex items-center gap-x-2 p-2">
                    <x-button color="none" class="pl-0 pr-0 border-none font-semibold bg-transparent text-emerald-600">
                        Todas
                    </x-button>

                    <x-button color="none" class="pl-0 pr-0 border-none font-medium bg-transparent text-emerald-800">
                        Não lidas (10)
                    </x-button>
                </div>

                <x-button color="none" class="pl-0 pr-2 border-none text-sm font-medium bg-transparent text-emerald-500">
                    <x-slot:icon>
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-check-icon lucide-check-check"><path d="M18 6 7 17l-5-5"/><path d="m22 10-7.5 7.5L13 16"/></svg>
                    </x-slot:icon>

                    Marcar todas como lidas
                </x-button>
            </div>

            <div class="flex flex-col gap-y-2">
                <span class="text-sm text-gray-900 uppercase tracking-tight font-semibold">
                    Hoje
                </span>

                {{-- O de baixo pode ser tornar um componente de notificação --}}

                <div class="flex flex-col gap-y-2">
                    <div class="flex items-center gap-x-2">
                        <div class="h-14 w-14 aspect-square rounded-md bg-gray-100 flex items-center justify-center">
                            <svg class="h-6 w-6 text-emerald-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-megaphone-icon lucide-megaphone"><path d="M11 6a13 13 0 0 0 8.4-2.8A1 1 0 0 1 21 4v12a1 1 0 0 1-1.6.8A13 13 0 0 0 11 14H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z"/><path d="M6 14a12 12 0 0 0 2.4 7.2 2 2 0 0 0 3.2-2.4A8 8 0 0 1 10 14"/><path d="M8 6v8"/></svg>
                        </div>

                        <div class="h-full w-full flex flex-col justify-between">
                            <h3 class="text-sm font-medium text-emerald-700">
                                Um administrador do sistema recusou a sua oportunidade.
                            </h3>

                            <h4 class="text-xs font-normal text-emerald-900">
                                11 de Outubro às 9:30h
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-drawer>

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
        @endforeach
    </div>
</x-layouts.clube>