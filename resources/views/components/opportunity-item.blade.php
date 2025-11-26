@php
    $status = $statusColor();
    $progress = $progress();
    $href = null;
@endphp

<div class="group flex flex-col bg-white border border-gray-300 rounded-xl hover:border-emerald-500 transition-all duration-200 overflow-hidden relative">
    <a href="{{ $href }}" class="absolute inset-0 z-2"></a>

    <div class="flex flex-row overflow-hidden relative">
        <div class="absolute top-3 right-3 z-10 opacity-0 group-hover:opacity-100 transition-opacity">
            <div class="flex items-center bg-white rounded-lg shadow-sm p-1 gap-x-1">
                <x-icon-button color="blue" onclick="openModal('edit-opportunity-{{ $opportunity->id }}')">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
                </x-icon-button>
        
                <div class="w-px h-4 bg-gray-200"></div>

                <x-icon-button color="red" onclick="openModal('delete-opportunity-{{ $opportunity->id }}')">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-icon lucide-trash"><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                </x-icon-button>
            </div>
        </div>

        <div class="absolute top-3 right-3">
            <x-badge color="{{ $status['color'] }}" dot :border="false" class="px-2.5">
                {{ $status['text'] }}
            </x-badge>
        </div>

        <div class="flex-1 p-4 flex flex-col justify-between gap-2">
            <span class="text-sm font-medium">
                Criado em: {{ \Carbon\Carbon::parse($opportunity->data)->format('d/m/Y') }}
            </span>

            <h3 class="text-xl font-semibold text-gray-800">
                {{ $opportunity->titulo }}
            </h3>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <div class="text-sm text-gray-600 font-medium">
                        @if($progress)
                            <span class="{{ $progress['is_full'] ? 'text-red-600 font-bold' : 'text-gray-900 font-bold' }}">
                                {{ $opportunity->inscritos }}
                            </span> 
                            <span class="text-gray-400">/ {{ $progress['limit'] }} vagas</span>
                        @else
                            <span class="text-gray-900 font-bold">{{ $opportunity->inscritos }}</span> inscritos
                        @endif
                    </div>
                </div>

                @if($progress)
                    <x-progress 
                        :percentage="$progress['percentage']" 
                        :showValue="false" 
                        color="{{ $progress['is_full'] ? 'red' : 'green' }}" 
                    />
                @endif
            </div>

            <div class="flex items-center justify-between mt-1">
                <x-avatar-group :items="[
                    ['nome' => 'BrainRot'],
                    ['nome' => 'BrainRot'],
                    ['nome' => 'BrainRot'],
                    ['nome' => 'BrainRot'],
                    ['nome' => 'BrainRot'],
                    ['nome' => 'BrainRot']
                ]" :max="3"/>

                <div class="flex items-center gap-x-3">
                    <div class="flex items-center gap-x-1 font-medium text-gray-400 text-sm">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg>

                        47
                    </div>

                    <div class="flex items-center gap-x-1 font-medium text-red-500 text-sm">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x-icon lucide-circle-x"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>

                        32
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>