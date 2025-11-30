@if($atletas->lastPage() > 1)
    <div class="w-full flex items-center justify-center"> 
        <x-pagination 
            :maxPage="$atletas->lastPage()" 
            :currentPage="$atletas->currentPage()" 
            :currentLimit="9" {{-- Limitado a 9 --}}
            :showPerPage="false" {{-- Desabilita o select --}}
        />
    </div>
@endif