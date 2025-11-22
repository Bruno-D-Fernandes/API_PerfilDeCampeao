<x-layouts.base :title="$title">
    <div {{ $attributes->merge(['class' => 'h-screen w-full flex bg-white overflow-hidden']) }}>
        <div class="w-full h-full grid grid-cols-1 md:grid-cols-2">
            <div class="flex flex-col h-full w-full">
                {{ $left }}
            </div>

            <div class="hidden md:block relative h-full w-full bg-gray-50">
                <div class="absolute inset-4 rounded-3xl overflow-hidden">
                    {{ $right }}
                </div>  
            </div>
        </div>
    </div>
</x-layouts.base>