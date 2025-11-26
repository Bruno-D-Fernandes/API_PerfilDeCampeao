@php
    $containerClass = $isMe 
        ? 'self-end flex-row-reverse' 
        : 'self-start';

    $avatarClass = $isMe 
        ? 'bg-emerald-500' 
        : 'bg-gray-200';

    $bubbleClass = $isMe 
        ? 'bg-emerald-500 rounded-s-xl rounded-ee-xl' 
        : 'bg-gray-50 rounded-e-xl rounded-es-xl';

    $textAlignment = $isMe ? 'text-right' : 'text-left';
    $headerDirection = $isMe ? 'flex-row-reverse' : '';
    
    $nameColor = $isMe ? 'text-white/90' : 'text-gray-900';
    $timeColor = $isMe ? 'text-white/70' : 'text-gray-500';
    $statusColor = $isMe ? 'text-emerald-900' : 'text-gray-400';

    $status = $isMe ? 'Enviado' : 'Recebido';
@endphp

<div class="flex items-start gap-2 {{ $containerClass }}">
    
    <div class="w-8 h-8 rounded-full flex-shrink-0 {{ $avatarClass }}">
        </div>

    <div class="flex flex-col w-full max-w-[320px] leading-1.5 p-3 {{ $bubbleClass }}">
        
        <div class="flex items-center gap-2 {{ $headerDirection }}">
            <span class="text-sm font-semibold {{ $nameColor }}">
                João Pedro
            </span>

            <span class="text-sm {{ $timeColor }}">
                11:32
            </span>
        </div>

        <p class="text-sm py-2.5 text-gray-900 {{ $textAlignment }}">
            Insanooo!
        </p>

        <span class="text-xs font-medium {{ $textAlignment }} {{ $statusColor }}">
            {{ $status}}
        </span>
    </div>
</div>