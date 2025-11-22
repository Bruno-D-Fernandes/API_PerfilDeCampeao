<div class="flex flex-col gap-4 items-center">
    <div class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center text-gray-700">
        {{ $icon }}
    </div>

    <div class="flex flex-col gap-2 items-center">
        <h3 class="text-gray-700 text-xl font-medium">
            {{ $text }}
        </h3>

        {{ $slot }}
    </div>

    <div class="flex items-start justify-center gap-x-4">
        {{ $actions }}
    </div>
</div>