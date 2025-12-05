<div class="flex items-center justify-between w-full gap-[0.83vw] pagination-container">
    <nav>
        <ul class="flex -space-x-[0.052vw] text-[0.73vw]">
            <li>
                <button 
                    type="button"
                    @if($currentPage > 1)
                        onclick="handlePageChange({{ $currentPage - 1 }})"
                        class="cursor-pointer flex items-center justify-center bg-gray-50 text-gray-500 border border-[0.052vw] border-gray-300 hover:bg-gray-200 hover:text-gray-700 font-medium rounded-s-[0.42vw] px-[0.63vw] h-[1.88vw] transition-colors"
                    @else
                        disabled
                        class="cursor-pointer flex items-center justify-center bg-gray-100 text-gray-400 border border-[0.052vw] border-gray-300 font-medium rounded-s-[0.42vw] px-[0.63vw] h-[1.88vw] cursor-not-allowed"
                    @endif
                >
                    Anterior
                </button>
            </li>

            @foreach($pages() as $page)
                <li>
                    @if($page === '...')
                        <span class="flex items-center justify-center bg-white text-gray-500 border border-[0.052vw] border-gray-300 font-medium w-[1.88vw] h-[1.88vw]">
                            ...
                        </span>
                    @else
                        @php
                            $isActive = ($page == $currentPage);
                            
                            $classes = $isActive 
                                ? 'bg-gray-200 text-gray-900 font-medium border border-[0.052vw] border-gray-300' 
                                : 'bg-gray-50 text-gray-500 font-medium border border-[0.052vw] border-gray-300 hover:bg-gray-200 hover:text-gray-700'; 
                        @endphp

                        <button 
                            type="button"
                            onclick="handlePageChange({{ $page }})"
                            class="flex items-center justify-center w-[1.88vw] h-[1.88vw] text-[0.73vw] transition-colors {{ $classes }} cursor-pointer"
                        >
                            {{ $page }}
                        </button>
                    @endif
                </li>
            @endforeach

            <li>
                <button 
                    type="button"
                    @if($currentPage < $maxPage)
                        onclick="handlePageChange({{ $currentPage + 1 }})"
                        class="cursor-pointer flex items-center justify-center bg-gray-50 text-gray-500 border border-[0.052vw] border-gray-300 hover:bg-gray-200 hover:text-gray-700 font-medium rounded-e-[0.42vw] px-[0.63vw] h-[1.88vw] transition-colors"
                    @else
                        disabled
                        class="cursor-pointer flex items-center justify-center bg-gray-100 text-gray-400 border border-[0.052vw] border-gray-300 font-medium rounded-e-[0.42vw] px-[0.63vw] h-[1.88vw] cursor-not-allowed"
                    @endif
                >
                    Próxima
                </button>
            </li>
        </ul>
    </nav>

    @if($hasPerPageSelect)
        <div class="w-[7.92vw]">
            <select 
                id="per_page"
                onchange="handlePerPageChange(this.value)"
                class="block w-full px-[0.63vw] py-[0.52vw] border border-[0.052vw] border-gray-300 text-gray-700 font-medium text-[0.73vw] rounded-[0.42vw] focus:ring-[0.052vw] focus:ring-gray-300 focus:border-gray-300 shadow-xs"
            >
                @foreach([10, 25, 50, 100] as $limit)
                    <option value="{{ $limit }}" @selected($limit == $perPageCurrent)> 
                        {{ $limit }} por página
                    </option>
                @endforeach
            </select>
        </div>
    @endif
</div>