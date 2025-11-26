<x-layouts.clube title="Agenda" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Agenda' => null,
]">
    @php
        $mes = request()->query('month', now()->month);
        $ano = request()->query('year', now()->year);
        
        $selectedDateStr = request()->query('date', now()->format('Y-m-d'));
        $selectedDate = \Carbon\Carbon::parse($selectedDateStr);

        $dataVisualizada = \Carbon\Carbon::create($ano, $mes, 1);

        $primeiroDiaSemana = $dataVisualizada->dayOfWeek;
        $colStart = $primeiroDiaSemana + 1; 
        $totalDiasNoMes = $dataVisualizada->daysInMonth;

        $dias = [];
        
        for ($i = 1; $i <= $totalDiasNoMes; $i++) {
            $currentDateObj = \Carbon\Carbon::create($ano, $mes, $i);
            $currentDateStr = $currentDateObj->format('Y-m-d');

            $listaEventos = [];

            if ($i == 5) $listaEventos[] = ['titulo' => 'Treino Tático', 'color' => '#22c55e'];
            if ($i == 12) {
                $listaEventos[] = ['titulo' => 'Final Regional', 'color' => '#ef4444'];
                $listaEventos[] = ['titulo' => 'Fisioterapia', 'color' => '#3b82f6'];
            }
            if ($i == 20) {
                $listaEventos[] = ['titulo' => 'Reunião Diretoria', 'color' => '#eab308'];
                $listaEventos[] = ['titulo' => 'Peneira Sub-15', 'color' => '#a855f7'];
            }

            $dias[] = [
                'numero' => $i,
                'full_date' => $currentDateStr,
                'is_today' => $currentDateObj->isToday(),
                // Verifica se é o dia selecionado na URL
                'is_selected' => ($currentDateStr === $selectedDateStr),
                'eventos' => $listaEventos
            ];
        }

        $maxEventos = 2;
    @endphp

    <div class="h-full w-full flex gap-6">
        <div class="w-3/12 border border-2 border-gray-200 p-3.5 rounded-xl bg-white flex flex-col justify-between">
            <div class="flex flex-col gap-4">
                <x-mini-calendar 
                    class="bg-white rounded-xl"
                />

                <div class="w-full h-px bg-gray-100"></div>

                <div class="flex flex-col gap-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-tight flex items-center gap-2">
                            Hoje
                        </h3>

                        <span id="sidebar-selected-date" class="text-xs text-gray-400 font-medium">
                            {{ \Carbon\Carbon::parse($selectedDateStr)->translatedFormat('l, d') }}
                        </span>
                    </div>

                    <div id="sidebar-event-list" class="flex flex-col gap-3">
                        <x-event-item :item="null" />
                        <x-event-item :item="null" />
                    </div>
                </div>

                <div class="w-full h-px bg-gray-100"></div>

                <div class="flex flex-col gap-3">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-tight flex items-center gap-2">
                        Próximos Eventos
                    </h3>

                    <div class="flex flex-col gap-3 opacity-80">
                        <x-event-item :item="null" />
                        <x-event-item :item="null" />
                    </div>
                </div>
            </div>

            <x-button onclick="openModal('create-event')" color="clube" :full="true">
                <x-slot:icon>
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                </x-slot:icon>

                Adicionar novo evento
            </x-button>
        </div>

        <div class="w-9/12 flex flex-col gap-4 h-full max-h-full overflow-hidden">
            <div class="shrink-0 w-full h-auto flex flex-col gap-4 bg-emerald-500 rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div class="flex gap-x-4 items-center">
                        <div class="flex gap-x-1 items-end text-white">
                            <span id="label-month" class="text-2xl font-semibold capitalize">{{ \Carbon\Carbon::create($ano, $mes, 1)->translatedFormat('F') }}</span>
                            <span id="label-year" class="text-md font-medium">{{ $ano }}</span>
                        </div>

                        <div class="h-8 bg-gray-100 flex gap-x-1 rounded-md p-1">
                            <button onclick="changeCalendarMonth(-1)" class="cursor-pointer h-full aspect-square bg-white text-gray-400 rounded-sm flex items-center justify-center group hover:bg-gray-50 transition-colors">
                                <svg class="h-4 w-4 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                            </button>

                            <button onclick="changeCalendarMonth(1)" class="cursor-pointer h-full aspect-square bg-white text-gray-400 rounded-sm flex items-center justify-center group hover:bg-gray-50 transition-colors">
                                <svg class="h-4 w-4 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <button class="bg-white text-emerald-500 px-4 py-2 rounded font-medium" onclick="openModal('create-event')">
                            Adicionar novo evento
                        </button>
                    </div>
                </div>
            </div>

            <div class="shrink-0 grid grid-cols-7">
                @foreach(['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'] as $diaSemana)
                    <div class="text-center font-bold text-gray-500 text-sm uppercase">{{ $diaSemana }}</div>
                @endforeach
            </div>

            <div class="w-full flex-1 relative min-h-0 bg-gray-300 rounded-lg border border-gray-300"> 
                <div id="calendar-grid-container" class="h-full w-full relative">
                    @include('clube.partials.calendar-grid', ['dias' => $dias, 'colStart' => $colStart, 'maxEventos' => $maxEventos])
                </div>
                
                <div id="calendar-loading" class="absolute inset-0 bg-white/50 backdrop-blur-sm z-50 flex items-center justify-center hidden rounded-lg">
                    <svg class="animate-spin h-8 w-8 text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <x-modal maxWidth="2xl" name="create-event" title="Criar novo evento" titleSize="2xl" titleColor="green">
            <div class="flex flex-col gap-4">
                <div class="px-1">
                    <ol class="flex items-center w-full text-sm font-medium text-center text-gray-500 sm:text-base">
                        <li id="evt-crumb-1" class="flex md:w-full items-center text-emerald-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 transition-colors duration-300">
                            <span class="me-2 flex items-center">
                                <span id="evt-crumb-num-1">1</span>
                                <svg id="evt-crumb-check-1" class="w-5 h-5 hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            </span>
                            Detalhes
                        </li>

                        <li id="evt-crumb-2" class="flex items-center whitespace-nowrap transition-colors duration-300">
                            <span class="me-2 flex items-center">
                                <span id="evt-crumb-num-2">2</span>
                                <svg id="evt-crumb-check-2" class="w-5 h-5 hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            </span>
                            Localização
                        </li>

                    </ol>
                </div>

                <form id="form-create-event" class="flex flex-col gap-4">
                    <div id="evt-step-1" class="flex flex-col gap-4">
                        <x-form-group label="Título" name="titulo" id="evt-titulo" labelColor="green" required>
                            <x-slot:icon>
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 4v16"/><path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"/><path d="M9 20h6"/></svg>
                            </x-slot:icon>
                        </x-form-group>
                        
                        <div class="flex flex-col gap-2">
                            <label class="block text-base font-medium text-emerald-500">Cor do Evento</label>
                            <input type="hidden" name="color" id="evt-color" value="#10b981">
                            
                            <div class="flex flex-wrap justify-between gap-2 items-center p-1">
                                @php
                                    $colors = ['#64748b', '#ef4444', '#f97316', '#f59e0b', '#eab308', '#84cc16', '#22c55e', '#10b981', '#14b8a6', '#06b6d4', '#0ea5e9', '#3b82f6', '#6366f1', '#8b5cf6', '#a855f7', '#d946ef', '#ec4899', '#f43f5e'];
                                @endphp

                                @foreach($colors as $hex)
                                    <button type="button" 
                                            onclick="selectColor(this, '{{ $hex }}')" 
                                            class="color-btn w-6 h-6 rounded-full transition-all focus:outline-none {{ $hex == '#10b981' ? 'ring-2 ring-offset-1 ring-gray-400 opacity-100 scale-110' : 'opacity-40 hover:opacity-100' }}"
                                            style="background-color: {{ $hex }}; --tw-ring-color: {{ $hex }};">
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <x-form-group label="Descrição" name="descricao" id="evt-descricao" labelColor="green" required>
                            <x-slot:icon>
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 5H3"/><path d="M17 12H7"/><path d="M19 19H5"/></svg>
                            </x-slot:icon>
                        </x-form-group>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex gap-2 items-end">
                                <div class="flex-1">
                                    <x-form-group label="Início" type="date" name="data_inicio" id="evt-data-inicio" labelColor="green" required />
                                </div>
                                <div class="w-32">
                                    <x-form-group :label="null" type="time" name="hora_inicio" id="evt-hora-inicio" labelColor="green" required />
                                </div>
                            </div>

                            <div class="flex gap-2 items-end">
                                <div class="flex-1">
                                    <x-form-group label="Fim" type="date" name="data_fim" id="evt-data-fim" labelColor="green" required />
                                </div>
                                <div class="w-32">
                                    <x-form-group :label="null" type="time" name="hora_fim" id="evt-hora-fim" labelColor="green" required />
                                </div>
                            </div>
                        </div>

                        <x-form-group label="Limite de pessoas" type="number" name="limite_participantes" id="evt-limite" labelColor="green">
                            <x-slot:icon>
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            </x-slot:icon>
                        </x-form-group>
                    </div>

                    <div id="evt-step-2" class="hidden flex flex-col gap-4">
                        
                        <div class="flex gap-2 items-end">
                            <div class="w-48">
                                <x-form-group label="CEP" name="cep" id="evt-cep" labelColor="green" placeholder="00000-000" required>
                                    <x-slot:icon>
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hash-icon lucide-hash"><line x1="4" x2="20" y1="9" y2="9"/><line x1="4" x2="20" y1="15" y2="15"/><line x1="10" x2="8" y1="3" y2="21"/><line x1="16" x2="14" y1="3" y2="21"/></svg>
                                    </x-slot:icon>
                                </x-form-group>
                            </div>

                            <button type="button" class="h-[42px] w-[42px] bg-gray-100 text-gray-600 hover:bg-gray-200 border border-gray-200 rounded-lg transition-colors flex items-center justify-center shrink-0"> 
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-4 gap-4">
                            <div class="col-span-3">
                                <x-form-group label="Rua" name="rua" id="evt-rua" labelColor="green" required>
                                    <x-slot:icon>
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-route-icon lucide-route"><circle cx="6" cy="19" r="3"/><path d="M9 19h8.5a3.5 3.5 0 0 0 0-7h-11a3.5 3.5 0 0 1 0-7H15"/><circle cx="18" cy="5" r="3"/></svg>
                                    </x-slot:icon>
                                </x-form-group>
                            </div>

                            <div class="col-span-1">
                                <x-form-group label="Número" name="numero" id="evt-numero" labelColor="green" required>
                                    <x-slot:icon>
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list-ordered-icon lucide-list-ordered"><path d="M11 5h10"/><path d="M11 12h10"/><path d="M11 19h10"/><path d="M4 4h1v5"/><path d="M4 9h2"/><path d="M6.5 20H3.4c0-1 2.6-1.925 2.6-3.5a1.5 1.5 0 0 0-2.6-1.02"/></svg>
                                    </x-slot:icon>
                                </x-form-group>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <x-form-group label="Bairro" name="bairro" id="evt-bairro" labelColor="green" required>
                                <x-slot:icon>
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-icon lucide-map"><path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"/><path d="M15 5.764v15"/><path d="M9 3.236v15"/></svg>
                                </x-slot:icon>
                            </x-form-group>

                            <x-form-group label="Cidade" name="cidade" id="evt-cidade" labelColor="green" required>
                                <x-slot:icon>
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-icon lucide-building"><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M12 6h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M16 6h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/><path d="M8 6h.01"/><path d="M9 22v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/><rect x="4" y="2" width="16" height="20" rx="2"/></svg>
                                </x-slot:icon>
                            </x-form-group>
                            
                            <div class="flex flex-col gap-1.5">
                                <label class="block text-base font-medium text-emerald-600">Estado</label>

                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-gray-500 z-10">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                    </div>

                                    <select name="estado" id="evt-estado" class="block w-full p-2.5 ps-10 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 h-[42px]">
                                        <option value="">UF</option>
                                        <option value="SP">SP</option>
                                        <option value="RJ">RJ</option>
                                        <option value="MG">MG</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <x-form-group label="Complemento" name="complemento" id="evt-complemento" labelColor="green">
                            <x-slot:icon>
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layers-icon lucide-layers"><path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"/><path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"/><path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"/></svg>
                            </x-slot:icon>
                        </x-form-group>
                    </div>
                </form>

                <x-slot:footer>
                    <div class="w-full flex justify-between items-center gap-x-4 bg-white">
                        <div>
                            <x-button color="gray" id="evt-btn-prev" onclick="eventChangeStep(-1)" size="md" class="hidden">
                                Voltar
                            </x-button>
                        </div>
                        <div class="flex gap-3">
                            <x-button color="gray" size="md" onclick="closeModal('create-event')">
                                Cancelar
                            </x-button>

                            <x-button type="button" id="evt-btn-next" onclick="eventChangeStep(1)" color="clube" size="md">
                                Próximo
                            </x-button>

                            <x-button type="submit" form="form-create-event" id="evt-btn-submit" class="hidden" color="clube" size="md">
                                Salvar Evento
                            </x-button>
                        </div>
                    </div>
                </x-slot:footer>
            </div>
        </x-modal>
    </div>

    <script>
        let evtCurrentStep = 1;
        const evtTotalSteps = 2;

        document.addEventListener('DOMContentLoaded', () => {
            updateEventUI();
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

            const buttons = document.querySelectorAll('#form-create-event .color-btn');

            buttons.forEach(b => {
                b.classList.remove('ring-2', 'ring-offset-1', 'ring-gray-400', 'opacity-100', 'scale-110');
                
                b.classList.add('opacity-40', 'hover:opacity-100');
            });

            btn.classList.remove('opacity-40', 'hover:opacity-100');
            btn.classList.add('ring-2', 'ring-offset-1', 'ring-gray-400', 'opacity-100', 'scale-110');
        }

        let calState = {
            month: {{ $mes }},
            year: {{ $ano }},
            routeName: "{{ route('clube.ajax.calendar') }}"
        };

        const monthNames = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

        async function changeCalendarMonth(direction) {
            let newMonth = calState.month + direction;
            let newYear = calState.year;

            if (newMonth > 12) {
                newMonth = 1;
                newYear++;
            } else if (newMonth < 1) {
                newMonth = 12;
                newYear--;
            }

            calState.month = newMonth;
            calState.year = newYear;

            document.getElementById('label-month').innerText = monthNames[newMonth - 1];
            document.getElementById('label-year').innerText = newYear;
            
            const loader = document.getElementById('calendar-loading');
            const container = document.getElementById('calendar-grid-container');
            loader.classList.remove('hidden');

            try {
                const response = await fetch(`${calState.routeName}?month=${newMonth}&year=${newYear}`);
                if (!response.ok) throw new Error('Erro na rede');
                
                const html = await response.text();
                
                container.innerHTML = html;
            } catch (error) {
                console.error("Erro ao carregar calendário:", error);
                alert("Não foi possível carregar os eventos.");
            } finally {
                loader.classList.add('hidden');
            }
        }

        async function selectDate(dateStr) {
            const dateObj = new Date(dateStr + 'T00:00:00');
            const options = { weekday: 'long', day: 'numeric' };

            const formattedDate = dateObj.toLocaleDateString('pt-BR', options); 
            
            const labelSidebar = document.getElementById('sidebar-selected-date');

            if(labelSidebar) labelSidebar.innerText = formattedDate;

            const containerLista = document.getElementById('sidebar-event-list');
            
            containerLista.innerHTML = '<div class="p-4 text-center text-gray-400 text-xs">Carregando...</div>';

            try {
                const url = "{{ route('clube.ajax.day-details') }}?date=" + dateStr;
                const res = await fetch(url);
                const html = await res.text();
                
                containerLista.innerHTML = html;
            } catch (err) {
                console.error(err);
                containerLista.innerHTML = '<div class="text-red-500 text-xs">Erro ao carregar.</div>';
            }
        }
    </script>
</x-layouts.clube>