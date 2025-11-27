<x-layouts.clube title="Mensagens" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Mensagens' => null,
]">
    <div class="flex w-full gap-x-[1.25vw] min-h-0 flex-1 h-full">
        
        <div class="flex-1 min-h-0 bg-white w-[33.33vw] border border-[0.052vw] border-gray-300 rounded-[0.63vw] p-[0.63vw] flex flex-col gap-[0.63vw]">
            <div class="w-full">
                <x-search-input placeholder="Pesquisar por conversas..." ></x-search-input>

                <div class="w-full border-t-[0.052vw] border-gray-200 mt-[0.63vw]"></div>
            </div>

            <div class="flex flex-col gap-[0.31vw]">
                <x-conversation-item :chat="null">
                </x-conversation-item>
            </div>
        </div>

        <div class="flex-[3] flex flex-col min-h-0 bg-white w-full border border-[0.052vw] border-gray-300 rounded-[0.63vw] p-[0.63vw] gap-[0.63vw]">
            <div class="flex items-center gap-x-[0.42vw]">
                <div class="w-[2.08vw] h-[2.08vw] rounded-full bg-gray-200"></div>
                <span class="text-[0.73vw] font-semibold">João Pedro Insano</span>
            </div>

            <div class="w-full border-t-[0.052vw] border-gray-200"></div>

            <div class="flex-1 h-0 overflow-y-auto custom-scrollbar">
                <div class="h-full flex flex-col gap-y-[0.63vw] flex-grow justify-end"> 
                    <x-message-item :message="null" :isMe="false"></x-message-item>
                    <x-message-item :message="null" :isMe="true"></x-message-item>
                    <x-event-bubble :event="null"></x-event-bubble>
                </div>
            </div>

            <div class="w-full border-t-[0.052vw] border-gray-200"></div>

            <div>
                <x-message-input></x-message-input>
            </div>
        </div>
    </div>

    <x-modal maxWidth="[26.67vw]" name="send-invite-modal" title="Enviar Convite" titleSize="[1.04vw]" titleColor="emerald">
        <div class="flex flex-col gap-[0.83vw]">
            <x-search-input placeholder="Buscar eventos..."></x-search-input>

            <div class="flex flex-col gap-[0.42vw]">
                <h3 class="text-[0.63vw] font-semibold text-gray-400 uppercase tracking-wider">
                    Próximos Eventos
                </h3>

                <div class="max-h-[12.5vw] overflow-y-auto flex flex-col gap-[0.42vw] custom-scrollbar pr-[0.21vw]" id="event-list-container">
                    
                    <div onclick="selectEvent(this)" class="event-card cursor-pointer relative p-[0.73vw] rounded-[0.63vw] border border-[0.052vw] border-emerald-500 bg-emerald-50/50 transition-all duration-200 hover:border-emerald-400 group">
                        <input type="radio" name="event_id" value="1" checked class="hidden">
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1 flex flex-col gap-[0.42vw]">
                                <span class="event-title block text-[0.73vw] font-semibold text-emerald-900 tracking-tight">Peneira Sub-17: Zagueiros</span>
                                
                                <div class="flex flex-wrap items-center gap-x-[0.42vw] text-[0.63vw] text-gray-500 font-medium">
                                    <span class="flex items-center gap-[0.42vw] text-emerald-600">
                                        <svg class="h-[0.73vw] w-[0.73vw] stroke-[0.1vw]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                        28 Nov, 14:00
                                    </span>
                                    <span class="flex items-center gap-[0.42vw] text-emerald-600">
                                        <svg class="h-[0.73vw] w-[0.73vw] stroke-[0.1vw]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                        CT Barra Funda
                                    </span>
                                </div>
                            </div>
                            
                            <div class="indicator-container">
                                <div class="w-[1.04vw] h-[1.04vw] rounded-full bg-emerald-500 flex items-center justify-center text-white">
                                    <svg class="w-[0.63vw] h-[0.63vw] stroke-[0.15vw]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div onclick="selectEvent(this)" class="event-card cursor-pointer relative p-[0.73vw] rounded-[0.63vw] border border-[0.052vw] border-gray-200 bg-white transition-all duration-200 hover:border-emerald-300 hover:bg-gray-50 group">
                        <input type="radio" name="event_id" value="2" class="hidden">
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1 flex flex-col gap-[0.42vw]">
                                <span class="event-title block text-[0.73vw] font-semibold text-zinc-700 tracking-tight">Treino Tático: Meio-Campo</span>
                                
                                <div class="flex flex-wrap items-center gap-x-[0.42vw] text-[0.63vw] text-gray-500 font-medium">
                                    <span class="flex items-center gap-[0.42vw] group-hover:text-emerald-600 transition-colors">
                                        <svg class="h-[0.73vw] w-[0.73vw] stroke-[0.1vw]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                        29 Nov, 09:00
                                    </span>
                                    <span class="flex items-center gap-[0.42vw] group-hover:text-emerald-600 transition-colors">
                                        <svg class="h-[0.73vw] w-[0.73vw] stroke-[0.1vw]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                        Campo 2
                                    </span>
                                </div>
                            </div>
                            
                            <div class="indicator-container">
                                <div class="w-[1.04vw] h-[1.04vw] rounded-full border-[0.1vw] border-gray-300 group-hover:border-emerald-400 transition-colors"></div>
                            </div>
                        </div>
                    </div>

                    <div onclick="selectEvent(this)" class="event-card cursor-pointer relative p-[0.73vw] rounded-[0.63vw] border border-[0.052vw] border-gray-200 bg-white transition-all duration-200 hover:border-emerald-300 hover:bg-gray-50 group">
                        <input type="radio" name="event_id" value="3" class="hidden">
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1 flex flex-col gap-[0.42vw]">
                                <span class="event-title block text-[0.73vw] font-semibold text-zinc-700 tracking-tight">Avaliação Física Geral</span>
                                
                                <div class="flex flex-wrap items-center gap-x-[0.42vw] text-[0.63vw] text-gray-500 font-medium">
                                    <span class="flex items-center gap-[0.42vw] group-hover:text-emerald-600 transition-colors">
                                        <svg class="h-[0.73vw] w-[0.73vw] stroke-[0.1vw]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                        30 Nov, 08:00
                                    </span>
                                    <span class="flex items-center gap-[0.42vw] group-hover:text-emerald-600 transition-colors">
                                        <svg class="h-[0.73vw] w-[0.73vw] stroke-[0.1vw]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                        Academia
                                    </span>
                                </div>
                            </div>
                            
                            <div class="indicator-container">
                                <div class="w-[1.04vw] h-[1.04vw] rounded-full border-[0.1vw] border-gray-300 group-hover:border-emerald-400 transition-colors"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="flex flex-col gap-[0.42vw]">
                <h3 class="text-[0.63vw] font-semibold text-gray-400 uppercase tracking-wider">
                    VALIDADE
                </h3>
                
                <div class="grid grid-cols-2 gap-[0.83vw]">
                    <label class="cursor-pointer relative group h-full">
                        <input type="radio" name="expiration_type" value="auto" checked class="peer sr-only">

                        <div class="p-[0.73vw] rounded-[0.63vw] border border-[0.052vw] border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:border-gray-300 peer-checked:bg-emerald-50/50 peer-checked:border-emerald-500 peer-checked:text-emerald-800 peer-checked:[&_svg]:text-emerald-600 transition-all duration-200 flex flex-col items-center justify-center text-center gap-[0.42vw] h-full">
                            <svg class="h-[1.04vw] w-[1.04vw] text-gray-400 group-hover:text-gray-500 transition-colors stroke-[0.1vw]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                            <span class="text-[0.63vw] font-medium leading-tight">Até o evento iniciar</span>
                        </div>
                    </label>

                    <label class="cursor-pointer relative group h-full">
                        <input type="radio" name="expiration_type" value="manual" class="peer sr-only">

                        <div class="p-[0.73vw] rounded-[0.63vw] border border-[0.052vw] border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:border-gray-300 peer-checked:bg-emerald-50/50 peer-checked:border-emerald-500 peer-checked:text-emerald-800 peer-checked:[&_svg]:text-emerald-600 transition-all duration-200 flex flex-col items-center justify-center text-center gap-[0.42vw] h-full">
                            <svg class="h-[1.04vw] w-[1.04vw] text-gray-400 group-hover:text-gray-500 transition-colors stroke-[0.1vw]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span class="text-[0.63vw] font-medium leading-tight">Duração de 24h</span>
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
                
                <x-button color="clube" type="submit">
                    Enviar
                </x-button>
            </div>
        </x-slot:footer>

        <script>
            function selectEvent(element) {
                const checkIcon = `
                    <div class="w-[1.04vw] h-[1.04vw] rounded-full bg-emerald-500 flex items-center justify-center text-white animate-in fade-in zoom-in duration-200">
                        <svg class="w-[0.63vw] h-[0.63vw] stroke-[0.15vw]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                    </div>
                `;

                const emptyIcon = `
                    <div class="w-[1.04vw] h-[1.04vw] rounded-full border-[0.1vw] border-gray-300 group-hover:border-emerald-400 transition-colors"></div>
                `;

                document.querySelectorAll('.event-card').forEach(card => {
                    card.classList.remove('border-emerald-500', 'bg-emerald-50/50');
                    card.classList.add('border-gray-200', 'bg-white');
                    
                    const title = card.querySelector('.event-title');

                    if(title) {
                        title.classList.remove('text-emerald-900');
                        title.classList.add('text-zinc-700');
                    }

                    const metaInfos = card.querySelectorAll('.text-[0.63vw] span');

                    metaInfos.forEach(span => {
                        span.classList.remove('text-emerald-600');
                    });

                    const indicatorContainer = card.querySelector('.indicator-container');
                    if(indicatorContainer) {
                        indicatorContainer.innerHTML = emptyIcon;
                    }
                });

                element.classList.remove('border-gray-200', 'bg-white');
                element.classList.add('border-emerald-500', 'bg-emerald-50/50');
                
                const title = element.querySelector('.event-title');

                if(title) {
                    title.classList.remove('text-zinc-700');
                    title.classList.add('text-emerald-900');
                }

                const metaInfos = element.querySelectorAll('.text-[0.63vw] span');
                metaInfos.forEach(span => {
                    span.classList.add('text-emerald-600');
                });

                const indicatorContainer = element.querySelector('.indicator-container');

                if(indicatorContainer) {
                    indicatorContainer.innerHTML = checkIcon;
                }

                const radio = element.querySelector('input[type="radio"]');
                if(radio) radio.checked = true;
            }
        </script>
    </x-modal>
</x-layouts.clube>