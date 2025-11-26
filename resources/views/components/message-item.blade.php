@php
    $containerClass = $isMe 
        ? 'self-end flex-row-reverse' 
        : 'self-start';

    $avatarClass = $isMe 
        ? 'bg-emerald-500' 
        : 'bg-gray-200';

    $bubbleClass = $isMe 
        ? 'bg-emerald-500 rounded-s-xl rounded-ee-xl' 
        : 'bg-gray-100 rounded-e-xl rounded-es-xl';

    $textAlignment = $isMe ? 'text-right' : 'text-left';
    $headerDirection = $isMe ? 'flex-row-reverse' : '';
    
    $nameColor = $isMe ? 'text-white/90' : 'text-gray-900';
    $timeColor = $isMe ? 'text-white/70' : 'text-gray-500';
    $statusColor = $isMe ? 'text-emerald-900' : 'text-gray-400';

    $status = $isMe ? 'Enviado' : 'Recebido';
@endphp

<div class="flex items-start gap-2 {{ $containerClass }}">
    
    <div class="w-8 md:w-7 h-8 md:h-7 rounded-full flex-shrink-0 {{ $avatarClass }}">
        </div>

    <div class="flex flex-col w-full max-w-[320px] md:max-w-[240px] leading-1.5 p-3 md:p-2 {{ $bubbleClass }}">
        
        <div class="flex items-center gap-2 {{ $headerDirection }}">
            <span class="text-sm md:text-xs font-semibold {{ $nameColor }}">
                João Pedro
            </span>

            <span class="text-sm md:text-[9px] {{ $timeColor }}">
                11:32
            </span>
        </div>

        <p class="text-sm py-2.5 md:py-1.5 text-gray-900 {{ $textAlignment }}">
            Insanooo!
        </p>

        <span class="text-xs md:text-[8px] font-medium {{ $textAlignment }} {{ $statusColor }}">
            {{ $status}}
        </span>
    </div>
</div>