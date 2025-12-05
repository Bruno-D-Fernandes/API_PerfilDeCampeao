{{-- resources/views/clube/mensagens.blade.php --}}
<x-layouts.clube title="Mensagens" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Mensagens' => null,
]">
    @php
        $eventos = $eventos ?? collect();
    @endphp

    <div class="flex w-full gap-x-[1.25vw] flex-1 min-h-0 h-full">
        <div class="flex-1 bg-white w-[33.33vw] border border-[0.052vw] border-gray-300 rounded-[0.63vw] p-[0.63vw] flex flex-col gap-[0.63vw] h-full">
            <div class="w-full">
                <x-search-input 
                    name="search_conversation"
                    placeholder="Pesquisar por conversas..."
                ></x-search-input>

                <div class="w-full border-t-[0.052vw] border-gray-200 mt-[0.63vw]"></div>
            </div>

            <div class="flex-1 min-h-0 overflow-y-auto custom-scrollbar flex flex-col gap-[0.31vw]" id="conversation-list">
                <div id="conversation-empty" class="text-[0.63vw] text-gray-500">
                    Nenhuma conversa encontrada.
                </div>
            </div>
        </div>

        <div class="flex-[3] flex flex-col bg-white w-full border border-[0.052vw] border-gray-300 rounded-[0.63vw] p-[0.63vw] gap-[0.63vw]
        h-full min-h-[24rem]">
            <div class="flex items-center gap-x-[0.42vw]">
                <div class="w-[2.08vw] h-[2.08vw] rounded-full bg-gray-200 overflow-hidden" id="chat-contact-avatar"></div>
                <span class="text-[0.73vw] font-semibold" id="chat-contact-name">
                    Selecione uma conversa
                </span>
            </div>

            <div class="w-full border-t-[0.052vw] border-gray-200"></div>

            {{-- ÁREA DAS MENSAGENS (TEM QUE TER SCROLL AQUI) --}}
            <div class="flex-1 min-h-0 overflow-y-auto custom-scrollbar pr-[0.21vw]" id="chat-messages-container">
                <div class="flex flex-col gap-y-[0.63vw] justify-end min-h-full" id="messages-list"> 
                    <div id="messages-empty" class="text-[0.63vw] text-gray-900 justify-center items-center mb-80 flex-column">
                      <div class="flex-1 h-full flex flex-col items-center justify-center text-center py-4 opacity-80">
                            <x-empty-state text="Nenhuma conversa selecionada.">
                                <x-slot:icon>
                                    <svg class="w-12 h-12"xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-circle-off-icon lucide-message-circle-off"><path d="m2 2 20 20"/><path d="M4.93 4.929a10 10 0 0 0-1.938 11.412 2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 0 0 11.302-1.989"/><path d="M8.35 2.69A10 10 0 0 1 21.3 15.65"/></svg>
                                </x-slot:icon>
                            </x-empty-state>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full border-t-[0.052vw] border-gray-200"></div>

            <div>
                <form id="chat-send-form">
                    <x-message-input name="message" placeholder="Digite sua mensagem..." />
                </form>
            </div>
        </div>
    </div>

    <x-modal maxWidth="xl" name="send-invite-modal" title="Enviar Convite" titleSize="[1.04vw]" titleColor="emerald">
        <div class="flex flex-col gap-[0.83vw]">
            <x-search-input placeholder="Buscar eventos..."></x-search-input>

            <div class="flex flex-col gap-[0.42vw]">
                <h3 class="text-[0.63vw] font-semibold text-gray-400 uppercase tracking-wider">
                    Próximos Eventos
                </h3>

                <div class="max-h-[12.5vw] overflow-y-auto flex flex-col gap-[0.42vw] custom-scrollbar pr-[0.21vw]" id="event-list-container">
                    @forelse ($eventos as $evento)
                        @php $isFirst = $loop->first; @endphp

                        <div onclick="selectEvent(this)" 
                            class="event-card cursor-pointer relative p-[0.73vw] rounded-[0.63vw] border border-[0.052vw] 
                                {{ $isFirst ? 'border-emerald-500 bg-emerald-50/50' : 'border-gray-200 bg-white hover:border-emerald-300 hover:bg-gray-50' }} 
                                transition-all duration-200 group">
                            
                            <input type="radio" name="evento_id" value="{{ $evento->id }}" 
                                class="hidden" {{ $isFirst ? 'checked' : '' }}>
                            
                            <div class="flex justify-between items-start">
                                <div class="flex-1 flex flex-col gap-[0.42vw]">
                                    <span class="event-title block text-[0.73vw] font-semibold tracking-tight 
                                        {{ $isFirst ? 'text-emerald-900' : 'text-zinc-700' }}">
                                        {{ $evento->titulo }}
                                    </span>
                                    
                                    <div class="flex flex-wrap items-center gap-x-[0.42vw] text-[0.63vw] text-gray-500 font-medium">
                                        <span class="flex items-center gap-[0.42vw] 
                                            {{ $isFirst ? 'text-emerald-600' : 'group-hover:text-emerald-600 transition-colors' }}">
                                            <svg class="h-[0.73vw] w-[0.73vw] stroke-[0.1vw]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                                                <line x1="16" x2="16" y1="2" y2="6"/>
                                                <line x1="8" x2="8" y1="2" y2="6"/>
                                                <line x1="3" x2="21" y1="10" y2="10"/>
                                            </svg>
                                            {{ optional($evento->data_hora_inicio)->format('d M, H:i') }}
                                        </span>

                                        <span class="flex items-center gap-[0.42vw] 
                                            {{ $isFirst ? 'text-emerald-600' : 'group-hover:text-emerald-600 transition-colors' }}">
                                            <svg class="h-[0.73vw] w-[0.73vw] stroke-[0.1vw]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                                <circle cx="12" cy="10" r="3"/>
                                            </svg>
                                            {{ $evento->endereco_formatado ?? $evento->cidade ?? 'Local a definir' }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="indicator-container">
                                    @if ($isFirst)
                                        <div class="w-[1.04vw] h-[1.04vw] rounded-full bg-emerald-500 flex items-center justify-center text-white">
                                            <svg class="w-[0.63vw] h-[0.63vw] stroke-[0.15vw]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M20 6 9 17l-5-5"/>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-[1.04vw] h-[1.04vw] rounded-full border-[0.1vw] border-gray-300 group-hover:border-emerald-400 transition-colors"></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-[0.63vw] text-gray-500">
                            Nenhum evento futuro encontrado para este clube.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- VALIDADE DO CONVITE --}}
            <div class="flex flex-col gap-[0.42vw]">
                <h3 class="text-[0.63vw] font-semibold text-gray-400 uppercase tracking-wider">
                    VALIDADE
                </h3>
                
                <div class="grid grid-cols-2 gap-[0.83vw]">
                    <label class="cursor-pointer relative group h-full">
                        <input type="radio" name="expiration_type" value="auto" checked class="peer sr-only">

                        <div class="p-[0.73vw] rounded-[0.63vw] border border-[0.052vw] border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:border-gray-300 peer-checked:bg-emerald-50/50 peer-checked:border-emerald-500 peer-checked:text-emerald-800 peer-checked:[&_svg]:text-emerald-600 transition-all duration-200 flex flex-col items-center justify-center text-center gap-[0.42vw] h-full">
                            <svg class="h-[1.04vw] w-[1.04vw] text-gray-400 group-hover:text-gray-500 transition-colors stroke-[0.1vw]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                            </svg>
                            <span class="text-[0.63vw] font-medium leading-tight">
                                Até o evento iniciar
                            </span>
                        </div>
                    </label>

                    <label class="cursor-pointer relative group h-full">
                        <input type="radio" name="expiration_type" value="manual" class="peer sr-only">

                        <div class="p-[0.73vw] rounded-[0.63vw] border border-[0.052vw] border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:border-gray-300 peer-checked:bg-emerald-50/50 peer-checked:border-emerald-500 peer-checked:text-emerald-800 peer-checked:[&_svg]:text-emerald-600 transition-all duration-200 flex flex-col items-center justify-center text-center gap-[0.42vw] h-full">
                            <svg class="h-[1.04vw] w-[1.04vw] text-gray-400 group-hover:text-gray-500 transition-colors stroke-[0.1vw]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            <span class="text-[0.63vw] font-medium leading-tight">
                                Duração de 24h
                            </span>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <x-slot:footer>
            <div class="w-full flex gap-x-[0.42vw] justify-end pt-[0.42vw]">
                <x-button color="gray" onclick="closeModal('send-invite-modal')">
                    Cancelar
                </x-button>
                
                <x-button color="clube" type="button" id="send-invite-button">
                    Enviar
                </x-button>
            </div>
        </x-slot:footer>

       <script>
    function selectEvent(card) {
        const checkIcon = `
            <div class="w-[1.04vw] h-[1.04vw] rounded-full bg-emerald-500 flex items-center justify-center text-white animate-in fade-in zoom-in duration-200">
                <svg class="w-[0.63vw] h-[0.63vw] stroke-[0.15vw]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 6 9 17l-5-5"/>
                </svg>
            </div>
        `;

        const emptyIcon = `
            <div class="w-[1.04vw] h-[1.04vw] rounded-full border-[0.1vw] border-gray-300 group-hover:border-emerald-400 transition-colors"></div>
        `;

        // 1) limpa todos os cards + radios
        document.querySelectorAll('.event-card').forEach(c => {
            c.classList.remove('border-emerald-500', 'bg-emerald-50/50');
            c.classList.add('border-gray-200', 'bg-white');

            const title = c.querySelector('.event-title');
            if (title) {
                title.classList.remove('text-emerald-900');
                title.classList.add('text-zinc-700');
            }

            const spans = c.querySelectorAll('.flex.flex-wrap.items-center span');
            spans.forEach(span => span.classList.remove('text-emerald-600'));

            const indicator = c.querySelector('.indicator-container');
            if (indicator) {
                indicator.innerHTML = emptyIcon;
            }

            const radio = c.querySelector('input[type="radio"][name="evento_id"]');
            if (radio) {
                radio.checked = false;
            }
        });

        // 2) aplica estilo no card clicado
        card.classList.remove('border-gray-200', 'bg-white');
        card.classList.add('border-emerald-500', 'bg-emerald-50/50');

        const title = card.querySelector('.event-title');
        if (title) {
            title.classList.remove('text-zinc-700');
            title.classList.add('text-emerald-900');
        }

        const spans = card.querySelectorAll('.flex.flex-wrap.items-center span');
        spans.forEach(span => span.classList.add('text-emerald-600'));

        const indicator = card.querySelector('.indicator-container');
        if (indicator) {
            indicator.innerHTML = checkIcon;
        }

        // 3) marca o radio correspondente
        const radio = card.querySelector('input[type="radio"][name="evento_id"]');
        if (radio) {
            radio.checked = true;
            // opcional: dispara change caso vc queira pegar em algum outro script
            radio.dispatchEvent(new Event('change'));
        }
    }
