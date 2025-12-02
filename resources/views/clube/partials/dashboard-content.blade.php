<div class="shrink-0 grid grid-rows-[auto_1fr] gap-[0.42vw] h-full min-h-0">
    <div class="w-full grid grid-cols-4 gap-[0.83vw] shrink-0">
        <x-dashboard-widget 
            title="Inscrições pendentes" 
            :value="$dados['resumo']['inscricoes_pendentes']['mes_atual']" 
            :trend="$dados['resumo']['inscricoes_pendentes']['percentual']"
        >
            <x-slot:icon>
                <svg class="h-[0.83vw] w-[0.83vw] text-emerald-500/70" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg>
            </x-slot:icon>
        </x-dashboard-widget>

        <x-dashboard-widget 
            title="Oportunidades ativas" 
            :value="$dados['resumo']['oportunidades_ativas']['total_ativo_agora']" 
            :trend="$dados['resumo']['oportunidades_ativas']['percentual']"
        >
            <x-slot:icon>
                <svg class="h-[0.83vw] w-[0.83vw] text-emerald-500/70" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-megaphone-icon lucide-megaphone"><path d="M11 6a13 13 0 0 0 8.4-2.8A1 1 0 0 1 21 4v12a1 1 0 0 1-1.6.8A13 13 0 0 0 11 14H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z"/><path d="M6 14a12 12 0 0 0 2.4 7.2 2 2 0 0 0 3.2-2.4A8 8 0 0 1 10 14"/><path d="M8 6v8"/></svg>
            </x-slot:icon>
        </x-dashboard-widget>

        @php
            $evento = $dados['resumo']['proximo_evento']['evento'];
            $textoEvento = $evento 
                ? $evento->titulo . ' (' . \Carbon\Carbon::parse($evento->data_hora_inicio)->format('d/m') . ')'
                : 'Nenhum evento';
        @endphp
        
        <x-dashboard-widget 
            title="Próximo evento" 
            :value="$textoEvento"
        >
            <x-slot:icon>
                <svg class="h-[0.83vw] w-[0.83vw] text-emerald-500/70" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-icon lucide-calendar"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
            </x-slot:icon>
        </x-dashboard-widget>

        <x-dashboard-widget 
            title="Perfis salvos" 
            :value="$dados['resumo']['usuarios_unicos_listas']['total']" 
            :trend="$dados['resumo']['usuarios_unicos_listas']['percentual']" 
        >
            <x-slot:icon>
                <svg class="h-[0.83vw] w-[0.83vw] text-emerald-500/70" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
            </x-slot:icon>
        </x-dashboard-widget>
    </div>
</div>

