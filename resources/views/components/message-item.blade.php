@props([
    'message' => null,
    'isMe'    => false,
])

@php
    $containerClass = $isMe 
        ? 'self-end flex-row-reverse' 
        : 'self-start';

    $avatarClass = $isMe 
        ? 'bg-emerald-500' 
        : 'bg-gray-200';

    $bubbleClass = $isMe 
        ? 'bg-emerald-500 rounded-s-[0.63vw] rounded-ee-[0.63vw]' 
        : 'bg-gray-100 rounded-e-[0.63vw] rounded-es-[0.63vw]';

    $textAlignment   = $isMe ? 'text-right' : 'text-left';
    $headerDirection = $isMe ? 'flex-row-reverse' : '';

    $nameColor   = $isMe ? 'text-white/90' : 'text-gray-900';
    $timeColor   = $isMe ? 'text-white/70' : 'text-gray-500';
    $statusColor = $isMe ? 'text-emerald-900' : 'text-gray-400';

    // Se tiver mensagem real
    $nome  = $message->sender_name ?? ($isMe ? 'Você' : 'Contato');
    $hora  = $message && $message->created_at
        ? $message->created_at->format('H:i')
        : '11:32';

    $texto = $message->message ?? 'Insanooo!';

    $status = $message->status_label 
        ?? ($isMe ? 'Enviado' : 'Recebido');
@endphp

<div class="flex items-start gap-[0.42vw] {{ $containerClass }}">
    
    <div class="w-[1.46vw] h-[1.46vw] rounded-full flex-shrink-0 {{ $avatarClass }}">
        {{-- Aqui no futuro dá pra colocar avatar --}}
    </div>

    <div class="flex flex-col gap-[0.42vw] w-full max-w-[12.5vw] leading-1.5 p-[0.75vw] {{ $bubbleClass }}">
        <div class="flex items-center gap-[0.42vw] {{ $headerDirection }}">
            <span class="text-[0.75vw] font-semibold {{ $nameColor }}">
                {{ $nome }}
            </span>

            <span class="text-[0.75vw] font-semibold {{ $timeColor }}">
                {{ $hora }}
            </span>
        </div>

        <p class="text-[0.73vw] py-[0.31vw] text-gray-900 {{ $textAlignment }}">
            {{ $texto }}
        </p>

        <span class="text-[0.55vw] font-medium {{ $textAlignment }} {{ $statusColor }}">
            {{ $status }}
        </span>
    </div>
</div>
