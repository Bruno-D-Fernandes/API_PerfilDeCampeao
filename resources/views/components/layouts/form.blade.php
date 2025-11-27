<x-layouts.base :title="$title">
    <div {{ $attributes->merge(['class' => 'h-screen w-full flex bg-white overflow-hidden']) }}>
        <div class="w-full h-full grid grid-cols-2">
            <div class="flex flex-col h-full w-full">
                {{ $left }}
            </div>

            <div class="relative h-full w-full">
                <div class="absolute inset-[0.83vw] rounded-[1.25vw] overflow-hidden">
                    {{ $right }}
                </div>  
            </div>
        </div>
    </div>
</x-layouts.base>