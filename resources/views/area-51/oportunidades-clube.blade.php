<x-layouts.clube title="Minhas Oportunidades" :breadcrumb="[
    'Dashboard' => route('admin-clubes'),
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
            Adicionar Oportunidade
        </x-button>
    </x-slot:action>

    <div class="grid grid-cols-2 gap-4 auto-rows-auto">
        @foreach($oportunidades as $item)
            <x-opportunity-item :opportunity="$item" />
        @endforeach
        </button>
    </div>
</x-layouts.clube>