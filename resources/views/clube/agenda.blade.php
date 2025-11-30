<x-layouts.clube title="Agenda" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Agenda' => null,
]">
    @php
        $currentDate = \Carbon\Carbon::createFromFormat('Y-m', $data['month']);
        $ano = $currentDate->year;
        $mes = $currentDate->month;
        
        $selectedDateStr = request()->query('date', now()->format('Y-m-d'));
    @endphp

    <div id="toast-container" class="fixed top-4 left-4 z-[9999] flex flex-col gap-3 pointer-events-auto"></div>

    <div class="h-full w-full flex gap-[1.25vw]">
        
        <div class="w-[20vw] border border-[0.1vw] border-gray-200 p-[0.73vw] rounded-[0.63vw] bg-white flex flex-col justify-between">
            <div class="flex flex-col gap-[0.83vw]">
                <x-mini-calendar 
                    class="bg-white rounded-[0.63vw]"
                    :events="$data['calendar']"
                />

                <div class="w-full h-[0.052vw] bg-gray-100"></div>

                <div class="flex flex-col gap-[0.63vw]">
                    <div class="flex items-center justify-between">
                        <h3 class="text-[0.63vw] font-semibold text-gray-400 uppercase tracking-wide flex items-center gap-[0.21vw]">
                            Hoje
                        </h3>

                        <span id="sidebar-selected-date" class="text-[0.575vw] text-gray-400 font-medium">
                            
                        </span>
                    </div>

                    <div id="sidebar-event-list" class="flex flex-col gap-[0.21vw]">
                        <div class="text-gray-400 text-[0.63vw] p-[0.5vw]">Carregando agenda...</div>
                    </div>
                </div>

                <div class="flex flex-col gap-[0.63vw]">
                    <h3 class="text-[0.63vw] font-semibold text-gray-400 uppercase tracking-wide flex items-center gap-[0.21vw]">
                        Próximos Eventos
                    </h3>

                    <div id="sidebar-next-events-list" class="flex flex-col gap-[0.21vw] opacity-80">
                        <div class="text-gray-400 text-[0.63vw] p-[0.5vw]">Buscando eventos...</div>
                    </div>
                </div>
            </div>

            <x-button onclick="openModal('create-event')" color="clube" :full="true">
                <x-slot:icon>
                    <svg class="h-[0.63vw] w-[0.63vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                </x-slot:icon>

                Adicionar novo evento
            </x-button>
        </div>

        <div class="flex-1 flex flex-col gap-[0.83vw] h-full max-h-full overflow-hidden">
            <div class="shrink-0 w-full h-auto flex flex-col gap-[0.83vw] bg-emerald-500 rounded-[0.42vw] p-[1.25vw]">
                <div class="flex items-center justify-between">
                    <div class="flex gap-x-[0.83vw] items-center">
                        <div class="flex gap-x-[0.21vw] items-end text-white">
                            <span id="label-month" class="text-[1.25vw] font-semibold capitalize">{{ \Carbon\Carbon::create($ano, $mes, 1)->translatedFormat('F') }}</span>
                            <span id="label-year" class="text-[0.83vw] font-medium">{{ $ano }}</span>
                        </div>

                        <div class="h-[1.67vw] bg-gray-100 flex gap-x-[0.21vw] rounded-[0.31vw] p-[0.21vw]">
                            <button onclick="changeCalendarMonth(-1)" class="cursor-pointer h-full aspect-square bg-white text-gray-400 rounded-[0.1vw] flex items-center justify-center group hover:bg-gray-50 transition-colors">
                                <svg class="h-[0.83vw] w-[0.83vw] group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                            </button>

                            <button onclick="changeCalendarMonth(1)" class="cursor-pointer h-full aspect-square bg-white text-gray-400 rounded-[0.1vw] flex items-center justify-center group hover:bg-gray-50 transition-colors">
                                <svg class="h-[0.83vw] w-[0.83vw] group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <button class="bg-white text-emerald-500 px-[0.83vw] py-[0.42vw] rounded-[0.21vw] font-medium" onclick="openModal('create-event')">
                            Adicionar novo evento
                        </button>
                    </div>
                </div>
            </div>

            <div class="shrink-0 grid grid-cols-7">
                @foreach(['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'] as $diaSemana)
                    <div class="text-center font-bold text-gray-500 text-[0.73vw] uppercase">{{ $diaSemana }}</div>
                @endforeach
            </div>

            <div class="w-full flex-1 relative min-h-0 bg-gray-300 rounded-[0.42vw] border border-[0.052vw] border-gray-300"> 
                <div id="calendar-grid-container" class="h-full w-full relative">
                    @include('clube.partials.calendar-grid', ['data' => $data, 'selectedDateStr' => $selectedDateStr ])
                </div>
                
                <div id="calendar-loading" class="absolute inset-0 bg-white/50 backdrop-blur-sm z-50 flex items-center justify-center hidden rounded-[0.42vw]">
                    <svg class="animate-spin h-[1.67vw] w-[1.67vw] text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <x-modal maxWidth="2xl" name="create-event" title="Criar novo evento" titleSize="2xl" titleColor="green">
            <div class="flex flex-col gap-[0.83vw]">
                <div class="px-[0.21vw]">
                    <ol class="flex items-center w-full text-[0.73vw] font-medium text-center text-gray-500">
                        <li id="evt-crumb-1" class="flex w-full items-center text-emerald-600 after:content-[''] after:w-full after:h-[0.21vw] after:border-b after:border-gray-200 after:border-[0.052vw] after:inline-block after:mx-[1.25vw] transition-colors duration-300">
                            <span class="me-[0.42vw] flex items-center">
                                <span id="evt-crumb-num-1">1</span>
                                <svg id="evt-crumb-check-1" class="w-[1.04vw] h-[1.04vw] hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            </span>
                            Detalhes
                        </li>

                        <li id="evt-crumb-2" class="flex items-center whitespace-nowrap transition-colors duration-300">
                            <span class="me-[0.42vw] flex items-center">
                                <span id="evt-crumb-num-2">2</span>
                                <svg id="evt-crumb-check-2" class="w-[1.04vw] h-[1.04vw] hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            </span>
                            Localização
                        </li>

                    </ol>
                </div>

                <x-form id="create-event-form" class="flex flex-col gap-[0.83vw]">
                    @csrf
                    <div id="evt-step-1" class="flex flex-col gap-[0.83vw]">
                        <x-form-group label="Título" name="titulo" id="evt-titulo" labelColor="green" required>
                            <x-slot:icon>
                                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 4v16"/><path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"/><path d="M9 20h6"/></svg>
                            </x-slot:icon>
                        </x-form-group>
                        
                        <div class="flex flex-col gap-[0.42vw]">
                            <label class="block text-[0.83vw] font-medium text-emerald-500">Cor do Evento</label>
                            <input type="hidden" name="color" id="evt-color" value="#10b981">
                            
                            <div class="flex flex-wrap justify-between gap-[0.42vw] items-center p-[0.21vw]">
                                @php
                                    $colors = ['#64748b', '#ef4444', '#f97316', '#f59e0b', '#eab308', '#84cc16', '#22c55e', '#10b981', '#14b8a6', '#06b6d4', '#0ea5e9', '#3b82f6', '#6366f1', '#8b5cf6', '#a855f7', '#d946ef', '#ec4899', '#f43f5e'];
                                @endphp

                                @foreach($colors as $hex)
                                    <button type="button" 
                                            onclick="selectColor(this, '{{ $hex }}')" 
                                            class="color-btn w-[1.25vw] h-[1.25vw] rounded-full transition-all focus:outline-none {{ $hex == '#10b981' ? 'ring-[0.1vw] ring-offset-[0.052vw] ring-gray-400 opacity-100 scale-110' : 'opacity-40 hover:opacity-100' }}"
                                            style="background-color: {{ $hex }}; --tw-ring-color: {{ $hex }};">
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <x-form-group label="Descrição" name="descricao" id="evt-descricao" labelColor="green" required>
                            <x-slot:icon>
                                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 5H3"/><path d="M17 12H7"/><path d="M19 19H5"/></svg>
                            </x-slot:icon>
                        </x-form-group>

                        <div class="grid grid-cols-2 gap-[0.83vw]">
                            <div class="flex gap-[0.42vw] items-end">
                                <div class="flex-1">
                                    <x-form-group label="Início" type="date" name="data_inicio" id="evt-data-inicio" labelColor="green" required />
                                </div>
                                <div class="w-[6.67vw]">
                                    <x-form-group :label="null" type="time" name="hora_inicio" id="evt-hora-inicio" labelColor="green" required />
                                </div>
                            </div>

                            <div class="flex gap-[0.42vw] items-end">
                                <div class="flex-1">
                                    <x-form-group label="Fim" type="date" name="data_fim" id="evt-data-fim" labelColor="green" required />
                                </div>
                                <div class="w-[6.67vw]">
                                    <x-form-group :label="null" type="time" name="hora_fim" id="evt-hora-fim" labelColor="green" required />
                                </div>
                            </div>
                        </div>

                        <x-form-group label="Limite de pessoas" type="number" name="limite_participantes" id="evt-limite" labelColor="green">
                            <x-slot:icon>
                                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            </x-slot:icon>
                        </x-form-group>
                    </div>

                    <div id="evt-step-2" class="hidden flex flex-col gap-[0.83vw]">
                        
                        <div class="flex gap-[0.42vw] items-end">
                            <div class="w-[10vw]">
                                <x-form-group label="CEP" name="cep" id="evt-cep" labelColor="green" placeholder="00000-000" required>
                                    <x-slot:icon>
                                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hash-icon lucide-hash"><line x1="4" x2="20" y1="9" y2="9"/><line x1="4" x2="20" y1="15" y2="15"/><line x1="10" x2="8" y1="3" y2="21"/><line x1="16" x2="14" y1="3" y2="21"/></svg>
                                    </x-slot:icon>
                                </x-form-group>
                            </div>

                            <button type="button" class="h-[2.5vw] w-[2.5vw] bg-gray-100 text-gray-600 hover:bg-gray-200 border border-[0.052vw] border-gray-200 rounded-[0.42vw] transition-colors flex items-center justify-center shrink-0"> 
                                <svg class="h-[1.04vw] w-[1.04vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-4 gap-[0.83vw]">
                            <div class="col-span-3">
                                <x-form-group label="Rua" name="rua" id="evt-rua" labelColor="green" required>
                                    <x-slot:icon>
                                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-route-icon lucide-route"><circle cx="6" cy="19" r="3"/><path d="M9 19h8.5a3.5 3.5 0 0 0 0-7h-11a3.5 3.5 0 0 1 0-7H15"/><circle cx="18" cy="5" r="3"/></svg>
                                    </x-slot:icon>
                                </x-form-group>
                            </div>

                            <div class="col-span-1">
                                <x-form-group label="Número" name="numero" id="evt-numero" labelColor="green" required>
                                    <x-slot:icon>
                                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list-ordered-icon lucide-list-ordered"><path d="M11 5h10"/><path d="M11 12h10"/><path d="M11 19h10"/><path d="M4 4h1v5"/><path d="M4 9h2"/><path d="M6.5 20H3.4c0-1 2.6-1.925 2.6-3.5a1.5 1.5 0 0 0-2.6-1.02"/></svg>
                                    </x-slot:icon>
                                </x-form-group>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-[0.83vw]">
                            <x-form-group label="Bairro" name="bairro" id="evt-bairro" labelColor="green" required>
                                <x-slot:icon>
                                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-icon lucide-map"><path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"/><path d="M15 5.764v15"/><path d="M9 3.236v15"/></svg>
                                </x-slot:icon>
                            </x-form-group>

                            <x-form-group label="Cidade" name="cidade" id="evt-cidade" labelColor="green" required>
                                <x-slot:icon>
                                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-icon lucide-building"><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M12 6h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M16 6h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/><path d="M8 6h.01"/><path d="M9 22v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/><rect x="4" y="2" width="16" height="20" rx="2"/></svg>
                                </x-slot:icon>
                            </x-form-group>

                            <x-form-group label="Estado" name="estado" id="evt-estado" labelColor="green" required>
                                <x-slot:icon>
                                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                </x-slot:icon>

                                <option value="">UF</option>
                                <option value="SP">SP</option>
                                <option value="RJ">RJ</option>
                                <option value="MG">MG</option>
                            </x-form-group>
                        </div>

                        <x-form-group label="Complemento" name="complemento" id="evt-complemento" labelColor="green">
                            <x-slot:icon>
                                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layers-icon lucide-layers"><path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"/><path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"/><path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"/></svg>
                            </x-slot:icon>
                        </x-form-group>
                    </div>
                </x-form>

                <x-slot:footer>
                    <div class="w-full flex justify-between items-center gap-x-[0.83vw] bg-white">
                        <div>
                            <x-button color="gray" id="evt-btn-prev" onclick="eventChangeStep(-1)" size="md" class="hidden">
                                Voltar
                            </x-button>
                        </div>
                        <div class="flex gap-[0.63vw]">
                            <x-button color="gray" size="md" onclick="closeModal('create-event')">
                                Cancelar
                            </x-button>

                            <x-button type="button" id="evt-btn-next" onclick="eventChangeStep(1)" color="clube" size="md">
                                Próximo
                            </x-button>

                            <x-button type="button" onclick="submitAjaxEvent('create-event-form', '/api/clube/eventos', 'POST', 'create-event')" id="evt-btn-submit" class="hidden" color="clube" size="md">
                                Salvar Evento
                            </x-button>
                        </div>
                    </div>
                </x-slot:footer>
            </div>
        </x-modal>
        
        <x-modal maxWidth="2xl" name="edit-event" title="Editar evento" titleSize="2xl" titleColor="blue">
            <div class="flex flex-col gap-[0.83vw]">
                <div class="px-[0.21vw]">
                    <ol class="flex items-center w-full text-[0.73vw] font-medium text-center text-gray-500">
                        <li id="edit-evt-crumb-1" class="flex w-full items-center text-sky-600 after:content-[''] after:w-full after:h-[0.21vw] after:border-b after:border-gray-200 after:border-[0.052vw] after:inline-block after:mx-[1.25vw] transition-colors duration-300">
                            <span class="me-[0.42vw] flex items-center">
                                <span id="edit-evt-crumb-num-1">1</span>
                                <svg id="edit-evt-crumb-check-1" class="w-[1.04vw] h-[1.04vw] hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            </span>
                            Detalhes
                        </li>

                        <li id="edit-evt-crumb-2" class="flex items-center whitespace-nowrap transition-colors duration-300">
                            <span class="me-[0.42vw] flex items-center">
                                <span id="edit-evt-crumb-num-2">2</span>
                                <svg id="edit-evt-crumb-check-2" class="w-[1.04vw] h-[1.04vw] hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            </span>
                            Localização
                        </li>
                    </ol>
                </div>

                <x-form id="edit-event-form" method="POST" class="flex flex-col gap-[0.83vw]">
                    @csrf
                    @method('PUT') <div id="edit-evt-step-1" class="flex flex-col gap-[0.83vw]">
                        <x-form-group label="Título" name="titulo" id="edit-evt-titulo" labelColor="blue" required>
                            <x-slot:icon>
                                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 4v16"/><path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"/><path d="M9 20h6"/></svg>
                            </x-slot:icon>
                        </x-form-group>
                        
                        <div class="flex flex-col gap-[0.42vw]">
                            <label class="block text-[0.83vw] font-medium text-blue-500">Cor do Evento</label>
                            <input type="hidden" name="color" id="edit-evt-color" value="#10b981">
                            
                            <div class="flex flex-wrap justify-between gap-[0.42vw] items-center p-[0.21vw]">
                                @php
                                    $colors = ['#64748b', '#ef4444', '#f97316', '#f59e0b', '#eab308', '#84cc16', '#22c55e', '#10b981', '#14b8a6', '#06b6d4', '#0ea5e9', '#3b82f6', '#6366f1', '#8b5cf6', '#a855f7', '#d946ef', '#ec4899', '#f43f5e'];
                                @endphp

                                @foreach($colors as $hex)
                                    <button type="button" 
                                            onclick="selectEditColor(this, '{{ $hex }}')" 
                                            class="color-btn w-[1.25vw] h-[1.25vw] rounded-full transition-all focus:outline-none {{ $hex == '#10b981' ? 'ring-[0.1vw] ring-offset-[0.052vw] ring-gray-400 opacity-100 scale-110' : 'opacity-40 hover:opacity-100' }}"
                                            style="background-color: {{ $hex }}; --tw-ring-color: {{ $hex }};"
                                            data-color="{{ $hex }}">
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <x-form-group label="Descrição" name="descricao" id="edit-evt-descricao" labelColor="blue" required>
                            <x-slot:icon>
                                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 5H3"/><path d="M17 12H7"/><path d="M19 19H5"/></svg>
                            </x-slot:icon>
                        </x-form-group>

                        <div class="grid grid-cols-2 gap-[0.83vw]">
                            <div class="flex gap-[0.42vw] items-end">
                                <div class="flex-1">
                                    <x-form-group label="Início" type="date" name="data_inicio" id="edit-evt-data-inicio" labelColor="blue" required />
                                </div>
                                <div class="w-[6.67vw]">
                                    <x-form-group :label="null" type="time" name="hora_inicio" id="edit-evt-hora-inicio" labelColor="blue" required />
                                </div>
                            </div>

                            <div class="flex gap-[0.42vw] items-end">
                                <div class="flex-1">
                                    <x-form-group label="Fim" type="date" name="data_fim" id="edit-evt-data-fim" labelColor="blue" required />
                                </div>
                                <div class="w-[6.67vw]">
                                    <x-form-group :label="null" type="time" name="hora_fim" id="edit-evt-hora-fim" labelColor="blue" required />
                                </div>
                            </div>
                        </div>

                        <x-form-group label="Limite de pessoas" type="number" name="limite_participantes" id="edit-evt-limite" labelColor="blue">
                            <x-slot:icon>
                                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            </x-slot:icon>
                        </x-form-group>
                    </div>

                    <div id="edit-evt-step-2" class="hidden flex flex-col gap-[0.83vw]">
                        <div class="flex gap-[0.42vw] items-center">
                            <div class="w-[10vw]">
                                <x-form-group label="CEP" name="cep" id="edit-evt-cep" labelColor="blue" placeholder="00000-000" required>
                                    <x-slot:icon>
                                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hash-icon lucide-hash"><line x1="4" x2="20" y1="9" y2="9"/><line x1="4" x2="20" y1="15" y2="15"/><line x1="10" x2="8" y1="3" y2="21"/><line x1="16" x2="14" y1="3" y2="21"/></svg>
                                    </x-slot:icon>
                                </x-form-group>
                            </div>

                            <button type="button" class="h-[2.19vw] w-[2.19vw] bg-gray-100 text-gray-600 hover:bg-gray-200 border border-[0.052vw] border-gray-200 rounded-[0.42vw] transition-colors flex items-center justify-center shrink-0"> 
                                <svg class="h-[1.04vw] w-[1.04vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-4 gap-[0.83vw]">
                            <div class="col-span-3">
                                <x-form-group label="Rua" name="rua" id="edit-evt-rua" labelColor="blue" required>
                                    <x-slot:icon>
                                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-route-icon lucide-route"><circle cx="6" cy="19" r="3"/><path d="M9 19h8.5a3.5 3.5 0 0 0 0-7h-11a3.5 3.5 0 0 1 0-7H15"/><circle cx="18" cy="5" r="3"/></svg>
                                    </x-slot:icon>
                                </x-form-group>
                            </div>

                            <div class="col-span-1">
                                <x-form-group label="Número" name="numero" id="edit-evt-numero" labelColor="blue" required>
                                    <x-slot:icon>
                                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list-ordered-icon lucide-list-ordered"><path d="M11 5h10"/><path d="M11 12h10"/><path d="M11 19h10"/><path d="M4 4h1v5"/><path d="M4 9h2"/><path d="M6.5 20H3.4c0-1 2.6-1.925 2.6-3.5a1.5 1.5 0 0 0-2.6-1.02"/></svg>
                                    </x-slot:icon>
                                </x-form-group>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-[0.83vw]">
                            <x-form-group label="Bairro" name="bairro" id="edit-evt-bairro" labelColor="blue" required>
                                <x-slot:icon>
                                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-icon lucide-map"><path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"/><path d="M15 5.764v15"/><path d="M9 3.236v15"/></svg>
                                </x-slot:icon>
                            </x-form-group>

                            <x-form-group label="Cidade" name="cidade" id="edit-evt-cidade" labelColor="blue" required>
                                <x-slot:icon>
                                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-icon lucide-building"><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M12 6h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M16 6h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/><path d="M8 6h.01"/><path d="M9 22v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/><rect x="4" y="2" width="16" height="20" rx="2"/></svg>
                                </x-slot:icon>
                            </x-form-group>

                            <x-form-group label="Estado" name="estado" id="edit-evt-estado" labelColor="blue" required>
                                <x-slot:icon>
                                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-icon lucide-building"><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M12 6h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M16 6h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/><path d="M8 6h.01"/><path d="M9 22v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/><rect x="4" y="2" width="16" height="20" rx="2"/></svg>
                                </x-slot:icon>

                                <option value="">UF</option>
                                <option value="SP">SP</option>
                                <option value="RJ">RJ</option>
                                <option value="MG">MG</option>
                            </x-form-group>
                        </div>

                        <x-form-group label="Complemento" name="complemento" id="edit-evt-complemento" labelColor="blue">
                            <x-slot:icon>
                                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layers-icon lucide-layers"><path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"/><path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"/><path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"/></svg>
                            </x-slot:icon>
                        </x-form-group>
                    </div>
                </x-form>

                <x-slot:footer>
                    <div class="w-full flex justify-between items-center gap-x-[0.83vw] bg-white">
                        <div>
                            <x-button color="gray" id="edit-evt-btn-prev" onclick="editEventChangeStep(-1)" size="md" class="hidden">
                                Voltar
                            </x-button>
                        </div>
                        <div class="flex gap-[0.63vw]">
                            <x-button color="gray" size="md" onclick="closeModal('edit-event')">
                                Cancelar
                            </x-button>

                            <x-button type="button" id="edit-evt-btn-next" onclick="editEventChangeStep(1)" color="blue" size="md">
                                Próximo
                            </x-button>

                            <x-button type="button" id="edit-evt-btn-submit" class="hidden" color="blue" size="md" onclick="submitAjaxEvent(
                                'edit-event-form', 
                                '/api/clube/eventos/' + document.getElementById('edit-event-form').getAttribute('data-event-id'),
                                'PUT', 
                                'edit-event', 
                                document.getElementById('edit-event-form').getAttribute('data-event-id')
                            )">
                                Salvar Alterações
                            </x-button>
                        </div>
                    </div>
                </x-slot:footer>
            </div>
        </x-modal>

        <x-modal maxWidth="2xl" name="show-event" title="Detalhes do Evento" titleSize="2xl" titleColor="green">
            <div class="flex flex-col gap-[0.83vw] p-[0.21vw]">
                <div class="flex items-center gap-[0.83vw] border-b border-gray-200 pb-[0.63vw]">        
                    <div id="show-evt-color-icon" class="h-[1.5vw] w-[1.5vw] rounded-full shrink-0" 
                        style="background-color: #10b981;"> 
                    </div>
                    
                    <h2 id="show-evt-title" class="text-[1.25vw] font-semibold text-emerald-500">
                        Treino Tático de Reforço
                    </h2>
                </div>

                <div class="grid grid-cols-2 gap-[1.25vw]">
                    
                    <div class="flex flex-col gap-[0.21vw]">
                        <span class="text-[0.83vw] font-medium text-emerald-600 flex items-center gap-[0.21vw]">
                            <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-arrow-up-icon lucide-clock-arrow-up"><path d="M12 6v6l1.56.78"/><path d="M13.227 21.925a10 10 0 1 1 8.767-9.588"/><path d="m14 18 4-4 4 4"/><path d="M18 22v-8"/></svg>
                            Início
                        </span>

                        <p id="show-evt-start-date" class="text-[0.83vw] text-gray-800 font-medium">
                            15/03/2026 às 19:30
                        </p>
                    </div>

                    <div class="flex flex-col gap-[0.21vw]">
                        <span class="text-[0.83vw] font-medium text-emerald-600 flex items-center gap-[0.21vw]">
                            <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-arrow-down-icon lucide-clock-arrow-down"><path d="M12 6v6l2 1"/><path d="M12.337 21.994a10 10 0 1 1 9.588-8.767"/><path d="m14 18 4 4 4-4"/><path d="M18 14v8"/></svg>
                            Término
                        </span>

                        <p id="show-evt-end-date" class="text-[0.83vw] text-gray-800 font-medium">
                            15/03/2026 às 21:30
                        </p>
                    </div>
                    
                    <div class="flex flex-col gap-[0.21vw]">
                        <span class="text-[0.83vw] font-medium text-emerald-600 flex items-center gap-[0.21vw]">
                            <svg class="h-[0.83vw] w-[0.83vw] stroke-[2px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            Limite de Pessoas
                        </span>

                        <p id="show-evt-limit" class="text-[0.83vw] text-gray-800 font-medium">
                            30 participantes
                        </p>
                    </div>
                    
                    <div class="flex flex-col gap-[0.21vw]">
                        <span class="text-[0.83vw] font-medium text-emerald-600 flex items-center gap-[0.21vw]">
                            <svg class="h-[0.83vw] w-[0.83vw] stroke-[2px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            Confirmados
                        </span>

                        <p id="show-evt-confirmed" class="text-[0.83vw] text-gray-800 font-medium">
                            18/30
                        </p>
                    </div>
                    
                </div>
                
                <div class="grid grid-cols-1 gap-[0.83vw]">
                    <div class="flex flex-col gap-[0.21vw] pt-[0.42vw]">
                        <span class="text-[0.83vw] font-medium text-emerald-600 flex items-center gap-[0.21vw]">
                            <svg class="h-[0.83vw] w-[0.83vw] stroke-[2px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 5H3"/><path d="M17 12H7"/><path d="M19 19H5"/></svg>
                            Descrição
                        </span>

                        <p id="show-evt-description" class="text-[0.83vw] text-gray-700 leading-relaxed">
                            Foco total na movimentação ofensiva e recomposição defensiva. Presença obrigatória para todos os atletas Sub-20. Levar chuteiras e material de hidratação.
                        </p>
                    </div>

                    <div class="flex flex-col gap-[0.21vw] pt-[0.42vw]">
                        <span class="text-[0.83vw] font-medium text-emerald-600 flex items-center gap-[0.21vw]">
                            <svg class="h-[0.83vw] w-[0.83vw] stroke-[2px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin-icon"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            Localização
                        </span>

                        <p id="show-evt-location" class="text-[0.83vw] text-gray-700 leading-relaxed">
                            Rua dos Craques, 450 - Centro - São Paulo, SP (Próximo ao Portão B)
                        </p>
                    </div>
                    
                </div>

            </div>

            <x-slot:footer>
                <div class="w-full flex justify-end items-center bg-white">
                    <x-button color="gray" size="md" onclick="closeModal('show-event')">
                        Fechar
                    </x-button>
                </div>
            </x-slot:footer>
        </x-modal>
    </div>

    <script>
        let evtCurrentStep = 1;
        const evtTotalSteps = 2;

        document.addEventListener('DOMContentLoaded', () => {
            updateEventUI();
            updateEditEventUI();

            if (typeof window.updateMiniCalendar === 'function') {
                window.updateMiniCalendar(calState.selectedDate);
            }
            
            updateSidebarDetails(calState.selectedDate);

            loadNextEvents();
        });

        function eventChangeStep(direction) {
            if (direction === 1 && !validateEventStep(evtCurrentStep)) {
                return;
            }

            document.getElementById(`evt-step-${evtCurrentStep}`).classList.add('hidden');
            
            evtCurrentStep += direction;
            
            document.getElementById(`evt-step-${evtCurrentStep}`).classList.remove('hidden');

            updateEventUI();
        }

        function validateEventStep(step) {
            const currentDiv = document.getElementById(`evt-step-${step}`);
            const inputs = currentDiv.querySelectorAll('input, select');
            
            let isValid = true;

            for (let input of inputs) {
                if (input.type !== 'hidden' && !input.checkValidity()) {
                    input.reportValidity();
                    isValid = false;
                    break;
                }
            }

            return isValid;
        }

        function updateEventUI() {
            const btnPrev = document.getElementById('evt-btn-prev');
            const btnNext = document.getElementById('evt-btn-next');
            const btnSubmit = document.getElementById('evt-btn-submit');

            if (evtCurrentStep === 1) {
                btnPrev.classList.add('hidden');
            } else {
                btnPrev.classList.remove('hidden');
            }

            if (evtCurrentStep === evtTotalSteps) {
                btnNext.classList.add('hidden');
                btnSubmit.classList.remove('hidden');
            } else {
                btnNext.classList.remove('hidden');
                btnSubmit.classList.add('hidden');
            }

            for (let i = 1; i <= evtTotalSteps; i++) {
                const crumb = document.getElementById(`evt-crumb-${i}`);
                const num = document.getElementById(`evt-crumb-num-${i}`);
                const check = document.getElementById(`evt-crumb-check-${i}`);
                
                crumb.classList.remove('text-emerald-600', 'text-gray-500', 'after:border-emerald-600', 'after:border-gray-200');

                if (i < evtCurrentStep) {
                    crumb.classList.add('text-emerald-600');
                    crumb.classList.add('after:border-emerald-600');
                    num.classList.add('hidden');
                    check.classList.remove('hidden');
                } 
                else if (i === evtCurrentStep) {
                    crumb.classList.add('text-emerald-600');
                    crumb.classList.add('after:border-gray-200');
                    num.classList.remove('hidden');
                    check.classList.add('hidden');
                } 
                else {
                    crumb.classList.add('text-gray-500');
                    crumb.classList.add('after:border-gray-200');
                    num.classList.remove('hidden');
                    check.classList.add('hidden');
                }
            }
        }

        function selectColor(btn, color) {
            document.getElementById('evt-color').value = color;

            const buttons = document.querySelectorAll('#create-event-form .color-btn');

            buttons.forEach(b => {
                b.classList.remove('ring-[0.1vw]', 'ring-offset-[0.052vw]', 'ring-gray-400', 'opacity-100', 'scale-110');
                
                b.classList.add('opacity-40', 'hover:opacity-100');
            });

            btn.classList.remove('opacity-40', 'hover:opacity-100');
            btn.classList.add('ring-[0.1vw]', 'ring-offset-[0.052vw]', 'ring-gray-400', 'opacity-100', 'scale-110');
        }

        let calState = {
            month: parseInt("{{ $mes }}"), 
            year: parseInt("{{ $ano }}"),  
            selectedDate: "{{ $selectedDateStr }}",
            routeName: "{{ route('clube.ajax.calendar') }}",
            isLoading: false
        };

        const monthNames = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

        async function changeCalendarMonth(direction) {
            if (calState.isLoading) return;

            let nextMonth = calState.month + direction;
            let nextYear = calState.year;

            if (nextMonth > 12) { 
                nextMonth = 1; 
                nextYear++; 
            } else if (nextMonth < 1) { 
                nextMonth = 12; 
                nextYear--; 
            }

            await loadCalendarGrid(nextMonth, nextYear, calState.selectedDate);
            
            if (typeof window.updateMiniCalendar === 'function') {
                let padMonth = String(nextMonth).padStart(2, '0');
                window.updateMiniCalendar(`${nextYear}-${padMonth}-01`, false); 
            }
        }

        window.selectDate = async function(dateStr) {
            calState.selectedDate = dateStr;

            if (typeof window.updateMiniCalendar === 'function') {
                window.updateMiniCalendar(dateStr, true); 
            }

            const parts = dateStr.split('-');
            const y = parseInt(parts[0]);
            const m = parseInt(parts[1]);
            
            if (y !== calState.year || m !== calState.month) {
                await loadCalendarGrid(m, y, dateStr);
            } else {
                updateVisualBadges(dateStr);
            }

            updateSidebarDetails(dateStr);
        }

        async function loadCalendarGrid(targetMonth, targetYear, dateToHighlight) {
            const loader = document.getElementById('calendar-loading');
            const container = document.getElementById('calendar-grid-container');
            
            calState.isLoading = true;
            if (loader) loader.classList.remove('hidden');

            try {
                let monthFormatted = String(targetMonth).padStart(2, '0');
                let phpMonthParam = `${targetYear}-${monthFormatted}`;

                const params = new URLSearchParams({
                    month: phpMonthParam,      
                    date: dateToHighlight,
                    _t: new Date().getTime()   
                });

                const response = await fetch(`${calState.routeName}?${params.toString()}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                if (!response.ok) throw new Error('Erro na rede');

                const resData = await response.json(); 

                if (container) container.innerHTML = resData.html;

                calState.month = targetMonth;
                calState.year = targetYear;

                const lblMonth = document.getElementById('label-month');
                const lblYear = document.getElementById('label-year');

                if (lblMonth) lblMonth.innerText = monthNames[targetMonth - 1];
                if (lblYear) lblYear.innerText = targetYear;

                if (dateToHighlight) {
                    updateVisualBadges(dateToHighlight);
                }

                if (typeof window.updateMiniCalendar === 'function') {
                    window.updateMiniCalendarData(resData.calendarData); 
                    window.updateMiniCalendar(dateToHighlight || `${targetYear}-${monthFormatted}-01`, !!dateToHighlight);
                }

            } catch (error) {
                console.error("Erro ao carregar calendário:", error);
            } finally {
                calState.isLoading = false;
                if(loader) loader.classList.add('hidden');
            }
        }

        function updateVisualBadges(dateStr) {
            const allBadges = document.querySelectorAll('#calendar-grid-container .day-badge');
            
            const activeClasses = [
                'bg-emerald-500', 'text-white', 
                'w-[1.04vw]', 'h-[1.04vw]', 
                'rounded-[0.25vw]', 'font-bold', 'text-[0.63vw]',
                'flex', 'items-center', 'justify-center' 
            ];

            const inactiveClasses = [
                'text-gray-700', 'font-medium', 
                'w-[0.83vw]', 'h-[0.83vw]', 'text-[0.63vw]',
                'flex', 'items-center', 'justify-center'
            ];

 
            allBadges.forEach(badge => {
                badge.classList.remove(...activeClasses);
                badge.classList.add(...inactiveClasses);
            });

            const container = document.getElementById('cal-day-' + dateStr);

            if (container) {
                const badge = container.querySelector('.day-badge');
                if (badge) {
                    badge.classList.remove(...inactiveClasses);
                    badge.classList.add(...activeClasses);
                }
            }
        }

        async function updateSidebarDetails(dateStr) {
            const [y, m, d] = dateStr.split('-');
            const dateObj = new Date(y, m - 1, d); 
            
            const options = { weekday: 'long', day: 'numeric' };
            const formattedDate = dateObj.toLocaleDateString('pt-BR', options); 
            
            const labelSidebar = document.getElementById('sidebar-selected-date');
            if (labelSidebar) labelSidebar.innerText = formattedDate;

            const containerLista = document.getElementById('sidebar-event-list');

            if (containerLista) {
                containerLista.innerHTML = '<div class="p-[0.83vw] text-center text-gray-400 text-[0.63vw]">Carregando...</div>';
                
                try {
                    const url = "{{ route('clube.ajax.day-details') }}?date=" + dateStr;
                    const res = await fetch(url);
                    if (!res.ok) throw new Error('Erro sidebar');
                    const html = await res.text();
                    containerLista.innerHTML = html;
                } catch (err) {
                    console.error(err);
                    containerLista.innerHTML = '<div class="text-red-500 text-center text-[0.63vw] py-4">Erro ao carregar detalhes.</div>';
                }
            }
        }

        async function loadNextEvents() {
            const nextContainer = document.getElementById('sidebar-next-events-list');
            
            if (nextContainer) {
                try {
                    const url = "{{ route('clube.ajax.next-events') }}"; 
                    const res = await fetch(url);
                    
                    if (res.ok) {
                        const html = await res.text();
                        nextContainer.innerHTML = html;
                    }
                } catch (err) {
                    console.error("Erro ao carregar próximos eventos", err);
                    nextContainer.innerHTML = '<div class="text-red-400 text-[0.63vw]">Erro.</div>';
                }
            }
        }

        let editEvtCurrentStep = 1;
        const editEvtTotalSteps = 2;

        function openEditEventModal() {
            editEvtCurrentStep = 1;
            
            document.getElementById('edit-evt-step-1').classList.remove('hidden');
            document.getElementById('edit-evt-step-2').classList.add('hidden');
            
            updateEditEventUI();
        }

        function editEventChangeStep(direction) {
            if (direction === 1 && !validateEditEventStep(editEvtCurrentStep)) {
                return;
            }

            document.getElementById(`edit-evt-step-${editEvtCurrentStep}`).classList.add('hidden');
            
            editEvtCurrentStep += direction;
            
            document.getElementById(`edit-evt-step-${editEvtCurrentStep}`).classList.remove('hidden');

            updateEditEventUI();
        }

        function validateEditEventStep(step) {
            const currentDiv = document.getElementById(`edit-evt-step-${step}`);
            const inputs = currentDiv.querySelectorAll('input, select');
            
            let isValid = true;

            for (let input of inputs) {
                if (input.type !== 'hidden' && !input.checkValidity()) {
                    input.reportValidity();
                    isValid = false;
                    break;
                }
            }

            return isValid;
        }

        function updateEditEventUI() {
            const btnPrev = document.getElementById('edit-evt-btn-prev');
            const btnNext = document.getElementById('edit-evt-btn-next');
            const btnSubmit = document.getElementById('edit-evt-btn-submit');

            if (editEvtCurrentStep === 1) {
                btnPrev.classList.add('hidden');
            } else {
                btnPrev.classList.remove('hidden');
            }

            if (editEvtCurrentStep === editEvtTotalSteps) {
                btnNext.classList.add('hidden');
                btnSubmit.classList.remove('hidden');
            } else {
                btnNext.classList.remove('hidden');
                btnSubmit.classList.add('hidden');
            }

            for (let i = 1; i <= editEvtTotalSteps; i++) {
                const crumb = document.getElementById(`edit-evt-crumb-${i}`);
                const num = document.getElementById(`edit-evt-crumb-num-${i}`);
                const check = document.getElementById(`edit-evt-crumb-check-${i}`);
                
                crumb.classList.remove('text-sky-600', 'text-gray-500', 'after:border-sky-600', 'after:border-gray-200');

                if (i < editEvtCurrentStep) {
                    crumb.classList.add('text-sky-600');
                    crumb.classList.add('after:border-sky-600');
                    num.classList.add('hidden');
                    check.classList.remove('hidden');
                } else if (i === editEvtCurrentStep) {
                    crumb.classList.add('text-sky-600');
                    crumb.classList.add('after:border-gray-200');
                    num.classList.remove('hidden');
                    check.classList.add('hidden');
                } else {
                    crumb.classList.add('text-gray-500');
                    crumb.classList.add('after:border-gray-200');
                    num.classList.remove('hidden');
                    check.classList.add('hidden');
                }
            }
        }

        function selectEditColor(btn, color) {
            document.getElementById('edit-evt-color').value = color;

            const buttons = document.querySelectorAll('#edit-event-form .color-btn');

            buttons.forEach(b => {
                b.classList.remove('ring-[0.1vw]', 'ring-offset-[0.052vw]', 'ring-gray-400', 'opacity-100', 'scale-110');
                b.classList.add('opacity-40', 'hover:opacity-100');
            });

            btn.classList.remove('opacity-40', 'hover:opacity-100');
            btn.classList.add('ring-[0.1vw]', 'ring-offset-[0.052vw]', 'ring-gray-400', 'opacity-100', 'scale-110');
        }

        function splitDateTime(dateTimeStr) {
            if (!dateTimeStr) return { date: '', time: '' };
            
            const parts = String(dateTimeStr).split('T'); 
            
            const date = parts[0] || '';
            
            let rawTime = parts[1] || '';

            const time = rawTime.split('.')[0].substring(0, 5);
            
            return { date, time };
        }

        async function openEditModal(eventId) {
            const url = `/api/clube/eventos/${eventId}`;
            const form = document.getElementById('edit-event-form');
            const modalName = 'edit-event';
            
            resetEditModal(modalName); 

            try {
                const response = await fetch(url, {
                    method: 'GET',
                    headers: { 'Accept': 'application/json' },
                    credentials: 'include'
                });
                
                if (!response.ok) throw new Error('Falha ao carregar evento');
                
                const result = await response.json();
                const event = result.evento;
                
                if (!event) throw new Error('Dados vazios');

                console.log(event.data_hora_inicio);

                const start = splitDateTime(event.data_hora_inicio);
                const end = splitDateTime(event.data_hora_fim);

                form.action = url; 

                form.setAttribute('data-event-id', eventId);
                
                document.getElementById('edit-evt-titulo').value = event.titulo || '';
                document.getElementById('edit-evt-descricao').value = event.descricao || '';
                
                document.getElementById('edit-evt-data-inicio').value = start.date;
                document.getElementById('edit-evt-hora-inicio').value = start.time;
                document.getElementById('edit-evt-data-fim').value = end.date;
                document.getElementById('edit-evt-hora-fim').value = end.time;
                
                document.getElementById('edit-evt-limite').value = event.limite_participantes || '';
                document.getElementById('edit-evt-color').value = event.color || '#10b981';

                document.getElementById('edit-evt-cep').value = event.cep || '';
                document.getElementById('edit-evt-rua').value = event.rua || '';
                document.getElementById('edit-evt-numero').value = event.numero || '';
                document.getElementById('edit-evt-bairro').value = event.bairro || '';
                document.getElementById('edit-evt-cidade').value = event.cidade || '';

                document.getElementById('edit-evt-estado').value = event.estado || ''; 
                document.getElementById('edit-evt-complemento').value = event.complemento || '';
                
                openModal(modalName);

                await Promise.resolve();

                const eventColor = event.color || '#10b981'; 
        
                document.getElementById('edit-evt-color').value = eventColor;
                
                const selectedColorButton = document.querySelector(
                    `#edit-event-form .color-btn[data-color="${eventColor}"]`
                );

                selectEditColor(selectedColorButton, eventColor);

            } catch (error) {
                console.error('Erro ao abrir edição:', error);
                showToast('error', 'Erro!', 'Não foi possível abrir os dados do evento!');
            }
        }
        
        function resetEditModal(modalName) {
            editEvtCurrentStep = 1;
            document.getElementById('edit-evt-step-1').classList.remove('hidden');
            document.getElementById('edit-evt-step-2').classList.add('hidden');
            updateEditEventUI(); 
            
            document.getElementById('edit-event-form').reset(); 
        }

        async function submitAjaxEvent(formId, url, method, modalName, eventId = null) {
            const form = document.getElementById(formId);
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            if (data.data_inicio && data.hora_inicio) {
                data.data_hora_inicio = data.data_inicio + ' ' + data.hora_inicio + ':00';
                delete data.data_inicio;
                delete data.hora_inicio;
            }

            if (data.data_fim && data.hora_fim) {
                data.data_hora_fim = data.data_fim + ' ' + data.hora_fim + ':00';
                delete data.data_fim;
                delete data.hora_fim;
            }

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    credentials: 'include',
                    body: JSON.stringify(data)
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    showToast('error', 'Erro na Submissão.', errorData.message || 'Verifique os dados.');
                    return;
                }

                const result = await response.json();

                resetAndClose(formId, modalName); 
                
                if (method === 'POST') {
                    await loadCalendarGrid(calState.month, calState.year, calState.selectedDate);

                    updateSidebarDetails(calState.selectedDate); 

                    loadNextEvents();
                    
                    showToast('success', 'Evento Criado!', 'Seu evento foi adicionado à agenda.');
                } else if (method === 'PUT' && eventId) {
                    await loadCalendarGrid(calState.month, calState.year, calState.selectedDate);
                    updateSidebarDetails(calState.selectedDate); 
                    loadNextEvents(); 
                    
                    showToast('success', 'Alterações Salvas!', 'O evento foi atualizado com sucesso.');
                }

            } catch (error) {
                console.error('Erro na requisição:', error);
                showToast('error', 'Erro de Conexão.', 'Não foi possível se conectar ao servidor.');
            }
        }

        function formatDateTimeForDisplay(dateTimeStr) {
            if (!dateTimeStr) return 'Data/Hora não definida';
            
            const date = new Date(dateTimeStr);
            
            if (isNaN(date)) return 'Data inválida';

            const datePart = date.toLocaleDateString('pt-BR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });

            const timePart = date.toLocaleTimeString('pt-BR', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });

            return `${datePart} às ${timePart}`;
        }

        async function showEventDetails(eventId) {
            const url = `/api/clube/eventos/${eventId}`;
            const modalName = 'show-event';
            
            try {
                const response = await fetch(url, {
                    method: 'GET',
                    headers: { 'Accept': 'application/json' },
                    credentials: 'include'
                });
                
                if (!response.ok) throw new Error('Falha ao carregar evento');
                
                const result = await response.json();
                const event = result.evento;
                
                if (!event) throw new Error('Dados do evento não encontrados.');
                
                const modalContent = document.querySelector(`[name="${modalName}"] .flex.flex-col.gap-\\[0\\.83vw\\]`);
                
                const acceptedCount = 0; 
                const limit = event.limite_participantes;
                const confirmedText = limit ? `${acceptedCount}/${limit}` : `${acceptedCount} (sem limite)`;

                const eventColor = event.color || '#10b981';

                document.getElementById('show-evt-title').textContent = event.titulo;
                document.getElementById('show-evt-color-icon').style.backgroundColor = eventColor;
                
                document.getElementById('show-evt-start-date').textContent = formatDateTimeForDisplay(event.data_hora_inicio);
                document.getElementById('show-evt-end-date').textContent = formatDateTimeForDisplay(event.data_hora_fim);
                
                document.getElementById('show-evt-limit').textContent = limit ? `${limit} participantes` : 'Sem limite';
                document.getElementById('show-evt-confirmed').textContent = confirmedText;
                
                document.getElementById('show-evt-description').textContent = event.descricao || 'Nenhuma descrição fornecida.';
                
                const locationParts = [
                    event.rua && event.numero ? `${event.rua}, ${event.numero}` : event.rua,
                    event.bairro,
                    event.cidade,
                    event.estado
                ].filter(p => p).join(' - ');
                
                document.getElementById('show-evt-location').textContent = locationParts || 'Localização não informada.';

                openModal(modalName);

            } catch (error) {
                console.error('Erro ao carregar detalhes do evento:', error);
  
                showToast('error', 'Erro na leitura.', 'Não foi possível carregar os detalhes deste evento.');
            }
        }
    </script>
</x-layouts.clube>