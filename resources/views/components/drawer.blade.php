<div 
    id="{{ $id }}-overlay" 
    onclick="closeDrawer('{{ $id }}')" 
    class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-40 hidden transition-opacity duration-300"
    aria-hidden="true"
></div>

<div 
    id="{{ $id }}-panel" 
    class="fixed top-0 right-0 z-50 h-full w-full bg-white shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out {{ $width }}"
>
    <div class="h-full overflow-y-auto bg-white">
        {{ $slot }}
    </div>
</div>