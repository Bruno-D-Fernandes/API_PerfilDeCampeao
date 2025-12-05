@props([
    'tableId'    => 'table-' . uniqid(),
    'hasActions' => false,
    'items'      => null,
])

<div id="{{ $tableId }}" class="relative h-full w-full overflow-x-auto bg-gray-50 rounded-[0.63vw] border border-[0.052vw] border-gray-300">
    <div class="p-[0.83vw] flex items-center justify-between space-x-[0.83vw]">
        <div class="search-box-wrapper">
            <x-search-input class="!border !border-[0.1vw] !border-gray-50 !focus:border-gray-100 !bg-white !w-[25.5vw]" />
        </div>

        @if ($hasActions)   
            <div class="flex items-center gap-x-[0.42vw]">
                <x-button size="md" type="button">
                    <x-slot:icon>
                        <svg class="w-[0.83vw] h-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download-icon lucide-download"><path d="M12 15V3"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m7 10 5 5 5-5"/></svg>
                    </x-slot:icon>

                    Exportar
                </x-button>

                <x-button size="md" type="button" color="admin">
                    Adicionar novo
                </x-button>
            </div>
        @endif
    </div>
    
    <table class="w-full text-[0.73vw] text-left rtl:text-right text-body border-b-[0.052vw] border-gray-300">
        <thead class="text-[0.73vw] text-body bg-gray-50 border-b-[0.052vw] border-t-[0.052vw] border-gray-300 hover:bg-gray-100">
            <tr>
                {{ $header }}
            </tr>
        </thead>

        <tbody class="table-body">
            {{ $body }}
        </tbody>
    </table>

    @if ($items && method_exists($items, 'lastPage'))
        <div class="pagination-container w-full p-[0.83vw] flex items-center justify-center border-t-[0.052vw] border-gray-200 bg-white rounded-b-[0.63vw]">
            <x-pagination 
                :maxPage="$items->lastPage()" 
                :currentPage="$items->currentPage()" 
            />
        </div>
    @endif
</div>