</script>
    </x-modal>

    {{-- JS DO CHAT --}}
    @php
        $clubeAuth  = auth('club')->user();
        $avatarPath = $clubeAuth->logo ?? $clubeAuth->avatar ?? null;

        if ($avatarPath) {
            $clubeAvatar = asset('storage/' . ltrim($avatarPath, '/'));
        } else {
            $clubeAvatar = null;
        }
    @endphp

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const conversationsUrl    = "{{ route('clube.mensagens.conversas') }}";
        const messagesUrlTemplate = "{{ route('clube.mensagens.messages', ['conversation' => '__ID__']) }}";
        const sendMessageUrl      = "{{ route('clube.mensagens.send') }}";
        const sendInviteUrl       = "{{ route('clube.mensagens.sendInvite') }}";
        const csrfToken           = "{{ csrf_token() }}";
        const loggedClubId        = {{ auth('club')->id() }};
        const loggedClubType      = @json(\App\Models\Clube::class);
        const loggedClubAvatar    = @json($clubeAvatar);
        const agendaBaseUrl       = "{{ route('clube.agenda') }}";
        const defaultAvatarUrl    = "{{ asset('storage/imagens_seeders/usuario_perfil.png') }}";

        let activeConversationId = null;
        let activeContact        = null;

        // controla último id e meta da última mensagem por conversa (para não recriar tudo)
        let lastMessageIdByConversation   = {};
        let lastMessageMetaByConversation = {};

        const conversationListEl = document.getElementById('conversation-list');
        const messagesListEl     = document.getElementById('messages-list');
        const contactNameEl      = document.getElementById('chat-contact-name');
        const messagesContainer  = document.getElementById('chat-messages-container');
        const contactAvatarEl    = document.getElementById('chat-contact-avatar');

        function buildMessagesUrl(conversationId) {
            return messagesUrlTemplate.replace('__ID__', conversationId);
        }

        function timeFromDateString(dateString) {
            if (!dateString) return '';
            const d = new Date(dateString);
            if (Number.isNaN(d.getTime())) return '';
            return d.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
        }

        function truncatePreview(text, maxLength = 40) {
            if (!text) return '';
            return text.length > maxLength ? text.slice(0, maxLength) + '…' : text;
        }

        function relativeTimeFromDateString(dateString) {
            if (!dateString) return '';
            const d = new Date(dateString);
            if (Number.isNaN(d.getTime())) return '';

            const now     = new Date();
            const diffMs  = now - d;
            const diffSec = Math.round(diffMs / 1000);

            if (diffSec < 60) return 'agora';

            const diffMin = Math.round(diffSec / 60);
            if (diffMin < 60) {
                return `há ${diffMin} minuto${diffMin > 1 ? 's' : ''}`;
            }

            const diffHours = Math.round(diffMin / 60);
            if (diffHours < 24) {
                return `há ${diffHours} hora${diffHours > 1 ? 's' : ''}`;
            }

            const diffDays = Math.round(diffHours / 24);
            return `há ${diffDays} dia${diffDays > 1 ? 's' : ''}`;
        }

        function updateConversationPreview(conversationId, lastMsg) {
            if (!lastMsg) return;

            lastMessageMetaByConversation[conversationId] = {
                created_at: lastMsg.created_at,
                message: lastMsg.message ?? '',
            };

            const item = conversationListEl.querySelector(
                `.conversation-item[data-conversation-id="${conversationId}"]`
            );
            if (!item) return;

            const previewEl = item.querySelector('[data-conversation-preview]');
            const timeEl    = item.querySelector('[data-conversation-time]');

            if (previewEl) {
                previewEl.textContent = truncatePreview(lastMsg.message ?? '');
            }
            if (timeEl) {
                timeEl.textContent = relativeTimeFromDateString(lastMsg.created_at);
            }
        }

        function renderConversationItem(conv) {
    const name     = conv.contact?.name ?? 'Contato';
    const lastText = conv.last_message?.text ?? '';
    const preview  = truncatePreview(lastText);
    const lastTime = conv.last_message?.time ?? '';

    // usa o avatar do contato, se tiver, senão o padrão
    const avatarUrl = conv.contact?.avatar || defaultAvatarUrl;

    return `
        <div class="conversation-item flex items-center justify-between bg-gray-100 rounded-[0.7vw] hover:bg-gray-100 transition-colors cursor-pointer p-[0.42vw] mt-[0.31vw]"
             data-conversation-id="${conv.conversation_id}">
            <div class="flex items-center gap-x-[0.42vw] w-full">
                <div class="h-[2.08vw] w-[2.08vw] aspect-square rounded-full bg-gray-200 overflow-hidden">
                    <img src="${avatarUrl}" class="w-full h-full object-cover" />
                </div>

                <div class="w-full h-full flex flex-col justify-between">
                    <h2 class="text-[0.73vw] font-medium tracking-tight text-gray-800 truncate">
                        ${name}
                    </h2>

                    <h3 class="text-[0.63vw] font-normal text-gray-500 truncate"
                        data-conversation-preview>
                        ${preview || '&nbsp;'}
                    </h3>
                </div>
            </div>

            <div class="h-full flex flex-col items-end justify-center gap-y-[0.31vw]">
                <span class="text-[0.63vw] font-normal text-gray-700 pl-[0.63vw]"
                      data-conversation-time>
                    ${lastTime}
                </span>
            </div>
        </div>
    `;
}

        function formatEventDateTime(dateString) {
            if (!dateString) {
                return {
                    label: 'Data a definir',
                    ymd: null,
                };
            }

            const d = new Date(dateString);
            if (Number.isNaN(d.getTime())) {
                return {
                    label: 'Data a definir',
                    ymd: null,
                };
            }

            const dia  = String(d.getDate()).padStart(2, '0');
            const mes  = String(d.getMonth() + 1).padStart(2, '0');
            const ano  = d.getFullYear();
            const hora = String(d.getHours()).padStart(2, '0');
            const min  = String(d.getMinutes()).padStart(2, '0');

            return {
                label: `${dia}/${mes}/${ano} - ${hora}:${min}`,
                ymd:   `${ano}-${mes}-${dia}`,
            };
        }

        function renderInviteBubble(message, isMe, time, displayName, avatarHtml, avatarClass) {
            const evento  = message.evento || {};
            const convite = message.convite_evento || message.conviteEvento || {};

            const eventDateInfo = formatEventDateTime(evento.data_hora_inicio);
            const localLabel    = evento.endereco_formatado || evento.cidade || 'Local a definir';

            const now       = new Date();
            const startsAt  = evento.data_hora_inicio ? new Date(evento.data_hora_inicio) : null;
            const isExpired = startsAt && startsAt.getTime() < now.getTime();

            const statusRaw = (convite.status || '').toLowerCase();

            let statusLabel;
            let bottomLabel;
            let btnClass;
            let btnText;
            let showPulseDot = false;

            if (isExpired || statusRaw === 'expirado') {
                statusLabel  = 'EXPIRADO';
                bottomLabel  = 'Expirado';
                btnText      = 'Finalizado';
                btnClass     = 'bg-gray-200 text-gray-500 cursor-not-allowed';
                showPulseDot = false;
            } else if (statusRaw === 'aceito') {
                statusLabel  = 'ACEITO';
                bottomLabel  = 'Aceito';
                btnText      = 'Aceito';
                btnClass     = 'bg-emerald-500 text-white cursor-default';
                showPulseDot = false;
            } else {
                statusLabel  = 'CONVITE';
                bottomLabel  = isMe ? 'Pendente' : 'Convite pendente';
                btnText      = isMe ? 'Ver Evento' : 'Aceitar';
                btnClass     = 'bg-emerald-500 hover:bg-emerald-600 text-white transition-colors';
                showPulseDot = true;
            }

            const dateQuery = eventDateInfo.ymd
                ? `${agendaBaseUrl}?date=${encodeURIComponent(eventDateInfo.ymd)}`
                : agendaBaseUrl;

            const statusColor = isExpired ? 'text-gray-500' : 'text-emerald-900';

            return `
                <div class="w-full flex justify-end">
                    <div class="flex items-start gap-[0.42vw] flex-row-reverse">
                        <div class="w-[1.46vw] h-[1.46vw] rounded-full flex-shrink-0 overflow-hidden ${avatarClass || 'bg-emerald-500 flex items-center justify-center text-white text-[0.63vw] font-bold border-[0.1vw] border-white'}">
                            ${avatarHtml || 'EU'}
                        </div>

                        <div class="flex flex-col gap-[0.42vw] w-[18vw] leading-1.5 p-[0.75vw] bg-emerald-500 rounded-s-[0.63vw] rounded-ee-[0.63vw]">
                            <div class="flex items-center gap-[0.42vw] flex-row-reverse mb-[0.42vw]">
                                <span class="text-[0.75vw] font-semibold text-white/90">
                                    ${displayName}
                                </span>
                                <span class="text-[0.75vw] font-semibold text-white/70">
                                    ${time}
                                </span>
                            </div>

                            <div class="w-full rounded-[0.42vw] overflow-hidden bg-white border-[0.052vw] border-gray-200 p-[0.525vw]">
                                <div class="pb-[0.375vw] border-b-[0.052vw] border-gray-300 flex justify-between items-center">
                                    <span class="text-[0.63vw] font-semibold tracking-tight ${isExpired ? 'text-gray-400' : 'text-emerald-500'}">
                                        ${statusLabel}
                                    </span>
                                    ${showPulseDot ? `
                                        <div class="w-[0.31vw] h-[0.31vw] rounded-full bg-emerald-500 animate-pulse"></div>
                                    ` : ''}
                                </div>

                                <div class="flex flex-col gap-[0.21vw]">
                                    <h4 class="text-[0.73vw] font-medium mt-[0.21vw] leading-tight ${isExpired ? 'text-gray-400 line-through' : 'text-emerald-500'}">
                                        ${evento.titulo || 'Evento'}
                                    </h4>

                                    <div class="flex flex-col gap-[0.21vw]">
                                        <div class="flex items-center gap-[0.42vw] text-[0.63vw] ${isExpired ? 'text-gray-400' : 'text-gray-600'} leading-tight">
                                            <svg class="w-[0.73vw] h-[0.73vw] ${isExpired ? 'text-gray-300' : 'text-emerald-500'} shrink-0 stroke-[0.1vw]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>${eventDateInfo.label}</span>
                                        </div>

                                        <div class="flex items-center gap-[0.42vw] text-[0.63vw] ${isExpired ? 'text-gray-400' : 'text-gray-600'} leading-tight">
                                            <svg class="w-[0.73vw] h-[0.73vw] ${isExpired ? 'text-gray-300' : 'text-emerald-500'} shrink-0 stroke-[0.1vw]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0z" />
                                            </svg>
                                            <span class="truncate">${localLabel}</span>
                                        </div>
                                    </div>

                                    <div class="mt-[0.1vw]">
                                        <a href="${dateQuery}"
                                           class="block w-full py-[0.55vw] rounded text-[0.6vw] font-medium text-center ${btnClass}"
                                           ${isExpired ? 'aria-disabled="true"' : ''}>
                                            ${btnText}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <span class="text-[0.55vw] font-medium text-right mt-[0.31vw] ${statusColor}">
                                ${bottomLabel}
                            </span>
                        </div>
                    </div>
                </div>
            `;
        }

        function renderMessageBubble(message) {
            const isMe = message.sender_type === loggedClubType && message.sender_id === loggedClubId;

            const time = timeFromDateString(message.created_at);
            const text = message.message ?? '';
            const displayName = isMe ? 'Você' : (activeContact?.name ?? 'Contato');

            let avatarHtml = '';
            if (isMe) {
                if (loggedClubAvatar) {
                    avatarHtml = `<img src="${loggedClubAvatar}" class="w-full h-full object-cover rounded-full" />`;
                }
            } else {
                const avatarUrl = activeContact?.avatar || defaultAvatarUrl;
                avatarHtml = `<img src="${avatarUrl}" class="w-full h-full object-cover rounded-full" />`;
            }

            const avatarClass = avatarHtml ? '' : 'bg-gray-200';

            if (message.type === 'convite' && message.evento) {
                return renderInviteBubble(message, isMe, time, displayName, avatarHtml, avatarClass);
            }

            // MENSAGEM DO CLUBE (DIREITA)
            if (isMe) {
                return `
                    <div class="w-full flex justify-end">
                        <div class="flex items-start gap-[0.42vw] flex-row-reverse">
                            <div class="w-[1.46vw] h-[1.46vw] rounded-full flex-shrink-0 overflow-hidden ${avatarClass}">
                                ${avatarHtml}
                            </div>

                            <div class="flex flex-col gap-[0.42vw] leading-1.5 p-[0.75vw] bg-emerald-500 rounded-s-[0.63vw] rounded-ee-[0.63vw] max-w-[25vw]">
                                <div class="flex items-center gap-[0.42vw] flex-row-reverse">
                                    <span class="text-[0.75vw] font-semibold text-white/90">
                                        ${displayName}
                                    </span>
                                    <span class="text-[0.75vw] font-semibold text-white/70">
                                        ${time}
                                    </span>
                                </div>

                                <p class="text-[0.73vw] py-[0.31vw] text-white text-right break-all my-1">
                                    ${text}
                                </p>

                                <span class="text-[0.55vw] font-medium text-right text-emerald-900">
                                    Enviado
                                </span>
                            </div>
                        </div>
                    </div>
                `;
            }

            // MENSAGEM DO USUÁRIO (ESQUERDA)
            return `
                <div class="w-full flex justify-start">
                    <div class="flex items-start gap-[0.42vw]">
                        <div class="w-[1.46vw] h-[1.46vw] rounded-full flex-shrink-0 overflow-hidden ${avatarClass}">
                            ${avatarHtml}
                        </div>

                        <div class="flex flex-col gap-[0.42vw] leading-1.5 p-[0.75vw] bg-gray-100 rounded-e-[0.63vw] rounded-es-[0.63vw] max-w-[25vw]">
                            <div class="flex items-center gap-[0.42vw]">
                                <span class="text-[0.75vw] font-semibold text-gray-900">
                                    ${displayName}
                                </span>
                                <span class="text-[0.75vw] font-semibold text-gray-500">
                                    ${time}
                                </span>
                            </div>

                            <p class="text-[0.73vw] py-[0.31vw] text-gray-900 text- break-all my-1" style="text-align:left;">
                                ${text}
                            </p>

                            <span class="text-[0.55vw] font-medium text-left text-gray-400" style="text-align:left;">
                                Recebido
                            </span>
                        </div>
                    </div>
                </div>
            `;
        }

        async function loadConversations(preserveActive = true) {
            try {
                const res = await fetch(conversationsUrl, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                });

                if (!res.ok) {
                    console.error('Erro ao carregar conversas');
                    return;
                }

                const data = await res.json();

                conversationListEl.innerHTML = '';

                if (!data.length) {
                    conversationListEl.innerHTML = `
                        <div class="text-[0.63vw] text-gray-500">
                            Nenhuma conversa encontrada.
                        </div>
                    `;
                    return;
                }

                data.forEach(conv => {
                    conversationListEl.insertAdjacentHTML('beforeend', renderConversationItem(conv));
                });

                const items = conversationListEl.querySelectorAll('.conversation-item');

                items.forEach((el, index) => {
                    el.addEventListener('click', () => {
                        const conv = data[index];
                        openConversation(conv, el);
                    });
                });

                if (preserveActive && activeConversationId) {
                    const activeIndex = data.findIndex(
                        c => c.conversation_id === activeConversationId
                    );

                    if (activeIndex !== -1 && items[activeIndex]) {
                        items[activeIndex].classList.add('ring-1', 'ring-emerald-500');
                    }
                }
            } catch (e) {
                console.error(e);
            }
        }

        async function openConversation(conv, element) {
            activeConversationId = conv.conversation_id;
            activeContact        = conv.contact;

            conversationListEl.querySelectorAll('.conversation-item').forEach(el => {
                el.classList.remove('ring-1', 'ring-emerald-500');
            });
            if (element) {
                element.classList.add('ring-1', 'ring-emerald-500');
            }

            contactNameEl.textContent = conv.contact?.name ?? 'Contato';

            if (contactAvatarEl) {
                const avatarUrl = conv.contact?.avatar || defaultAvatarUrl;

                contactAvatarEl.innerHTML =
                    `<img src="${avatarUrl}" class="w-full h-full object-cover" />`;
            }

            await loadMessages(activeConversationId, false);
        }

        async function loadMessages(conversationId, append = false) {
            if (!conversationId) return;

            const url = buildMessagesUrl(conversationId);

            try {
                const res = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                });

                if (!res.ok) {
                    console.error('Erro ao carregar mensagens');
                    return;
                }

                const data = await res.json();

                if (!append) {
                    messagesListEl.innerHTML = '';

                    if (!data.length) {
                        messagesListEl.innerHTML = `
                            <div class="text-[0.63vw] text-gray-500 text-center">
                                Nenhuma mensagem ainda. Envie a primeira!
                            </div>
                        `;
                        return;
                    }

                    data.forEach(msg => {
                        messagesListEl.insertAdjacentHTML('beforeend', renderMessageBubble(msg));
                    });
                } else {
                    if (!data.length) return;

                    const lastId = lastMessageIdByConversation[conversationId] ?? null;

                    if (!lastId) {
                        messagesListEl.innerHTML = '';
                        data.forEach(msg => {
                            messagesListEl.insertAdjacentHTML('beforeend', renderMessageBubble(msg));
                        });
                    } else {
                        const index = data.findIndex(m => m.id === lastId);
                        const newMessages = index === -1 ? data : data.slice(index + 1);

                        if (!newMessages.length) {
                            const lastMsg = data[data.length - 1];
                            updateConversationPreview(conversationId, lastMsg);
                            return;
                        }

                        newMessages.forEach(msg => {
                            messagesListEl.insertAdjacentHTML('beforeend', renderMessageBubble(msg));
                        });
                    }
                }

                if (data.length) {
                    const lastMsg = data[data.length - 1];
                    lastMessageIdByConversation[conversationId] = lastMsg.id;
                    updateConversationPreview(conversationId, lastMsg);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            } catch (e) {
                console.error(e);
            }
        }

        const form  = document.getElementById('chat-send-form');
        const input = form.querySelector('input[name="message"]');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const text = input.value.trim();

            if (!activeConversationId || !activeContact) {
                alert('Selecione uma conversa antes de enviar uma mensagem.');
                return;
            }

            if (!text) return;

            try {
                const receiverType =
                    activeContact.type === loggedClubType ? 'clube' : 'usuario';

                const res = await fetch(sendMessageUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({
                        receiver_id: activeContact.id,
                        receiver_type: receiverType,
                        message: text,
                    }),
                });

                const data = await res.json();

                if (!res.ok) {
                    console.error(data);
                    alert(data.message || 'Erro ao enviar mensagem.');
                    return;
                }

                input.value = '';
                await loadMessages(activeConversationId, true);
            } catch (e) {
                console.error(e);
                alert('Erro ao enviar mensagem.');
            }
        });

        const inviteButton = document.getElementById('send-invite-button');

        if (inviteButton) {
            inviteButton.addEventListener('click', async () => {
                if (!activeConversationId || !activeContact) {
                    alert('Selecione uma conversa antes de enviar um convite.');
                    return;
                }

                const selectedEventRadio = document.querySelector('input[name="evento_id"]:checked');
                if (!selectedEventRadio) {
                    alert('Selecione um evento.');
                    return;
                }

                const expirationTypeInput = document.querySelector('input[name="expiration_type"]:checked');
                const expirationType      = expirationTypeInput ? expirationTypeInput.value : 'auto';

                try {
                    const receiverType =
                        activeContact.type === loggedClubType ? 'clube' : 'usuario';

                    const res = await fetch(sendInviteUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({
                            evento_id: selectedEventRadio.value,
                            receiver_id: activeContact.id,
                            receiver_type: receiverType,
                            expiration_type: expirationType,
                        }),
                    });

                    const data = await res.json();

                    if (!res.ok) {
                        console.error(data);
                        alert(data.message || 'Erro ao enviar convite.');
                        return;
                    }

                    if (typeof closeModal === 'function') {
                        closeModal('send-invite-modal');
                    }

                    await loadMessages(activeConversationId, true);
                } catch (e) {
                    console.error(e);
                    alert('Erro ao enviar convite.');
                }
            });
        }

        setInterval(() => {
            Object.entries(lastMessageMetaByConversation).forEach(([conversationId, meta]) => {
                const item = conversationListEl.querySelector(
                    `.conversation-item[data-conversation-id="${conversationId}"]`
                );
                if (!item) return;

                const timeEl = item.querySelector('[data-conversation-time]');
                if (timeEl) {
                    timeEl.textContent = relativeTimeFromDateString(meta.created_at);
                }
            });

            if (activeConversationId) {
                loadMessages(activeConversationId, true);
            }
        }, 3000);

        loadConversations(true);
    });
</script>

</x-layouts.clube>
