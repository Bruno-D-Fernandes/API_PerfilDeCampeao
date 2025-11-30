@php
    $status = $statusColor();
    $progress = $progress();
    $href = null;
@endphp

<div class="h-[9vw] group flex flex-col bg-white border border-[0.052vw] border-gray-300 rounded-[0.63vw] hover:border-emerald-500 transition-all duration-200 overflow-hidden relative">
    <a href="{{ $href }}" class="absolute inset-0 z-2"></a>

    <div class="w-full h-full flex flex-row overflow-hidden relative">
        <div class="absolute top-[0.63vw] right-[0.63vw] z-10 opacity-0 group-hover:opacity-100 transition-opacity">
            <div class="flex items-center bg-white rounded-[0.42vw] shadow-sm p-[0.21vw] gap-x-[0.21vw]">
                <x-icon-button color="blue" onclick="openModal('edit-opportunity-{{ $opportunity->id }}')">
                    <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
                </x-icon-button>
        
                <div class="w-[0.052vw] h-[0.83vw] bg-gray-200"></div>

                <x-icon-button color="red" onclick="openModal('delete-opportunity-{{ $opportunity->id }}')">
                    <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-icon lucide-trash"><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                </x-icon-button>
            </div>
        </div>

        <div class="absolute top-[0.63vw] right-[0.63vw]">
            <x-badge color="{{ $status['color'] }}" dot :border="false" class="px-[0.52vw]">
                {{ $status['text'] }}
            </x-badge>
        </div>

        <div class="w-full flex-1 p-[0.63vw] flex flex-col justify-between">
            <span class="text-[0.63vw] font-medium">
                Criado em: {{ \Carbon\Carbon::parse($opportunity->datapostagemOportunidades)->format('d/m/Y') }}
            </span>

            <h3 class="text-[0.83vw] font-semibold text-gray-800 truncate">
                {{ $opportunity->tituloOportunidades }}
            </h3>

            <div>
                <div class="flex items-center justify-between mb-[0.31vw]">
                    <div class="text-[0.73vw] text-gray-600 font-medium">
                        <span class="{{ $progress['is_full'] ? 'text-red-600 font-bold' : 'text-gray-900 font-bold' }}">
                            {{ $opportunity->inscricoes->count() }}
                        </span> 

                        <span class="text-gray-400">/ {{ $progress['limit'] }} vagas</span>
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

            <div class="flex items-center justify-between mt-[0.21vw]">
                @if($opportunity->inscricoes->count() > 0)
                    <x-avatar-group :items="$opportunity->inscricoes" size="sm" :max="3"/>
                @else
                    <p class="text-[0.6vw] text-gray-400 font-normal">Nenhum inscrito.</p>
                @endif

                <div class="flex items-center gap-x-[0.63vw]">
                    <div class="flex items-center gap-x-[0.21vw] font-medium text-gray-400 text-[0.73vw]">
                        <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg>

                        {{ $opportunity->inscricoesPendentes->count() }}
                    </div>

                    <div class="flex items-center gap-x-[0.21vw] font-medium text-red-500 text-[0.73vw]">
                        <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x-icon lucide-circle-x"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>

                        {{ $opportunity->inscricoesRejeitadas->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>