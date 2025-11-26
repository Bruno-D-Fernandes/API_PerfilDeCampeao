@php
    use Carbon\Carbon;

    $dataInicio = Carbon::parse($event->data_inicio ?? now()); 
    $isExpired = false;

    $cardTheme = $isExpired ? [
        'bg'           => 'bg-white',
        'border'       => 'border-0',
        'title_color'  => 'text-gray-400 line-through',
        'text_color'   => 'text-gray-400',
        'icon_color'   => 'text-gray-300',
        'btn_class'    => 'bg-gray-200 text-gray-500 cursor-not-allowed',
        'status_label' => 'EXPIRADO',
        'active'       => false
    ] : [
        'bg'           => 'bg-white',
        'border'       => 'border-none',
        'title_color'  => 'text-emerald-500',
        'text_color'   => 'text-gray-600',
        'icon_color'   => 'text-emerald-500',
        'btn_class'    => 'bg-emerald-500 hover:bg-emerald-600 text-white transition-colors',
        'status_label' => 'CONVITE',
        'active'       => true
    ];

    $bubbleClass = 'bg-emerald-500 rounded-s-xl rounded-ee-xl';
    $nameColor = 'text-white/90';
    $timeColor = 'text-white/70';
    $statusColor = 'text-emerald-900';
@endphp

<div class="flex items-start gap-2 self-end flex-row-reverse mb-4 md:mb-3">
    <div class="w-8 md:w-7 h-8 md:h-7 rounded-full flex-shrink-0 bg-emerald-500 flex items-center justify-center text-white text-xs font-bold border-2 border-white">
        EU
    </div>

    <div class="flex flex-col w-[240px] md:w-[200px] leading-1.5 p-3 md:p-2 {{ $bubbleClass }}">
        <div class="flex items-center gap-2 flex-row-reverse mb-2">
            <span class="text-sm md:text-xs font-semibold {{ $nameColor }}">
                Você
            </span>
            <span class="text-xs md:text-[9px] {{ $timeColor }}">
                {{ now()->format('H:i') }}
            </span>
        </div>

        <div class="w-full rounded-lg overflow-hidden {{ $cardTheme['bg'] }} border {{ $cardTheme['border'] }} p-3 md:p-2">
            <div class="pb-1.5 md:pb-0.5 border-b border-gray-300 flex justify-between items-center">
                <span class="text-sm md:text-xs font-semibold tracking-tight {{ $isExpired ? 'text-gray-400' : 'text-emerald-500' }}">
                    {{ $cardTheme['status_label'] }}
                </span>
                @if(!$isExpired)
                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                @endif
            </div>

            <div class="flex flex-col gap-2 md:gap-1">
                <h4 class="text-sm md:text-s font-medium mt-2 md:mt-1 leading-tight {{ $cardTheme['title_color'] }}">
                    {{ $event->titulo ?? 'Evento' }}
                </h4>

                <div class="flex flex-col gap-1">
                    <div class="flex items-center gap-2 text-xs {{ $cardTheme['text_color'] }}">
                        <svg class="w-3.5 h-3.5 {{ $cardTheme['icon_color'] }} shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <span>{{ $dataInicio->format('d/m/Y - H:i') }}</span>
                    </div>
                    
                    <div class="flex items-center gap-2 text-xs {{ $cardTheme['text_color'] }}">
                        <svg class="w-3.5 h-3.5 {{ $cardTheme['icon_color'] }} shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        <span class="truncate">{{ $event->local ?? 'A definir' }}</span>
                    </div>
                </div>

                <div class="mt-0.5">
                    @if($isExpired)
                        <div class="w-full py-1.5 md:py-0.5 rounded text-xs font-bold uppercase text-center border border-gray-200 bg-gray-100 text-gray-400">
                            Finalizado
                        </div>
                    @else
                        <a href="{{ route('clube.agenda', ['date' => $dataInicio->format('Y-m-d')]) }}" class="block w-full py-2 md:py-1 rounded text-sm font-medium text-center {{ $cardTheme['btn_class'] }}">
                            Ver Evento
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <span class="text-xs md:text-[8px] font-medium text-right {{ $statusColor }} mt-1.5">
            Enviado
        </span>
    </div>
</div>