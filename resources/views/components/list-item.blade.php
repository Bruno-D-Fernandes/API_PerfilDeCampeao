@php
    $href = null;
@endphp

<div {{ $attributes->merge(['class' => 'group flex flex-col bg-white border border-2 border-gray-200 rounded-xl hover:border-emerald-500 transition-all duration-200 overflow-hidden relative']) }}>
    <a href="{{ $href }}" class="absolute inset-0 z-2"></a>

    <div class="flex flex-col gap-4 overflow-hidden relative p-5">
        <div class="absolute top-3 right-3 z-10 opacity-0 group-hover:opacity-100 transition-opacity">
            <div class="flex items-center bg-white rounded-lg shadow-sm p-1 gap-x-1">
                <x-icon-button color="blue">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
                </x-icon-button>
        
                <div class="w-px h-4 bg-gray-200"></div>

                <x-icon-button color="red">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-icon lucide-trash"><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                </x-icon-button>
            </div>
        </div>

        <div class="w-full relative text-white flex">
            <div class="bg-emerald-500 flex-shrink-0 flex items-center justify-center rounded-lg h-16 w-16">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-folder-icon lucide-folder"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/></svg>
            </div>

            <div class="flex-1 p-4 flex items-center">
                <h3 class="text-xl font-semibold text-gray-800">
                    {{ $list->nome }}
                </h3>
            </div>
        </div>

        <div class="flex-1 flex flex-col justify-between gap-2">
            <span class="text-sm font-medium">
                {{ $list->descricao }}
            </span>

            <div class="flex items-center justify-between">
                <x-avatar-group :items="[
                    ['nome' => 'BrainRot'],
                    ['nome' => 'BrainRot'],
                    ['nome' => 'BrainRot'],
                    ['nome' => 'BrainRot'],
                    ['nome' => 'BrainRot'],
                    ['nome' => 'BrainRot']
                ]" :max="5"/>

                <div class="flex items-center gap-x-3">
                    <div class="flex items-center gap-x-1 font-medium text-gray-400 text-sm">
                        14

                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>