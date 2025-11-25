<x-layouts.clube title="Agenda" :breadcrumb="[
    'Dashboard' => route('admin-clubes'),
    'Agenda' => null,
]">
    @php
        $colStart = 4; 

        $dias = [];
        
        for ($i = 1; $i <= 30; $i++) {
            $listaEventos = [];

            if ($i == 5) {
                $listaEventos[] = ['titulo' => 'Treino Tático', 'color' => '#22c55e'];
            }

            if ($i == 12) {
                $listaEventos[] = ['titulo' => 'Final Regional', 'color' => '#ef4444'];
                $listaEventos[] = ['titulo' => 'Fisioterapia', 'color' => '#3b82f6'];
            }

            if ($i == 20) {
                $listaEventos[] = ['titulo' => 'Reunião Diretoria', 'color' => '#eab308'];
                $listaEventos[] = ['titulo' => 'Peneira Sub-15', 'color' => '#a855f7'];
                $listaEventos[] = ['titulo' => 'Manutenção Campo', 'color' => '#64748b'];
                $listaEventos[] = ['titulo' => 'Visita Técnica', 'color' => '#f97316'];
            }

            $dias[] = [
                'numero' => $i,
                'is_today' => ($i == 12),
                'eventos' => $listaEventos
            ];
        }

        $maxEventos = 3;
    @endphp

    <div class="flex flex-col gap-4">
        <div class="w-full h-auto flex flex-col gap-4 bg-emerald-500 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div class="flex gap-x-4 items-center">
                    <div class="flex gap-x-1 items-end text-white">
                        <span class="text-2xl font-semibold">
                            Novembro
                        </span>

                        <span class="text-md font-medium">
                            2025
                        </span>
                    </div>

                    <div class="h-8 bg-gray-100 flex gap-x-1 rounded-md p-1">
                        <div class="h-full aspect-square bg-white text-gray-400 rounded-sm flex items-center justify-center">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left"><path d="m15 18-6-6 6-6"/></svg>
                        </div>

                        <div class="h-full aspect-square bg-white text-gray-400 rounded-sm flex items-center justify-center">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <x-button color="none" size="md" class="bg-white text-emerald-500">
                        Adicionar novo evento
                    </x-button>
                </div>
            </div>
            
            <div class="w-full flex items-center justify-between bg-white rounded-lg">
                <x-search-input class="w-96" placeholder="Buscar evento por título..." style="background-color: #fff !important;">

                </x-search-input>

                <div class="h-5 border border-l border-gray-200"></div>

                <div>
                    <div class="flex gap-x-4 items-center pr-4">
                        @foreach(['red', 'orange', 'amber', 'yellow', 'sky', 'blue', 'indigo', 'purple', 'emerald', 'green', 'teal'] as $cor)
                            <button class="relative cursor-pointer h-5 w-5 rounded-full bg-{{ $cor }}-500 group">
                                <div class="absolute inset-0 z-10 rounded-full bg-black/10 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
                                </div>
                            </button>
                        @endforeach

                        <div class="h-5 border border-l border-gray-200"></div>

                        <x-button color="none" class="pl-0 pr-0 border-none bg-transparent text-emerald-800">
                            Limpar filtros
                        </x-button>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-7">
            @foreach(['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'] as $diaSemana)
                <div class="text-center font-bold text-gray-500 text-xs uppercase py-2">
                    {{ $diaSemana }}
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-7 gap-px bg-gray-200 border border-gray-200 rounded-lg overflow-hidden">
            @foreach($dias as $dia)
                <x-calendar-day 
                    :day="$dia['numero']" 
                    :is-today="$dia['is_today']"
                    class="{{ $loop->first ? 'col-start-' . $colStart : '' }}"
                >
                    @php
                        $qtdEventos = count($dia['eventos']);
                    @endphp

                    @foreach($dia['eventos'] as $evento)
                        @if($loop->index + 1 <= $maxEventos)
                            <div class="flex gap-x-2 items-center">
                                <div class="w-3 h-3 rounded-full shrink-0" style="background-color: {{ $evento['color'] }};"></div>

                                <span class="text-md font-medium text-gray-700 truncate">
                                    {{ $evento['titulo'] }}
                                </span>
                            </div>
                        @endif
                    @endforeach

                    @if($qtdEventos > $maxEventos)
                        <div class="text-xs text-gray-500 hover:text-green-600 font-medium cursor-pointer hover:underline transition-colors">
                            + {{ $qtdEventos - $maxEventos }} mais
                        </div>
                    @endif
                </x-calendar-day>
            @endforeach
            
        </div>
    </div>
</x-layouts.clube>