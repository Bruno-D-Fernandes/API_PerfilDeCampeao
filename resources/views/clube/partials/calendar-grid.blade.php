<div class="absolute inset-0 grid grid-cols-7 gap-px overflow-hidden rounded-lg bg-gray-200 auto-rows-[1fr]">
    @foreach($dias as $dia)
        <x-calendar-day 
            :day="$dia['numero']" 
            :is-today="$dia['is_today']"
            class="min-h-0 flex flex-col bg-white relative group transition-colors hover:bg-emerald-50" 
            style="{{ $loop->first ? 'grid-column-start: ' . $colStart : '' }}"
            onclick="selectDate('{{ $dia['full_date'] }}')"
        >
            @php $qtdEventos = count($dia['eventos']); @endphp

            <div class="flex-1 overflow-y-auto px-1 custom-scrollbar">
                @foreach($dia['eventos'] as $evento)
                    @if($loop->index + 1 <= $maxEventos)
                        <div class="flex gap-x-2 items-center mb-1">
                            <div class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: {{ $evento['color'] }};"></div>
                            <span class="text-sm font-medium truncate" style="color: {{ $evento['color'] }};">
                                {{ $evento['titulo'] }}
                            </span>
                        </div>
                    @endif
                @endforeach

                @if($qtdEventos > $maxEventos)
                    <div class="sticky bottom-0 bg-white/95 backdrop-blur-sm py-0.5 text-xs text-gray-500 hover:text-green-600 font-medium cursor-pointer hover:underline transition-colors border-t border-transparent">
                        + {{ $qtdEventos - $maxEventos }} mais
                    </div>
                @endif
            </div>
        </x-calendar-day>
    @endforeach
</div>