<aside class="fixed top-0 left-0 z-20 w-[16.67vw] h-screen transition-transform -translate-x-full sm:translate-x-0 bg-white border-r border-gray-300 px-[0.83vw]">
    <div class="h-auto w-full flex items-center justify-center border-b border-gray-200 shrink-0 relative flex justify-center">
        @if(isset($logo))
            {{ $logo }}
        @else
            LOGO
        @endif
    </div>

    <div class="flex-1 overflow-y-auto pt-[0.42vw]">
        <nav>
            {{ $slot }}
        </nav>
    </div>
</aside>