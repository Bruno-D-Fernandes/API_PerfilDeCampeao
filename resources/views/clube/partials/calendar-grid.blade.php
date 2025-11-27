<div class="absolute inset-0 grid grid-cols-7 gap-[0.052vw] overflow-hidden rounded-[0.42vw] bg-gray-200 auto-rows-[1fr]">
    @foreach($dias as $dia)
        <x-calendar-day 
            :day="$dia['numero']" 
            :is-today="$dia['is_today']"
            class="min-h-0 flex flex-col bg-white relative group transition-colors hover:bg-emerald-50" 
            style="{{ $loop->first ? 'grid-column-start: ' . $colStart : '' }}"
            onclick="selectDate('{{ $dia['full_date'] }}')"
        >
            @php $qtdEventos = count($dia['eventos']); @endphp

            <div class="flex-1 overflow-y-auto p-[0.1vw] custom-scrollbar">
                @foreach($dia['eventos'] as $evento)
                    @if($loop->index + 1 <= $maxEventos)
                        <div class="flex gap-x-[0.21vw] items-center mb-[0.21vw]">
                            <div class="w-[0.31vw] h-[0.31vw] rounded-full shrink-0" style="background-color: {{ $evento['color'] }};"></div>
                            
                            <span class="text-[0.63vw] font-medium truncate" style="color: {{ $evento['color'] }};">
                                {{ $evento['titulo'] }}
                            </span>
                        </div>
                    @endif
                @endforeach

                @if($qtdEventos > $maxEventos)
                    <div class="sticky bottom-0 bg-white/95 backdrop-blur-sm py-[0.1vw] text-[0.63vw] text-gray-500 hover:text-green-600 font-medium cursor-pointer hover:underline transition-colors border-t-[0.052vw] border-transparent">
                        + {{ $qtdEventos - $maxEventos }} mais
                    </div>
                @endif
            </div>
        </x-calendar-day>
    @endforeach
</div>