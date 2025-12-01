<x-layouts.clube title="Minhas Listas" :breadcrumb="[
    'Dashboard' => route('admin-clubes'),
    'Minhas Listas' => null
]">
    <x-slot:action>
        <x-button onclick="openModal('create-opportunity')" color="clube">
            <x-slot:icon>
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            </x-slot:icon>

            Criar Lista
        </x-button>
    </x-slot:action>

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
            (object) [
                'id' => 2, 
                'nome' => 'Pivôs - Basquete', 
                'descricao' => 'Tanto faz',
                'data' => '2025-11-20',
                'atletas' => 12,
            ],
        ];
    @endphp

    <x-slot:action>
        <x-button onclick="openModal('create-opportunity')" color="clube">
            <x-slot:icon>
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            </x-slot:icon>

            Criar Lista
        </x-button>
    </x-slot:action>

    <div class="grid grid-cols-3 gap-4">
        <button class="group break-inside-avoid w-full h-48 rounded-lg border-2 border-dashed border-emerald-500 hover:border-emerald-600 bg-white flex flex-col items-center justify-center gap-4 cursor-pointer hover:-translate-y-0.5 transition-transform hover:-translate-y-0.5 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
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