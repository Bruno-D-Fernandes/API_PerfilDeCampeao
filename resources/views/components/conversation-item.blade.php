@props([
    'chat' => null,
])

@php
    if ($chat) {
        // Suporta tanto array quanto objeto/Eloquent
        $nomeContato    = data_get($chat, 'contact.name', 'Contato');
        $ultimaMensagem = data_get($chat, 'last_message.text', '');
        $horaUltima     = data_get($chat, 'last_message.time', '');
        $naoLidas       = data_get($chat, 'unread_count', 0);
    } else {
        // Mock padrão para quando você passar :chat="null"
        $nomeContato    = 'João Pedro Insano';
        $ultimaMensagem = 'Vai corinthians';
        $horaUltima     = '12:45';
        $naoLidas       = 3;
    }
@endphp

<div class="flex items-center justify-between bg-gray-50 rounded-[0.42vw] hover:bg-gray-100 transition-colors cursor-pointer p-[0.42vw]">
    <div class="flex items-center gap-x-[0.42vw] w-full">
        <div class="h-[2.08vw] w-[2.08vw] aspect-square rounded-full bg-gray-200">
            {{-- Futuro: avatar do contato aqui --}}
            @if(false && isset($chat['contact']['avatar']))
                <img src="{{ $chat['contact']['avatar'] }}" class="w-full h-full object-cover">
            @endif
        </div>

        <div class="w-full h-full flex flex-col justify-between">
            <h2 class="text-[0.73vw] font-medium tracking-tight text-gray-800 truncate">
                {{ $nomeContato }}
            </h2>

            @if($ultimaMensagem)
                <h3 class="text-[0.63vw] font-normal text-gray-500 truncate">
                    {{ $ultimaMensagem }}
                </h3>
            @endif
        </div>
    </div>

    <div class="h-full flex flex-col items-end justify-center gap-y-[0.31vw]">
        @if($horaUltima)
            <span class="text-[0.63vw] font-normal text-gray-700 pl-[0.63vw]">
                {{ $horaUltima }}
            </span>
        @endif

        @if($naoLidas > 0)
            <div class="h-[0.83vw] w-[0.83vw] bg-emerald-500 flex items-center justify-center rounded-full">
                <span class="text-[0.47vw] font-semibold text-white">
                    {{ $naoLidas }}
                </span>
            </div>
        @endif
    </div>
</div>
