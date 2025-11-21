<x-layouts.base :title="$title">
    <div {{ $attributes->merge(['class' => 'h-screen w-full flex bg-white']) }}>
        <div class="w-full grid grid-cols-1 md:grid-cols-2">
            <div class="flex flex-col h-full w-full">
                {{ $left }}
            </div>

            <div class="flex flex-col h-full w-full text-white">
                {{ $right }}
            </div>
        </div>
    </div>
</x-layouts.base>