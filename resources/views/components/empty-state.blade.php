@props([
    'text' => '',
    // slot opcional de ações
    'actions' => null,
])

<div class="w-full h-full flex items-center justify-center">
    <div class="flex flex-col gap-[0.83vw] items-center">
        <div class="h-[3.33vw] w-[3.33vw] rounded-full bg-gray-100 flex items-center justify-center text-gray-700">
            @isset($icon)
                {{ $icon }}
            @endisset
        </div>

        <div class="flex flex-col gap-[0.42vw] items-center">
            <h3 class="text-gray-700 text-[1.04vw] font-medium">
                {{ $text }}
            </h3>

            {{ $slot }}
        </div>

        @isset($actions)
            <div class="flex items-start justify-center gap-x-[0.83vw]">
                {{ $actions }}
            </div>
        @endisset
    </div>
</div>