<div class="flex-1 h-full min-h-0">
    <div class="h-full grid grid-cols-10 gap-[0.83vw] min-h-0">
        <div class="h-full col-span-7 flex flex-col gap-[0.83vw]">
            <div class="grid grid-cols-2 gap-[0.83vw] flex-1">
                <div class="bg-white p-[0.83vw] rounded-[0.42vw] border border-[0.15vw] border-gray-200 hover:border-emerald-500 transition-colors flex flex-col gap-[0.415vw]">
                    <span class="text-[0.83vw] font-medium text-gray-700">
                        Distribuição por posições
                    </span>

                    <div class="relative flex-1 min-h-0">
                        <div id="chart-posicoes" class="absolute inset-0" data-json="{{ json_encode($dados['distribuicaoPosicoes']) }}"></div>
                    </div>
                </div>

                <div class="bg-white h-full p-[0.83vw] rounded-[0.42vw] border border-[0.15vw] border-gray-200 hover:border-emerald-500 transition-colors flex flex-col gap-[0.73vw]">
                    <span class="text-[0.83vw] font-medium text-gray-700">
                        Origem das candidaturas
                    </span>

                    <div class="relative flex-1 min-h-0">
                        <div id="chart-origem" class="absolute inset-0" data-json="{{ json_encode($dados['topEstados']) }}"></div>
                    </div>
                </div>
            </div>

            <div class="flex-1 h-full min-h-0">
                <div class="bg-white h-full p-[0.83vw] rounded-[0.42vw] border border-[0.15vw] border-gray-200 hover:border-emerald-500 transition-colors flex flex-col gap-[0.73vw]">
                    <span class="text-[0.83vw] font-medium text-gray-700">
                        Evolução de candidaturas
                    </span>

                    <div class="relative flex-1 min-h-0">
                        <div id="chart-evolucao" class="absolute inset-0" data-json="{{ json_encode($dados['inscricoesMensais']) }}"></div>
                    </div>
                </div>
            </div>

            <div class="flex-1 flex flex-col max-h-[12.5vw]">
                <div class="bg-white h-full p-[0.83vw] rounded-[0.42vw] border border-[0.15vw] border-gray-200 hover:border-emerald-500 transition-colors flex flex-col gap-[0.42vw]">
                    <div class="flex items-center gap-x-[0.42vw] shrink-0 pb-[0.2vw]">
                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-activity-icon lucide-activity"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                        <span class="text-[0.83vw] font-medium text-gray-700">
                            Atividades recentes
                        </span>
                    </div>

                    <div class="w-full border border-t-[0.052vw] border-gray-200 shrink-0"></div>

                    <div class="flex-1 flex flex-col overflow-hidden">
                        
                        @php
                            $atividades = collect()
                                ->concat($dados['atividadesRecentes']['oportunidades'])
                                ->concat($dados['atividadesRecentes']['inscricoes'])
                                ->sortByDesc('created_at')
                                ->take(5);

                            $icons = [
                                'pending'  => '<svg class="h-[0.83vw] w-[0.83vw] text-gray-900" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
                                'approved' => '<svg class="h-[0.83vw] w-[0.83vw] text-emerald-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
                                'rejected' => '<svg class="h-[0.83vw] w-[0.83vw] text-red-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" x2="9" y1="9" y2="15"/><line x1="9" x2="15" y1="9" y2="15"/></svg>',
                            ];
                        @endphp

                        <div class="flex flex-col gap-[0.42vw]">
                            @forelse($atividades as $atividade)
                                @php
                                    $mensagem = '';
                                    $statusIcon = '';
                                    $data = $atividade->created_at->diffForHumans();
                                    $status = $atividade->status ?? 'pending'; // Fallback

                                    if ($atividade instanceof App\Models\Oportunidade) {
                                        $nomeEsporte = $atividade->esporte->nomeEsporte ?? 'Esporte';
                                        
                                        $statusIcon = $icons[$status] ?? $icons['pending'];

                                        if ($status === 'approved') {
                                            $mensagem = "Oportunidade de <strong>{$nomeEsporte}</strong> publicada.";
                                        } elseif ($status === 'rejected') {
                                            $mensagem = "Oportunidade de <strong>{$nomeEsporte}</strong> encerrada.";
                                        } else {
                                            $mensagem = "Nova oportunidade criada para <strong>{$nomeEsporte}</strong>.";
                                        }
                                    } elseif ($atividade instanceof App\Models\Inscricao) {
                                        $nomeUser = $atividade->usuario->nomeCompletoUsuario ?? 'Usuário';
                                        
                                        $statusIcon = $icons[$status] ?? $icons['pending'];

                                        switch ($status) {
                                            case 'approved':
                                                $mensagem = "Inscrição de <strong>{$nomeUser}</strong> aprovada.";
                                                break;
                                            case 'rejected':
                                                $mensagem = "Inscrição de <strong>{$nomeUser}</strong> recusada.";
                                                break;
                                            default:
                                                $mensagem = "<strong>{$nomeUser}</strong> solicitou inscrição.";
                                        }
                                    }
                                @endphp

                                <div class="flex items-start gap-x-[0.63vw] p-[0.31vw] border-b border-gray-50 last:border-b-0 hover:bg-gray-50 transition-colors rounded-[0.21vw]">
                                    <div class="flex-shrink-0">
                                        {!! $statusIcon !!}
                                    </div>

                                    <div class="flex-1 min-w-0 flex flex-col">
                                        <p class="text-[0.73vw] text-gray-600 leading-tight truncate">
                                            {!! $mensagem !!}
                                        </p>

                                        <span class="text-[0.63vw] text-gray-400">
                                            {{ $data }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="flex-1 h-full flex flex-col items-center justify-center text-center py-4 opacity-60">
                                    <x-empty-state text="Sem atividades recentes.">
                                        <x-slot:icon>
                                            <svg class="h-[1.25vw] w-[1.25vw] text-gray-300 mb-[0.21vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                                        </x-slot:icon>
                                    </x-empty-state>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="h-full col-span-3 flex flex-col gap-[0.83vw] min-h-0">
            @php
                $evento = $dados['proximosEventos']->first();
            @endphp

            <div class="bg-white p-[0.83vw] rounded-[0.42vw] border border-[0.15vw] border-gray-200 hover:border-emerald-500 transition-colors flex flex-1 flex-col gap-[0.63vw]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-x-[0.42vw]">
                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days-icon lucide-calendar-days"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>

                        <span class="text-[0.83vw] font-medium text-gray-700">
                            Próximo evento
                        </span>
                    </div>

                    @if($evento)
                        <div class="relative cursor-pointer h-[1.04vw] w-[1.04vw] rounded-full bg-{{ $evento->color ?? 'emerald' }}-500" title="Evento Ativo"></div>
                    @endif
                </div>

                <div class="w-full border border-t-[0.052vw] border-gray-200"></div>

                @if($evento)
                    <div class="flex flex-col gap-[0.42vw]">
                        <div class="flex flex-col gap-[0.31vw]">
                            <h2 class="text-[1.04vw] font-medium tracking-tight text-gray-800 truncate" title="{{ $evento->titulo }}">
                                {{ $evento->titulo }}
                            </h2>
                            
                            <h3 class="text-[0.83vw] font-normal text-gray-700 line-clamp-2" title="{{ $evento->descricao }}">
                                {{ $evento->descricao }}
                            </h3>
                        </div> 
                        
                        <div class="flex items-center gap-x-[0.42vw]">
                            <svg class="h-[0.83vw] w-[0.83vw] text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg>

                            <span class="text-[0.73vw] font-medium text-gray-500 truncate">
                                {{ \Carbon\Carbon::parse($evento->data_hora_inicio)->format('d/m - H:i') }}
                            </span>
                        </div>

                        <div class="flex items-center gap-x-[0.42vw]">
                            <svg class="h-[0.83vw] w-[0.83vw] text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin-icon lucide-map-pin"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>

                            <span class="block text-[0.73vw] font-medium text-gray-500 truncate">
                                {{ $evento->cidade }} - {{ $evento->estado }}
                            </span>
                        </div>

                        <div>
                            <div class="flex justify-between text-[0.63vw] text-gray-500 mb-[0.2vw]">
                                <span>Confirmações</span>
                                <span class="font-bold">{{ $evento->convites_count }}</span>
                            </div>

                            <x-progress 
                                :percentage="min($evento->convites_count, 100)" 
                                :showValue="false" 
                                color="{{ $evento->color ?? 'green' }}" 
                            />
                        </div>

                        <a href="{{ route('clube.agenda') }}">
                            <x-button color="clube" :full="true" class="mt-[0.21vw]">
                                Ver agenda
                            </x-button>
                        </a>
                    </div>
                @else
                    <div class="flex-1 flex items-center justify-center">
                        <x-empty-state text="Nenhum evento agendado.">
                            <x-slot:icon>
                                <svg class="w-[2vw] h-[2vw] text-gray-300" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-off"><path d="M4.2 4.2l15.6 15.6"/><path d="M21 10V6a2 2 0 0 0-2-2h-3"/><path d="M3 6v14a2 2 0 0 0 2 2h14"/><path d="M8 2v4"/><path d="M16 2v2"/><path d="M3 10h9.5"/><path d="M16.5 20.5L21 16"/></svg>
                            </x-slot:icon>
                        </x-empty-state>
                    </div>
                @endif
            </div>

            <div class="bg-white p-[0.83vw] rounded-[0.42vw] border border-[0.15vw] border-gray-200 hover:border-emerald-500 flex-1 transition-colors flex flex-col gap-[0.63vw]">
                <div class="flex items-center gap-x-[0.42vw]">
                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hourglass-icon lucide-hourglass"><path d="M5 22h14"/><path d="M5 2h14"/><path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22"/><path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2"/></svg>

                    <span class="text-[0.83vw] font-medium text-gray-700">
                        Inscrições pendentes
                    </span>
                </div>

                <div class="w-full border border-t-[0.052vw] border-gray-200"></div>

                <div class="flex-1 flex flex-col overflow-y-hidden min-h-0 gap-[0.42vw]">
                    @forelse($dados['atividadesRecentes']['inscricoes'] as $inscricao)
                        <div class="flex items-center justify-between hover:bg-gray-50 rounded-[0.31vw] transition-colors group">
                            <div class="flex items-center gap-x-[0.63vw] overflow-hidden">
                                <div class="h-[1.2vw] w-[0.2vw] bg-emerald-500 rounded-full"></div>

                                <div class="flex flex-col min-w-0">
                                    <span class="text-[0.83vw] font-medium text-gray-700 truncate">
                                        {{ $inscricao->usuario->nomeCompletoUsuario ?? 'Usuário desconhecido' }}
                                    </span>

                                    <a href="{{ route('clube.minhas-oportunidades', $inscricao->oportunidade->id ?? 0) }}" 
                                    class="text-[0.63vw] font-medium text-gray-400 hover:text-emerald-500 transition-colors truncate">
                                        {{ $inscricao->oportunidade->tituloOportunidades ?? 'Oportunidade removida' }}
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-center gap-x-[0.42vw] opacity-0 group-hover:opacity-100 transition-opacity">
                                <x-icon-button color="red" title="Recusar">
                                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                </x-icon-button>
                            
                                <div class="w-[0.052vw] h-[0.83vw] bg-gray-200"></div>

                                <x-icon-button color="green" title="Aprovar">
                                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
                                </x-icon-button>
                            </div>
                        </div>
                    @empty
                        <div class="flex-1 h-full flex flex-col items-center justify-center text-center opacity-60">
                            <x-empty-state text="Nenhuma inscrição pendente.">
                                <x-slot:icon>
                                    <svg class="w-[1.5vw] h-[1.5vw] text-gray-300" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle-2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                                </x-slot:icon>
                            </x-empty-state>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>