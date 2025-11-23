<aside class="fixed top-0 left-0 z-40 w-80 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-white border-r border-gray-300 px-4">
    <div class="h-36 w-full flex items-center justify-center border-b border-gray-200 shrink-0 relative">
        {{ $logo ?? 'LOGO' }}

        <div class="absolute top-13 right-0">
            <x-icon-button color="gray">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-panel-right-open-icon lucide-panel-right-open"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M15 3v18"/><path d="m10 15-3-3 3-3"/></svg>
            </x-icon-button>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto py-6">
        <nav class="space-y-2">
            {{ $slot }}
        </nav>
    </div>
</aside>