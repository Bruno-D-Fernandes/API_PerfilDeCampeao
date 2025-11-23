<th 
    scope="col" 
    {{-- Lógica de Classes CSS --}}
    {{ $attributes->class([
        'px-6 py-3 font-medium select-none transition-colors',
        'cursor-pointer group hover:bg-gray-100 sortable-column' => $sortable,
        'text-gray-500' => !$sortable
    ]) }}

    @if($sortable)
        data-col="{{ $name }}"
        data-state="neutral"
        onclick="handleSort('{{ $name }}')"
    @endif
>
    <div class="inline-flex items-center gap-x-1">
        {{ $label }}

        @if($sortable)
            <div class="relative w-4 h-4 flex items-center justify-center">
                <svg id="icon-neutral-{{ $name }}" class="w-4 h-4 text-gray-400 group-hover:text-gray-600 absolute transition-opacity" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                <svg id="icon-asc-{{ $name }}" class="w-4 h-4 text-gray-900 absolute hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
                <svg id="icon-desc-{{ $name }}" class="w-4 h-4 text-gray-900 absolute hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
            </div>
        @endif
    </div>
</th>