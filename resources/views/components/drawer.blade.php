<div 
    id="{{ $id }}-overlay" 
    onclick="closeDrawer('{{ $id }}')" 
    class="fixed inset-0 bg-gray-900/20 z-30 hidden transition-opacity duration-300"
    aria-hidden="true"
></div>

<div 
    id="{{ $id }}-panel" 
    class="fixed top-0 right-0 z-40 h-full w-full hidden transform transition-transform duration-300 ease-in-out {{ $width }} p-4"
>
    <div class="h-full overflow-y-auto bg-white rounded-lg p-4">
        {{ $slot }}
    </div>
</div>