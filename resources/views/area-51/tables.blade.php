<x-layouts.admin title="Oportunidades" :breadcrumb="[
    'Dashboard' => route('admin-clubes'),
    'Oportunidades' => null
]">
    @php
        $dadosFake = [
            (object) [
                'id' => 1, 
                'titulo' => 'Peneira Sub-17 - Base Forte', 
                'clube' => 'Santos FC', 
                'local' => 'CT Rei Pelé - Santos, SP',
                'inscritos' => 142,
                'status' => 'aberta',
                'data' => '12/11/2025'
            ],
            (object) [
                'id' => 2, 
                'titulo' => 'Seletiva de Goleiros', 
                'clube' => 'C.R. Flamengo', 
                'local' => 'Ninho do Urubu - Rio de Janeiro, RJ',
                'inscritos' => 58,
                'status' => 'fechada',
                'data' => '05/10/2025'
            ],
            (object) [
                'id' => 3, 
                'titulo' => 'Avaliação Técnica - Meio Campo', 
                'clube' => 'S.E. Palmeiras', 
                'local' => 'Academia de Futebol - SP',
                'inscritos' => 89,
                'status' => 'analise',
                'data' => '20/12/2025'
            ],
        ];

        $oportunidades = new \Illuminate\Pagination\LengthAwarePaginator(
            collect($dadosFake),
            45,               
            10,                  
            1,                 
            ['path' => url()->current()]
        );
    @endphp

    <x-table :items="$oportunidades">
        <x-slot:header>
            <x-table-header name="titulo" label="Oportunidade" />
            <x-table-header name="clube" label="Clube" :sortable="true" />
            <x-table-header name="local" label="Localização" :sortable="true" />
            <x-table-header name="inscritos" label="Inscritos" :sortable="true" />
            <x-table-header name="status" label="Status" :sortable="true" />
            <x-table-header label="Ações" />
        </x-slot:header>

        <x-slot:body>
            @foreach($oportunidades as $item)
                <tr class="bg-white border-b border-gray-300 hover:bg-gray-50 transition-colors }}">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        <div class="flex flex-col">
                            <span class="text-base">{{ $item->titulo }}</span>
                            <span class="text-xs text-gray-500 font-normal">Criado em {{ $item->data }}</span>
                        </div>
                    </th>

                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-gray-200 flex-shrink-0"></div>
                            <span class="font-medium text-gray-700">{{ $item->clube }}</span>
                        </div>
                    </td>

                    <td class="px-6 py-4 text-gray-500">
                        {{ $item->local }}
                    </td>

                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            {{ $item->inscritos }}
                        </span>
                    </td>

                    <td class="px-6 py-4">
                        @if($item->status === 'aberta')
                            <x-badge color="green">Aberta</x-badge>
                        @elseif($item->status === 'fechada')
                            <x-badge color="red">Fechada</x-badge>
                        @else
                            <x-badge color="yellow">Em Análise</x-badge>
                        @endif
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex items-center gap-x-1">
                            <x-icon-button color="blue" onclick="openModal('modal-create-{{ $item->id }}')">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
                            </x-icon-button>

                            <x-icon-button color="red">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-icon lucide-trash"><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            </x-icon-button>
                        </div>
                    </td>
                </tr>

                <x-modal name="modal-create-{{ $item->id }}" title="Criar Nova Oportunidade">
                    <form action="..." method="POST">
                        <div class="space-y-4">
                            <x-form-group label="Título" name="titulo" />
                            <x-form-group label="Data" name="data" type="date" />
                        </div>
                    </form>

                    <x-slot:footer>
                        <x-button color="red" onclick="closeModal('modal-create')">Cancelar</x-button>
                        <x-button color="admin" type="submit">Salvar</x-button>
                    </x-slot:footer>
                </x-modal>
            @endforeach
        </x-slot:body>
    </x-table>
</x-layouts.admin>