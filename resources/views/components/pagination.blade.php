<div class="flex flex-col sm:flex-row items-center justify-between w-full gap-4">
    <nav>
        <ul class="flex -space-x-px text-sm">
            <li>
                <button 
                    type="button"
                    @if($currentPage > 1)
                        onclick="handlePageChange({{ $currentPage - 1 }})"
                        class="cursor-pointer flex items-center justify-center bg-gray-50 text-gray-500 border border-gray-300 hover:bg-gray-200 hover:text-gray-700 font-medium rounded-s-lg px-3 h-9 transition-colors"
                    @else
                        disabled
                        class="cursor-pointer flex items-center justify-center bg-gray-100 text-gray-400 border border-gray-300 font-medium rounded-s-lg px-3 h-9 cursor-not-allowed"
                    @endif
                >
                    Anterior
                </button>
            </li>

            @foreach($pages() as $page)
                <li>
                    @if($page === '...')
                        <span class="flex items-center justify-center bg-white text-gray-500 border border-gray-300 font-medium w-9 h-9">
                            ...
                        </span>
                    @else
                        @php
                            $isActive = ($page == $currentPage);
                            $classes = $isActive 
                                ? 'bg-gray-200 text-gray-900 font-medium border border-gray-300' 
                                : 'bg-gray-50 text-gray-500 font-medium border border-gray-300 hover:bg-gray-200 hover:text-gray-700'; 
                        @endphp

                        <button 
                            type="button"
                            onclick="handlePageChange({{ $page }})"
                            class="flex items-center justify-center w-9 h-9 text-sm transition-colors {{ $classes }} cursor-pointer"
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
                        class="cursor-pointer flex items-center justify-center bg-gray-50 text-gray-500 border border-gray-300 hover:bg-gray-200 hover:text-gray-700 font-medium rounded-e-lg px-3 h-9 transition-colors"
                    @else
                        disabled
                        class="cursor-pointer flex items-center justify-center bg-gray-100 text-gray-400 border border-gray-300 font-medium rounded-e-lg px-3 h-9 cursor-not-allowed"
                    @endif
                >
                    Próxima
                </button>
            </li>
        </ul>
    </nav>

    <div class="w-[9.50rem]">
        <select 
            id="per_page"
            onchange="handlePerPageChange(this.value)"
            class="block w-full px-3 py-2.5 border border-gray-300 text-gray-700 font-medium text-sm rounded-lg focus:ring-1 focus:ring-gray-300 focus:border-gray-300 shadow-xs"
        >
            @foreach([10, 25, 50, 100] as $limit)
                <option value="{{ $limit }}">
                    {{ $limit }} por página
                </option>
            @endforeach
        </select>
    </div>
</div>