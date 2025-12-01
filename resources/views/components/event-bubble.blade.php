@php
    use Carbon\Carbon;

    // Garante que temos um objeto de evento e uma data válida
    $dataInicio = $event?->data_hora_inicio instanceof \Carbon\Carbon
        ? $event->data_hora_inicio
        : Carbon::parse($event->data_hora_inicio ?? now());

    // Evento é considerado expirado se a data/hora de início já passou
    $isExpired = $dataInicio->isPast();

    $cardTheme = $isExpired ? [
        'bg'           => 'bg-white',
        'border'       => 'border-0',
        'title_color'  => 'text-gray-400 line-through',
        'text_color'   => 'text-gray-400',
        'icon_color'   => 'text-gray-300',
        'btn_class'    => 'bg-gray-200 text-gray-500 cursor-not-allowed',
        'status_label' => 'EXPIRADO',
        'active'       => false,
    ] : [
        'bg'           => 'bg-white',
        'border'       => 'border-none',
        'title_color'  => 'text-emerald-500',
        'text_color'   => 'text-gray-600',
        'icon_color'   => 'text-emerald-500',
        'btn_class'    => 'bg-emerald-500 hover:bg-emerald-600 text-white transition-colors',
        'status_label' => 'CONVITE',
        'active'       => true,
    ];

    // Esse bubble é sempre "meu" convite (lado do clube)
    $bubbleClass = 'bg-emerald-500 rounded-s-xl rounded-ee-xl';
    $nameColor   = 'text-white/90';
    $statusColor = 'text-emerald-900';
@endphp

<div class="flex items-start gap-[0.42vw] self-end flex-row-reverse mb-[0.83vw]">
    <div class="w-[1.46vw] h-[1.46vw] rounded-full flex-shrink-0 bg-emerald-500 flex items-center justify-center text-white text-[0.63vw] font-bold border-[0.1vw] border-white">
        EU
    </div>

    <div class="flex flex-col gap-[0.42vw] w-[10.42vw] leading-1.5 p-[0.75vw] {{ $bubbleClass }}">
        <div class="flex items-center gap-[0.42vw] flex-row-reverse mb-[0.42vw]">
            <span class="text-[0.75vw] font-semibold {{ $nameColor }}">
                Você
            </span>

            <span class="text-[0.75vw] font-semibold {{ $nameColor }}">
                {{ now()->format('H:i') }}
            </span>
        </div>

        <div class="w-full rounded-[0.42vw] overflow-hidden {{ $cardTheme['bg'] }} border-[0.052vw] {{ $cardTheme['border'] }} p-[0.525vw]">
            <div class="pb-[0.375vw] border-b-[0.052vw] border-gray-300 flex justify-between items-center">
                <span class="text-[0.63vw] font-semibold tracking-tight {{ $isExpired ? 'text-gray-400' : 'text-emerald-500' }}">
                    {{ $cardTheme['status_label'] }}
                </span>
                @if (! $isExpired)
                    <div class="w-[0.31vw] h-[0.31vw] rounded-full bg-emerald-500 animate-pulse"></div>
                @endif
            </div>

            <div class="flex flex-col gap-[0.21vw]">
                <h4 class="text-[0.73vw] font-medium mt-[0.21vw] leading-tight {{ $cardTheme['title_color'] }}">
                    {{ $event->titulo ?? 'Evento' }}
                </h4>

                <div class="flex flex-col gap-[0.21vw]">
                    <div class="flex items-center gap-[0.42vw] text-[0.63vw] {{ $cardTheme['text_color'] }} leading-tight">
                        <svg class="w-[0.73vw] h-[0.73vw] {{ $cardTheme['icon_color'] }} shrink-0 stroke-[0.1vw]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>{{ $dataInicio->format('d/m/Y - H:i') }}</span>
                    </div>
                    
                    <div class="flex items-center gap-[0.42vw] text-[0.63vw] {{ $cardTheme['text_color'] }} leading-tight">
                        <svg class="w-[0.73vw] h-[0.73vw] {{ $cardTheme['icon_color'] }} shrink-0 stroke-[0.1vw]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0z" />
                        </svg>
                        <span class="truncate">
                            {{ $event->endereco_formatado ?? 'Local a definir' }}
                        </span>
                    </div>
                </div>

                <div class="mt-[0.1vw]">
                    @if ($isExpired)
                        <div class="w-full py-[0.1vw] rounded text-[0.63vw] font-bold uppercase text-center border-[0.052vw] border-gray-200 bg-gray-100 text-gray-400">
                            Finalizado
                        </div>
                    @else
                        <a href="{{ route('clube.agenda', ['date' => $dataInicio->format('Y-m-d')]) }}"
                           class="block w-full py-[0.55vw] rounded text-[0.6vw] font-medium text-center {{ $cardTheme['btn_class'] }}">
                            Ver Evento
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <span class="text-[0.55vw] font-medium text-right mt-[0.31vw] {{ $statusColor }}">
            Enviado
        </span>
    </div>
</div>
