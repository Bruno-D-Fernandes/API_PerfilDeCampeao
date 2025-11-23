

<div class="relative h-full w-full overflow-x-auto bg-gray-50 shadow-xs rounded-xl border border-gray-300">
    <div class="p-4 flex items-center justify-between space-x-4">
        <x-search-input />

        <div class="flex items-center gap-x-2">
            <x-button size="md" type="button">
                <x-slot:icon>
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download-icon lucide-download"><path d="M12 15V3"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m7 10 5 5 5-5"/></svg>
                </x-slot:icon>

                Exportar
            </x-button>

            <x-button size="md" type="button" color="admin">
                Adicionar novo
            </x-button>
        </div>
    </div>
    
    <table class="w-full text-sm text-left rtl:text-right text-body border-b border-gray-300">
        <thead class="text-sm text-body bg-gray-50 border-b border-t border-gray-300 hover:bg-gray-100">
            <tr>
                {{ $header }}
            </tr>
        </thead>

        <tbody>
            {{ $body }}
        </tbody>
    </table>

    @if(isset($items) && method_exists($items, 'lastPage'))
        <div class="w-full p-4 flex items-center justify-center border-t border-gray-200 bg-white rounded-b-xl">
            <x-pagination 
                :maxPage="$items->lastPage()" 
                :currentPage="$items->currentPage()" 
            />
        </div>
    @endif
</div>